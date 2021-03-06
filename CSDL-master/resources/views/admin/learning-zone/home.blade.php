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
                <h2>Courses Pending</h2>
            </div>

        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Teacher</th>
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
                    <td>{{ $course->category}}</td>
                    <td>{{ $course->teacher}}</td>
                    <td>PENDING</td>
                    <td>{{ $course->cost}}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.course.request', ['course' => $course->id]) }}">Show</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection