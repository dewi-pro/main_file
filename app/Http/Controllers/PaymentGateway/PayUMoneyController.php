<?php

namespace App\Http\Controllers;

use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PayUMoneyController extends Controller
{
    public function payumoneyfillPaymentPrepare(Request $request)
    {
        // dd($request->all());
        $authuser  = User::find($request->payumoney_created_by);
        $form = Form::find($request->payumoney_form_id);

        $price  = $request->payumoney_amount;
        $currency = $request->payumoney_currency;
        $symbol = $form->currency_symbol;
        // dd($authuser ,$form ,$discount_value , $price ,  $currency);

        $resData['form_id'] = $form->id;
        $resData['email']       = $authuser->email;
        $resData['total_price'] = $price;
        $key = UtilityFacades::getsettings('payumoney_merchant_key');
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $salt = UtilityFacades::getsettings('payumoney_salt_key');
        $amount = $price;
        $hashString = $key . '|' . $txnid . '|' . $amount . '|' . $form->title . '|' . $authuser->name . '|' . $authuser->email . '|' . '||||||||||' . $salt;
        $hash = strtolower(hash('sha512', $hashString));

        $payuUrl = 'https://test.payu.in/_payment';

        $paymentData = [
            'key' => $key,
            'txnid' => $txnid,
            'amount' => $resData['total_price'],
            'productinfo' => $form->title,
            'firstname' => $authuser->name,
            'email' => $authuser->email,
            'phone' => '1234567890',
            'hash' => $hash,
            'surl' => route('payumoneyfillcallback', Crypt::encrypt(['key' => $key, 'productinfo' => $form->name, 'firstname' => $authuser->name,  'phone' => '1234567890', 'email' => $authuser->email, 'amount' => $resData['total_price'] , 'txnid' => $txnid,  'user_id' => $authuser->id,   'currency' => $currency , 'payment_type'=>'payumoney' , 'status' => 'pending'])),
            'furl' => route('payumoneyfillcallback', Crypt::encrypt(['key' => $key, 'productinfo' => $form->name, 'firstname' => $authuser->name, 'phone' => '1234567890','email' => $authuser->email,  'txnid' => $txnid, 'amount' => $resData['total_price'], 'user_id' => $authuser->id,  'currency' => $currency, 'payment_type'=>'payumoney' , 'status' => 'failed'])),
        ];
        return view('form.payumoneyRedirect', compact('payuUrl', 'paymentData'));

    }

    public function payumoneyfillPlanGetPayment($data)
    {
        $data = Crypt::decrypt($data);
        $form = Form::find($data['form_id']);
        if ($data['status'] == 'pending') {
            $formvalue = FormValue::where('form_id', $form->id)->latest('id')->first();
            $formvalue->currency_symbol = $form->currency_symbol;
            $formvalue->currency_name = $form->currency_name;
            $formvalue->amount = $form->amount;
            $formvalue->status = 'successfull';
            $formvalue->payment_type = 'payumoney';
        } else {
            $formvalue = FormValue::where('form_id', $form->id)->latest('id')->first();
            $formvalue->currency_symbol = $form->currency_symbol;
            $formvalue->currency_name = $form->currency_name;
            $formvalue->amount = $form->amount;
            $formvalue->status = 'failed';
            $formvalue->payment_type = 'payumoney';
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
