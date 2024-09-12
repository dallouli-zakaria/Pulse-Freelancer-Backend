<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidateSended extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
     public $userName;
     public $postTitle;
    public function __construct($userName,$postTitle)
    {
        $this->userName=$userName;
        $this->postTitle=$postTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $name=$this->userName;
        $titel=$this->postTitle;
        $url=url('https://pulse-freelancer-frontend-v2j-jawad-haidasses-projects.vercel.app/pulse/offers');
        return (new MailMessage)
        ->subject('candidature envoyée avec succès.' )
        ->view('CandidateSended', ['name' => $name, 'titel' => $titel, 'url' => $url]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
