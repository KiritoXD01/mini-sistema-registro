@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.userRoles'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users-cog"></i> @lang('messages.userRoles')
        </h1>
        @can('role-create')
        <a href="{{ route('role.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.userRol')
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
                            <th>@lang('messages.createdAt')</th>
                            <td>@lang('messages.actions')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr class="text-center">
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <form action="{{ route('role.destroy', $role->id) }}" method="post" id="formDelete{{ $role->id }}">
                                    @method("DELETE")
                                    @csrf
                                    <div class="btn-group" role="group">
                                        @can('role-edit')
                                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-info">
                                            <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                        </a>
                                        @endcan
                                        @can('role-delete')
                                        <button type="button" class="btn btn-danger" onclick="deleteItem({{ $role->id }})">
                                            <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                        </button>
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
        function deleteItem(item) {
            Swal
                .fire({
                    title: (item.status) ? "@lang('messages.confirmUserActivation')" : "@lang('messages.confirmUserDeactivation')",
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
            $("#datatable").dataTable({
                "order": [[ 1, "desc" ]]
            });
        });
    </script>
@endsection
