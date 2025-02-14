<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdatd extends Notification
{
    use Queueable;

    protected $freelancer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($freelancer)
    {
        $this->freelancer = $freelancer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Verification de votre profile')
                    ->greeting('Bonjour ' . $this->freelancer->name . ',')
                    ->line('Votre statut de profil a été mis à jour. Vous êtes désormais vérifié et pouvez maintenant postuler à nos différentes offres. ')
                    ->action('Voire les Details', url('https://pulse-freelancer.vercel.app/#/freelancer-dashboard/freelancer-profile'))
                    ->line('Merci d\'avoir choisi PULSE.FREELANCER !.')
                    ->salutation('cordialement , 
                    PULSE.freelancer')
                ;
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
            'freelancer_id' => $this->freelancer->id,
            'status' => $this->freelancer->status,
        ];
    }
}
