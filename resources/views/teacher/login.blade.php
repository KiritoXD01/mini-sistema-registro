<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mini Sistema Registro">
    <meta name="author" content="Javier Mercedes">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('vendor/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">@lang('messages.welcome')</h1>
                                </div>
                                <form action="{{ route('teacher.login') }}" class="user needs-validation" autocomplete="off" method="post" id="form">
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('error') }}</strong>
                                        </div>
                                    @endif
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email" name="email" autofocus required placeholder="@lang('messages.pleaseEnterEmail')..." value="{{ old('email') }}">
                                        <div class="invalid-feedback">@lang('messages.pleaseEnterEmail')</div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" required placeholder="@lang('messages.pleaseEnterPassword')...">
                                        <div class="invalid-feedback">@lang('messages.pleaseEnterPassword')</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" id="btnSubmit">
                                        <i class="fa fa-sign-in-alt fa-fw"></i> @lang('messages.login')
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    $(document).ready(function() {
        $("#form").submit(function() {
            Swal.fire({
                title: "@lang('messages.pleaseWait')",
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
</script>

</body>

</html>
