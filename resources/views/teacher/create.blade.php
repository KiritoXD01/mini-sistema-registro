@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.create').' '.trans('messages.teacher'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-chalkboard-teacher"></i> @lang('messages.create') @lang('messages.teacher')
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('teacher.store') }}" method="post" autocomplete="off" id="form" enctype="multipart/form-data">
        @csrf
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
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.teacher')
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
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="firstname">@lang('messages.fistName')</label>
                                <input type="text" id="firstname" name="firstname" required autofocus class="form-control" value="{{ old('firstname') }}" placeholder="@lang('messages.fistName')...">
                            </div>
                            <div class="col-6">
                                <label for="lastname">@lang('messages.lastName')</label>
                                <input type="text" id="lastname" name="lastname" required autofocus class="form-control" value="{{ old('lastname') }}" placeholder="@lang('messages.lastName')...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required class="form-control" value="{{ old('email') }}" placeholder="Email...">
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('messages.password')</label>
                            <input type="password" id="password" name="password" class="form-control" required value="" placeholder="@lang('messages.password')...">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">@lang('messages.confirmPassword')</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required value="" placeholder="@lang('messages.confirmPassword')...">
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
                            <label for="digital_signature">@lang('messages.digitalSignature')</label>
                            <input type="file" id="digital_signature" name="digital_signature" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-primary btn-block" id="btnDigitalSignature">
                                <i class="fa fa-signature fa-fw"></i> @lang('messages.add') @lang('messages.digitalSignature')
                            </button>
                            <br>
                            <div class="text-center">
                                <img src="{{ asset('img/addimage.png') }}" alt="" id="digitalSignaturePreview" class="img-thumbnail mx-auto" style="width: 50%;">
                            </div>
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

            $("#btnDigitalSignature").click(function(){
                document.getElementById("digital_signature").click();
            });

            $("#digital_signature").change(function(){
                let file    = document.getElementById("digital_signature").files[0];
                let preview = document.getElementById("digitalSignaturePreview");
                let reader  = new FileReader();

                reader.onload = function() {
                    preview.src = reader.result;
                };

                if (file)
                    reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
