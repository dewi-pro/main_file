<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\DataTables\UsersDataTable;
use App\Facades\UtilityFacades;
use App\Mail\RegisterMail;
use App\Models\NotificationsSetting;
use App\Models\SocialLogin;
use App\Notifications\RegisterMail as NotificationsRegisterMail;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Support\Facades\Mail;
use Lab404\Impersonate\Impersonate;
use Spatie\MailTemplates\Models\MailTemplate;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manage-user|create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    public function index(UsersDataTable $dataTable)
    {
        if (\Auth::user()->users_grid_view == 1) {
            return redirect()->route('grid.view', 'view');
        }
        return $dataTable->render('users.index');
    }

    public function create()
    {
        $role = Role::where('name', '!=', 'Admin')->get();
        $roles = [];
        $roles[''] = __('Select role');
        foreach ($role as $value) {
            $roles[$value->name] = $value->name;
        }
        $view =  view('users.create', compact('roles'));
        return ['html' => $view->render()];
    }

    public function store(Request $request)
    {
        request()->validate([
            'name'          => 'required|max:50',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|same:confirm-password',
            'roles'         => 'required',
            'phone'         => 'required|unique:users,phone',
        ]);
        $countries          = \App\Core\Data::getCountriesList();
        $country_code       = $countries[$request->country_code]['phone_code'];

        $input                      = $request->all();
        $input['type']              =  $input['roles'];
        $input['password']          = Hash::make($input['password']);
        $input['lang']              = setting('default_language');
        $input['active_status']     = '1';
        $input['country_code']      = $country_code;
        $input['phone']             = $input['phone'];
        $input['created_by']        = \Auth::user()->id;
        $input['email_verified_at'] = (UtilityFacades::getsettings('email_verification') == '1') ? null : Carbon::now()->toDateTimeString();
        $input['phone_verified_at'] = (UtilityFacades::getsettings('sms_verification') == '1') ? null : Carbon::now()->toDateTimeString();
        $user                       = User::create($input);
        $user->assignRole($request->input('roles'));

        if (UtilityFacades::getsettings('email_verification') == '1') {
            try {
                $user->sendEmailVerificationNotification();
            } catch (\Exception $th) {
                return redirect()->back()->with('errors', $th->getMessage());
            }
        }

        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (UtilityFacades::getsettings('mail_host') == true) {
                if (MailTemplate::where('mailable', RegisterMail::class)->first()) {
                    try {
                        Mail::to($request->email)->send(new RegisterMail($request));
                    } catch (\Exception $e) {
                        return redirect()->back()->with('errors', $e->getMessage());
                    }
                }
            }
        }

        $Admin = User::where('type', 'Admin')->first();
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {

            $notify = NotificationsSetting::where('title', 'Register mail')->first();
            if (isset($notify)) {
                if ($notify->notify == '1') {
                    $Admin->notify(new NotificationsRegisterMail($user));
                }
            }
        }

        $message = "Welcome" . env('APP_NAME') . "<br/>";
        $message .= "
        <b>Dear </b> $request->name <br/>
        <b>You are added in our app
        <p> Your login Details:</p>
        </b> $request->email<br/>";
        return redirect()->route('users.index')
            ->with('success',  __('User created successfully.'));
    }

    public function edit($id)
    {
        $user           = User::find($id);
        $role           = Role::all();
        $roles          = [];
        $roles['']      = __('Select role');
        foreach ($role as $value) {
            $roles[$value->name] = $value->name;
        }
        $userRole       = $user->roles->pluck('name', 'name')->all();
        $view           =   view('users.edit', compact('user', 'roles', 'userRole'));
        return ['html' => $view->render()];
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'phone' => 'required|unique:users,phone,' . $id,
        ]);
        $countries          = \App\Core\Data::getCountriesList();
        $country_code       = $countries[$request->country_code]['phone_code'];
        $input              = $request->all();

        if (!isset($input['password']) || $input['password'] != '') {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $input['country_code']   = $country_code;
        $input['phone']          = $input['phone'];
        $input['type']           = $input['roles'];
        $user                    = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')->with('success',  __('User updated successfully.'));
    }

    public function destroy($id)
    {
        if ($id != 1) {
            $user           = User::find($id);
            $social_login   = SocialLogin::where('user_id', $id)->get();
            foreach ($social_login as $value) {
                if ($user->type != 'Admin') {
                    if ($value) {
                        $value->delete();
                    }
                }
            }
            $user->delete();
            return redirect()->back()->with('success', __('User deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function userEmailVerified($id)
    {
        $user = User::find($id);
        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $user->save();
            return redirect()->back()->with('success', 'User email unverification successfully.');
        } else {
            $user->email_verified_at = Carbon::now()->toDateString();
            $user->save();
            return redirect()->back()->with('success', 'User email verification successfully.');
        }

    }

    public function userPhoneVerified($id)
    {
        $user = User::find($id);
        if ($user->phone_verified_at) {
            $user->phone_verified_at = null;
            $user->save();
            return redirect()->back()->with('success', __('User email unverification successfully.'));
        } else {
            $user->phone_verified_at = Carbon::now()->toDateString();
            $user->save();
            return redirect()->back()->with('success', __('User email verification successfully.'));
        }
    }

    public function userStatus(Request $request, $id)
    {
        $users = User::find($id);
        $input = ($request->value == "true") ? 1 : 0;
        if ($users) {
            $users->active_status = $input;
            $users->save();
        }
        return response()->json(['is_success' => true, 'message' => __('User status changed successfully.')]);
    }

    public function gridView($slug = '')
    {
        $user                   = \Auth::user();
        $user->users_grid_view  = ($slug) ? 1 : 0;
        $user->save();
        if ($user->users_grid_view == 0) {
            return redirect()->route('users.index');
        }
        $users = User::where('type', '!=', 'Admin')->get();
        return view('users.grid-view', compact('users'));
    }

    public function impersonate(Request $request, User $user,  $id)
    {
        $user = User::find($id);
        if ($user && auth()->check()) {
            Impersonate::take($request->user(), $user);
            return redirect('/home');
        }
    }

    public function leaveImpersonate(Request $request)
    {
        \Auth::user()->leaveImpersonation($request->user());
        return redirect('/home');
    }
}
