<?php

namespace App\Http\Controllers\AuthStudent;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = 'student/home';

    public function __construct()
    {
        $this->middleware('guest:student');
    }

    public function guard()
    {
        return Auth::guard('student');
    }

    public function broker()
    {
        return Password::broker('students');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('student.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
