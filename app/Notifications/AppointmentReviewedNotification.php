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
    protected string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(AppointmentBooking $appointmentBooking , string $url)
    {
        $this->appointmentBooking = $appointmentBooking;
        $this->url = $url;
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
                ->line('Start Date Time: ' . $this->appointmentBooking->start_date_time->format('d/m/Y H:i'))
                ->line('End Date Time: ' . $this->appointmentBooking->end_date_time->format('d/m/Y H:i'))
                ->line('Contact Person: ' . $this->appointmentBooking->contact_person_name)
                ->line('Contact Number: ' . $this->appointmentBooking->contact_person_phone)
                ->line('Contact Email: ' . $this->appointmentBooking->contact_person_email)
                ->action('View Appointment Details', $this->url)
                ->line('Thank you !.');
        }
        return (new MailMessage)
            ->subject('Appointment Reviewed')
            ->greeting('Hello!' . $this->appointmentBooking->name)
            ->line('Your appointment has been reviewed.')
            ->line('Unfortunately, your appointment has been rejected.')
            ->action('View Appointment Details', $this->url)
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
