<?php

namespace App\Services;

use App\Models\Booking;

class BookingFilterService
{
    /**
     * Apply filters to the Booking query.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filterBookings(array $filters)
    {
        $startDate = $filters['start_date'] ?? null;
        $endDate = $filters['end_date'] ?? null;
        $roomType = $filters['room_type'] ?? null;
        $status = $filters['status'] ?? null;

        $query = Booking::query()
            ->with(['room.building', 'room.roomType']);

        // Apply filters
        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('end_date', '<=', $endDate);
        }

        if ($roomType) {
            $query->whereHas('room', function ($query) use ($roomType) {
                $query->where('room_type_id', $roomType);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }
}
