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
            @foreach($course as $course)

                <div class="info-panel col-md-12 bg-info">
                    <h1> Course Name: {{$course->name}}</h1>
                    <div class="col-md-6 col-md-offset-2">
                        <p> <b>ID:</b> {{ $course->id }}</p>
                        <p><b>Description:</b> {{$course->description}}</p>
                        <p><b>Teacher:</b> {{ $course->teacher }}</p>
                        <p><b>Category:</b> {{$course->category}}</p>
                        <p><b>Status:</b>@if($course->status==\App\Course::STATUS_PENDING) {{"PENDING"}}
                            @elseif($course->status==\App\Course::STATUS_ACTIVE){{ "ACTIVE" }}
                            @elseif($course->status==\App\Course::STATUS_DEACTIVED){{"DEACTIVED"}}
                            @else {{"REJECTED"}}
                            @endif
                            </p>
                        <p><b>Cost:</b> {{$course->cost}}</p>
                        <p><b>Created:</b> {{ $course->created_at }}</p>
                        <p><b>Updated:</b> {{ $course->updated_at }}</p>
                        <a class="btn btn-primary" href="{{ route('admin.courses.edit', ['course' => $course->id]) }}">Edit Course</a>
                        <a class="btn btn-primary" href="{{ route('admin.course.request', ['course' => $course->id]) }}">Info Course</a>
                    </div>
                </div>
            @endforeach
        </div>


@endsection