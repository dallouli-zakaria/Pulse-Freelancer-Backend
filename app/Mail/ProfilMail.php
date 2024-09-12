<?php

namespace App\Mail;

use Illuminate\Foundation\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfilMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private readonly User $user, public $message)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification de PULSE.freelancer',
        );
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url=url('https://pulse-freelancer-frontend-v2j-jawad-haidasses-projects.vercel.app/');
        $email='jhaidasse@gmail.com';
        return new Content(
            view: 'email', 
             
            with: [  'name' => $this->user->name,
                    'email' => $email,
                    'messageContent'=>$this->message,
                    'url'=>$url
                  ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
