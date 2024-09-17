<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUS extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

   
    private $emailSender;
    private $firstName;
    private $lastName;
    private $userMessage;

    public function __construct($emailSender, $firstName, $lastName, $userMessage)
    {
        $this->emailSender = (string) $emailSender;
        $this->firstName = (string) $firstName;
        $this->lastName = (string) $lastName;
        $this->userMessage = (string) $userMessage; // Renommé ici
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'un utilisateur envoiyer un message ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'contactUsMail',
       
        with: [  
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'emailSender' => $this->emailSender,
            'userMessage' => $this->userMessage, 
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
