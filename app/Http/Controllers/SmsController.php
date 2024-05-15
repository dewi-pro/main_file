<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use App\Models\User;
use App\Models\UserCode;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function smsNoticeIndex(Request $request)
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        if (UtilityFacades::keysettings('sms_verification', 1) == '1') {
            return view('auth.smsnotice', compact('lang'));
        } else {
            return view('dashboard.home');
        }
    }

    public function smsNoticeVerify(Request $request)
    {
        $user = User::where('email', $request->email)->where('phone', $request->phone)->first();
        $code = rand(100000, 999999);
        if (UtilityFacades::keysettings('smssetting', 1) == 'nexmo') {
            $response = Http::asForm()->post('https://rest.nexmo.com/sms/json/', [
                'api_key' => UtilityFacades::keysettings('nexmo_key', 1),
                'api_secret' => UtilityFacades::keysettings('nexmo_secret', 1),
                'from' => env('APP_NAME'),
                'text' => $code,
                'to' => $user->country_code . $user->phone,
            ]);
        }
        if (UtilityFacades::keysettings('smssetting', 1) == 'twilio' || UtilityFacades::keysettings('smssetting', 1) == 'nexmo' && $response->status() == 200) {
            UserCode::updateOrCreate(
                ['user_id' => $user->id],
                ['code' => $code]
            );
            $datas =  UserCode::where('user_id', '=', $user->id)->first();
            $data = [];
            $data['code'] = $datas->code;
            $data['name'] = $user->name;
        } else {
            return redirect()->back()->with('errors', __('Please check nexmo sms setting.'));
        }
        if (UtilityFacades::keysettings('sms_verification', 1) == '1') {
            if ($sendSms = SmsTemplate::where('event', 'verification code sms')->first()) {
                $result = $sendSms->send("+" . $user->country_code . $user->phone, $data);
            } else {
                return redirect()->back()->with('errors', __('Sms template not found.'));
            }
        } else {
            return redirect()->back()->with('errors', __('Please check sms setting.'));
        }
        return redirect()->route('smsindex.verification');
    }

    public function smsIndex(Request $request)
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);

        if (UtilityFacades::keysettings('sms_verification', 1) == '1') {
            return view('auth.sms', compact('lang'));
        } else {
            return view('dashboard.home');
        }
    }

    public function smsVerify(Request $request)
    {
        $user = Auth::user();
        if (!empty($user)) {
            if ($user->type == 'Super Admin') {
                if ($usercode =  UserCode::where('code', $request->code)->where('user_id', $user->id)->first()) {
                    $user['phone_verified_at'] = Carbon::now()->toDateTimeString();
                    $user->save();
                    return view('dashboard.home');
                } else {
                    return redirect()->back()->with('errors', __('Code invalid.'));
                }
            } elseif (!empty($user->id)) {
                if ($user->active_status == 1) {
                    if ($usercode =  UserCode::where('code', $request->code)->where('user_id', $user->id)->first()) {
                        $user['phone_verified_at'] = Carbon::now()->toDateTimeString();
                        $user->save();
                        return view('dashboard.home');
                    } else {
                        return redirect()->back()->with('errors', __('Code invalid.'));
                    }
                } else {
                    return redirect()->back()->with('errors', __('Please contact to administrator.'));
                }
            } else {
                return redirect()->back()->with('errors', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('errors', __('User not found.'));
        }
    }

    public function smsResend()
    {
        $user = auth()->user();
        $code = rand(100000, 999999);
        if (UtilityFacades::keysettings('smssetting', 1) == 'nexmo') {
            $response = Http::asForm()->post('https://rest.nexmo.com/sms/json/', [
                'api_key' => UtilityFacades::keysettings('nexmo_key', 1),
                'api_secret' => UtilityFacades::keysettings('nexmo_secret', 1),
                'from' => env('APP_NAME'),
                'text' => $code,
                'to' => $user->country_code . $user->phone,
            ]);
        }
        if (UtilityFacades::keysettings('smssetting', 1) == 'twilio' || UtilityFacades::keysettings('smssetting', 1) == 'nexmo' && $response->status() == 200) {
            UserCode::updateOrCreate(
                ['user_id' => $user->id],
                ['code' => $code]
            );
            $datas =  UserCode::where('user_id', '=', $user->id)->first();
            $data = [];
            $data['code'] = $datas->code;
            $data['name'] = $user->name;
        } else {
            return redirect()->back()->with('errors', __('Please check nexmo sms setting.'));
        }
        if (UtilityFacades::keysettings('sms_verification', 1) == '1') {
            if ($sendSms = SmsTemplate::where('event', 'verification code sms')->first()) {
                $result = $sendSms->send("+" . $user->country_code . $user->phone, $data);
            } else {
                return redirect()->back()->with('errors', __('Please check sms setting.'));
            }
        } else {
            return redirect()->back()->with('errors', __('Please check sms setting.'));
        }
        return redirect()->back()
            ->with('success', 'We have resent OTP on your mobile number.');
    }
}
