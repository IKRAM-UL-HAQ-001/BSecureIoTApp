<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($sub, $otp)
    {
        $this->subject = $sub;
        $this->otp = $otp;
    }

    public function build()
    {
        $subject = $this->subject ?? 'Default Subject';
        $message = $this->otp ?? 'Default Message';

    return $this->subject($subject)
                ->html("<p>{$message}</p>");
    }

    protected function toMarkdown($notifiable)
    {
        return "Your email content here. You can use variables like {{$this->key}}.";
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'BSecure IoT Verification Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
