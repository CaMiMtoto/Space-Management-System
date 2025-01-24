<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Department;
use App\Models\User;
use App\Notifications\UserCreated;
use App\Services\RoleService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;
use Yajra\DataTables\Exceptions\Exception;

class UsersController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function index(RoleService $roleService)
    {
        if (\request()->ajax()) {
            return datatables()->of(User::select('*'))
                ->addColumn('action', function (User $user) {
                    return view('admin.users.action', compact('user'));
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $roles = $this->roleService->getAllRoles();
        $departments = Department::all();
        return view('admin.users.list', [
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email',
                Rule::unique('users')->ignore($request->id),
            ],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'integer', 'exists:roles,id'],
            'phone' => ['required', 'string', 'max:255'],
            'is_admin' => ['nullable']
        ]);

        $id = $request->input('id');
        DB::beginTransaction();
        $random = Str::random(5);
        $user = User::updateOrCreate(['id' => $id], [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone'),
            'password' => Hash::make($random),
            'is_admin' => $request->input('is_admin') == 'on'
        ]);

        $user->roles()->sync($request->input('roles'));

        if (!$id || $id == 0) {
            $user->notify(new UserCreated($user, $random));
        }
        DB::commit();
        return response()->json([
            'message' => 'User saved successfully',
            'user' => $user,
        ]);
    }

    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        $user->permissions()->detach();
        $user->roles()->detach();
        $user->delete();
        DB::commit();
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    public function show(User $user)
    {
        return $user->load('roles');
    }

    /**
     * @throws Throwable
     */
    public function import(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            Excel::import(new UsersImport, $request->file('file'));
            DB::commit();
            return redirect()->back()->with('success', 'Users imported successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }
    }


}
