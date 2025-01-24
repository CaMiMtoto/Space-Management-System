<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {
        if (\request()->ajax()) {
            $data = Room::query()->with('roomType', 'building');
            return datatables()->eloquent($data)
                ->addColumn('action', function (Room $room) {
                    return view('rooms.action', compact('room'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $roomTypes = RoomType::all();
        $buildings = Building::all();

        $services = Service::query()->latest()->get();

        return view('rooms.index', [
            'roomTypes' => $roomTypes,
            'buildings' => $buildings,
            'services' => $services
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['nullable'], // Used for updateOrCreate
            'name' => ['required', 'string'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'building_id' => ['required', 'exists:buildings,id'],
            'floor' => [
                'required', 'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    $building = Building::query()->find($request->building_id);

                    if ($building && $value > $building->floors) {
                        $fail('The floor must not be greater than the building\'s number of floors (' . $building->floors . ').');
                    }
                },
                function ($attribute, $value, $fail) use ($request) {
                    $room = Room::query()
                        ->where('building_id', $request->building_id)
                        ->where('floor', $value)
                        ->where('room_number', $request->room_number)
                        ->first();

                    if ($room && $room->id != $request->id) {
                        $fail('The floor and room number have already been taken.');
                    }
                }
            ],
            'room_number' => ['required', 'string'],
            'capacity' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'images' => ['nullable', 'array'], // Ensures images is an array
            'images.*' => ['mimes:jpeg,jpg,png,gif', 'max:2048'], // Validates each image
            'services' => ['nullable', 'array'], // Ensures services is an array
            'services.*' => ['exists:services,id'] // Validates each service id
        ]);

        DB::beginTransaction();

        try {
            // Create or update the Room record
            unset($data['images']); // Remove images from the data array
            $services = $data['services'] ?? []; // Get the services array
            unset($data['services']); // Remove services from the data array
            $model = Room::query()->updateOrCreate(['id' => $data['id']], $data);
            // Attach services
            if ($request->has('services')) {
                $model->services()->sync($services);
            }
            // Handle image uploads
            if ($request->hasFile('images')) {
                // remove existing images
                $model->clearMediaCollection('images');
                $model->addMultipleMediaFromRequest(['images'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('images');
                    });
            }

            DB::commit();

            // Return success response
            if ($request->ajax()) {
                return response()->json(['success' => 'Room saved successfully']);
            }

            return back()->with('success', 'Room saved successfully');

        } catch (\Exception $e) {
            // Rollback on any exception and return a generic error response
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while saving the room.' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $room->load('roomType', 'building');

        return response()->json($room);
    }


    /**
     * Remove the specified resource from storage.
     * @throws \Throwable
     */
    public function destroy(Room $room)
    {
        DB::beginTransaction();
        $room->clearMediaCollection('images');

        $room->delete();

        DB::commit();
        return response()->json(['success' => 'Room deleted successfully']);
    }

    public function details(Room $room)
    {
        $room->load('roomType', 'building');

        return view('rooms._details', compact('room'));
    }

    public function rooms(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'guests' => ['required']
        ]);

        $type = $data['type'];
        $guests = $data['guests'];
        // find rooms with the given type and capacity
        $rooms = Room::query()
            ->where('room_type_id', '=', $type)
            ->where('capacity', '>=', $guests)
            ->get();
        return response()->json($rooms);
    }
}
