@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Edit Course Info</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
@foreach($courses as $courses)
            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.courses.update', ['courses' => $courses->id]) }}"
            >
@endforeach
                <div class="form-group">
                    <label for="nameTxt" class="col-sm-2 control-label">Course Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nameTxt" placeholder="Name" name="name" value="{{ $courses->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="categoryTxt" class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category" >
                           @foreach($categories as $categories)
                                <option value="{{$categories->id}}">{{$categories->name}}</option>
                               @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="statusTxt" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status" >
                            <option value="{{ \App\Course::STATUS_PENDING }}">PENDING</option>
                            <option value="{{ \App\Course::STATUS_ACTIVE }}">ACTIVE</option>
                            <option value="{{ \App\Course::STATUS_DEACTIVED}}">DEACTIVED</option>
                            <option value="{{ \App\Course::STATUS_REJECTED}}">REJECTED</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        })
    </script>
@endsection