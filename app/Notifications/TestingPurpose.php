<?php

namespace App\Notifications;

use App\Facades\UtilityFacades;
use App\Mail\TestMail;
use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestingPurpose extends Notification
{
    use Queueable;
    public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notifications_setting = NotificationsSetting::where('title', 'testing purpose')->first();

        if ($notifications_setting->email_notification == '1' && $notifications_setting->notify == '1') {
            return ['mail', 'database'];
        } else if ($notifications_setting->email_notification == '1') {
            return ['mail'];
        } else if ($notifications_setting->notify == '1') {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = $this->email;
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            try {
                return (new TestMail())->to($this->email);
            } catch (\Exception $e) {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                return redirect()->back()->with('error', $smtp_error);
            }
        }
    }
    public function toDatabase($notifiable)
    {
        return [
            'data' => [
                'email' => $this->email,
            ],
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'email' => $this->email,
        ];
    }
}
