<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::all();
        return view('userRol.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('userRol.create', compact('permissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('userRol.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'       => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permission' => ['required']
        ])->validate();

        $role = Role::create([
            'name' => strtoupper($request->name)
        ]);

        $role->syncPermissions($request->input('permission'));

        return redirect()
                ->route('role.edit', $role)
                ->with('success', trans('messages.roleCreated'));
    }

    public function update(Request $request, Role $role)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignoreModel($role)]
        ])->validate();

        $role->update([
            'name' => strtoupper($request->name)
        ]);

        $role->syncPermissions($request->input('permission'));

        return redirect(route('role.edit', compact('role')))->with('success', trans('messages.roleUpdated'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect(route('role.index'))->with('success', trans('messages.roleDeleted'));
    }
}
