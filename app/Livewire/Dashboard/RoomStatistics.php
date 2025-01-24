<?php

namespace App\Livewire\Dashboard;

use App\Constants\Status;
use App\Models\Booking;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class RoomStatistics extends Component
{

    public int $totalRooms = 0;
    public int $availableRooms = 0;
    public int $underMaintenance = 0;

    public function render(): Factory|Application|\Illuminate\Contracts\View\View|View
    {
        $this->totalRooms = Room::count();

        // Today's available rooms, considering time
        $this->availableRooms = $this->getAvailableRooms();


        $this->underMaintenance = Room::whereHas('maintenances', function ($query) {
            $query->where('start_date', '<=', now())->where('end_date', '>=', now());
        })->count();

        $totalBookings = Booking::query()->where('status', '=', Status::Approved)->count();
        return view('livewire.dashboard.room-statistics', compact('totalBookings'));
    }

    /**
     * @return int
     */
    public function getAvailableRooms(): int
    {
        return Room::whereDoesntHave('maintenances', function ($query) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('start_date', '<=', now()) // Maintenance started before or at now
                    ->where('end_date', '>=', now());  // Maintenance ends after or at now
                })
                    ->orWhere(function ($query) {
                        $query->whereDate('start_date', '=', today()) // Maintenance starts today
                        ->orWhereDate('end_date', '=', today()); // Maintenance ends today
                    });
            });
        })
            ->whereDoesntHave('bookings', function ($query) {
                $query->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('start_date', '<=', now()) // Booking started before or at now
                        ->where('end_date', '>=', now());  // Booking ends after or at now
                    })
                        ->orWhere(function ($query) {
                            $query->whereDate('start_date', '=', today()) // Booking starts today
                            ->orWhereDate('end_date', '=', today()); // Booking ends today
                        });
                })
                    ->whereNotIn('status', [Status::Approved, Status::Pending]); // Consider only active bookings
            })
            ->count();
    }
}
