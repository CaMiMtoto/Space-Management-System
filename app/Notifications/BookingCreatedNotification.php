<?php

namespace App\Notifications;

use App\Models\Booking;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
class BookingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Booking $booking;
    protected string $bookingUrl;

    /**
     * Create a new notification instance.
     *
     * @param Booking $booking
     */
    public function __construct(Booking $booking,string $bookingUrl)
    {
        $this->booking = $booking;
        $this->bookingUrl = $bookingUrl;
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
        $bookingUrl = $this->bookingUrl;

        return (new MailMessage)
            ->greeting('Hello ' . $this->booking->guest_name . ',')
            ->line(' Your booking has been successfully created.')
            ->line('Here are your booking details:')
            ->line('Booking Code: ' . $this->booking->booking_code)
            ->line('Booking Date: ' . $this->booking->created_at->format('F d, Y'))
            ->action('View Booking Details', $bookingUrl)
            ->line('Note that you can view your booking also by using that code above.')
            ->line('If you have any questions, feel free to contact us.')
            ->line('Thank you for booking!');
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
