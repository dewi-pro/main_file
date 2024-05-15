<?php

namespace App\Http\Controllers;

use App\Facades\Utility;
use App\Facades\UtilityFacades;
use App\Mail\config;
use App\Models\NotificationsSetting;
use App\Models\settings;
use App\Models\User;
use App\Notifications\TestingPurpose;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Spatie\MailTemplates\Models\MailTemplate;
use Str;

class SettingsController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage-setting')) {
            $alllanguages = UtilityFacades::languages();
            foreach ($alllanguages as  $lang) {
                $languages[$lang] = Str::upper($lang);
            }
            $notificationsSettings = NotificationsSetting::all();
            return view('settings.index', compact('languages', 'notificationsSettings'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    public function appNameUpdate(Request $request)
    {
        request()->validate([
            'app_name' => 'required|min:4|regex:/([A-Za-z0-9 ])+/',
            'app_logo' => 'image|max:2048|mimes:png',
            'favicon_logo' => 'image|max:2048|mimes:png',
            'app_dark_logo' => 'image|max:2048|mimes:png',
        ]);

        $appLogo = UtilityFacades::getsettings('app_logo');
        $appDarkLogo = UtilityFacades::getsettings('app_dark_logo');
        $faviconLogo = UtilityFacades::getsettings('favicon_logo');
        $data = [
            'app_name' => $request->app_name
        ];
        if ($request->app_logo) {
            $appLogo = 'app-logo' . '.' . 'png';
            $logoPath = "app-logo";
            $image = request()->file('app_logo')->storeAs(
                $logoPath,
                $appLogo,
            );
            $data['app_logo'] = $image;
        }
        if ($request->app_dark_logo) {
            $appDarkLogo = 'app-dark-logo' . '.' . 'png';
            $logoPath = "app-logo";
            $image = request()->file('app_dark_logo')->storeAs(
                $logoPath,
                $appDarkLogo,
            );
            $data['app_dark_logo'] = $image;
        }
        if ($request->favicon_logo) {
            $faviconLogo = 'app-favicon-logo' . '.' . 'png';
            $logoPath = "app-logo";
            $image = request()->file('favicon_logo')->storeAs(
                $logoPath,
                $faviconLogo,
            );
            $data['favicon_logo'] = $image;
        }
        $arrEnv = [
            'APP_NAME' => $request->app_name,
        ];
        UtilityFacades::setEnvironmentValue($arrEnv);
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('App setting updated successfully.'));
    }

    public function appThemeUpdate(Request $request)
    {
        request()->validate([
            'app_theme' => 'required',
        ]);

        $data = [
            'app_theme' => $request->app_theme,
            'app_sidebar' => $request->app_sidebar,
            'app_navbar' => $request->app_navbar,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('App theme updated successfully.'));
    }

    public function pusherSettingUpdate(Request $request)
    {
        request()->validate([
            'pusher_id' => 'required|regex:/^[0-9]+$/',
            'pusher_key' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_secret' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_cluster' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
        ]);

        $data = [
            'pusher_id' => $request->pusher_id,
            'pusher_key' => $request->pusher_key,
            'pusher_secret' => $request->pusher_secret,
            'pusher_cluster' => $request->pusher_cluster,
            'pusher_status' => ($request->pusher_status == 'on') ? 1 : 0,
        ];
        $arrEnv = [
            'PUSHER_APP_ID' => $request->pusher_id,
            'PUSHER_APP_KEY' => $request->pusher_key,
            'PUSHER_APP_SECRET' => $request->pusher_secret,
            'PUSHER_APP_CLUSTER' => $request->pusher_cluster,
        ];
        UtilityFacades::setEnvironmentValue($arrEnv);


        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Pusher API key updated successfully.'));
    }

    public function testMail()
    {
        return view('settings.test-mail');
    }

    public function wasabiSettingUpdate(Request $request)
    {
        if ($request->storage_type == 's3') {
            request()->validate([
                's3_key'        => 'required',
                's3_secret'     => 'required',
                's3_region'     => 'required',
                's3_bucket'     => 'required',
                's3_url'        => 'required',
                's3_endpoint'   => 'required',

            ]);

            $s3 = [
                's3_key'        => $request->s3_key,
                's3_secret'     => $request->s3_secret,
                's3_region'     => $request->s3_region,
                's3_bucket'     => $request->s3_bucket,
                's3_url'        => $request->s3_url,
                's3_endpoint'   => $request->s3_endpoint,

            ];
            // dd($data);
            $data = [
                'storage_type' => $request->storage_type
            ];
            $this->updateSettings($s3);
            $this->updateSettings($data);
            return redirect()->back()->with('success',  __('S3 API keys updated successfully.'));
        }
        if ($request->storage_type == 'wasabi') {
            request()->validate([
                'wasabi_key' => 'required',
                'wasabi_secret' => 'required',
                'wasabi_region' => 'required',
                'wasabi_bucket' => 'required',
                'wasabi_url' => 'required',
                'wasabi_root' => 'required',

            ]);

            $wasabi = [
                'wasabi_key' => $request->wasabi_key,
                'wasabi_secret' => $request->wasabi_secret,
                'wasabi_region' => $request->wasabi_region,
                'wasabi_bucket' => $request->wasabi_bucket,
                'wasabi_url' => $request->wasabi_url,
                'wasabi_root' => $request->wasabi_root,
                'FILESYSTEM_DRIVER' => $request->storage_type,
            ];
            $data = [
                'storage_type' => $request->storage_type
            ];
            $this->updateSettings($data);
            $this->updateSettings($wasabi);
            return redirect()->back()->with('success',  __('Wasabi keys updated successfully.'));
        } else {
            $data = [
                'storage_type' => $request->storage_type
            ];
            $this->updateSettings($data);
            return redirect()->back()->with('success', __('Storage setting updated successfully'));
        }
    }

    public function emailSettingUpdate(Request $request)
    {
        request()->validate([
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required|email',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);

        $data = [
            'email_setting_enable' => ($request->email_setting_enable) ? 'on' : 'off',
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Email setting updated successfully.'));
    }

    public function captchaSettingUpdate(Request $request)
    {

        request()->validate([
            'captcha' => 'required|min:1'
        ]);

        if ($request->captcha_enable == 'on') {
            if ($request->captcha == 'hcaptcha') {
                request()->validate([
                    'hcaptcha_key' => 'required',
                    'hcaptcha_secret' => 'required',
                ]);
            }
            if ($request->captcha == 'recaptcha') {
                request()->validate([
                    'recaptcha_key' => 'required',
                    'recaptcha_secret' => 'required',
                ]);
            }
            $data = [
                'captcha_enable' => $request->captcha_enable == 'on' ? 'on' : 'off',
                'captcha'  => $request->captcha,
                'captcha_secret' => $request->recaptcha_secret,
                'captcha_sitekey' => $request->recaptcha_key,
                'hcaptcha_secret' => $request->hcaptcha_secret,
                'hcaptcha_sitekey' => $request->hcaptcha_key,
            ];

            $this->updateSettings($data);
            return redirect()->back()->with('success',  __('Captcha settings updated successfully.'));
        } else {
            $data = ['captcha_enable' => 'off'];

            $this->updateSettings($data);
            return redirect()->back()->with('success',  __('Captcha settings updated successfully.'));
        }
    }

    public function seoSettingUpdate(Request $request)
    {
        request()->validate(
            [
                'meta_title' => 'required|max:100',
                'meta_keywords' => 'required|max:100',
                'meta_description' => 'required',
                'meta_image' => 'mimes:png,jpg,jpeg,image',
            ]
        );

        $data = [
            'seo_setting' => ($request->seo_setting) ? 'on' : 'off',
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ];
        if ($request->hasFile('meta_image')) {
            $metaImage = 'meta-image' . '.' . $request->meta_image->getClientOriginalExtension();
            $logoPath = "seo-image";
            $image = request()->file('meta_image')->storeAs(
                $logoPath,
                $metaImage,
            );
            $data['meta_image'] = $image;
        }

        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('SEO setting updated successfully.'));
    }

    public function cookieSettingUpdate(Request $request)
    {
        request()->validate(
            [
                'cookie_title' => 'required',
                'cookie_description' => 'required',
                'strictly_cookie_title' => 'required',
                'strictly_cookie_description' => 'required',
                'more_information_description' => 'required',
                'contactus_url' => 'required',
            ]
        );

        $data = [
            'enable_cookie' => ($request->enable_cookie) ? 'on' : 'off',
            'cookie_logging' => ($request->cookie_logging) ? 'on' : 'off',
            'cookie_title'  => $request->cookie_title,
            'cookie_description' => $request->cookie_description,
            'strictly_cookie_title' => $request->strictly_cookie_title,
            'strictly_cookie_description' => $request->strictly_cookie_description,
            'more_information_description' => $request->more_information_description,
            'contactus_url' => $request->contactus_url,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Cookie setting updated successfully.'));
    }

    public function CookieConsent(Request $request)
    {
        if (UtilityFacades::keysettings('enable_cookie', 1) == "on" && UtilityFacades::keysettings('cookie_logging', 1) == "on") {
            $allowedLevels = ['necessary', 'analytics', 'targeting'];
            $levels = array_filter($request['cookie'], function ($level) use ($allowedLevels) {
                return in_array($level, $allowedLevels);
            });
            $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            $browserName = $whichbrowser->browser->name ?? null;
            $osName = $whichbrowser->os->name ?? null;
            $browserLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $deviceType = Utility::get_device_type($_SERVER['HTTP_USER_AGENT']);

            $ip = '49.36.83.154';

            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));

            $date = (new \DateTime())->format('Y-m-d');
            $time = (new \DateTime())->format('H:i:s') . ' UTC';

            $newLine = implode(',', [
                $ip, $date, $time, json_encode($request['cookie']), $deviceType, $browserLanguage, $browserName, $osName,
                isset($query) ? $query['country'] : '', isset($query) ? $query['region'] : '', isset($query) ? $query['regionName'] : '', isset($query) ? $query['city'] : '', isset($query) ? $query['zip'] : '', isset($query) ? $query['lat'] : '', isset($query) ? $query['lon'] : ''
            ]);

            if (!file_exists(Storage::path('seo-image/cookie-data.csv'))) {
                $firstLine = 'IP,Date,Time,Accepted cookies,Device type,Browser language,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';
                file_put_contents(Storage::path('seo-image/cookie-data.csv'), $firstLine . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            file_put_contents(Storage::path('seo-image/cookie-data.csv'), $newLine . PHP_EOL, FILE_APPEND | LOCK_EX);

            return response()->json('success');
        }
        return response()->json('error');
    }

    public function socialSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'socialsetting' => 'required|min:1'
        ]);
        $googlestatus = 'off';
        $facebookstatus = 'off';
        $githubstatus = 'off';
        $linkedinstatus = 'off';
        if ($request->socialsetting) {
            if (in_array('google', $request->get('socialsetting'))) {
                request()->validate([
                    'google_client_id' => 'required',
                    'google_client_secret' => 'required',
                    'google_redirect' => 'required',
                ]);

                $data = [
                    'google_client_id' => $request->google_client_id,
                    'google_client_secret' => $request->google_client_secret,
                    'google_redirect' => $request->google_redirect,
                    'googlesetting' => (!empty($request->googlesetting)) ? 'on' : 'off',
                ];
                $googlestatus = 'on';
            }
            if (in_array('facebook', $request->get('socialsetting'))) {
                request()->validate([
                    'facebook_client_id' => 'required',
                    'facebook_client_secret' => 'required',
                    'facebook_redirect' => 'required',
                ]);

                $data = [
                    'facebook_client_id' => $request->facebook_client_id,
                    'facebook_client_secret' => $request->facebook_client_secret,
                    'facebook_redirect' => $request->facebook_redirect,
                    'facebooksetting' => (!empty($request->facebooksetting)) ? 'on' : 'off',
                ];
                $facebookstatus = 'on';
            }
            if (in_array('github', $request->get('socialsetting'))) {
                request()->validate([
                    'github_client_id' => 'required',
                    'github_client_secret' => 'required',
                    'github_redirect' => 'required',
                ]);

                $data = [
                    'github_client_id' => $request->github_client_id,
                    'github_client_secret' => $request->github_client_secret,
                    'github_redirect' => $request->github_redirect,
                    'githubsetting' => (!empty($request->githubsetting)) ? 'on' : 'off',
                ];
                $githubstatus = 'on';
            }
            if (in_array('linkedin', $request->get('socialsetting'))) {

                request()->validate([
                    'linkedin_client_id' => 'required',
                    'linkedin_client_secret' => 'required',
                    'linkedin_redirect' => 'required',
                ]);

                $data = [
                    'linkedin_client_id' => $request->linkedin_client_id,
                    'linkedin_client_secret' => $request->linkedin_client_secret,
                    'linkedin_redirect' => $request->linkedin_redirect,
                    'linkedinsetting' => (!empty($request->linkedinsetting)) ? 'on' : 'off',
                ];
                $linkedinstatus = 'on';
            }
            $data = [
                'google_client_id' => $request->google_client_id,
                'google_client_secret' => $request->google_client_secret,
                'google_redirect' => $request->google_redirect,
                'facebook_client_id' => $request->facebook_client_id,
                'facebook_client_secret' => $request->facebook_client_secret,
                'facebook_redirect' => $request->facebook_redirect,
                'github_client_id' => $request->github_client_id,
                'github_client_secret' => $request->github_client_secret,
                'github_redirect' => $request->github_redirect,
                'linkedin_client_id' => $request->linkedin_client_id,
                'linkedin_client_secret' => $request->linkedin_client_secret,
                'linkedin_redirect' => $request->linkedin_redirect,
                'googlesetting' => (in_array('google', $request->get('socialsetting'))) ? 'on' : 'off',
                'facebooksetting' => (in_array('facebook', $request->get('socialsetting'))) ? 'on' : 'off',
                'githubsetting' => (in_array('github', $request->get('socialsetting'))) ? 'on' : 'off',
                'linkedinsetting' => (in_array('linkedin', $request->get('socialsetting'))) ? 'on' : 'off',
            ];
        } else {
            $data = [
                'googlesetting' => 'off',
                'facebooksetting' => 'off',
                'githubsetting' => 'off',
                'linkedinsetting' => 'off',
            ];
        }
        $this->updateSettings($data);
        return redirect()->back()->with('success', __('Social setting updated successfully.'));
    }

    public function authSettingsUpdate(Request $request)
    {
        $user = \Auth::user();
        if ($request->email_verification == 'on') {
            if (UtilityFacades::getsettings('mail_host') != '') {
                $val = [
                    'email_verification' => ($request->email_verification == 'on') ? '1' : '0',
                ];
                $this->updateSettings($val);
            } else {
                return redirect("/settings#useradd-6")->with('warning', __('Please set email setting.'));
            }
        }
        if ($request->sms_verification == 'on') {
            if (UtilityFacades::getsettings('multisms_setting') == 'on') {
                $val = [
                    'sms_verification' => ($request->sms_verification == 'on') ? '1' : '0',
                ];
                $this->updateSettings($val);
            } else {
                return redirect("/settings#useradd-9")->with('warning', __('Please set sms setting.'));
            }
        }

        $data = [
            'rtl' => ($request->rtl_setting == 'on') ? 1 : 0,
            '2fa' => ($request->two_factor_auth == 'on') ? 1 : 0,
            'register' => ($request->register == 'on') ? 1 : 0,
            'landing_page' => ($request->landing_page == 'on') ? 1 : 0,
            'gtag' => $request->gtag,
            'default_language' => $request->default_language,
            'date_format' => $request->date_format,
            'time_format' => $request->time_format,
            'email_verification' => ($request->email_verification == 'on') ? 1 : 0,
            'sms_verification' => ($request->sms_verification == 'on') ? 1 : 0,
            'color' => ($request->color) ? $request->color : UtilityFacades::getsettings('color'),
            'dark_mode' => $request->dark_mode,
            'transparent_layout' => ($request->transparent_layout == 'on') ? 'on' : 'off',
            'roles' => $request->roles
        ];
        $this->updateSettings($data);
        $user->dark_layout = ($request->dark_mode && $request->dark_mode == 'on') ? 1 : 0;
        $user->rtl_layout = ($request->rtl_setting && $request->rtl_setting == 'on') ? 1 : 0;
        $user->transprent_layout = ($request->transparent_layout && $request->transparent_layout == 'on') ? 1 : 0;
        $user->theme_color = ($request->color) ? $request->color : UtilityFacades::getsettings('color');
        $user->save();
        return redirect()->back()->with('success',  __('General setting updated successfully.'));
    }

    public function paymentSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'paymentsetting' => 'required|min:1'
        ]);
        $stripestatus = 'off';
        $paypalstatus = 'off';
        $razorpaystatus = 'off';
        $Offlinestatus = 'off';
        $mercadostatus = 'off';
        $payumoneystatus = 'off';
        $molliestatus = 'off';

        if (in_array('stripe', $request->get('paymentsetting'))) {
            request()->validate([
                'stripe_key' => 'required',
                'stripe_secret' => 'required',
            ]);

            $data = [
                'stripe_key' => $request->stripe_key,
                'stripe_secret' => $request->stripe_secret,
                'stripesetting' => (in_array('stripe', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $stripestatus = 'on';
        }
        if (in_array('paypal', $request->paymentsetting)) {
            request()->validate([
                'client_id' => 'required',
                'client_secret' => 'required',
            ]);

            $data = [
                'paypal_sandbox_client_id' => $request->client_id,
                'paypal_sandbox_client_secret' => $request->client_secret,
                'paypal_mode' => $request->paypal_mode,
                'paypalsetting' => (in_array('paypal', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $paypalstatus = 'on';
        }
        if (in_array('razorpay', $request->paymentsetting)) {
            request()->validate([
                'razorpay_key' => 'required',
                'razorpay_secret' => 'required',
            ]);
            $data = [
                'razorpay_key' => $request->razorpay_key,
                'razorpay_secret' =>  $request->razorpay_secret,
                'razorpaysetting' => (in_array('razorpay', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $razorpaystatus = 'on';
        }
        if (in_array('mollie', $request->get('paymentsetting'))) {
            request()->validate([
                'mollie_api_key' => 'required',
                'mollie_profile_id' => 'required',
                'mollie_partner_id' => 'required',
            ]);
            $data = [
                'mollie_api_key' => $request->mollie_api_key,
                'mollie_profile_id' => $request->mollie_profile_id,
                'mollie_partner_id' => $request->mollie_partner_id,
                'molliesetting' => (in_array('mollie', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
        }
        if (in_array('paytm', $request->get('paymentsetting'))) {
            request()->validate([
                'merchant_id' => 'required',
                'merchant_key' => 'required',
                'paytm_environment' => 'required',
            ]);

            $data = [
                'paytm_merchant_id' => $request->merchant_id,
                'paytm_merchant_key' => $request->merchant_key,
                'paytm_environment' => $request->paytm_environment,
                'paytm_merchant_website' => 'local',
                'paytm_channel' => 'WEB',
                'paytm_indistry_type' => 'local',
                'paytmsetting' => (in_array('paytm', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $paytmstatus = 'on';
        }
        if (in_array('flutterwave', $request->get('paymentsetting'))) {
            request()->validate([
                'flw_public_key' => 'required',
                'flw_secret_key' => 'required',
            ]);

            $data = [
                'flw_public_key' => $request->flw_public_key,
                'flw_secret_key' => $request->flw_secret_key,
                'flutterwavesetting' => (in_array('flutterwave', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $flutterwavestatus = 'on';
        }
        if (in_array('coingate', $request->get('paymentsetting'))) {
            request()->validate([
                'coingate_auth_token' => 'required',
            ]);
            $data = [
                'coingate_environment' => $request->coingate_mode,
                'coingate_auth_token' => $request->coingate_auth_token,
                'coingatesetting' => (in_array('coingate', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $stripestatus = 'on';
        }
        if (in_array('paystack', $request->get('paymentsetting'))) {
            request()->validate([
                'paystack_public_key' => 'required',
                'paystack_secret_key' => 'required',
            ]);

            $data = [
                'paystack_public_key' => $request->paystack_public_key,
                'paystack_secret_key' => $request->paystack_secret_key,
                'paystacksetting' => (in_array('paystack', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $flutterwavestatus = 'on';
        }
        if (in_array('payumoney', $request->get('paymentsetting'))) {
            request()->validate([
                'payumoney_merchant_key' => 'required',
                'payumoney_salt_key' => 'required',
            ]);
            $data = [
                'payumoney_merchant_key' => $request->payumoney_merchant_key,
                'payumoney_salt_key' => $request->payumoney_salt_key,
                'payumoneysetting' => (in_array('payumoney', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $payumoneystatus = 'on';
        }
        if (in_array('mercado', $request->paymentsetting)) {
            request()->validate([
                'mercado_access_token' => 'required',
            ]);
            $data = [
                'mercado_mode' => $request->mercado_mode,
                'mercado_access_token' => $request->mercado_access_token,
                'mercadosetting' => (in_array('mercado', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $mercadostatus = 'on';
        }

        if (in_array('offlinepayment', $request->paymentsetting)) {
            request()->validate([
                'offline_payment_details'   => 'required'
            ]);

            $data = [
                'offline_payment_details' =>  $request->offline_payment_details,
                'offlinepaymentsetting' => (in_array('offlinepayment', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $Offlinestatus = 'on';
        }
        $data = [
            'stripe_key' => $request->stripe_key,
            'stripe_secret' => $request->stripe_secret,
            'paypal_sandbox_client_id' => $request->client_id,
            'paypal_sandbox_client_secret' => $request->client_secret,
            'paypal_mode' => $request->paypal_mode,
            'razorpay_key' => $request->razorpay_key,
            'razorpay_secret' =>  $request->razorpay_secret,
            'paytm_merchant_id' => $request->merchant_id,
            'paytm_merchant_key' => $request->merchant_key,
            'paytm_environment' => $request->paytm_environment,
            'paytm_merchant_website' => 'local',
            'paytm_channel' => 'WEB',
            'paytm_indistry_type' => 'local',
            'flw_public_key' => $request->flw_public_key,
            'flw_secret_key' => $request->flw_secret_key,
            'paystack_public_key' => $request->paystack_public_key,
            'paystack_secret_key' => $request->paystack_secret_key,
            'payumoney_merchant_key' => $request->payumoney_merchant_key,
            'payumoney_salt_key' => $request->payumoney_salt_key,
            'mollie_api_key' => $request->mollie_api_key,
            'mollie_profile_id' => $request->mollie_profile_id,
            'mollie_partner_id' => $request->mollie_partner_id,
            'coingate_environment' => $request->coingate_mode,
            'coingate_auth_token' => $request->coingate_auth_token,
            'payment_mode' => $request->payment_mode,
            'offline_payment_details' =>  $request->offline_payment_details,
            'mercado_mode' => $request->mercado_mode,
            'mercado_access_token' => $request->mercado_access_token,
            'mercadosetting' => (in_array('mercado', $request->get('paymentsetting'))) ? 'on' : 'off',
            'coingatesetting' => (in_array('coingate', $request->get('paymentsetting'))) ? 'on' : 'off',
            'stripesetting' => (in_array('stripe', $request->get('paymentsetting'))) ? 'on' : 'off',
            'paypalsetting' => (in_array('paypal', $request->get('paymentsetting'))) ? 'on' : 'off',
            'razorpaysetting' => (in_array('razorpay', $request->get('paymentsetting'))) ? 'on' : 'off',
            'offlinepaymentsetting' => (in_array('offlinepayment', $request->get('paymentsetting'))) ? 'on' : 'off',
            'paytmsetting' => (in_array('paytm', $request->get('paymentsetting'))) ? 'on' : 'off',
            'flutterwavesetting' => (in_array('flutterwave', $request->get('paymentsetting'))) ? 'on' : 'off',
            'paystacksetting' => (in_array('paystack', $request->get('paymentsetting'))) ? 'on' : 'off',
            'payumoneysetting' => (in_array('payumoney', $request->get('paymentsetting'))) ? 'on' : 'off',
            'molliesetting' => (in_array('mollie', $request->get('paymentsetting'))) ? 'on' : 'off',
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success', __('Payment setting updated successfully.'));
    }

    public function smsSettingUpdate(Request $request)
    {
        if ($request->smssetting == 'twilio') {
            request()->validate([
                'twilio_sid' => 'required',
                'twilio_auth_token' => 'required',
                'twilio_verify_sid' => 'required',
                'twilio_number' => 'required',
            ]);
        } else if ($request->smssetting == 'nexmo') {
            request()->validate([
                'nexmo_key' => 'required',
                'nexmo_secret' => 'required',
            ]);
        }
        $data = [
            'multisms_setting' => ($request->multisms_setting) ? 'on' : 'off',
            'smssetting' => ($request->smssetting),
            'nexmo_key' => $request->nexmo_key,
            'nexmo_secret' => $request->nexmo_secret,
            'twilio_sid' => $request->twilio_sid,
            'twilio_auth_token' => $request->twilio_auth_token,
            'twilio_verify_sid' => $request->twilio_verify_sid,
            'twilio_number' => $request->twilio_number,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Sms setting updated successfully.'));
    }


    private function updateSettings($input)
    {
        foreach ($input as $key => $value) {
            settings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    public function testSendMail(Request $request)
    {
        $user = User::where('type', 'Admin')->first();
        $email = $request->email;
        request()->validate([
            'email' => 'required|email'
        ]);

        $notificationsSetting = NotificationsSetting::where('title', 'testing purpose')->first();
        if (isset($notificationsSetting)) {
            if ($notificationsSetting->email_notification == '1') {
                if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                    try {
                        $user->notify(new TestingPurpose($email));
                    } catch (\Exception $e) {
                        $smtpError = __('E-Mail has been not sent due to SMTP configuration');
                        return redirect()->back()->with('error', $smtpError);
                    }
                } else {
                    return redirect()->back()->with('status', __('Please turn on email enable/disable button.'));
                }
            } else {
                return redirect()->back()->with('status', __('Please turn on Email notification'));
            }
        }

        return redirect()->back()->with('success', __('Email send successfully.'));
    }

    public function googleCalender(Request $request)
    {
        request()->validate([
            'google_calendar_id' => 'required',
            'google_calendar_json_file' => 'required',
        ]);

        if ($request->google_calendar_json_file) {
            $dir = md5(time());
            $path = $dir . '/' . md5(time()) . "." . $request->google_calendar_json_file->getClientOriginalExtension();

            $file = $request->file('google_calendar_json_file');
            $file->storeAs('google-json-file', $path);
            $url = Storage::path($path);
        }

        $data = [
            'google_calendar_enable' => ($request->google_calendar_enable  && $request->google_calendar_enable == 'on')  ? 'on' : 'off',
            'google_calendar_id' => $request->google_calendar_id,
            'google_calendar_json_file' => $path,
        ];

        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Google Calendar API key updated successfully.'));
    }

    public function googleMapUpdate(Request $request)
    {
        request()->validate([
            'google_map_api' => 'required',
        ]);

        $data = [
            'google_map_enable' => ($request->google_map_enable && $request->google_map_enable == 'on') ? 'on' : 'off',
            'google_map_api' => $request->google_map_api,
        ];


        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Google map API key updated successfully.'));
    }

    public function pwaSettingUpdate(Request $request)
    {
        request()->validate([
            'pwa_icon_128' => 'mimes:png,jpg,jpeg,image',
            'pwa_icon_144' => 'mimes:png,jpg,jpeg,image',
            'pwa_icon_152' => 'mimes:png,jpg,jpeg,image',
            'pwa_icon_192' => 'mimes:png,jpg,jpeg,image',
            'pwa_icon_256' => 'mimes:png,jpg,jpeg,image',
            'pwa_icon_512' => 'mimes:png,jpg,jpeg,image',
        ]);

        if ($request->pwa_icon_128) {
            $pwaIcon128             = 'pwa-icon-128' . '.' . $request->pwa_icon_128->getClientOriginalExtension();
            $logoPath               = "pwa-image";
            $image                  = request()->file('pwa_icon_128')->storeAs($logoPath, $pwaIcon128);
            $data['pwa_icon_128']   = $image;
        }
        if ($request->pwa_icon_144) {
            $pwaIcon144             = 'pwa-icon-144' . '.' . $request->pwa_icon_144->getClientOriginalExtension();
            $logoPath               = "pwa-image";
            $image144               = request()->file('pwa_icon_144')->storeAs($logoPath, $pwaIcon144);
            $data['pwa_icon_144']   = $image144;
        }
        if ($request->pwa_icon_152) {
            $pwaIcon152             = 'pwa-icon-152' . '.' . $request->pwa_icon_152->getClientOriginalExtension();
            $logoPath               = "pwa-image";
            $image152               = request()->file('pwa_icon_152')->storeAs($logoPath, $pwaIcon152);
            $data['pwa_icon_152']   = $image152;
        }
        if ($request->pwa_icon_192) {
            $pwaIcon192             = 'pwa-icon-192' . '.' . $request->pwa_icon_192->getClientOriginalExtension();
            $logoPath               = "pwa-image";
            $image192               = request()->file('pwa_icon_192')->storeAs($logoPath, $pwaIcon192);
            $data['pwa_icon_192']   = $image192;
        }
        if ($request->pwa_icon_256) {
            $pwaIcon256             = 'pwa-icon-256' . '.' . $request->pwa_icon_256->getClientOriginalExtension();
            $logoPath               = "pwa-image";
            $image256               = request()->file('pwa_icon_256')->storeAs($logoPath, $pwaIcon256);
            $data['pwa_icon_256']   = $image256;
        }
        if ($request->hasFile('pwa_icon_512')) {
            $pwaIcon512             = 'pwa-icon-512' . '.' . $request->pwa_icon_512->getClientOriginalExtension();
            $logoPath               = "pwa-image";
            $image512               = request()->file('pwa_icon_512')->storeAs($logoPath, $pwaIcon512);
            $data['pwa_icon_512']   = $image512;
        }

        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('PWA setting updated successfully.'));
    }
}
