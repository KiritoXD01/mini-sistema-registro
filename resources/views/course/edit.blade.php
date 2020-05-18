@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.course'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-university"></i> @lang('messages.edit') @lang('messages.course') - {{ $course->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('course.update', $course->id) }}" method="post" autocomplete="off" id="form">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('course.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.course')
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('messages.name')</label>
                            <input type="text" id="name" name="name" required autofocus class="form-control" value="{{ old('name') ?? $course->name }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="teacher_id">@lang('messages.teacher')</label>
                            <select id="teacher_id" name="teacher_id" class="form-control" required>
                                <option value="" disabled selected hidden>-- @lang('messages.teacher') --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @if(old('teacher_id') == $teacher->id || $course->teacher_id == $teacher->id) selected @endif>{{ $teacher->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="created_by">@lang('messages.createdBy')</label>
                            <input type="text" id="created_by" readonly class="form-control" value="{{ $course->createdBy->name }}">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" @if($course->status) checked @endif value="1">
                                <label class="custom-control-label" for="status">@lang('messages.status')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">@lang('messages.code')</label>
                            <input type="text" id="code" name="code" required class="form-control" value="{{ old('code') ?? $course->code }}" placeholder="@lang('messages.code')...">
                        </div>
                        <div class="form-group">
                            <label for="study_subject_id">@lang('messages.studySubject')</label>
                            <select id="study_subject_id" name="study_subject_id" class="form-control" required>
                                <option value="" disabled selected hidden>-- @lang('messages.studySubject') --</option>
                                @foreach($studySubjects as $studySubject)
                                    <option value="{{ $studySubject->id }}" @if(old('study_subject_id') == $studySubject->id || $course->study_subject_id == $studySubject->id) selected @endif>{{ $studySubject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="created_at">@lang('messages.createdAt')</label>
                            <input type="text" id="created_at" class="form-control" readonly value="{{ $course->created_at }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-fw fa-user-graduate"></i> @lang('messages.students')
                        </h1>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary float-right" id="btnAddStudent">
                            <i class="fa fa-fw fa-user-plus"></i> @lang('messages.add') @lang('messages.student')
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="datatable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>@lang('messages.name')</th>
                                <td>@lang('messages.actions')</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->students as $student)
                                <tr>
                                    <td>{{ $student->student->full_name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger">
                                            <i class="fa fa-fw fa-trash"></i> @lang('messages.delete')
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('course.addStudent', $course->id) }}" method="post" autocomplete="off" id="formStudent">
        @csrf
        <!-- The Modal -->
        <div class="modal fade" id="modalAddStudent">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('messages.add') @lang('messages.student')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="student_id">@lang('messages.student')</label>
                            <select id="student_id" name="student_id" required class="form-control">
                                <option value="" disabled hidden selected>-- @lang('messages.student') --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btnCloseAddStudent">@lang('messages.cancel')</button>
                        <button type="button" class="btn btn-success" id="btnSaveStudent">@lang('messages.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#form").submit(function(){
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#datatable").dataTable();

            $("#btnAddStudent").click(function() {
                $("#modalAddStudent").modal({
                    backdrop: 'static'
                });
            });

            $("#btnCloseAddStudent").click(function(){
                document.getElementById("student_id").value = "";
                $("#modalAddStudent").modal("hide");
            });

            $("#btnSaveStudent").click(function() {
                let student_id = document.getElementById("student_id");

                if (student_id.checkValidity())
                {
                    Swal.fire({
                        title: "@lang('messages.pleaseWait')",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: () => {
                            Swal.showLoading();
                            document.getElementById("formStudent").submit();
                        }
                    });
                }
                else
                {
                    student_id.focus();
                }
            });
        });
    </script>
@endsection
