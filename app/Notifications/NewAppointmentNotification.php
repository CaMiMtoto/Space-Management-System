<?php

namespace App\Notifications;

use App\Models\AppointmentBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private AppointmentBooking $appointmentBooking;

    /**
     * Create a new notification instance.
     */
    public function __construct(AppointmentBooking $appointmentBooking)
    {
        $this->appointmentBooking = $appointmentBooking;
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
        return (new MailMessage)
            ->subject('New Appointment')
            ->greeting('Hello!')
            ->line('A new appointment has been booked.')
            ->line('Appointment Details:')
            ->line('Start Date:' . $this->appointmentBooking->start_date_time)
            ->line('End Date:' . $this->appointmentBooking->end_date_time)
            ->line('Name:' . $this->appointmentBooking->name)
            ->line('Email:' . $this->appointmentBooking->email)
            ->line('Phone:' . $this->appointmentBooking->phone)
            ->line('Address:' . $this->appointmentBooking->address)
            ->line('Organization:' . $this->appointmentBooking->organization)
            ->action('Login for Details', url('/login'))
            ->line('Thank you for using our application!');

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
