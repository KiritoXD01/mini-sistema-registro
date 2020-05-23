@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.course'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-university"></i> @lang('messages.show') @lang('messages.course') - {{ $course->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="{{ route('course.destroy', $course->id) }}" method="post" id="formDelete{{ $course->id }}">
                @method("DELETE")
                @csrf
                <a href="{{ route('course.index') }}" class="btn btn-warning">
                    <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                </a>
                @can('course-edit')
                    <a href="{{ route('course.edit', $course->id) }}" class="btn btn-primary">
                        <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.course')
                    </a>
                @endcan
                @can('course-delete')
                    @if($course->status)
                        <input type="hidden" name="status" value="0">
                        <button type="button" class="btn btn-danger" onclick="deleteItem('{{ $course }}')">
                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                        </button>
                    @else
                        <input type="hidden" name="status" value="1">
                        <button type="button" class="btn btn-primary" onclick="deleteItem('{{ $course }}')">
                            <i class="fa fa-check-square fa-fw"></i> @lang('messages.enable')
                        </button>
                    @endif
                @endcan
            </form>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('messages.name')</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $course->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="teacher_id">@lang('messages.teacher')</label>
                        <input type="text" id="teacher_id" class="form-control" value="{{ $course->teacher->full_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.createdBy')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $course->createdBy->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($course->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code">@lang('messages.code')</label>
                        <input type="text" id="code" class="form-control" value="{{ $course->code }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="study_subject_id">@lang('messages.studySubject')</label>
                        <input type="text" id="study_subject_id" class="form-control" value="{{ $course->studySubject->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">@lang('messages.createdAt')</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $course->created_at }}" readonly>
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($course->students as $student)
                        <tr>
                            <td>{{ $student->student->full_name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
