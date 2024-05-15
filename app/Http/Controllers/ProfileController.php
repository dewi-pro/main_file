<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use PragmaRX\Countries\Package\Countries;
use App\Google2fa as TwoFactor;
use Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $country;

    public function __construct(Countries $country)
    {
        if (setting('email_verification')) {
            $this->middleware(['verified']);
        }
        $this->middleware(['auth', 'web']);
        $this->countries = $country->all()->sortBy('name.common')->pluck('name.common');
    }

    public function index()
    {
        if (!setting('2fa')) {
            $user       = auth()->user();
            $role       = $user->roles->first();
            $countries  = $this->countries;
            foreach ($countries as  $countrie) {
                $allcountries[$countrie] = $countrie;
            }
            return view('profile.index', [
                'user' => $user,
                'role' => $role,
                'countries' => $allcountries,
            ]);
        }
        return $this->activeTwoFactor();
    }

    private function activeTwoFactor()
    {
        $user           = Auth::user();
        $google2faUrl  = "";
        $secretKey     = "";
        if ($user->loginSecurity()->exists()) {
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2faUrl = $google2fa->getQRCodeInline(
                @setting('app_name'),
                $user->name,
                $user->loginSecurity->google2fa_secret
            );
            $secretKey = $user->loginSecurity->google2fa_secret;
        }
        $user       = auth()->user();
        $role       = $user->roles->first();
        $countries  = $this->countries;
        foreach ($countries as  $countrie) {
            $allcountries[$countrie] = $countrie;
        }

        $data = array(
            'user'          => $user,
            'secret'        => $secretKey,
            'google2fa_url' => $google2faUrl,
            'countries'     => $countries
        );
        return view('profile.index', [
            'user'          => $user,
            'role'          => $role,
            'secret'        => $secretKey,
            'google2fa_url' => $google2faUrl,
            'countries'     => $allcountries
        ]);
    }

    public function BasicInfoUpdate(Request $request)
    {
        $user = User::find(auth()->id());
        request()->validate([
            'fullname' => 'required|regex:/^[A-Za-z0-9_.,() ]+$/|max:191',
            'address' => 'required|regex:/^[A-Za-z0-9_.,() ]+$/',
            'country' => 'required|string',
            'phone' => 'required',
        ]);

        $user->name     = $request->fullname;
        $user->address  = $request->address;
        $user->country  = $request->country;
        $user->phone    = $request->phone;
        $user->save();
        return redirect()->back()->with('success',  __('Account details updated successfully.'));
    }

    public function updateAvatar(Request $request)
    {
        $disk = Storage::disk();
        $user = User::find(auth()->id());
        $this->validate($request, [
            'avatar' => 'required|',
        ]);
        $image          = $request->avatar;
        $image          = str_replace('data:image/png;base64,', '', $image);
        $image          = str_replace(' ', '+', $image);
        $imagename      = time() . '.' . 'png';
        $imagepath      = "avatar/" . $imagename;
        $disk->put($imagepath, base64_decode($image));
        $user->avatar = $imagepath;

        if ($user->save()) {
            return __("Avatar updated successfully.");
        }
        return __("Avatar updated failed.");
    }

    public function LoginDetails(Request $request)
    {
        $user = User::find(auth()->id());
        request()->validate([
            'email'                 => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password'              => 'required|min:5|confirmed',
            'password_confirmation' => 'same:password',
        ]);

        $user->email = $request->email;
        if (!is_null($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success',  __('Login details updated successfully.'));
    }

    public function profileStatus()
    {
        $user = User::find(Auth::user()->id);
        $user->active_status = 0;
        $user->save();
        auth()->logout();
        return redirect()->route('home');
    }

    public function verify()
    {
        return redirect(URL()->previous());
    }
}
