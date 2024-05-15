<?php

namespace App\Models;

use App\Facades\UtilityFacades;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Mail\PasswordReset;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Spatie\MailTemplates\Models\MailTemplate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use Impersonate;

    protected $fillable = [
        'name', 'email', 'password', 'type', 'profile', 'active_status', 'email_verified_at', 'lang', 'created_by', 'country',
        'country_code', 'phone', 'isVerified', 'phone_verified_at', 'theme_color', 'dark_layout', 'rtl_layout', 'transprent_layout', 'users_grid_view', 'forms_grid_view'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function loginSecurity()
    {
        return $this->hasOne('App\Models\LoginSecurity');
    }

    public function currentLanguage()
    {
        return $this->lang;
    }

    public function sendPasswordResetNotification($token)
    {
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (MailTemplate::where('mailable', PasswordReset::class)->first()) {
                $url = URL::temporarySignedRoute(
                    'password.reset',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                    [
                        'token' => $token,
                    ]
                );
                try {
                    Mail::to($this->email)->send(new PasswordReset($this, $url));
                } catch (\Exception $e) {  //$e->getMessage()
                }
            }
        }
    }

    public function uploadFolder()
    {
        return 'data/' . $this->id;
    }

    public function getAvatarImageAttribute()
    {
        $avatar = \File::exists($this->avatar) ? Storage::url($this->avatar) : Storage::url('avatar/avatar.png');
        return $avatar;
    }

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function lastCodeRemainingSeconds()
    {
        $temp = UserCode::where('user_id', '=', $this->id)->first();
        if (isset($temp)) {
            $seconds = $temp->updated_at->diffInSeconds(Carbon::now());
            if ($seconds > 60) {
                return 60;
            } else {
                return 60 - $seconds;
            }
        } else {
            return 60;
        }
    }

}
