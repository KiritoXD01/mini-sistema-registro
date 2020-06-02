<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudySubject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $userRoles = Role::count();
        $teachers = Teacher::count();
        $students = Student::count();
        $courses = Course::count();
        $studySubjects = StudySubject::count();
        return view('admin.home', compact('users', 'userRoles', 'teachers', 'students', 'courses', 'studySubjects'));
    }

    /**
     * Change the application language
     * @param $language
     */
    public function changeLanguage($language)
    {
        session(['locale' => $language]);
        return redirect()->back();
    }
}
