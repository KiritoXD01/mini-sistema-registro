<?php

namespace App\Http\Controllers;

use App\Models\StudySubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudySubjectController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the user permissions for this controller
         */
        $this->middleware('permission:study-subject-list|study-subject-create|study-subject-edit|study-subject-delete', ['only' => ['index','store']]);
        $this->middleware('permission:study-subject-create', ['only' => ['create','store']]);
        $this->middleware('permission:study-subject-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:study-subject-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $studySubjects = StudySubject::all();
        return view('studySubject.index', compact('studySubjects'));
    }

    public function create()
    {
        return view('studySubject.create');
    }

    public function edit(StudySubject $studySubject)
    {
        return view('studySubject.edit', compact('studySubject'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:study_subjects,name'],
            'code' => ['required', 'string', 'max:255', 'unique:study_subjects,code']
        ])->validate();

        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $data['code'] = strtoupper(Str::slug($data['code']));

        $studySubject = StudySubject::create($data);

        return redirect(route('studySubject.edit', compact('studySubject')))->with('success', trans('messages.studySubjectCreated'));
    }

    public function update(Request $request, StudySubject $studySubject)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('study_subjects')->ignoreModel($studySubject)],
            'code' => ['required', 'string', 'max:255', Rule::unique('study_subjects')->ignoreModel($studySubject)]
        ])->validate();

        $data = $request->all();
        $data['code'] = strtoupper(Str::slug($data['code']));

        $studySubject->update($data);

        return redirect(route('studySubject.edit', compact('studySubject')))->with('success', trans('messages.studySubjectUpdated'));
    }

    public function destroy(Request $request, StudySubject $studySubject)
    {
        $studySubject->update($request->all());

        if (trim($request->status) == 0) {
            return redirect(route('studySubject.index'))->with('success', trans('messages.studySubjectDeactivated'));
        }
        else {
            return redirect(route('studySubject.index'))->with('success', trans('messages.studySubjectActivated'));
        }
    }
}
