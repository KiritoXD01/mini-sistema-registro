<?php

namespace App\Http\Controllers;

use App\Enums\CourseModality;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\CourseType;
use App\Models\Institution;
use App\Models\Student;
use App\Models\StudySubject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade as PDF;

class CourseController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        if (Auth::check()) {
            $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index','store']]);
            $this->middleware('permission:course-show', ['only' => ['show']]);
            $this->middleware('permission:course-create', ['only' => ['create','store']]);
            $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
            $this->middleware('permission:course-delete', ['only' => ['destroy']]);
            $this->middleware('permission:course-students', ['only' => ['addStudent', 'removeStudent']]);
            $this->middleware('permission:course-points', ['only' => ['updatePoints']]);
            $this->middleware('permission:course-certification', ['only' => ['getCertification']]);
        }
    }

    public function index()
    {
        if (Auth::guard('teacher')->check())
        {
            $courses = Course::where([
                                    ['teacher_id', Auth::guard('teacher')->user()->id],
                                    ['status', true]
                                ])->get();
            return view('course.index', compact('courses'));
        }
        elseif(Auth::guard('student')->check())
        {
            $courses = Auth::guard('student')->user()->courses;
            return view('student.course', compact('courses'));
        }
        else
        {
            $courses = Course::all();
            return view('course.index', compact('courses'));
        }
    }

    public function create()
    {
        $teachers = Teacher::where('status', true)->get();
        $studySubjects = StudySubject::where('status', true)->get();
        $courseTypes = CourseType::where('status', true)->get();
        $courseModalities = CourseModality::getItems();
        $countries = Country::where('status', true)->orderBy('name', 'asc')->get();
        $cities = City::where('status', true)->orderBy('name', 'asc')->get();
        return view('course.create', compact('teachers', 'studySubjects', 'courseTypes', 'courseModalities', 'countries', 'cities'));
    }

    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $teachers = Teacher::where('status', true)->get();
        $studySubjects = StudySubject::where('status', true)->get();
        $students = Student::whereNotIn('id', $course->students->pluck('student_id'))->where('status', true)->orderBy("firstname", "desc")->get();
        $courseTypes = CourseType::where('status', true)->get();
        $courseModalities = CourseModality::getItems();
        $countries = Country::where('status', true)->orderBy('name', 'asc')->get();
        $cities = City::where('status', true)->orderBy('name', 'asc')->get();
        return view('course.edit', compact('course', 'teachers', 'studySubjects', 'students', 'courseTypes', 'courseModalities', 'countries', 'cities'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'               => ['required', 'string', 'max:255', 'unique:courses,name'],
            'code'               => ['required', 'string', 'max:255', 'unique:courses,code'],
            'teacher_id'         => ['required'],
            'study_subject_id'   => ['required'],
            'close_points'       => ['required', 'date'],
            'hour_count'         => ['required', 'numeric', 'min:1'],
            'course_type_id'     => ['required'],
            'course_modality_id' => ['required'],
            'start_date'         => ['required'],
            'end_date'           => ['required']
        ])->validate();

        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $data['code']       = strtoupper(Str::slug($data['code']));

        $course = Course::create($data);

        return redirect(route('course.edit', compact('course')))->with('success', trans('messages.courseCreated'));
    }

    public function update(Request $request, Course $course)
    {
        Validator::make($request->all(), [
            'name'               => ['required', 'string', 'max:255', Rule::unique('courses')->ignoreModel($course)],
            'code'               => ['required', 'string', 'max:255', Rule::unique('courses')->ignoreModel($course)],
            'teacher_id'         => ['required'],
            'study_subject_id'   => ['required'],
            'close_points'       => ['required', 'date'],
            'hour_count'         => ['required', 'numeric', 'min:1'],
            'course_type_id'     => ['required'],
            'course_modality_id' => ['required'],
            'start_date'         => ['required'],
            'end_date'           => ['required']
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
        foreach($request->student_id as $student)
        {
            $course->students()->create([
                "student_id"  => $student,
                "assigned_by" => auth()->user()->id
            ]);
        }

        return redirect(route('course.edit', compact('course')))->with('success', trans('messages.studentAdded'));
    }

    public function removeStudent(Request $request, Course $course)
    {
        CourseStudent::where([
            ['course_id', $course->id],
            ['student_id', $request->student_id]
        ])->delete();

        return redirect(route('course.edit', compact('course')))->with('success', trans('messages.studentRemoved'));
    }

    public function updatePoints(Request $request, Course $course)
    {
        if (Auth::guard('teacher')->check())
        {
            $today = date('Y-m-d');

            if ($today > $course->close_points)
            {
                return redirect(route('course.edit', compact('course')))->with('unableToPoint', trans('messages.unableToPoint'));
            }
            else
            {
                CourseStudent
                    ::where([
                        ['course_id', $course->id],
                        ['student_id', $request->student_id]
                    ])
                    ->update([
                        'points' => $request->points
                    ]);

                return redirect(route('course.edit', compact('course')))->with('success', trans('messages.pointsUpdated'));
            }
        }
        else
        {
            CourseStudent
                ::where([
                    ['course_id', $course->id],
                    ['student_id', $request->student_id]
                ])
                ->update([
                    'points' => $request->points
                ]);

            return redirect(route('course.edit', compact('course')))->with('success', trans('messages.pointsUpdated'));
        }
    }

    public function getCertification(CourseStudent $courseStudent)
    {
        $data = [
            'course'      => $courseStudent->course,
            'points'      => $courseStudent->points,
            'student'     => $courseStudent->student,
            'institution' => Institution::first(),
            'teacher'     => $courseStudent->course->teacher,
            "status"      => $courseStudent->points <= 69 ? "asistido" : "aprobado"
        ];

        $pdf = PDF::loadView('certificates.student', $data);
        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream();
    }

    public function checkCertification(Request $request, Course $course, Student $student)
    {
        $isValid = CourseStudent::where([
            ["course_id", $course->id],
            ["student_id", $student->id]
        ])->exists();

        if ($isValid)
        {
            $courseStudent = CourseStudent::where([
                ["course_id", $course->id],
                ["student_id", $student->id]
            ])->first();

            $data = [
                'course'      => $courseStudent->course,
                'points'      => $courseStudent->points,
                'student'     => $courseStudent->student,
                'institution' => Institution::first(),
                'teacher'     => $courseStudent->course->teacher
            ];

            $pdf = PDF::loadView('certificates.student', $data);
            $pdf->setPaper('letter', 'landscape');
            return $pdf->stream();
        }
        else
        {
            return abort(404);
        }
    }
}
