<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Exceptions\Exception;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {

        if (\request()->ajax()) {
            $data = Building::query()->with('buildingType');
            return datatables()->eloquent($data)
                ->addColumn('action', function (Building $building) {
                    return view('buildings.action', compact('building'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $buildingTypes = BuildingType::all();
        return view('buildings.index', compact('buildingTypes'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate the input
        $data = $request->validate([
            'id' => ['nullable'], // Used for updateOrCreate
            'name' => ['required', 'string'],
            'building_type_id' => ['required', 'exists:building_types,id'],
            'floors' => ['nullable', 'numeric'],
            'rooms' => ['nullable', 'numeric'],
            'address' => ['required', 'string'],
            'intended_use' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'images' => ['nullable'], // Ensures images is an array
            'images.*' => ['mimes:jpeg,jpg,png,gif', 'max:2048'], // Validates each image
        ]);

        // Create a slug if id is not provided (new building)
        if (!$data['id']) {
            $data['slug'] = Str::slug($data['name'] . '-' . Str::random(5));
        }

        // Start a transaction
        DB::beginTransaction();

        try {
            // Create or update the building record
            unset($data['images']);
            $model = Building::query()->updateOrCreate(['id' => $data['id']], $data);

            // Attach images using Spatie Media Library
            if ($request->hasFile('images')) {
                // remove existing images
                $model->clearMediaCollection('images');
                $model->addMultipleMediaFromRequest(['images'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('images');
                    });
            }

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => 'Building saved successfully'], 200);

        } catch (\Exception $e) {
            // Rollback on any general error
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while saving the building.'.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $building->load('buildingType');
        return response()->json($building);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return response()->json(['success' => 'Building deleted successfully']);
    }
}
