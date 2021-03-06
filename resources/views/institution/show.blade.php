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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('institution-edit')
                <a href="{{ route('institution.edit') }}" class="btn btn-primary">
                    <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.institution')
                </a>
            @endcan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('messages.name')</label>
                        <input type="text" id="name" class="form-control" value="{{ $institution->name ?? "" }}" readonly placeholder="@lang('messages.name')...">
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('messages.phone')</label>
                        <input type="text" id="phone" class="form-control" value="{{ $institution->phone ?? "" }}" readonly placeholder="@lang('messages.phone')...">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" value="{{ $institution->email ?? "" }}" readonly placeholder="Email...">
                    </div>
                    <div class="form-group">
                        <label for="code">@lang('messages.code')</label>
                        <input type="text" id="code" class="form-control" value="{{ $institution->code ?? "" }}" readonly placeholder="@lang('messages.code')...">
                    </div>
                    <div class="form-group">
                        <label for="address">@lang('messages.address')</label>
                        <input type="text" id="address" class="form-control" value="{{ $institution->address ?? "" }}" readonly placeholder="@lang('messages.address')...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Logo</label>
                        <br>
                        <div class="text-center">
                            @if(isset($institution))
                                <img src="{{ asset($institution->logo) }}" alt="" class="img-thumbnail mx-auto" style="width: 50%;" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.directorSignature')</label>
                        <br>
                        <div class="text-center">
                            @if(isset($institution))
                                <img src="{{ asset($institution->director_signature) }}?dummy={{ time() }}" alt="" class="img-thumbnail mx-auto" style="width: 50%;" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.rectorSignature')</label>
                        <br>
                        <div class="text-center">
                            @if(isset($institution))
                                <img src="{{ asset($institution->rector_signature) }}?dummy={{ time() }}" alt="" class="img-thumbnail mx-auto" style="width: 50%;" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="director_name" class="form-control" value="{{ $institution->director_name ?? "" }}" placeholder="Director..." readonly />
                </div>
                <div class="col-md-6">
                    <input type="text" id="rector_name" class="form-control" value="{{ $institution->rector_name ?? "" }}" placeholder="Rector..." readonly />
                </div>
            </div>
        </div>
    </div>
@endsection
