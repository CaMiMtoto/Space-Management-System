<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingAutoApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Booking $booking;
    protected string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, string $url = '')
    {
        $this->booking = $booking;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail']; // You can add 'database', 'sms', etc. depending on how you notify users.
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Room Booking has been Approved')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are pleased to inform you that your booking for the room has been automatically approved.')
            ->line('Booking Details:')
            ->line('Room: ' . $this->booking->room->name)
            ->line('Start Date: ' . $this->booking->start_date->format('M d Y , h:i A'))
            ->line('End Date: ' . $this->booking->end_date->format('M d Y , h:i A'))
            ->action('View Booking for More Details', $this->url)
            ->line('Thank you for using our service!');
    }
}
