@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.institution'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-school"></i> @lang('messages.show') @lang('messages.institution')
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('institution.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off" id="form">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('institution.show') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.update') @lang('messages.institution')
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
                            <input type="text" id="name" name="name" class="form-control" value="{{ $institution->name ?? old('name') }}" required placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="phone">@lang('messages.phone')</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $institution->phone ?? old('phone') }}" required placeholder="@lang('messages.phone')...">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $institution->email ?? old('email') }}" required placeholder="Email...">
                        </div>
                        <div class="form-group">
                            <label for="code">@lang('messages.code')</label>
                            <input type="text" id="code" name="code" class="form-control" value="{{ $institution->code ?? old('code') }}" readonly placeholder="@lang('messages.code')...">
                        </div>
                        <div class="form-group">
                            <label for="address">@lang('messages.address')</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ $institution->address ?? old('address') }}" required placeholder="@lang('messages.address')...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Logo</label>
                            <input type="file" id="logo" name="logo" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-primary btn-block" id="btnLogo">
                                <i class="fa fa-picture-o fa-fw"></i> Logo
                            </button>
                            <br>
                            <div class="text-center">
                                @if(isset($institution))
                                    @if(!empty($institution->logo))
                                        <img src="{{ asset($institution->logo) }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                    @else
                                        <img src="{{ asset('img/addimage.png') }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                    @endif
                                @else
                                    <img src="{{ asset('img/addimage.png') }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb=4">
            <div class="card-header py-3">
                <h4>@lang('messages.digitalSignature')</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="director_signature">@lang('messages.directorSignature')</label>
                            <input type="file" id="director_signature" name="director_signature" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-primary btn-block" id="btnDirectorSignature">
                                <i class="fa fa-signature fa-fw"></i> @lang('messages.directorSignature')
                            </button>
                            <br>
                            <div class="text-center">
                                @if(isset($institution))
                                    @if(!empty($institution->director_signature))
                                        <img src="{{ asset($institution->director_signature) }}" alt="" id="DirectorSignaturePreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                    @else
                                        <img src="{{ asset('img/addimage.png') }}" alt="" id="DirectorSignaturePreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                    @endif
                                @else
                                    <img src="{{ asset('img/addimage.png') }}" alt="" id="DirectorSignaturePreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                @endif
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
        $(document).ready(function () {
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

            $("#btnLogo").click(function(){
                document.getElementById("logo").click();
            });

            $("#btnDirectorSignature").click(function(){
                document.getElementById("director_signature").click();
            });

            $("#logo").change(function() {
                let file    = document.getElementById('logo').files[0];
                let preview = document.getElementById('LogoPreview');
                let reader  = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                };

                if (file)
                    reader.readAsDataURL(file);
            });

            $("#director_signature").change(function(){
                let file    = document.getElementById('director_signature').files[0];
                let preview = document.getElementById('DirectorSignaturePreview');
                let reader  = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                };

                if (file)
                    reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
