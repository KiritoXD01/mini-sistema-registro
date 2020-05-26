<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:student-list|student-create|student-edit|student-delete', ['only' => ['index','store']]);
        $this->middleware('permission:student-show', ['only' => ['show']]);
        $this->middleware('permission:student-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    public function create()
    {
        return view('student.create');
    }

    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email:rfc', 'max:255', 'unique:students,email,{email}'],
            'password'  => ['required', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data = $request->all();
        $data['email']      = strtolower($data['email']);
        $data['created_by'] = auth()->user()->id;
        $data['code']       = $this->generateCode(6);

        $student = Student::create($data);

        return redirect(route('student.edit', compact('student')))->with('success', trans('messages.studentCreated'));
    }

    public function update(Request $request, Student $student)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email:rfc', 'max:255', Rule::unique('students')->ignoreModel($student)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data = $request->all();
        $data['email'] = strtolower($data['email']);

        $student->update($data);

        return redirect(route('student.edit', compact('student')))->with('success', trans('messages.studentUpdated'));
    }

    public function destroy(Request $request, Student $student)
    {
        $student->update($request->all());

        if (trim($request->status) == 0) {
            return redirect(route('student.index'))->with('success', trans('messages.studentDeactivated'));
        }
        else {
            return redirect(route('student.index'))->with('success', trans('messages.studentActivated'));
        }
    }

    public function home()
    {
        return view('student.home');
    }

    private function generateCode($length = 20)
    {
        $characters = '1234567890abcdefghijklmnpqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
