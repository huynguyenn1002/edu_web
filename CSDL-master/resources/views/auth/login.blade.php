@extends('layouts.login')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/pages/login.min.css') }}">
    <link rel="shortcut icon" href="favicon.ico" />
@endsection

@section('content')
        <div class="logo">
            ITE system
        </div>
        <div class="content">
            @include('auth.partials.login')
            @include('auth.partials.forget_password')
            @include('auth.partials.register')
        </div>
@endsection

@section('script')
    <script src="{{ asset('js/login-4.min.js') }}" type="text/javascript"></script>
@endsection