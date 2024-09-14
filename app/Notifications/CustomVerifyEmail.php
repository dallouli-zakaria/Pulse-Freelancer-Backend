<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;

class CustomVerifyEmail extends VerifyEmailNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    public function toMail($notifiable){
        $verificationUrl = url('/api/email/verify/' . $notifiable->id . '/' . sha1($notifiable->email));

        return (new MailMessage)
        ->subject('Please Verify Your Email Address')
        ->view('notification-Email-verefication', [
            'name' => $notifiable->name,
            'verificationUrl' => $verificationUrl,
        ]);
           
        }
}
