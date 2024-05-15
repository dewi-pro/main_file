<?php

namespace App\Http\Controllers;

use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MollieController extends Controller
{

    public function molliefillPaymentPrepare(Request $request)
    {
        $authuser  = User::find($request->mollie_created_by);
        $form = Form::find($request->mollie_form_id);
        $price  = $request->mollie_amount;
        $currency = $request->mollie_currency;
        $resData['form_id'] = $form->id;
        $resData['email']       = $authuser->email;
        $resData['total_price'] = $price;
        $mollieApiKey = UtilityFacades::getsettings('mollie_api_key');
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($mollieApiKey);

        $payment = $mollie->payments->create(
            [
                "amount" => [
                    "currency" => $currency,
                    "value" => number_format((float)$price, 2, '.', ''),
                ],
                "description" => "payment for form details",
                "redirectUrl" => route('molliefillcallback', ['currency_symbol' => '$' , 'currency_name' => $currency , 'amount' => $price ,'status' => 'successfull']),
            ]
        );
        return redirect($payment->getCheckoutUrl())->with('payment_id', $payment->id);
    }

    public function molliefillPlanGetPayment(Request $request, $data)
    {
        $data = Crypt::decrypt($data);
        $form = Form::find($data['form_id']);
        if ($data['status'] == 'pending') {
            $formvalue = FormValue::where('form_id', $form->id)->latest('id')->first();
            $formvalue->currency_symbol = $form->currency_symbol;
            $formvalue->currency_name = $form->currency_name;
            $formvalue->amount = $form->amount;
            $formvalue->status = 'successfull';
            $formvalue->payment_type = 'mollie';
        } else {
            $formvalue = FormValue::where('form_id', $form->id)->latest('id')->first();
            $formvalue->currency_symbol = $form->currency_symbol;
            $formvalue->currency_name = $form->currency_name;
            $formvalue->amount = $form->amount;
            $formvalue->status = 'failed';
            $formvalue->payment_type = 'mollie';
        }
        $formvalue->save();
        $hashids = new Hashids('', 20);
        $id = $hashids->encodeHex($form->id);
        $successMsg = strip_tags($form->success_msg);
        if ($data['submit_type'] == 'public_fill') {
            return redirect()->route('forms.survey', $id)->with('success', $successMsg);
        } else {
            return redirect()->back()->with('success', $successMsg);
        }
    }
}
