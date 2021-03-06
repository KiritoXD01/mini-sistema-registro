@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.courses'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-university"></i> @lang('messages.courses')
        </h1>
        @can('course-create')
            <a href="{{ route('course.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.course')
            </a>
        @endcan
    </div>
    <!-- End Page Heading -->

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover" id="datatable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.code')</th>
                        @if(!auth()->guard('teacher')->check())
                            <th>@lang('messages.teacher')</th>
                            <th>@lang('messages.courseModality')</th>
                            <th>@lang('messages.courseType')</th>
                        @endif
                        <th>@lang('messages.students')</th>
                        <th>@lang('messages.status')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr class="text-center">
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->code }}</td>
                            @if(!auth()->guard('teacher')->check())
                                <td>{{ $course->teacher->full_name }}</td>
                                <td>{{ $course->course_modality }}</td>
                                <td>{{ $course->courseType->name }}</td>
                            @endif
                            <td>{{ $course->students->count() }}</td>
                            <td>
                                @if($course->status)
                                    <span class="badge badge-primary">@lang('messages.enabled')</span>
                                @else
                                    <span class="badge badge-danger">@lang('messages.disabled')</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->guard('teacher')->check())
                                    <a href="{{ route('course.edit', $course->id) }}" class="btn btn-primary btn-block">
                                        <i class="fa fa-eye fa-fw"></i> @lang('messages.edit') @lang('messages.points')
                                    </a>
                                @else
                                    <form action="{{ route('course.destroy', $course->id) }}" method="post" id="formDelete{{ $course->id }}">
                                        @method("DELETE")
                                        @csrf
                                        <div class="btn-group" role="group">
                                            @can('course-show')
                                                <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                                </a>
                                            @endcan
                                            @can('course-edit')
                                                <a href="{{ route('course.edit', $course->id) }}" class="btn btn-info">
                                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
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
                                        </div>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Table -->
@endsection

@section('javascript')
    <script>
        function deleteItem(item) {
            item = JSON.parse(item);
            Swal
                .fire({
                    title: (item.status) ? "@lang('messages.confirmTeacherActivation')" : "@lang('messages.confirmTeacherDeactivation')",
                    icon: 'question',
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: "@lang('messages.yes')",
                    cancelButtonText: "No",
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formDelete${item.id}`).submit();
                            }
                        });
                    }
                });
        }

        $(document).ready(function(){
            $("#datatable").dataTable({
                "order": [[ 0, "asc" ]]
            });
        });
    </script>
@endsection
