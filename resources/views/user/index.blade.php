@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.users'))

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('messages.users')</h1>
    <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.user')
    </a>
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
            <table class="table table-bordered table-hover" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>Email</th>
                        <th>@lang('messages.status')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="text-center">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->status)
                                <span class="badge badge-primary">@lang('messages.enabled')</span>
                            @else
                                <span class="badge badge-danger">@lang('messages.disabled')</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="post" id="formDelete{{ $user->id }}">
                                @method('DELETE')
                                @csrf
                                <div class="btn-group" role="group">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">
                                        <i class="fa fa-edit"></i> @lang('messages.edit')
                                    </a>
                                    @if ($user->id != auth()->user()->id)
                                    <button type="button" class="btn btn-danger" onclick="deleteItem({{ $user->id }})">
                                        <i class="fa fa-trash"></i> @lang('messages.delete')
                                    </button>
                                    @endif
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
function deleteItem(item) {
    Swal
        .fire({
            title: "@lang('messages.confirmUserDelete')",
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
                        document.getElementById(`formDelete${item}`).submit();
                    }
                });
            }
        });
}

$(document).ready(function(){
    $("#datatable").dataTable();
});
</script>
@endsection
