<?php

namespace App\Http\Controllers\PaymentGateway;

use Illuminate\Http\Request;
use CoinGate\CoinGate;
use App\Http\Controllers\Controller;
use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormValue;
use Hashids\Hashids;
use Illuminate\Support\Facades\Crypt;

class CoingateController extends Controller
{
    public function coingatePaymentPrepare(Request $request)
    {
        CoinGate::config(
            array(
                'environment' => UtilityFacades::getsettings('coingate_environment'),   // sandbox OR live
                'auth_token' => UtilityFacades::getsettings('coingate_auth_token'),
                'curlopt_ssl_verifypeer' => FALSE  // default is false
            )
        );
        $params = array(
            'order_id' => rand(),
            'price_amount' => $request->cg_amount,
            'price_currency' => $request->cg_currency,
            'receive_currency' => $request->cg_currency,
            'callback_url' => route('coingatecallback',Crypt::encrypt(['form_id' => $request->cg_form_id ,'submit_type' => $request->cg_submit_type])),
            'cancel_url' => route('coingatecallback',Crypt::encrypt(['form_id' => $request->cg_form_id,'status'=>'failed' ,'submit_type' => $request->cg_submit_type])),
            'success_url' => route('coingatecallback',Crypt::encrypt(['form_id' => $request->cg_form_id,'status'=>'successfull' ,'submit_type' => $request->cg_submit_type])),
        );
        $order = \CoinGate\Merchant\Order::create($params);
        $formvalue = FormValue::where('form_id', $request->cg_form_id)->latest('id')->first();
        $formvalue->transaction_id = $order->id;
        $formvalue->save();
        if ($order) {
            return redirect($order->payment_url);
        } else {
            return redirect()->back()->with('error', __('opps something wents wrong.'));
        }
    }

    public function coingatePlanGetPayment(Request $request, $data)
    {
        $data = Crypt::decrypt($data);
        $form = Form::find($data['form_id']);
        if ($data['status'] == 'successfull') {
            $formvalue = FormValue::where('form_id', $form->id)->latest('id')->first();
            $formvalue->currency_symbol = $form->currency_symbol;
            $formvalue->currency_name = $form->currency_name;
            $formvalue->amount = $form->amount;
            $formvalue->status = 'successfull';
            $formvalue->payment_type = 'Coingate';
        } else {
            $formvalue = FormValue::where('form_id', $form->id)->latest('id')->first();
            $formvalue->currency_symbol = $form->currency_symbol;
            $formvalue->currency_name = $form->currency_name;
            $formvalue->amount = $form->amount;
            $formvalue->status = 'failed';
            $formvalue->payment_type = 'Coingate';
        }
        $formvalue->save();
        $hashids = new Hashids('', 20);
        $id = $hashids->encodeHex($form->id);
        $success_msg = strip_tags($form->success_msg);
        if ($data['submit_type'] == 'public_fill') {
            return redirect()->route('forms.survey', $id)->with('success', $success_msg);
        } else {
            return redirect()->back()->with('success', $success_msg);
        }
    }
}
