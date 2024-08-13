<?php

namespace App\Http\Controllers;

use App\Models\LoginSecurity;
use Auth;
use Hash;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use App\Models\DashboardWidget;
use App\Models\Role;
use App\Models\User;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\Poll;
use App\Models\Testimonial;

class LoginSecurityController extends Controller
{
    protected $country;

    public function __construct(Countries $country)
    {
        $this->middleware(['auth']);
        $this->countries = $country->all()->sortBy('name.common')->pluck('name.common');
    }

    public function show2faForm(Request $request)
    {
        $user = Auth::user();
        $google2faUrl = "";
        $secretKey = "";
        if ($user->loginSecurity()->exists()) {
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2faUrl = $google2fa->getQRCodeInline(
                @setting('app_name'),
                $user->name,
                $user->loginSecurity->google2fa_secret
            );
            $secretKey = $user->loginSecurity->google2fa_secret;
        }
        $user = auth()->user();
        $role = $user->roles->first();
        $countries = $this->countries;
        $data = array(
            'user' => $user,
            'secret' => $secretKey,
            'google2faUrl' => $google2faUrl,
            'countries' => $countries
        );
        return view('profile.index', [
            'user' => $user,
            'role' => $role,
            'secret' => $secretKey,
            'google2faUrl' => $google2faUrl,
            'countries' => $countries
        ]);
    }

    public function generate2faSecret(Request $request)
    {
        $user = Auth::user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $loginSecurity = LoginSecurity::firstOrNew(array('user_id' => $user->id));
        $loginSecurity->user_id = $user->id;
        $loginSecurity->google2fa_enable = 0;
        $loginSecurity->google2fa_secret = $google2fa->generateSecretKey();
        $loginSecurity->save();
        return redirect()->route('profile.index')->with('success', __('Secret key is generated successfully.'));
    }

    public function enable2fa(Request $request)
    {
        $user = Auth::user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);
        if ($valid) {
            $user->loginSecurity->google2fa_enable = 1;
            $user->loginSecurity->save();
            return redirect('2fa')->with('success', __('2fa is enabled successfully.'));
        } else {
            return redirect('2fa')->with('failed', __('Invalid verification code, please try again.'));
        }
    }

    public function disable2fa(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("failed", __('Your password does not matches with your account password. please try again.'));
        }
        request()->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::user();
        $user->loginSecurity->google2fa_enable = 0;
        $user->loginSecurity->save();
        return redirect('/2fa')->with('success', __('2fa is disabled.'));
    }

    public function index()
    {
        $this->middleware(['auth', '2fa']);
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        } else {
            $widgets = DashboardWidget::orderBy('position')->get();
            $usr = \Auth::user();
            $userId = $usr->id;
            $roles = Role::where('name', $usr->type)->first();
            $roleId = $usr->roles->first()->id;
            if ($usr->type == 'Admin') {
                $user = User::where('type', '!=',  'Admin')->count();
                $form = Form::count();
                $submittedForm = FormValue::count();
                $poll = Poll::count();
                $forms = Form::where('created_by', Auth::user()->id)->orWhere('created_by', Auth::user()->created_by)->count();
            } else {
                $user = User::where('created_by', Auth::user()->id)->count();
                $form = Form::whereIn('id', function ($query) use ($roleId) {
                    $query->select('form_id')->from('user_forms')->where('role_id', $roleId);
                })->count();

                $submittedForm = FormValue::select(['form_values.*', 'forms.title'])
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where(function ($query1) use ($roleId, $userId) {
                    $query1->whereIn('form_values.form_id', function ($query) use ($roleId) {
                        $query->select('form_id')->from('assign_forms_roles')->where('role_id', $roleId);
                    })
                        ->orWhereIn('form_values.form_id', function ($query) use ($userId) {
                            $query->select('form_id')->from('assign_forms_users')->where('user_id', $userId);
                        })
                        ->OrWhere('assign_type', 'public');
                })->count();


                if (\Auth::user()->can('access-all-form')) {
                    $forms = Form::where('created_by', Auth::user()->id)->orWhere('created_by', Auth::user()->created_by)->count();
                } else {
                    $forms = Form::where(function ($query) use ($roleId, $userId) {
                        $query->whereIn('id', function ($query1) use ($roleId) {
                            $query1->select('form_id')->from('assign_forms_roles')->where('role_id', $roleId);
                        })->OrWhereIn('id', function ($query1) use ($userId) {
                            $query1->select('form_id')->from('assign_forms_users')->where('user_id', $userId);
                        })->OrWhere('assign_type', 'public');
                    })->count();
                }

                $poll = Poll::count();
            }

            return  view('dashboard/home', compact('user', 'form', 'submittedForm', 'widgets', 'poll', 'forms'));
        }
    }
}
