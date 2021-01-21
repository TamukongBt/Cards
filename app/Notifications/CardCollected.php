<?php

namespace App\Notifications;

use App\Transmissions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class CardCollected extends Notification
{
    use Queueable;

    // use Notifiable;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transmissions $transmissions)
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
        return ['database'];
    }



    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A card has been collected at your branch.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }




    public function toDatabase($notifiable)
    {
        return [
            'transmissions' => $this->transmissions
        ];
    }
    
    public function toArray($notifiable)
    {
        return [
            '$transmissions' => $this->transmissions
        ];
    }
}
