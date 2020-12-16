<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class AvailableChequeNotify extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $transmissions;

    public function __construct($transmissions)
    {
        $this->transmissions = $transmissions;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['nexmo','mail'];
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
        ->line('Your Bank Cheque is available  Please report to the '.$this->transmissions['branchcode'].' branch and collected your cards')
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
            //
        ];
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
        ->content('Dear Customer,
        Your Cheque Book is available  Please report to the '.$this->transmissions['branchcode'].' branch and collected your cards
        Regards Union Bank Of Cameroon Plc');

    }
}
