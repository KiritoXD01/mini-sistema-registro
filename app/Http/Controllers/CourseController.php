<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudySubject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index','store']]);
        $this->middleware('permission:course-create', ['only' => ['create','store']]);
        $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:course-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $courses = Course::all();
        return view('course.index', compact('courses'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $studySubjects = StudySubject::all();
        return view('course.create', compact('teachers', 'studySubjects'));
    }

    public function edit(Course $course)
    {
        $teachers = Teacher::all();
        $studySubjects = StudySubject::all();
        $students = Student::whereNotIn('id', $course->students->pluck('id')->all())->get();
        return view('course.edit', compact('course', 'teachers', 'studySubjects', 'students'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:courses,name'],
            'code' => ['required', 'string', 'max:255', 'unique:courses,code']
        ])->validate();

        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $data['code'] = strtoupper(Str::slug($data['code']));

        $course = Course::create($data);

        return redirect(route('course.edit', compact('course')))->with('success', trans('messages.courseCreated'));
    }

    public function update(Request $request, Course $course)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('courses')->ignoreModel($course)],
            'code' => ['required', 'string', 'max:255', Rule::unique('courses')->ignoreModel($course)]
        ])->validate();

        $data = $request->all();
        $data['code'] = strtoupper(Str::slug($data['code']));

        $course->update($data);

        return redirect(route('course.edit', compact('course')))->with('success', trans('messages.courseUpdated'));
    }

    public function destroy(Request $request, Course $course)
    {
        $course->update($request->all());

        if (trim($request->status) == 0) {
            return redirect(route('course.index'))->with('success', trans('messages.courseDeactivated'));
        }
        else {
            return redirect(route('course.index'))->with('success', trans('messages.courseActivated'));
        }
    }

    public function addStudent(Request $request, Course $course)
    {
        $course->students()->create([
            "student_id"  => $request->student_id,
            "assigned_by" => auth()->user()->id
        ]);

        return redirect(route('course.edit', compact('course')))->with('success', trans('messages.studentAdded'));
    }
}
