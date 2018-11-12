@extends('layouts.main')

@section('style')
  <style>
    .irs-bb-right {
      margin-bottom: 0;
    }

    .c-description {
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      height: 3rem;
    }
  </style>
@endsection

@section('content')
  <section class="irs-ip-brdcrumb">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-right irs-bb-right">
          <ul class="list-inline irs-brdcrmb">
            <li><a href="#">Home</a></li>
            <li><a href="#"> > </a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#"> > </a></li>
            <li><a class="active" href="#">Enrolled</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="irs-ip-details">
    <div class="container">
      <div class="row clearfix">
        <div class="col-sm-12 col-md-8 col-lg-9 clearfix">
          <div class="irs-courses-shorting-heading clearfix">
            <ul class="list-inline pull-left">
              <li><a href="#"><span class="flaticon-signs-3"></span></a></li>
              <li>
                <a href="#">
                  Showing {{ ($courses->currentPage()-1)*config('view.paginate') }}-{{ $courses->currentPage()*config('view.paginate') < $courses->total() ? $courses->currentPage()*config('view.paginate'):$courses->total() }} of {{ $courses->total() }} results
                </a>
              </li>
            </ul>
            <div class="input-group irs-nav-search-form">
              <input type="text" class="form-control pull-right" placeholder="Search courses">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="flaticon-musica-searcher"></span></button>
              </span>
            </div><!-- /input-group -->
          </div>
          @foreach($courses as $course)
            <div class="row clearfix">
              <div class="irs-cl-list">
                <div class="col-xs-12 col-lg-4">
                  <div class="irs-cl-list-thumb">
                    <a href="{{ route('user.learn_course', ['course' => $course->id]) }}">
                      <img class="img-responsive img-fluid" src="{{ Storage::url($course->avatar) }}" alt="cl1.png">
                    </a>
                  </div>
                </div>
                <div class="col-xs-12 col-lg-8">
                  <div class="irs-cl-details">
                    <h3>
                      <a href="{{ route('user.learn_course', ['course' => $course->id]) }}">
                        {{ $course->name }}
                      </a>
                    </h3>
                    <p class="c-description">{{ $course->description }} </p>
                    <ul class="list-inline irs-cl-teacher-info">
                      <li class="irs-cl-info">with <span class="text-thm2"> {{ $course->teacher->name }} </span></li>
                      <li class="irs-cl-thumb">
                        <img class="avatar-img"
                             src="{{ Storage::url($course->teacher->avatar) }}" alt="s3.png">
                      </li>
                      <li class="pull-right"> <small><cite> Enrolled in: {{ $course->pivot->date_bought }}</cite></small></li>
                    </ul>
                    <a href="{{ route('user.learn_course', ['course' => $course->id]) }}"
                       class="btn btn-default irs-btn-thm3"> Check Course</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          {{ $courses->links() }}
        </div>
        @include('includes.right-sidebar')
      </div>
    </div>
  </section>
@endsection