<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\MaintenanceType;
use App\Models\Room;
use App\Models\RoomMaintenance;
use App\Models\User;
use App\Notifications\MaintenanceScheduled;
use Illuminate\Http\Request;

class RoomMaintenanceController extends Controller
{
    // Create a maintenance record for a room
    /**
     * @throws \Throwable
     */
    public function store(Request $request, Room $room)
    {
        $data = $request->validate([
            'maintenance_type_id' => ['required'],
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        // Check for overlapping maintenance
        $overlap = RoomMaintenance::where('room_id', '=', $room->id)
            ->where('maintenance_type_id', '=', $data['maintenance_type_id'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                    ->orWhere(function ($query) use ($data) {
                        $query->where('start_date', '<=', $data['start_date'])
                            ->where('end_date', '>=', $data['end_date']);
                    });
            })
            ->exists();

        if ($overlap) {
            $message = 'Another maintenance is already scheduled for this room in the selected date range.';
            // return back with error message as laravel validation error
            return response()->json(['error' => $message], 422);
        }
        \DB::beginTransaction();

        $maintenance = $room->maintenances()->create($data);
        // notify admin users
        $adminUsers = User::query()
            ->where('is_admin', '=', true)
            ->get();
        foreach ($adminUsers as $user) {
            $user->notify(new MaintenanceScheduled($maintenance));
        }
        \DB::commit();
        return response()->json(['success' => 'Room maintenance scheduled successfully']);
    }

    // Mark a maintenance as completed
    public function complete(RoomMaintenance $maintenance)
    {
        $maintenance->status = Status::Completed;
        $maintenance->save();
        return response()->json(['success' => 'Room maintenance marked as completed']);
    }

    // Get all maintenances for a room
    public function index(Room $room)
    {
        $sortColumn = request('sort_col', 'created_at');
        $sortDirection = request('sort_dir', 'desc');
        $q = \request('q');

        $maintenances = $room->maintenances()
            ->with('maintenanceType')
            ->when($q, function ($query) use ($q) {
                $query->where('maintenance_type', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                    ->orWhere('status', 'like', "%$q%")
                    ->orWhere('start_date', 'like', "%$q%")
                    ->orWhere('end_date', 'like', "%$q%");
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);
        $maintenanceTypes = MaintenanceType::query()->get();
        return view('rooms.maintenances', compact('room', 'maintenances', 'maintenanceTypes'));
    }

    public function destroy(RoomMaintenance $maintenance)
    {
        $maintenance->delete();
        if (\request()->ajax()) {
            return response()->json(['success' => 'Room maintenance deleted successfully']);
        }
        return back()->with('success', 'Room maintenance deleted successfully');
    }
}
