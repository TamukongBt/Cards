<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class AvailableNotify extends Notification implements ShouldQueue
{
    use Queueable;
    public $transmissions;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transmissions)
    {

        $this->transmissions = $transmissions;

    }

    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email;


    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','nexmo'];
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
        ->line('Dear Customer')
        ->line('Your Bank Card is available  Please report to the '.$this->transmissions['branchcode'].' branch and collected your cards')
        ->line('Regards,')
        ->line('Union Bank Of Cameroon Plc');
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
           '$transmissions' => $this->transmissions
        ];
    }

    public function toNexmo($notifiable)
    {
      
}
