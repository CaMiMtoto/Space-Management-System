<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Notifications\UserCreated;
use App\Services\RoleService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
        ]);

        $id = $request->input('id');
        DB::beginTransaction();
        $random = Str::random(5);
        $user = User::updateOrCreate(['id' => $id], [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone'),
            'password' => Hash::make($random)
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

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    public function show(User $user)
    {
        return $user->load('roles');
    }


}
