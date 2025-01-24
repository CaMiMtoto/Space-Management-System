<?php

namespace App\Http\Requests;

use App\Constants\Permission;
use App\Constants\Status;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateStoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $nowHour = now()->hour;
        return [
            'room_type_id' => ['required', 'exists:room_types,id',
                function ($attribute, $value, $fail) {
                    $roomType = RoomType::where('id', $value)
                        ->first();

                    if ($roomType && $roomType->is_vip && auth()->user()->cannot(Permission::BOOK_VIP_ROOMS)) {
                        $fail('VIP rooms cannot be booked directly. Please contact the admin for assistance.');
                    }
                    // get max booking days
                    $maxBookingDays = $roomType->max_booking_days;
                    // get check in date time and check out date time
                    $start_date = $this->input('check_in_date') . ' ' . $this->input('check_in_time') . ':00';
                    $end_date = $this->input('check_out_date') . ' ' . $this->input('check_out_time') . ':00';
                    // get the difference between check in and check out date
                    $diff = strtotime($end_date) - strtotime($start_date);
                    $days = $diff / (60 * 60 * 24);
                    if ($days > $maxBookingDays) {
                        $fail('The maximum booking days for this room type is ' . $maxBookingDays . ' days.');
                    }
                }
            ],
            'guests' => ['required', 'integer', 'min:1'],
            'room_id' => [
                'required', 'exists:rooms,id',
                // Check if the room is available for the selected dates
                function ($attribute, $value, $fail) {
                    $this->validateRoomBookings($value, $fail);
                }

            ],
            'check_in_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:check_in_date'],
            'check_in_time' => ['required', 'date_format:H'],
            'check_out_time' => ['required', 'date_format:H',
                // validate that check_out_date and check_out_time are after check_in_date and check_in_time
                function ($attribute, $value, $fail) {
                    // Combine check-in date and time into one DateTime object
                    $checkInDateTime = strtotime($this->input('check_in_date') . ' ' . $this->input('check_in_time') . ':00');
                    // Combine check-out date and time into one DateTime object
                    $checkOutDateTime = strtotime($this->input('check_out_date') . ' ' . $value . ':00');

                    if ($checkOutDateTime <= $checkInDateTime) {
                        $fail('The check-out date and time must be after the check-in date and time.');
                    }
                }
            ],
            'is_guest_booking' => ['nullable', 'string'],
            'guest_name' => ['nullable', 'required_if:is_guest_booking,on', 'string'],
            'guest_email' => ['nullable', 'required_if:is_guest_booking,on', 'email'],
            'guest_phone' => ['nullable', 'required_if:is_guest_booking,on', 'string'],
            'purpose' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'room_type_id.required' => 'Please select a room type.',
            'room_type-id.exists' => 'The selected room type does not exist.',
            'guests.required' => 'Please enter the number of guests.',
            'guests.integer' => 'Please enter a valid number of guests.',
            'guests.min' => 'The minimum number of guests is 1.',
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'room_id.unique' => 'The selected room is already booked for the selected dates.',
            'start_date.required' => 'Please enter the start date and time.',
            'start_date.date_format' => 'Please enter a valid date and time format (YYYY-MM-DD HH:MM).',
            'start_date.after_or_equal' => 'The start date and time must be a future date and time.',
            'end_date.required' => 'Please enter the end date and time.',
            'end_date.date_format' => 'Please enter a valid date and time format (YYYY-MM-DD HH:MM).',
            'end_date.after' => 'The end date and time must be after the start date and time.',
            'is_guest_booking.string' => 'Please enter a valid value for is_guest_booking.',
            'guest_name.required_if' => 'Please enter the guest name.',
            'guest_name.string' => 'Please enter a valid guest name.',
            'guest_email.required_if' => 'Please enter the guest email.',
            'guest_email.email' => 'Please enter a valid guest email.',
            'guest_phone.required_if' => 'Please enter the guest phone number.',
            'guest_phone.string' => 'Please enter a valid guest phone number.',
            'purpose.required' => 'Please enter the purpose of the booking.',
            'purpose.string' => 'Please enter a valid purpose of the booking.',
        ];
    }

    /**
     * @param $value
     * @param $fail
     * @return void
     */
    function validateRoomBookings($value, $fail): void
    {
        // Step 1: Ensure the room itself is available
        $room = Room::where('id', $value)
            ->where('status', 'available') // Ensure room status is available
            ->first();

        if (!$room) {
            $fail('The room is not available for booking due to its current status.');
            return;
        }

        // Ensure check-in and check-out dates are valid
        $start_date = $this->input('check_in_date') . ' ' . $this->input('check_in_time') . ':00';
        $end_date = $this->input('check_out_date') . ' ' . $this->input('check_out_time') . ':00';

        if (!$start_date || !$end_date) {
            $fail('Please provide both check-in and check-out dates and times.');
            return;
        }

        // Ensure check-in time is not in the past
        if (strtotime($start_date) < strtotime(now())) {
            $fail('The check-in time cannot be in the past. Please select a valid check-in time.');
            return;
        }

        // Ensure the check-out time is after the check-in time
        if (strtotime($start_date) >= strtotime($end_date)) {
            $fail('The check-out time must be later than the check-in time.');
            return;
        }

        // Step 2: Check for overlapping bookings for the room
        $hasOverlappingBookings = $room->bookings()
            ->where(function ($query) use ($start_date, $end_date) {
                $query->where('start_date', '<=', $end_date)
                    ->where('end_date', '>=', $start_date);
            })
            ->whereIn('status', [Status::Approved, Status::Pending]) // Consider only active bookings
            ->exists(); // Check if any such booking exists

        if ($hasOverlappingBookings) {
            $fail('The room is already booked for the selected dates.');
            return;
        }

        // Step 3: Prevent the user from booking another room during the same time period
        $hasUserOverlappingBooking = Booking::where('user_id', auth()->id()) // Assuming the user is logged in
        ->where(function ($query) use ($start_date, $end_date) {
            $query->where('start_date', '<=', $end_date)
                ->where('end_date', '>=', $start_date);
        })
            ->whereIn('status', [Status::Approved, Status::Pending]) // Consider only active bookings
            ->exists();

        if ($hasUserOverlappingBooking) {
            $fail('You already have another room booked for the selected time period.');
        }

    }
}
