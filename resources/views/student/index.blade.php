@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.students'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-user-graduate"></i> @lang('messages.students')
        </h1>
        @can('student-create')
            <form action="{{ route('student.import') }}" method="post" id="frmExcel" enctype="multipart/form-data">
                @csrf
                <input type="file" id="excel" style="display: none;" name="excel" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
            </form>
            <div class="btn-group">
                <a href="{{ route('student.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.student')
                </a>
                <button type="button" class="d-none d-sm-inline-block btn btn-warning shadow-sm" id="btnModalImport">
                    <i class="fa fa-file-excel"></i> @lang('messages.import') @lang('messages.students')
                </button>
                <a href="{{ route('student.export') }}" class="d-none d-sm-inline-block btn btn-success shadow-sm" id="btnModalExport">
                    <i class="fa fa-file-excel"></i> @lang('messages.export') @lang('messages.students')
                </a>
            </div>
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
                        <th>@lang('messages.fistName')</th>
                        <th>@lang('messages.lastName')</th>
                        <th>Email</th>
                        <th>@lang('messages.code')</th>
                        <th>@lang('messages.status')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr class="text-center">
                            <td>{{ $student->firstname }}</td>
                            <td>{{ $student->lastname }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->code }}</td>
                            <td>
                                @if($student->status)
                                    <span class="badge badge-primary">@lang('messages.enabled')</span>
                                @else
                                    <span class="badge badge-danger">@lang('messages.disabled')</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('student.destroy', $student->id) }}" method="post" id="formDelete{{ $student->id }}">
                                    @method("DELETE")
                                    @csrf
                                    <div class="btn-group" role="group">
                                        @can('student-show')
                                            <a href="{{ route('student.show', $student->id) }}" class="btn btn-primary">
                                                <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                            </a>
                                        @endcan
                                        @can('student-edit')
                                            <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info">
                                                <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                            </a>
                                        @endcan
                                        @can('student-delete')
                                            @if($student->status)
                                                <input type="hidden" name="status" value="0">
                                                <button type="button" class="btn btn-danger" onclick="deleteItem({{ $student->id }}, {{ $student->status }})">
                                                    <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                </button>
                                            @else
                                                <input type="hidden" name="status" value="1">
                                                <button type="button" class="btn btn-primary" onclick="deleteItem({{ $student->id }}, {{ $student->status }})">
                                                    <i class="fa fa-check-square fa-fw"></i> @lang('messages.enable')
                                                </button>
                                            @endif
                                        @endcan
                                    </div>
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
        function deleteItem(id, status) {
            Swal
                .fire({
                    title: (status) ? "@lang('messages.confirmStudentDeactivation')" : "@lang('messages.confirmStudentActivation')",
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
                                document.getElementById(`formDelete${id}`).submit();
                            }
                        });
                    }
                });
        }

        $(document).ready(function(){
            $("#datatable").dataTable();

            $("#btnModalImport").click(function(){
                document.getElementById("excel").click();
            });

            $("#excel").change(function(){
                document.getElementById("frmExcel").submit();
            });
        });
    </script>
@endsection
