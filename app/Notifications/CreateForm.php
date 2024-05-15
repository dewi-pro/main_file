<?php

namespace App\Notifications;

use App\Models\NotificationsSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateForm extends Notification
{
    use Queueable;
    public $form;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {


            return ['database'];

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
                'form' => $this->form,
            ],
        ];
    }
    public function toArray($notifiable)
    {
        return [
            'form' => $this->form['form']
        ];
    }
}
