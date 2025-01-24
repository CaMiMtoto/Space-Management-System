<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomReportsController extends Controller
{
    // Room Utilization Report
    public function roomUtilizationReport()
    {
        $startDate = \request('start_date');
        $endDate = \request('end_date');


        if (\request()->ajax()) {
            $roomUtilization = Booking::query()
                ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                ->addSelect(DB::raw('rooms.name as room_number, COUNT(*) as booking_count, SUM(TIMESTAMPDIFF(HOUR, start_date, end_date)) as total_hours_booked'))
                ->whereIn('bookings.status', ['Approved', 'Completed']) // Only count approved/completed bookings
                ->groupBy('rooms.name')
                ->having('booking_count', '>', 0)
                ->orderBy('total_hours_booked', 'desc')
                ->limit(10)
                ->get();
            return response()->json($roomUtilization);
        }
        $roomUtilization = Booking::query()
            ->with(['room.building', 'room.roomType'])
            ->addSelect(DB::raw('room_id, COUNT(*) as booking_count, SUM(TIMESTAMPDIFF(HOUR, start_date, end_date)) as total_hours_booked'))
            ->whereIn('status', ['Approved', 'Completed']) // Only count approved/completed bookings
            ->when($startDate, fn($query) => $query->where('start_date', '>=', $startDate))
            ->when($endDate, fn($query) => $query->where('end_date', '<=', $endDate))
            ->groupBy('room_id')
            ->having('booking_count', '>', 0)
            ->get();
        return view('reports.room_utilization', compact('roomUtilization'));
    }

    // Peak Usage Times Report
    public function peakUsageTimes()
    {
        $peakUsageTimes = Booking::select(DB::raw('HOUR(start_date) as hour_of_day, COUNT(*) as booking_count'))
            ->whereIn('status', ['Approved', 'Completed'])
            ->groupBy(DB::raw('HOUR(start_date)'))
            ->orderBy('hour_of_day', 'asc')
            ->get();

        if (\request()->ajax()) {
            return response()->json($peakUsageTimes);
        }
        return view('reports.peak_usage_times', compact('peakUsageTimes'));
    }

    // Popular Rooms Report
    public function popularRooms()
    {
        $popularRooms = Booking::query()
            ->with(['room.building', 'room.roomType'])
            ->addSelect('room_id', DB::raw('COUNT(*) as booking_count'))
            ->whereIn('status', ['Approved', 'Completed'])
            ->groupBy('room_id')
            ->orderBy('booking_count', 'desc')
            ->get();

        if (\request()->ajax()) {
            return response()->json($popularRooms);
        }
        return view('reports.popular_rooms', compact('popularRooms'));
    }
}
