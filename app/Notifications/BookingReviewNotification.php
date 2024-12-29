<?php

namespace App\Notifications;

use App\Constants\Status;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Booking $booking;


    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $name = $this->booking->is_guest_booking ? $this->booking->guest_name : $this->booking->user->name;
        if ($this->booking->status == Status::Approved) {
            $subject = "Booking Review: Your booking has been approved";
            $startDateTime = $this->booking->start_date->format('l, F jS Y \a\t g:i A');
            $endDateTime = $this->booking->end_date->format('l, F jS Y \a\t g:i A');
            $line1 = "Dear $name";
            $line2 = "Your booking has been approved for $startDateTime to $endDateTime.";
            $line3 = "Thank you for choosing our services.";
            $line4 = "Please contact us if you have any questions or concerns.";
        } else {
            $subject = "Booking Review: Your booking has been declined";
            $startDateTime = $this->booking->start_date->format('l, F jS Y \a\t g:i A');
            $endDateTime = $this->booking->end_date->format('l, F jS Y \a\t g:i A');
            $line1 = "Dear $name";
            $line2 = "Unfortunately, your booking for $startDateTime to $endDateTime has been declined.";
            $line3 = "Please contact us if you have any questions or concerns.";
            $line4 = "Thank you for choosing our services.";
        }


        return (new MailMessage)
            ->subject($subject)
            ->greeting($line1)
            ->line($line2)
            ->line($line3)
            ->line($line4);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Your booking has been reviewed!',
            'booking_details' => $this->booking->toArray(),
        ];
    }
}
