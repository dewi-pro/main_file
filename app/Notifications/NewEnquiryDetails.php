<?php

namespace App\Notifications;

use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEnquiryDetails extends Notification
{
    use Queueable;
    public $request;
    // public $phone;
    // public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
        // $this->phone = $phone;
        // $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notify = NotificationsSetting::where('title' ,'new enquiry details')->first();
        if($notify->notify == '1' && $notify->email_notification = '1'){
            return ['mail','database'];
        }elseif($notify->notify = '1'){
            return ['database'];
        }elseif($notify->email_notification = '1'){
            return ['mail'];
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'data' => [
                'email' =>$this->request->email,
            ],
        ];
    }
    public function toArray($notifiable)
    {
        return [
            'email' =>$this->request->email,
        ];
    }
}
