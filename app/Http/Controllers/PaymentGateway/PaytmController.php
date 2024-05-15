<?php

namespace App\Http\Controllers;

use App\Models\FormValue;
use Illuminate\Http\Request;
use Paytm;

class PaytmController extends Controller
{
    public function paytmPayment(Request $request)
    {
        $payment = Paytm::with('receive');
        $payment->prepare([
            'order' => rand(),
            'user' => $request->name,
            'mobile_number' => $request->mobile,
            'email' => $request->email,
            'amount' => $request->amount,
            'callback_url' => route('paytm.callback', ['form_id' => $request->form_id]),
        ]);
        $response = $payment->receive();
        return $response;
    }

    public function paytmCallback(Request $request)
    {
        $transaction = Paytm::with('receive');
        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        $transaction->getTransactionId(); // Get transaction id
        $formvalue = FormValue::where('form_id', $request->form_id)->where('payment_type', 'Paytm')->where('status', 'pending')->latest('id')->first();
        if ($transaction->isSuccessful()) {
            //Transaction Successfull
            $formvalue->status = 'successfull';
            $formvalue->transaction_id = $transaction->getTransactionId();
            $formvalue->save();
            return redirect()->back()->with('success', __('Payment received.'));
        } else if ($transaction->isFailed()) {
            //Transaction Failed
            $formvalue->status = 'failed';
            $formvalue->transaction_id = $transaction->getTransactionId();
            $formvalue->save();
            return redirect()->back()->with('error', __('Payment failed.'));
        } else if ($transaction->isOpen()) {
            //Transaction Open/Processing
            $formvalue->status = 'failed';
            $formvalue->transaction_id = $transaction->getTransactionId();
            $formvalue->save();
            return redirect()->back()->with('Failed', __('Payment failed.'));
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
    }
}
