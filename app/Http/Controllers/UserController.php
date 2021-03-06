<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store', 'export']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store', 'import']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::all();
        $roles = Role::pluck('name')->all();
        return view('user.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::pluck('name')->all();
        return view('user.create', compact('roles'));
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email:rfc', 'max:255', 'unique:users,email,{email}'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data = $request->all();
        $data['email']      = strtolower($data['email']);
        $data['created_by'] = auth()->user()->id;
        $data['password']   = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect(route('user.edit', compact('user')))->with('success', trans('messages.userCreated'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->first()->name;
        return view('user.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email:rfc', 'max:255', Rule::unique('users')->ignoreModel($user)],
            'password' => ['nullable', 'string', 'min:8']
        ])->validate();

        $data             = $request->all();
        $data['email']    = strtolower($data['email']);
        $data['password'] = bcrypt($data['password']);

        $user->update($data);
        $user->syncRoles($data['role']);

        return redirect(route('user.edit', compact('user')))->with('success', trans('messages.userUpdated'));
    }

    public function destroy(Request $request, User $user)
    {
        $user->update($request->all());

        if (trim($request->status) == 0) {
            return redirect(route('user.index'))->with('success', trans('messages.userDeactivated'));
        }
        else {
            return redirect(route('user.index'))->with('success', trans('messages.userActivated'));
        }
    }

    public function import(Request $request)
    {
        for ($i = 0; $i < count($request->email); $i++)
        {
            $user = User::create([
                'name'       => $request->name[$i],
                'email'      => strtolower($request->email[$i]),
                'created_by' => auth()->user()->id,
                'password'   => bcrypt($request->password[$i])
            ]);
            $user->assignRole($request->role[$i]);
        }

        return redirect(route('user.index'))->with('success', trans('messages.usersImported'));
    }

    public function checkEmail(Request $request)
    {
        $emailExists = User::where('email', strtolower($request->email))->exists();

        return response()->json(['email' => $emailExists]);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
