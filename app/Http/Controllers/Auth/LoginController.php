<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\StudentLogin;
use App\Models\TeacherLogin;
use App\Models\UserLogin;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:teacher')->except('logout');
        $this->middleware('guest:student')->except('logout');
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function hasTooManyLoginAttempts(Request $request)
    {
        $attempts = 5;
        $lockoutMinites = 5;
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $attempts, $lockoutMinites
        );
    }

    public function showAdminLoginForm()
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {
        Validator::make($request->all(), [
            'email'    => ['required', 'email:rfc'],
            'password' => ['required']
        ])->validate();

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => true
        ];

        if (Auth::attempt($credentials)) {
            UserLogin::create([
                "user_id" => Auth::user()->id
            ]);
            return redirect()->intended(route('home'));
        }

        $error = 'Estas credenciales no coinciden con nuestros registros.';

        return redirect(route('loginForm'))->with('error', $error)->withInput($request->only('email'));
    }

    public function showTeacherLoginForm()
    {
        return view('teacher.login');
    }

    public function teacherLogin(Request $request)
    {
        Validator::make($request->all(), [
            'email'    => ['required', 'email:rfc'],
            'password' => ['required']
        ])->validate();

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => true
        ];

        if (Auth::guard('teacher')->attempt($credentials)) {
            TeacherLogin::create([
                'teacher_id' => Auth::guard('teacher')->user()->id
            ]);
            return redirect()->intended(route('teacher.home'));
        }

        $error = 'Estas credenciales no coinciden con nuestros registros.';

        return redirect(route('teacher.showLoginForm'))->with('error', $error)->withInput($request->only('email'));
    }

    public function showStudentLoginForm()
    {
        return view('student.login');
    }

    public function studentLogin(Request $request)
    {
        Validator::make($request->all(), [
            'email'    => ['required', 'email:rfc'],
            'password' => ['required']
        ])->validate();

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => true
        ];

        if (Auth::guard('student')->attempt($credentials)) {
            StudentLogin::create([
                'student_id' => Auth::guard('student')->user()->id
            ]);
            return redirect()->intended(route('student.home'));
        }

        $error = 'Estas credenciales no coinciden con nuestros registros.';

        return redirect(route('student.showLoginForm'))->with('error', $error)->withInput($request->only('email'));
    }
}
