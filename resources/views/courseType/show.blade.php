@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.courseType'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-university"></i> @lang('messages.show') @lang('messages.courseType') - {{ $courseType->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="{{ route('courseType.destroy', $courseType->id) }}" method="post" id="formDelete{{ $courseType->id }}">
                @method("DELETE")
                @csrf
                <a href="{{ route('courseType.index') }}" class="btn btn-warning">
                    <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                </a>
                @can('user-edit')
                    <a href="{{ route('courseType.edit', $courseType->id) }}" class="btn btn-primary">
                        <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.courseType')
                    </a>
                @endcan
                @can('course-type-delete')
                    @if($courseType->status)
                        <input type="hidden" name="status" value="0">
                        <button type="button" class="btn btn-danger" onclick="deleteItem('{{ $courseType }}')">
                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                        </button>
                    @else
                        <input type="hidden" name="status" value="1">
                        <button type="button" class="btn btn-primary" onclick="deleteItem('{{ $courseType }}')">
                            <i class="fa fa-check-square fa-fw"></i> @lang('messages.enable')
                        </button>
                    @endif
                @endcan
            </form>
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
                        <input type="text" id="name" class="form-control" value="{{ $courseType->name }}" placeholder="@lang('messages.name')..." readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($courseType->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function deleteItem(item) {
            item = JSON.parse(item);

            Swal
                .fire({
                    title: (item.status) ? "@lang('messages.confirmCourseTypeActivation')" : "@lang('messages.confirmCourseTypeDeactivation')",
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
    </script>
@endsection
