<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->pluck('name', 'name')->all();
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('auth.register', compact('roles', 'lang'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (UtilityFacades::getsettings('login_recaptcha_status') == 1) {
            request()->validate([
                'g-recaptcha-response' => 'required',
            ]);
        }
        request()->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $countries = \App\Core\Data::getCountriesList();
        $countryCode = $countries[$request->country_code]['phone_code'];
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_code' => $countryCode,
            'phone' => $request->phone,
            'active_status' => 1,
            'email_verified_at' => (UtilityFacades::getsettings('email_verification') == '1') ? null : Carbon::now(),
            'phone_verified_at' => (UtilityFacades::getsettings('sms_verification') == '1') ? null : Carbon::now(),
            'type' => UtilityFacades::getsettings('roles'),
            'lang' => 'en',
        ]);
        $user->assignRole(UtilityFacades::getsettings('roles'));

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);

        return $user;
    }
}
