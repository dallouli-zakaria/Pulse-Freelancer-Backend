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
    public function __construct(private readonly User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Profil Mail',
        );
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $random=rand(1000,9999);
        return new Content(
            view: 'email', 
         
            with: [  'name' => $this->user->name,
                    'email' => $this->user->email,
                    'random'=>$random
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
