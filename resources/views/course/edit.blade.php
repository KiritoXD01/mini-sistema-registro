@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.course'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @if(auth()->guard('teacher')->check())
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-user-graduate"></i> @lang('messages.students')
            </h1>
        @else
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-fw fa-university"></i> @lang('messages.edit') @lang('messages.course') - {{ $course->name }}
            </h1>
        @endif
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('course.update', $course->id) }}" method="post" autocomplete="off" id="form">
        @csrf
        @method("PATCH")
        @if(!auth()->guard('teacher')->check())
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
                                <select id="teacher_id" name="teacher_id" class="form-control" required style="width: 100%;">
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
                                <label for="close_points">@lang('messages.lastDayToPublishPoints')</label>
                                <input type="text" id="close_points" name="close_points" class="form-control" value="{{ old('close_points') ?? $course->close_points }}" placeholder="@lang('messages.lastDayToPublishPoints')..." required readonly style="background-color: white;">
                            </div>
                            <div class="form-group">
                                <label for="course_type_id">@lang('messages.courseType')</label>
                                <select id="course_type_id" name="course_type_id" class="form-control" required style="width: 100%;">
                                    <option value="" disabled selected hidden>-- @lang('messages.courseType') --</option>
                                    @foreach($courseTypes as $courseType)
                                        <option value="{{ $courseType->id }}" @if($courseType->id == old('course_type_id') || $courseType->id == $course->course_type_id) selected @endif>{{ $courseType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="country_id">@lang('messages.country')</label>
                                <select id="country_id" name="country_id" class="form-control" required style="width: 100%;">
                                    <option value="" selected hidden disabled>-- @lang('messages.country') --</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" @if($country->id == old('country_id') || $country->id == $course->country_id) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @can('course-delete')
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @if($course->status) checked @endif value="1">
                                        <label class="custom-control-label" for="status">@lang('messages.status')</label>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">@lang('messages.code')</label>
                                <input type="text" id="code" name="code" required class="form-control" value="{{ old('code') ?? $course->code }}" placeholder="@lang('messages.code')...">
                            </div>
                            <div class="form-group">
                                <label for="study_subject_id">@lang('messages.studySubject')</label>
                                <select id="study_subject_id" name="study_subject_id" class="form-control" required style="width: 100%;">
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
                            <div class="form-group">
                                <label for="hour_count">@lang('messages.hoursCount')</label>
                                <input type="number" id="hour_count" name="hour_count" min="1" value="{{ $course->hour_count ?? old('hour_count') }}" class="form-control" required placeholder="@lang('messages.hoursCount')...">
                            </div>
                            <div class="form-group">
                                <label for="course_modality_id">@lang('messages.courseModality')</label>
                                <select id="course_modality_id" name="course_modality_id" class="form-control" required style="width: 100%;">
                                    <option value="" hidden selected disabled>-- @lang('messages.courseModality') --</option>
                                    @foreach($courseModalities as $courseModality)
                                        <option value="{{ $courseModality['id'] }}" @if($courseModality['id'] == old('course_modality_id') || $courseModality['id'] == $course->course_modality_id) selected @endif>{{ $courseModality['value'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city_id">@lang('messages.city')</label>
                                <input type="hidden" name="city_id" value="0">
                                <select id="city_id" name="city_id" class="form-control" style="width: 100%;">
                                    <option value="" selected hidden disabled>-- @lang('messages.city') --</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" @if($city->id == old('city_id') || $city->id == $course->city_id) selected @endif>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-6">
                    @if(!auth()->guard('teacher')->check())
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-fw fa-user-graduate"></i> @lang('messages.students')
                        </h1>
                    @else
                        <a href="{{ route('course.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    @endif
                </div>
                <div class="col-6">
                    @if(!auth()->guard('teacher')->check())
                        @can('course-students')
                            <button type="button" class="btn btn-primary float-right" id="btnAddStudent">
                                <i class="fa fa-fw fa-user-plus"></i> @lang('messages.add') @lang('messages.student')
                            </button>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            @if(session('unableToPoint'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('unableToPoint') }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover" id="datatable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>@lang('messages.fistName')</th>
                        <th>@lang('messages.lastName')</th>
                        <th>@lang('messages.code')</th>
                        <th>@lang('messages.points')</th>
                        @if(!auth()->guard('teacher')->check())
                            @can('course-students')
                                <td>@lang('messages.actions')</td>
                            @endif
                        @endif
                        <th>@lang('messages.status')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($course->students as $student)
                        <tr class="text-center">
                            <td>{{ $student->student->firstname }}</td>
                            <td>{{ $student->student->lastname }}</td>
                            <td>{{ $student->student->code }}</td>
                            <td>
                                <form action="{{ route('course.updatePoints', $course->id) }}" method="post" id="student-course-{{ $student->student->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group">
                                        <input type="hidden" name="student_id" value="{{ $student->student->id }}">
                                        @if(!auth()->guard('teacher')->check())
                                            @if(auth()->user()->can('course-points'))
                                                <input type="number" min="0" max="100" id="student-points-{{ $student->student->id }}" name="points" class="form-control" placeholder="@lang('messages.points')..." value="{{ $student->points }}" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="updatePoints({{ $student->student->id }})">
                                                        <i class="fa fa-fw fa-book-open"></i> @lang('messages.update') @lang('messages.points')
                                                    </button>
                                                </div>
                                            @else
                                                <input type="number" min="0" max="100" id="student-points-{{ $student->student->id }}" name="points" class="form-control" placeholder="@lang('messages.points')..." value="{{ $student->points }}" readonly>
                                            @endif
                                        @else
                                            <input type="number" min="0" max="100" id="student-points-{{ $student->student->id }}" name="points" class="form-control" placeholder="@lang('messages.points')..." value="{{ $student->points }}" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" onclick="updatePoints({{ $student->student->id }})">
                                                    <i class="fa fa-fw fa-book-open"></i> @lang('messages.update') @lang('messages.points')
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </td>
                            <td>
                                @if($student->points >= 0 && $student->points <= 39)
                                    <span class="badge badge-danger">@lang('messages.studying')</span>
                                @elseif($student->points >= 40 && $student->points <= 69)
                                    <span class="badge badge-warning">@lang('messages.assisted')</span>
                                @else
                                    <span class="badge badge-success">@lang('messages.approved')</span>
                                @endif
                            </td>
                            @if(!auth()->guard('teacher')->check())
                                @can('course-students')
                                    <td>
                                        <form action="{{ route('course.removeStudent', $course->id) }}" method="post" id="formDelete{{ $student->student->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="student_id" value="{{ $student->student->id }}">
                                            <button type="button" class="btn btn-danger btn-block" onclick="deleteStudent({{ $student->student->id }})">
                                                <i class="fa fa-fw fa-trash"></i> @lang('messages.delete')
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(!auth()->guard('teacher')->check())
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
                        <form action="{{ route('course.addStudent', $course->id) }}" method="post" autocomplete="off" id="formStudent">
                            @csrf
                            <div class="form-group">
                                <label for="student_id">@lang('messages.student')</label>
                                <select id="student_id" name="student_id" required class="form-control">
                                    <option value="" disabled hidden selected>-- @lang('messages.student') --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btnCloseAddStudent">@lang('messages.cancel')</button>
                        <button type="button" class="btn btn-success" id="btnSaveStudent">@lang('messages.save')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('javascript')
    <script>
        function updatePoints(student_id) {
            let student = document.getElementById(`student-points-${student_id}`);

            if (student.checkValidity())
            {
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                        document.getElementById(`student-course-${student_id}`).submit();
                    }
                });
            }
            else
            {
                student.focus();
            }
        }

        function deleteStudent(student_id) {
            Swal
                .fire({
                    title: "@lang('messages.removeStudent')",
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
                                document.getElementById(`formDelete${student_id}`).submit();
                            }
                        });
                    }
                });
        }

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

            $("#teacher_id").select2({
                theme: 'bootstrap4'
            });

            $("#study_subject_id").select2({
                theme: 'bootstrap4'
            });

            $("#course_type_id").select2({
                theme: 'bootstrap4'
            });

            $("#course_modality_id").select2({
                theme: 'bootstrap4'
            });

            $("#country_id").select2({
                theme: 'bootstrap4'
            });

            $("#city_id").select2({
                theme: 'bootstrap4'
            });

            $("#country_id").change(function (){
                let cities = document.getElementById("city_id");

                if (this.value == 65)
                {
                    cities.disabled = false;
                    cities.required = true;
                }
                else
                {
                    cities.disabled = true;
                    cities.required = false;
                    cities.value = "";
                }
            });
        });
    </script>
@endsection
