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
                        <th>@lang('messages.course')</th>
                        <th>@lang('messages.studySubject')</th>
                        <th>@lang('messages.code')</th>
                        <th>@lang('messages.teacher')</th>
                        <th>@lang('messages.points')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr class="text-center">
                            <td>{{ $course->course->name }}</td>
                            <td>{{ $course->course->studySubject->name }}</td>
                            <td>{{ $course->course->code }}</td>
                            <td>{{ $course->course->teacher->full_name }}</td>
                            <td>
                                @if($course->points >= 0 && $course->points <= 39)
                                    <span class="badge badge-danger">
                                        {{ $course->points }}
                                    </span>
                                @elseif($course->points >= 40 && $course->points <= 69)
                                    <span class="badge badge-warning">
                                        {{ $course->points }}
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        {{ $course->points }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <form target="_blank" action="{{ route('course.getCertification') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit" class="btn btn-primary" @if($course->points < 40) disabled @endif>
                                        <i class="fa fa-file-pdf fa-fw"></i> @lang('messages.printCertificate')
                                    </button>
                                </form>
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
        $(document).ready(function(){
            $("#datatable").dataTable({
                "order": [[ 0, "asc" ]]
            });
        });
    </script>
@endsection
