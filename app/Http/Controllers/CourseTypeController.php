<?php

namespace App\Http\Controllers;

use App\Models\CourseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseTypeController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:course-type-list|course-type-create|course-type-edit|course-type-delete', ['only' => ['index','store']]);
        $this->middleware('permission:course-type-show', ['only' => ['show']]);
        $this->middleware('permission:course-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:course-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:course-type-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $courseTypes = CourseType::all();
        return view('courseType.index', compact('courseTypes'));
    }

    public function create()
    {
        return view('courseType.create');
    }

    public function show(CourseType $courseType)
    {
        return view('courseType.show', compact('courseType'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:course_types,name']
        ])->validate();

        $data = $request->all();
        $data['name'] = strtoupper($data['name']);

        $courseType = CourseType::create($data);

        return redirect(route('courseType.edit', compact('courseType')))->with('success', trans('messages.courseTypeCreated'));
    }

    public function edit(CourseType $courseType)
    {
        return view('courseType.edit', compact('courseType'));
    }

    public function update(Request $request, CourseType $courseType)
    {
        $data = $request->all();
        $data['name'] = strtoupper($data['name']);

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255', Rule::unique('course_types')->ignoreModel($courseType)]
        ])->validate();

        $courseType->update($data);

        return redirect(route('courseType.edit', compact('courseType')))->with('success', trans('messages.courseTypeUpdated'));
    }

    public function destroy(Request $request, CourseType $courseType)
    {
        $courseType->update($request->all());

        if (trim($request->status) == 0)
        {
            return redirect(route('courseType.index'))->with('success', trans('messages.courseTypeDeactivated'));
        }
        else
        {
            return redirect(route('courseType.index'))->with('success', trans('messages.courseTypeActivated'));
        }
    }
}
