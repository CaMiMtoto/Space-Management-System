<?php

namespace App\Http\Controllers;

use App\Models\BuildingType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Exceptions\Exception;

class BuildingTypeController extends Controller
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {
        if (\request()->ajax()) {
            $data = BuildingType::query();

            return datatables()->eloquent($data)
                ->addColumn('action', function (BuildingType $buildingType) {
                    return view('building_types.action', compact('buildingType'));
                })
                ->rawColumns(['action'])
                ->make(true);

        };
        return view('building_types.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        // slug
        $data['slug'] = Str::slug($data['name'] . '-' . Str::random(5));
        $id = $request->input('id');
        if ($id) {
            $buildingType = BuildingType::query()->findOrFail($id);
            $buildingType->update($data);
        } else {
            BuildingType::query()->create($data);
        }

        return response()->json(['success' => 'Building Type Saved Successfully']);
    }

    public function shoe(BuildingType $buildingType)
    {
        return response()->json($buildingType);
    }

    public function destroy(BuildingType $buildingType)
    {
        $buildingType->delete();
        return response()->json(['success' => 'Building Type Deleted Successfully']);
    }

}
