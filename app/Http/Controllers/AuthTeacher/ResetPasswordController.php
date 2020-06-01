<?php

namespace App\Http\Controllers\AuthTeacher;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = 'teacher/home';

    public function __construct()
    {
        $this->middleware('guest:teacher');
    }

    public function guard()
    {
        return Auth::guard('teacher');
    }

    public function broker()
    {
        return Password::broker('teachers');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('teacher.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
