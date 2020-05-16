@extends('layouts.app')

@section('content')
<h1>{{ auth()->user() }}</h1>
@endsection
