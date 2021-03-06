<?php

namespace App\Http\Controllers\AuthTeacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:teacher');
    }

    public function broker()
    {
        return Password::broker('teachers');
    }

    public function showLinkRequestForm()
    {
        return view('teacher.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $teacher = Teacher::where('email', $request->email)->first();

        if (!$teacher->status) {
            return redirect()->back()->with('error', trans('messages.accountDisabled'));
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? redirect(route('teacher.showLoginForm'))
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
