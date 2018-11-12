@extends('layouts.dashboard')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/bootstrap-fileinput.css') }}">
  <link rel="shortcut icon" href="favicon.ico"/>
@endsection

@section('content')
  <div class="container">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ route('profile') }}">Home</a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>Teaching course</span>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>{{ $course->id }}</span>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>Update course info</span>
        </li>
      </ul>
    </div>
    <h3 class="page-title"><strong>Course:</strong> {{ $course->name }} </h3>
    @if ($errors->has('create_failed'))
      <span class="help-block">
            <strong>{{ $errors->first('create_failed') }}</strong>
        </span>
    @endif
    <div class="portlet light form-fit bordered">
      <div class="portlet-title">
        <div class="caption center-block">
          <i class="icon-settings font-green"></i>
          <span class="caption-subject font-green sbold uppercase">Update Course Info</span>
        </div>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal form-bordered" enctype="multipart/form-data"
              action="{{ route('user.post_update_course_info', ['course' => $course->id]) }}" method="POST">
          {{ method_field('PUT') }}
          {{ csrf_field() }}
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-2">Course Name</label>
              <div class="col-md-9">
                <input class="no-border form-control" type="text" placeholder="JS essentials, PHP, ..."
                       value="{{ old('name') ? old('name') : $course->name }}"
                       name="name" required/>
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">About this course</label>
              <div class="col-md-9">
              <textarea class="no-border form-control" rows="4" placeholder="The best course ever"
                        name="description"
                        required>{{ old('description') ? old('description') : $course->description }}</textarea>
                @if ($errors->has('description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group ">
              <label class="control-label col-md-2">Course image</label>
              <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-height: 300px">
                    <img src="{{ Storage::url($course->avatar) }}" alt=""/>
                  </div>
                  <div>
                  <span class="btn red btn-outline btn-file">
                      <span class="fileinput-new"> Avatar </span>
                      <span class="fileinput-exists"> Change Avatar </span>
                      <input type="file" name="avatar"> </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-height: 300px">
                    <img src="{{ Storage::url($course->cover) }}" alt=""/>
                  </div>
                  <div>
                <span class="btn red btn-outline btn-file">
                    <span class="fileinput-new"> Cover </span>
                    <span class="fileinput-exists"> Change Cover </span>
                    <input type="file" name="cover"> </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                  </div>
                </div>
                @if ($errors->has('avatar') || $errors->has('cover'))
                  <span class="help-block">
                    <strong>{{ $errors->first('avatar') }}</strong>
                    <strong>{{ $errors->first('cover') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Category</label>
              <div class="col-md-3">
                <select class="form-control" name="category_id" required>
                  @foreach($courseCategories as $courseCategory)
                    <option value="{{ $courseCategory->id }}"
                            @if($course->course_category_id === $courseCategory->id) selected @endif>{{ $courseCategory->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('category_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Cost</label>
              <div class="col-md-3">
                <div class="input-group">
                  <input class="form-control" type="text" placeholder="0"
                         value="{{ old('cost') ? old('cost') : $course->cost }}"
                         name="cost" required/>
                  <span class="input-group-addon">$</span>
                </div>
                @if ($errors->has('cost'))
                  <span class="help-block">
                    <strong>{{ $errors->first('cost') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-2 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
                <a href="{{ route('profile') }}" class="btn btn-outline grey-salsa">Cancel</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endsection
