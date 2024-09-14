<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferValidated extends Notification
{
    use Queueable;

    protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your offer has been validated by the admin.')
                    ->action('View Offer', url('/offers/'.$this->offer->id))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
