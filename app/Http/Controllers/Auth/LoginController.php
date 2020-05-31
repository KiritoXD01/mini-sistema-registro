<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostValidation;
use App\Models\StudentLogin;
use App\Models\TeacherLogin;
use App\Models\UserLogin;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;

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

    use ThrottlesLogins;

    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected $maxAttempts = 10;

    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */
    protected $decayMinutes = 5;

    /**
     * Username used in ThrottlesLogins trait
     *
     * @return string
     */
    public function username(){
        return 'email';
    }

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

    public function showAdminLoginForm()
    {
        return view('auth.login');
    }

    public function adminLogin(LoginPostValidation $request)
    {
        if ($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

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
        else
        {
            $this->incrementLoginAttempts($request);

            $error = 'Estas credenciales no coinciden con nuestros registros.';

            return redirect(route('loginForm'))->with('error', $error)->withInput($request->only('email'));
        }
    }

    public function showTeacherLoginForm()
    {
        return view('teacher.login');
    }

    public function teacherLogin(LoginPostValidation $request)
    {
        if ($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

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
        else
        {
            $this->incrementLoginAttempts($request);

            $error = 'Estas credenciales no coinciden con nuestros registros.';

            return redirect(route('teacher.showLoginForm'))->with('error', $error)->withInput($request->only('email'));
        }
    }

    public function showStudentLoginForm()
    {
        return view('student.login');
    }

    public function studentLogin(LoginPostValidation $request)
    {
        if ($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

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
        else
        {
            $this->incrementLoginAttempts($request);

            $error = 'Estas credenciales no coinciden con nuestros registros.';

            return redirect(route('student.showLoginForm'))->with('error', $error)->withInput($request->only('email'));
        }
    }
}
