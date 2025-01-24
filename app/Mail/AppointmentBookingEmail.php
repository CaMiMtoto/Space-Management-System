<?php

namespace App\Mail;

use App\Models\AppointmentBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBookingEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected AppointmentBooking $appointmentBooking;

    /**
     * Create a new message instance.
     */
    public function __construct(AppointmentBooking $appointmentBooking)
    {
        $this->appointmentBooking = $appointmentBooking;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Booking Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment.created',
            with: [
                'appointmentBooking' => $this->appointmentBooking,
            ],
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
