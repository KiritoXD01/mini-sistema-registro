@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.studySubject'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-book"></i> @lang('messages.show') @lang('messages.studySubject') - {{ $studySubject->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="{{ route('studySubject.destroy', $studySubject->id) }}" method="post" id="formDelete{{ $studySubject->id }}">
                @method("DELETE")
                @csrf
                <a href="{{ route('studySubject.index') }}" class="btn btn-warning">
                    <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                </a>
                @can('study-subject-edit')
                    <a href="{{ route('studySubject.edit', $studySubject->id) }}" class="btn btn-primary">
                        <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.user')
                    </a>
                @endcan
                @can('study-subject-delete')
                    @if($studySubject->status)
                        <input type="hidden" name="status" value="0">
                        <button type="button" class="btn btn-danger" onclick="deleteItem('{{ $studySubject }}')">
                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                        </button>
                    @else
                        <input type="hidden" name="status" value="1">
                        <button type="button" class="btn btn-primary" onclick="deleteItem('{{ $studySubject }}')">
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
                        <input type="text" id="name" class="form-control" value="{{ $studySubject->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.createdBy')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $studySubject->createdBy->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($studySubject->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code">@lang('messages.code')</label>
                        <input type="text" id="code" class="form-control" value="{{ $studySubject->code }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">@lang('messages.createdAt')</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $studySubject->created_at }}" readonly>
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
                    title: (item.status) ? "@lang('messages.confirmStudySubjectDeactivation')" : "@lang('messages.confirmStudySubjectActivation')",
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
