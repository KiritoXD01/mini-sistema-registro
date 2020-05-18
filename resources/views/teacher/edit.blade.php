@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.teacher'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-chalkboard-teacher"></i> @lang('messages.edit') @lang('messages.teacher') - {{ $teacher->full_name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('teacher.update', $teacher->id) }}" method="post" id="form" autocomplete="off">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('teacher.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.update') @lang('messages.teacher')
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
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="firstname">@lang('messages.fistName')</label>
                                <input type="text" id="firstname" name="firstname" required autofocus class="form-control" value="{{ old('firstname') ?? $teacher->firstname }}" placeholder="@lang('messages.fistName')...">
                            </div>
                            <div class="col-6">
                                <label for="lastname">@lang('messages.lastName')</label>
                                <input type="text" id="lastname" name="lastname" required autofocus class="form-control" value="{{ old('lastname') ?? $teacher->lastname }}" placeholder="@lang('messages.lastName')...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required class="form-control" value="{{ old('email') ?? $teacher->email }}" placeholder="Email...">
                        </div>
                        <div class="form-group">
                            <label for="code">@lang('messages.code')</label>
                            <input type="text" id="code" name="code" readonly class="form-control" value="{{ $teacher->code }}" placeholder="@lang('messages.code')...">
                        </div>
                        <div class="form-group">
                            <label for="created_by">@lang('messages.createdBy')</label>
                            <input type="text" id="created_by" readonly class="form-control" value="{{ $teacher->createdBy->name }}">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" @if($teacher->status) checked @endif value="1">
                                <label class="custom-control-label" for="status">@lang('messages.status')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">@lang('messages.change') @lang('messages.password')</label>
                            <input type="password" id="password" name="password" class="form-control" value="" placeholder="@lang('messages.password')...">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">@lang('messages.confirmPassword')</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="" placeholder="@lang('messages.confirmPassword')...">
                        </div>
                        <div class="form-group">
                            <label for="created_at">@lang('messages.createdAt')</label>
                            <input type="text" id="created_at" class="form-control" readonly value="{{ $teacher->created_at }}">
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
                        @foreach($teacher->teacherLogins as $login)
                            <tr>
                                <td>{{ $login->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#password").keyup(function(){
                document.getElementById("password_confirmation").required = this.value.trim().length > 0;
            });

            $("#tableLogins").dataTable({
                "order": [[ 0, "desc" ]]
            });

            $("#form").submit(function() {
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
        });

    </script>
@endsection