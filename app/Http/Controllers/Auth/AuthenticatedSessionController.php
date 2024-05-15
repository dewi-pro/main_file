<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('auth.login', compact('lang'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if (UtilityFacades::getsettings('login_recaptcha_status') == 1) {
            request()->validate([
                'g-recaptcha-response' => 'required',
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if ($user->active_status == 1) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    if ($user->type == 'Admin') {
                        if (Auth::attempt($credentials)) {
                            $request->session()->regenerate();
                            return redirect()->intended(RouteServiceProvider::HOME);
                        } else {
                            return redirect()->back()->with('errors', __('Invalid username or password.'));
                        }
                    } else {
                        if (Auth::attempt($credentials)) {
                            if ($user->phone_verified_at == ''  && UtilityFacades::keysettings('sms_verification', 1) == '1') {
                                $request->session()->regenerate();
                                return redirect()->route('smsindex.noticeverification');
                            } else {
                                $request->session()->regenerate();
                                return redirect()->intended(RouteServiceProvider::HOME);
                            }
                        } else {
                            return redirect()->back()->with('errors', __('Invalid username or password.'));
                        }
                    }
                } else {
                    return redirect()->back()->with('errors', __('Invalid username or password.'));
                }
            } else {
                return redirect()->back()->with('errors', __('Please Contact to administrator.'));
            }
        } else {
            return redirect()->back()->with('errors', __('User not found.'));
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
