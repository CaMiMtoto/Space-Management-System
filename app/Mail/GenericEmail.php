<?php

namespace App\Mail;

use App\Models\EmailLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GenericEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $content;

    public ?EmailLink $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $emailSubject, string $content, EmailLink $link = null)
    {
        $this->emailSubject = $emailSubject;
        $this->content = $content;
        $this->link = $link;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.generic',
            with: [
                'content' => $this->content,
                'subject' => $this->emailSubject,
                'link' => $this->link,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
