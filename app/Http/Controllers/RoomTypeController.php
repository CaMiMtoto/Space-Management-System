<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Exceptions\Exception;

class RoomTypeController extends Controller
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {
        if (\request()->ajax()) {
            $data = RoomType::query();
            return datatables()->eloquent($data)
                ->addColumn('action', function (RoomType $roomType) {
                    return view('room_types.action', compact('roomType'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('room_types.index');
    }

    public function store(Request $request)
    {
        // Validate the input
        $data = $request->validate([
            'id' => ['nullable'], // Used for updateOrCreate
            'name' => ['required', 'string'],
            'is_vip' => ['nullable'],
            'max_booking_days'=> ['nullable'],
        ]);

        $data['is_vip'] = $request->input('is_vip') == 'on' ? 1 : 0;

        // Create a slug if id is not provided (new building)
        if ($data['id'] == 0) {
            $data['slug'] = Str::slug($data['name'] . '-' . Str::random(6));
        }

        // Store the building
        RoomType::query()->updateOrCreate(['id' => $data['id']], $data);

        if ($request->ajax()) {
            return response()->json(['success' => 'Room Type saved successfully']);
        }

        return back()->with('success', 'Room Type saved successfully');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return response()->json(['success' => 'Room Type deleted successfully']);
    }

    public function show(RoomType $roomType)
    {
        return response()->json($roomType);
    }
}
