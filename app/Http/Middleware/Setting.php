<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use App\Mail\config;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Setting
{
    public function handle(Request $request, Closure $next)
    {

        config([

            // 'app.name' => UtilityFacades::getsettings('app_name'),

            'mail.default'                                                      => UtilityFacades::getsettings('mail_mailer'),
            'mail.mailers.smtp.host'                                            => UtilityFacades::getsettings('mail_host'),
            'mail.mailers.smtp.port'                                            => UtilityFacades::getsettings('mail_port'),
            'mail.mailers.smtp.encryption'                                      => UtilityFacades::getsettings('mail_encryption'),
            'mail.mailers.smtp.username'                                        => UtilityFacades::getsettings('mail_username'),
            'mail.mailers.smtp.password'                                        => UtilityFacades::getsettings('mail_password'),
            'mail.from.address'                                                 => UtilityFacades::getsettings('mail_from_address'),
            'mail.from.name'                                                    => UtilityFacades::getsettings('mail_from_name'),

            'services.google.client_id'                                         => UtilityFacades::getsettings('google_client_id', ''),
            'services.google.client_secret'                                     => UtilityFacades::getsettings('google_client_secret', ''),
            'services.google.redirect'                                          => UtilityFacades::getsettings('google_redirect', ''),

            'services.facebook.client_id'                                       => UtilityFacades::getsettings('facebook_client_id', ''),
            'services.facebook.client_secret'                                   => UtilityFacades::getsettings('facebook_client_secret', ''),
            'services.facebook.redirect'                                        => UtilityFacades::getsettings('facebook_redirect', ''),

            'services.github.client_id'                                         => UtilityFacades::getsettings('github_client_id', ''),
            'services.github.client_secret'                                     => UtilityFacades::getsettings('github_client_secret', ''),
            'services.github.redirect'                                          => UtilityFacades::getsettings('github_redirect', ''),

            'services.linkedin.client_id'                                       => UtilityFacades::getsettings('linkedin_client_id', ''),
            'services.linkedin.client_secret'                                   => UtilityFacades::getsettings('linkedin_client_secret', ''),
            'services.linkedin.redirect'                                        => UtilityFacades::getsettings('linkedin_redirect', ''),

            'services.paytm.env'                                                => UtilityFacades::getsettings('paytm_environment', ''),
            'services.paytm.merchant_id'                                        => UtilityFacades::getsettings('paytm_merchant_id', ''),
            'services.paytm.merchant_key'                                       => UtilityFacades::getsettings('paytm_merchant_key', ''),
            'services.paytm.merchant_website'                                   => UtilityFacades::getsettings('paytm_merchant_website', ''),
            'services.paytm.channel'                                            => UtilityFacades::getsettings('paytm_channel', ''),
            'services.paytm.industry_type'                                      => UtilityFacades::getsettings('paytm_indistry_type', ''),

            'paypal.mode'                                                       => UtilityFacades::getsettings('paypal_mode'),
            'paypal.sandbox.client_id'                                          => UtilityFacades::getsettings('paypal_sandbox_client_id'),
            'paypal.sandbox.client_secret'                                      => UtilityFacades::getsettings('paypal_sandbox_client_secret'),
            'paypal.sandbox.app_id'                                             => 'APP-80W284485P519543T',

            'google-calendar.default_auth_profile'                              => 'service_account',
            'google-calendar.auth_profiles.service_account.credentials_json'    => Storage::path('/google-json-file/'.UtilityFacades::getsettings('google_calendar_json_file')),
            'google-calendar.auth_profiles.oauth.credentials_json'              => Storage::path('/google-json-file/'.UtilityFacades::getsettings('google_calendar_json_file')),
            'google-calendar.auth_profiles.oauth.token_json'                    => Storage::path('/google-json-file/'.UtilityFacades::getsettings('google_calendar_json_file')),
            'google-calendar.calendar_id'                                       => UtilityFacades::getsettings('google_calendar_id'),

            'seotools.meta.defaults.description'                                => UtilityFacades::getsettings('meta_description'),
            'seotools.meta.defaults.keywords'                                   => explode(',', UtilityFacades::getsettings('meta_keywords')),

            'seotools.opengraph.defaults.title'                                 => UtilityFacades::getsettings('meta_title'),
            'seotools.opengraph.defaults.description'                           => UtilityFacades::getsettings('meta_description'),
            'seotools.opengraph.defaults.image'                                 => UtilityFacades::getpath(UtilityFacades::getsettings('meta_image')).'?'.time(),
            'seotools.opengraph.defaults.locale'                                => 'en_US',
            'seotools.opengraph.defaults.type'                                  => 'website',
            'seotools.opengraph.defaults.site_name'                             => config('app.name'),

            'seotools.twitter.defaults.card'                                    => 'summary_large_image',
            'seotools.twitter.defaults.title'                                   => UtilityFacades::getsettings('meta_title'),
            'seotools.twitter.defaults.description'                             => UtilityFacades::getsettings('meta_description'),
            'seotools.twitter.defaults.image'                                   => UtilityFacades::getpath(UtilityFacades::getsettings('meta_image')).'?'.time(),
            'seotools.twitter.defaults.site'                                    => '@Prime',

            'seotools.json-ld.defaults.title'                                   => UtilityFacades::getsettings('meta_title'),
            'seotools.json-ld.defaults.description'                             => UtilityFacades::getsettings('meta_description'),
            'seotools.json-ld.defaults.image'                                   => UtilityFacades::getpath(UtilityFacades::getsettings('meta_image')).'?'.time(),
        ]);


        return $next($request);
    }
}
