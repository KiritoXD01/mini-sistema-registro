<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:teacher-list|teacher-create|teacher-edit|teacher-delete', ['only' => ['index','store']]);
        $this->middleware('permission:teacher-create', ['only' => ['create','store']]);
        $this->middleware('permission:teacher-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:teacher-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $teachers = Teacher::all();
        return view('teacher.index', compact('teachers'));
    }

    public function create()
    {
        return view('teacher.create');
    }

    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email:rfc', 'max:255', 'unique:teachers,email,{email}'],
            'password'  => ['required', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data = $request->all();
        $data['email']      = strtolower($data['email']);
        $data['created_by'] = auth()->user()->id;
        $data['code']       = $this->generateCode(6);

        $teacher = Teacher::create($data);

        return redirect(route('teacher.edit', compact('teacher')))->with('success', trans('messages.teacherCreated'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email:rfc', 'max:255', Rule::unique('teachers')->ignoreModel($teacher)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data = $request->all();
        $data['email'] = strtolower($data['email']);

        $teacher->update($data);

        return redirect(route('teacher.edit', compact('teacher')))->with('success', trans('messages.teacherUpdated'));
    }

    public function destroy(Request $request, Teacher $teacher)
    {
        $teacher->update($request->all());

        if (trim($request->status) == 0) {
            return redirect(route('teacher.index'))->with('success', trans('messages.teacherDeactivated'));
        }
        else {
            return redirect(route('teacher.index'))->with('success', trans('messages.teacherActivated'));
        }
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
