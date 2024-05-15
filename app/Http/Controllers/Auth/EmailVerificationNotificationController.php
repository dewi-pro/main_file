<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\config;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        config([
            'mail.default'                  => UtilityFacades::keysettings('mail_mailer', 1),
            'mail.mailers.smtp.host'        => UtilityFacades::keysettings('mail_host', 1),
            'mail.mailers.smtp.port'        => UtilityFacades::keysettings('mail_port', 1),
            'mail.mailers.smtp.encryption'  => UtilityFacades::keysettings('mail_encryption', 1),
            'mail.mailers.smtp.username'    => UtilityFacades::keysettings('mail_username', 1),
            'mail.mailers.smtp.password'    => UtilityFacades::keysettings('mail_password', 1),
            'mail.from.address'             => UtilityFacades::keysettings('mail_from_address', 1),
            'mail.from.name'                => UtilityFacades::keysettings('mail_from_name', 1),
        ]);
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            return back()->with('errors', $e->getMessage());
        }

        return back()->with('status', 'verification-link-sent');
    }
}
