<?php

namespace App\Console\Commands;

use App\Constants\Status;
use App\Models\Booking;
use App\Notifications\BookingAutoApprovedNotification;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Carbon;

class ApprovePendingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:auto-approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically approve pending bookings after a configurable number of hours.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Get the number of hours from the command argument or config (default to 2 hours)
        $hours = config('bookings.auto_approval_hours', 2);

        // Calculate the time threshold
        $thresholdTime = Carbon::now()->subHours($hours);

        // Find pending bookings created before the threshold time
        $pendingBookings = Booking::query()
            ->where('status', '=', Status::Pending)
            ->where('created_at', '<=', $thresholdTime) // Uncomment this line to filter correctly
            ->limit(5) // Limiting to 5 for performance in case of a large number of bookings
            ->get();

        $bookingCount = $pendingBookings->count();
        if ($bookingCount === 0) {
            $this->info('No pending bookings to approve.');
            return;
        }

        $this->info("Approving {$bookingCount} pending bookings:");

        // Approve each pending booking
        foreach ($pendingBookings as $booking) {
            $booking->status = Status::Approved;
            $booking->reviewed_at = Carbon::now();
            $booking->approval_type = 'auto';
            $booking->save();

            // Ensure the booking has a user to notify
            if ($booking->user) {
                $booking->user->notify(new BookingAutoApprovedNotification($booking));
                $this->info("Booking ID {$booking->id} has been auto-approved, and user has been notified.");
            } else {
                $this->warn("Booking ID {$booking->id} has been auto-approved, but no user was found to notify.");
            }
        }

        $this->info('Auto-approval of pending bookings completed.');
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'hours' => 'How many hours after which pending bookings should be auto-approved?'
        ];
    }
}
