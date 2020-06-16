@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.create').' '.trans('messages.course'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-university"></i> @lang('messages.create') @lang('messages.course')
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('course.store') }}" method="post" autocomplete="off" id="form">
        @csrf
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('messages.name')</label>
                            <input type="text" id="name" name="name" required autofocus class="form-control" value="{{ old('name') }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="teacher_id">@lang('messages.teacher')</label>
                            <select id="teacher_id" name="teacher_id" class="form-control" required>
                                <option value="" disabled selected hidden>-- @lang('messages.teacher') --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @if(old('teacher_id') == $teacher->id) selected @endif>{{ $teacher->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="close_points">@lang('messages.lastDayToPublishPoints')</label>
                            <input type="text" id="close_points" name="close_points" class="form-control" value="{{ old('close_points') }}" placeholder="@lang('messages.lastDayToPublishPoints')..." required readonly style="background-color: white;">
                        </div>
                        <div class="form-group">
                            <label for="course_type_id">@lang('messages.courseType')</label>
                            <select id="course_type_id" name="course_type_id" class="form-control" required>
                                <option value="" disabled selected hidden>-- @lang('messages.courseType') --</option>
                                @foreach($courseTypes as $courseType)
                                    <option value="{{ $courseType->id }}" @if($courseType->id == old('course_type_id')) selected @endif>{{ $courseType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="country_id">@lang('messages.country')</label>
                            <select id="country_id" name="country_id" class="form-control" required>
                                <option value="" selected hidden disabled>-- @lang('messages.country') --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id == old('country_id')) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" checked value="1">
                                <label class="custom-control-label" for="status">@lang('messages.status')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">@lang('messages.code')</label>
                            <input type="text" id="code" name="code" required class="form-control" value="{{ old('code') }}" placeholder="@lang('messages.code')...">
                        </div>
                        <div class="form-group">
                            <label for="study_subject_id">@lang('messages.studySubject')</label>
                            <select id="study_subject_id" name="study_subject_id" class="form-control" required>
                                <option value="" disabled selected hidden>-- @lang('messages.studySubject') --</option>
                                @foreach($studySubjects as $studySubject)
                                    <option value="{{ $studySubject->id }}" @if(old('study_subject_id') == $studySubject->id) selected @endif>{{ $studySubject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hour_count">@lang('messages.hoursCount')</label>
                            <input type="number" id="hour_count" name="hour_count" min="1" value="{{ old('hour_count') }}" class="form-control" required placeholder="@lang('messages.hoursCount')...">
                        </div>
                        <div class="form-group">
                            <label for="course_modality_id">@lang('messages.courseModality')</label>
                            <select id="course_modality_id" name="course_modality_id" class="form-control" required>
                                <option value="" hidden selected disabled>-- @lang('messages.courseModality') --</option>
                                @foreach($courseModalities as $courseModality)
                                    <option value="{{ $courseModality['id'] }}" @if($courseModality['id'] == old('course_modality_id')) selected @endif>{{ $courseModality['value'] }}</option>
                                @endforeach
                            </select>
                        </div>
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

            const today = () => {
                const today = new Date();
                let dd = today.getDate();
                let mm = today.getMonth() + 1;
                const yyyy = today.getFullYear();

                dd = (dd < 10) ? `0${dd}` : dd;
                mm = (mm < 10) ? `0${mm}` : mm;

                return `${yyyy}-${mm}-${dd}`;
            };

            $("#close_points").datepicker({
                format: "yyyy-mm-dd",
                startDate: today()
            });
        });
    </script>
@endsection
