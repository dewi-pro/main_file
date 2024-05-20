<?php

namespace Database\Seeders;

use App\Models\FormStatus;
use App\Models\Module;
use App\Models\NotificationsSetting;
use App\Models\settings;
use App\Models\SmsTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\MailTemplates\Models\MailTemplate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'dashboardwidget'      => ['manage', 'create', 'edit', 'delete', 'export'],
            'user'                 => ['manage', 'create', 'edit', 'delete', 'export', 'impersonate', 'phoneverified', 'emailverified'],
            'role'                 => ['manage', 'create', 'edit', 'delete', 'export'],
            'form-template'        => ['manage', 'create', 'edit', 'delete', 'design', 'export'],
            'form-category'        => ['manage', 'create', 'edit', 'delete'],
            'form-status'          => ['manage', 'create', 'edit', 'delete' , 'change-status'],
            'form'                 => ['manage', 'create', 'edit', 'delete', 'design', 'fill', 'duplicate', 'theme-setting', 'integration', 'payment', 'export', 'dashboard-qrcode','access-all'],
            'form-rule'            => ['manage', 'create', 'edit', 'delete'],
            'submitted-form'       => ['manage', 'edit', 'delete', 'download', 'export', 'show','access-all'],
            'booking'              => ['manage', 'create', 'edit', 'delete', 'design', 'export','payment','fill'],
            'booking-calendar'     => ['manage'],
            'submitted-booking'    => ['show', 'manage', 'edit', 'delete', 'export', 'copyurl'],
            'poll'                 => ['manage', 'create', 'edit', 'delete', 'vote', 'result', 'export'],
            'document'             => ['manage', 'create', 'edit', 'delete','document-generate','export'],
            'blog'                 => ['manage', 'create', 'edit', 'delete', 'show', 'export'],
            'category'             => ['manage', 'create', 'edit', 'delete', 'show', 'export'],
            'event'                => ['manage', 'create', 'edit', 'delete'],
            'mailtemplate'         => ['manage', 'edit', 'export'],
            'sms-template'         => ['manage', 'edit', 'export'],
            'language'             => ['create', 'manage','delete'],
            'setting'              => ['manage'],
            'chat'                 => ['manage'],
            'landing-page'         => ['manage'],
            'testimonial'          => ['manage', 'create', 'edit', 'delete', 'export'],
            'faqs'                 => ['manage', 'create', 'edit', 'delete', 'export'],
            'page-setting'         => ['manage', 'create', 'edit', 'delete', 'export'],
            'announcement'         => ['manage', 'create', 'edit', 'delete', 'export'],
        ];

        $settings = [
            ['key' => 'app_name', 'value' => 'Antavaya Survey'],
            ['key' => 'app_logo', 'value' => 'app-logo/app-logo.png'],
            ['key' => 'app_small_logo', 'value' => 'app-logo/app-small-logo.png'],
            ['key' => 'favicon_logo', 'value' => 'app-logo/app-favicon-logo.png'],
            ['key' => 'default_language', 'value' => 'en'],
            ['key' => 'color', 'value' => 'theme-2'],
            ['key' => 'app_dark_logo', 'value' => 'app-logo/app-dark-logo.png'],
            ['key' => 'storage_type', 'value' => 'local'],
            ['key' => 'date_format', 'value' => 'M j, Y'],
            ['key' => 'time_format', 'value' => 'g:i A'],
            ['key' => 'roles', 'value' => 'User'],
            ['key' => 'google_calendar_enable', 'value' => 'off'],
            ['key' => 'captcha_enable', 'value' => 'off'],
            ['key' => 'transparent_layout', 'value' => 'on'],
            ['key' => 'dark_mode', 'value' => 'off'],
            ['key' => 'meta_image', 'value' => 'seo-image/meta-image.jpg'],
            ['key' => 'document_theme1', 'value' => 'document-theme/Stisla.png'],
            ['key' => 'document_theme2', 'value' => 'document-theme/Editor.png'],
            ['key' => 'app_setting_status', 'value' => 'on'],
            ['key' => 'menu_setting_status', 'value' => 'on'],
            ['key' => 'feature_setting_status', 'value' => 'on'],
            ['key' => 'faq_setting_status', 'value' => 'on'],
            ['key' => 'testimonial_setting_status', 'value' => 'on'],
            ['key' => 'sidefeature_setting_status', 'value' => 'on'],
            ['key' => 'landing_page', 'value' => '1'],
            ['key' => 'pwa_icon_128', 'value' => 'pwa-image/pwa-icon-128.png'],
            ['key' => 'pwa_icon_144', 'value' => 'pwa-image/pwa-icon-144.png'],
            ['key' => 'pwa_icon_152', 'value' => 'pwa-image/pwa-icon-152.png'],
            ['key' => 'pwa_icon_192', 'value' => 'pwa-image/pwa-icon-192.png'],
            ['key' => 'pwa_icon_256', 'value' => 'pwa-image/pwa-icon-256.png'],
            ['key' => 'pwa_icon_512', 'value' => 'pwa-image/pwa-icon-512.png'],
        ];

        foreach ($settings as $setting) {
            settings::firstOrCreate($setting);
        }

        $role = Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        foreach ($permissions as $module => $adminpermission) {
            Module::firstOrCreate(['name' => $module]);
            foreach ($adminpermission as $permission) {
                $temp = Permission::firstOrCreate(['name' => $permission . '-' . $module]);
                $role->givePermissionTo($temp);
            }
        }

        $user = User::firstOrCreate(['name' => 'Admin'], [
            'name'                          => 'Admin',
            'email'                         => 'admin@example.com',
            'password'                      => Hash::make('admin@1232'),
            'active_status'                 => '1',
            'email_verified_at'             => Carbon::now()->toDateTimeString(),
            'phone_verified_at'             => Carbon::now()->toDateTimeString(),
            'avatar'                        => ('avatar/avatar.png'),
            'type'                          => 'Admin',
            'lang'                          => 'en',
        ]);

        $user->assignRole($role->id);

        Role::firstOrCreate([
            'name' => 'User'
        ]);

        $formStatus = [
            [
                'name' => 'Mark as read',
                'color' => 'success',
                'status' => '1'
            ],
            [
                'name' => 'Mark as Unread',
                'color' => 'danger',
                'status' => '1'
            ],
        ];
        foreach ($formStatus as $status) {
            FormStatus::firstOrCreate($status);
        }

        MailTemplate::firstOrCreate(['mailable' => 'App\Mail\TestMail'], [
            'mailable' => 'App\Mail\TestMail',
            'subject' => 'Mail send for testing purpose',
            'html_template' => '<p><strong>This Mail For Testing</strong></p>
            <p><strong>Thanks</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => 'App\Mail\Thanksmail'], [
            'mailable' => 'App\Mail\Thanksmail',
            'subject' => 'New survey Submited - {{ title }}',
            'html_template' => '<div class="section-body">
            <div class="mx-0 row">
            <div class="mx-auto col-6">
            <div class="card">
            <div class="card-header">
            <h4 class="text-center w-100">{{ title }}</h4>
            </div>
            <div class="card-body">
            <div class="text-center">
            <img src="{{image}}" id="app-dark-logo" class="my-5 text-center img img-responsive w-30 justify-content-center"/>
            </div>
            <h2 class="text-center w-100">{{ thanks_msg }}</h2>
            </div>
            </div>
            </div>
            </div>
            </div>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => 'App\Mail\BookingThanksmail'], [
            'mailable' => 'App\Mail\BookingThanksmail',
            'subject' => 'New booking Submited - {{ title }}',
            'html_template' => '<div class="section-body">
            <div class="mx-0 row">
            <div class="mx-auto col-6">
            <div class="card">
            <div class="card-header">
            <h4 class="text-center w-100">{{ title }}</h4>
            </div>
            <div class="card-body">
            <div class="text-center">
            <img src="{{image}}" id="app-dark-logo" class="my-5 text-center img img-responsive w-30 justify-content-center"/>
            </div>
            <h2 class="text-center w-100">{{ thanks_msg }}</h2>
            <h3 class="text-center w-100">Click to view your booking details: <a target="_blank" href="{{ link }}">Click Here</a></h3>
            </div>
            </div>
            </div>
            </div>
            </div>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => 'App\Mail\PasswordReset'], [
            'mailable' => 'App\Mail\PasswordReset',
            'subject' => 'Reset Password Notification',
            'html_template' => '<p><strong>Hello!</strong></p><p>You are receiving this email because we received a password reset request for your account. To proceed with the password reset please click on the link below:</p><p><a href="{{url}}">Reset Password</a></p><p>This password reset link will expire in 60 minutes.&nbsp;<br>If you did not request a password reset, no further action is required.</p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['subject' => 'Register Mail.'], [
            'mailable' => \App\Mail\RegisterMail::class,
            'subject' => 'Register Mail.',
            'html_template' => '<p><strong>Hi {{name}}</strong></p>
            <p><strong>Email : {{email}}</strong></p>
            <p><strong>Thanks for registration, your account is active.</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::firstOrCreate(['mailable' => \App\Mail\ConatctMail::class], [
            'mailable' => \App\Mail\ConatctMail::class,
            'subject' => 'New Enquiry Details.',
            'html_template' => '<p><strong>Name : {{name}}</strong></p>

            <p><strong>Email : </strong><strong>{{email}}</strong></p>

            <p><strong>Contact No : {{ contact_no }}&nbsp;</strong></p>

            <p><strong>Message :&nbsp;</strong><strong>{{ message }}</strong></p>',
            'text_template' => null,
        ]);

        SmsTemplate::firstOrCreate(['event' => 'verification code sms'], [
            'event' => 'verification code sms',
            'template' => 'Hello :name, Your verification code is :code',
            'variables' => 'name,code'
        ]);


        NotificationsSetting::firstOrCreate(['title' => 'testing purpose'], [
            'title' => 'testing purpose',
            'email_notification' => '1',
            'sms_notification' => '0',
            'notify' => '1',
            'status' => '2',
        ]);


        NotificationsSetting::firstOrCreate(['title' => 'new survey details'], [
            'title' => 'new survey details',
            'email_notification' => '2',
            'sms_notification' => '2',
            'notify' => '1',
            'status' => '2',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'From Create'], [
            'title' => 'From Create',
            'email_notification' => '2',
            'sms_notification' => '2',
            'notify' => '0',
            'status' => '1',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'New Enquiry Details'], [
            'title' => 'New Enquiry Details',
            'email_notification' => '1',
            'sms_notification' => '2',
            'notify' => '1',
            'status' => '1',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'Register mail'], [
            'title' => 'Register mail',
            'email_notification' => '1',
            'sms_notification' => '2',
            'notify' => '1',
            'status' => '1',
        ]);

        NotificationsSetting::firstOrCreate(['title' => 'new booking survey details'], [
            'title' => 'new booking survey details',
            'email_notification' => '1',
            'sms_notification' => '2',
            'notify' => '1',
            'status' => '1',
        ]);
    }
}
