@extends('admin.layouts.app')

@section('styles')
    <style>
        h1 {
            margin-bottom: 50px;
        }

        .btn {
            margin: 20px 0;
        }

        .info-panel {
            padding: 30px;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="row">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
            <div class="info-panel col-md-12 bg-info">
                <h1> {{ "Admin: " .$admin->name }}</h1>
                <div class="col-md-6 col-md-offset-2">
                    <p>Email: {{ $admin->email }}</p>
                    <p>Address: {{ $admin->address }}</p>
                    <p>Date of birth: {{ $admin->DOB }}</p>
                    <p>Created: {{ $admin->created_at }}</p>
                    <p>Updated: {{ $admin->updated_at }}</p>
                    <a class="btn btn-primary" href="{{ route('admin.edit', ['admin' => $admin->id]) }}">Edit profile</a>
                </div>
            </div>
        </div>


@endsection