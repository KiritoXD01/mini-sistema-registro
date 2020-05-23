@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.user'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.show') @lang('messages.user') - {{ $user->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="{{ route('user.destroy', $user->id) }}" method="post" id="formDelete{{ $user->id }}">
                @method("DELETE")
                @csrf
                <a href="{{ route('user.index') }}" class="btn btn-warning">
                    <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                </a>
                @can('user-edit')
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.user')
                    </a>
                @endcan
                @can('user-delete')
                    @if($user->status)
                        <input type="hidden" name="status" value="0">
                        <button type="button" class="btn btn-danger" onclick="deleteItem('{{ $user }}')" @if($user->id == auth()->user()->id) disabled @endif>
                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                        </button>
                    @else
                        <input type="hidden" name="status" value="1">
                        <button type="button" class="btn btn-primary" onclick="deleteItem('{{ $user }}')" @if($user->id == auth()->user()->id) disabled @endif>
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
                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.createdBy')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $user->createdBy->name }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">@lang('messages.userRol')</label>
                        <input type="text" id="role" class="form-control" value="{{ $user->roles->first()->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">@lang('messages.createdAt')</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $user->created_at }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($user->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow md-4">
        <div class="card-header py-3">
            <h4>Logins</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableLogins" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Login</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->userLogins as $login)
                        <tr>
                            <td>{{ $login->created_at }}</td>
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
        function deleteItem(item) {
            item = JSON.parse(item);

            Swal
                .fire({
                    title: (item.status) ? "@lang('messages.confirmUserDeactivation')" : "@lang('messages.confirmUserActivation')",
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
            $("#tableLogins").dataTable({
                "order": [[ 0, "desc" ]]
            });
        });
    </script>
@endsection
