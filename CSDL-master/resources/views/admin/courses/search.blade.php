@extends('admin.layouts.app')

@section('styles')
    <style>
        .actions-head {
            padding: 30px 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .new-btn {
            margin-right: 20px;
        }
        .pagination {
            text-align: center;
        }
        .form-inline {
            display:inline;
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
            <div class="col-md-6">
                <h2>Manage Courses</h2>
            </div>
            <div class="actions-head col-md-6">
                <form class="search-form form form-inline" method="GET" action="{{ route('admin.courses.search') }}">
                    <input class="form-control" type="text" placeholder="Course name" name="name">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th>Cost</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @php
                $count = 1;
            @endphp

            @foreach($courses as $course)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $course->name }}</td>
                    <td>
                        @if($course->status==\App\Course::STATUS_PENDING) {{"PENDING"}}
                        @elseif($course->status==\App\Course::STATUS_ACTIVE){{ "ACTIVE" }}
                        @elseif($course->status==\App\Course::STATUS_DEACTIVED){{"DEACTIVED"}}
                        @else {{"REJECTED"}}
                        @endif
                    </td>
                    <td>{{ $course->cost}}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.courses.show', ['course' => $course->id]) }}">Detail</a>
                        <a class="btn btn-primary" href="{{ route('admin.courses.edit', ['course' => $course->id]) }}">Edit</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection