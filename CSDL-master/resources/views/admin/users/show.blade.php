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
                <h1> {{ "User-id: " .$user->id }}</h1>
                <div class="col-md-3">
                    <img class="img-responsive img-rounded" src="{{ Storage::url($user->avatar) }}" alt="Avatar">
                </div>
                <div class="col-md-6 col-md-offset-2">
                    <p>Name: {{ $user->name }}</p>
                    <p>Gender: @if($user->gender==\App\User::GENDER_MALE) {{"Male"}}
                                   @elseif($user->gender==\App\User::GENDER_FEMALE){{"Female"}}
                                   @else {{"Orther"}}
                                   @endif
                    </p>
                    <p>Address: {{ $user->address }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Date of birth: {{ $user->DOB }}</p>
                    <p>Created: {{ $user->created_at }}</p>
                    <p>Updated: {{ $user->updated_at }}</p>
                    <a class="btn btn-primary" href="{{ route('admin.users.edit', ['user' => $user->id]) }}">Edit profile</a>
                </div>
            </div>
        </div>


@endsection