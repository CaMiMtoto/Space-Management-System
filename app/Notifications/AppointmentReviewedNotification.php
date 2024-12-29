<?php

namespace App\Notifications;

use App\Constants\Status;
use App\Models\AppointmentBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReviewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected AppointmentBooking $appointmentBooking;

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
        $name = $this->appointmentBooking->name;
        if ($this->appointmentBooking->status == Status::Approved) {
            return (new MailMessage)
                ->subject('Appointment Reviewed')
                ->greeting('Hello!' . $this->appointmentBooking->name)
                ->line('Your appointment has been reviewed.')
                ->line('Please check the details below:')
                ->line('Date: ' . $this->appointmentBooking->date->format('d/m/Y'))
                ->line('Contact Person: ' . $this->appointmentBooking->contact_person_name)
                ->line('Contact Number: ' . $this->appointmentBooking->contact_person_phone)
                ->line('Contact Email: ' . $this->appointmentBooking->contact_person_email)
                ->line('Thank you !.');
        }
        return (new MailMessage)
            ->subject('Appointment Reviewed')
            ->greeting('Hello!' . $this->appointmentBooking->name)
            ->line('Your appointment has been reviewed.')
            ->line('Unfortunately, your appointment has been rejected.')
            ->line('If you have any questions, please contact us.')
            ->line('Thank you !.');
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
