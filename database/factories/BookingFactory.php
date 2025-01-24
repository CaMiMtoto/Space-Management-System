<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        // Generate a random end date that is in the past or future
        $endDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $startDate = $this->faker->dateTimeBetween('-2 months', $endDate);

        // Generate a random status
        $statuses = ['Approved', 'Rejected', 'Pending'];
        $status = $this->faker->randomElement($statuses);

        $isGuestBooking = $this->faker->boolean();
        $id = Room::query()->inRandomOrder()->first()->id;
        return [
            'room_id' => $id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'purpose' => $this->faker->paragraph(),
            'user_id' => User::query()->inRandomOrder()->first()->id,// Assuming you have a User factory
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'check_in_date' => $startDate,
            'check_out_date' => $endDate,
            'check_in_time' => $this->faker->time("H"),
            'check_out_time' => $this->faker->time("H"),
            'guests' => random_int(1, 10),
            'is_guest_booking' => $isGuestBooking,
            'guest_name' => $isGuestBooking ? $this->faker->name : null,
            'guest_email' => $isGuestBooking ? $this->faker->email : null,
            'guest_phone' => $isGuestBooking ? $this->faker->phoneNumber : null,
            'booking_code' => "BKG".$id.$this->faker->randomNumber(3).now()->format('Ymds'),
        ];
    }
}
