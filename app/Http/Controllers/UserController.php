<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /*
     * Protected Variable to handle user repository
     */
    protected $user;

    public function __construct(UserRepository $userRepository)
    {
        //Assign the repository to the user
        $this->user = $userRepository;
    }

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
            'email'    => ['required', 'string', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ])->validate();

        $user = $this->user->create($request->all());

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
            'email'    => ['required', 'string', 'max:255', Rule::unique('users')->ignoreModel($user)],
        ])->validate();

        $this->user->update($request->all(), $user);

        return redirect(route('user.edit', compact('user')))->with('success', trans('messages.userUpdated'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('user.index'))->with('success', trans('messages.userDeleted'));
    }
}
