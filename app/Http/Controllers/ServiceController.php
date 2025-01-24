<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {
        if (\request()->ajax()) {
            $data = Service::query();
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $edit_url = route('admin.settings.services.show', $data->id);
                    $delete_url = route('admin.settings.services.destroy', $data->id);
                    return "<a href='$edit_url' class='js-edit btn btn-light-primary btn-icon btn-sm'><i class='bi bi-pencil'></i></a>
                            <a href='$delete_url' class='js-delete btn btn-light-danger btn-icon btn-sm'><i class='bi bi-trash'></i></a>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('services.index');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255', 'unique:services,name,' . $request->id],
            'fee' => ['required', 'numeric'],
        ]);

        $id = $request->id;
        if ($id) {
            $service = Service::find($id);
            $service->update($data);
        } else {
            Service::create($data);
        }
        if ($request->ajax())
            return response()->json(['success' => 'Service has been saved successfully']);
        return redirect()->route('admin.settings.services.index')->with('success', 'Service has been saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return $service;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        if (\request()->ajax())
            return response()->json(['success' => 'Service has been deleted successfully']);
        return redirect()->route('admin.settings.services.index')->with('success', 'Service has been deleted successfully');
    }
}
