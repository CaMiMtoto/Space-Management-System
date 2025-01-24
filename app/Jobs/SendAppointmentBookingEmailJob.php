<?php

namespace App\Jobs;

use App\Mail\AppointmentBookingEmail;
use App\Models\AppointmentBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAppointmentBookingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected AppointmentBooking $appointmentBooking;

    /**
     * Create a new job instance.
     */
    public function __construct(AppointmentBooking $appointmentBooking)
    {
        $this->appointmentBooking = $appointmentBooking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send the email using Laravel's Mail facade and the BookingEmail Mailable
        Mail::to($this->appointmentBooking->email)
            ->send(new AppointmentBookingEmail($this->appointmentBooking));
    }
}
