<?php

namespace App\Notifications;

use App\Mail\RegisterMail as MailRegisterMail;
use App\Models\NotificationsSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;

class RegisterMail extends Notification
{
    use Queueable;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        $notify = NotificationsSetting::where('title' , 'Register mail')->first();
        if($notify->email_notification == '1' && $notify->notify == '1'){
            return ['mail','database'];
        }
        elseif($notify->email_notification == '1'){
            return ['mail'];
        }
        elseif($notify->notify == '1'){
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

        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'data' => [
                'email' => $this->user->email,
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
            'email' => $this->user['user']['email'],
        ];
    }
}
