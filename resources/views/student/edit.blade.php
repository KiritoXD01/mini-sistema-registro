@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.student'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-user-graduate"></i> @lang('messages.edit') @lang('messages.student') - {{ $student->full_name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('student.update', $student->id) }}" method="post" id="form" autocomplete="off">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('student.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.update') @lang('messages.student')
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
                                <input type="text" id="firstname" name="firstname" required autofocus class="form-control" value="{{ old('firstname') ?? $student->firstname }}" placeholder="@lang('messages.fistName')...">
                            </div>
                            <div class="col-6">
                                <label for="lastname">@lang('messages.lastName')</label>
                                <input type="text" id="lastname" name="lastname" required autofocus class="form-control" value="{{ old('lastname') ?? $student->lastname }}" placeholder="@lang('messages.lastName')...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required class="form-control" value="{{ old('email') ?? $student->email }}" placeholder="Email...">
                        </div>
                        @can('student-delete')
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" @if($student->status) checked @endif value="1">
                                    <label class="custom-control-label" for="status">@lang('messages.status')</label>
                                </div>
                            </div>
                        @endcan
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
                    </div>
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
