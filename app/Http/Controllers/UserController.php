<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
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

        $user = User::create($data);

        return redirect(route('user.edit', compact('user')))->with('success', trans('messages.userCreated'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email:rfc', 'max:255', Rule::unique('users')->ignoreModel($user)],
            'password' => ['nullable', 'string', 'min:8']
        ])->validate();

        $data = $request->all();
        $data['email'] = strtolower($data['email']);

        $user->update($data);

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
}
