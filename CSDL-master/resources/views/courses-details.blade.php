@extends('layouts.main')

@section('style')
  <style>
    .irs-bb-right {
      margin-bottom: 0;
    }
  </style>
@endsection

@section('content')

  <!-- Breadcrumbs html -->
  <section class="irs-ip-brdcrumb">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-right irs-bb-right">
          <ul class="list-inline irs-brdcrmb">
            <li><a href="#">Home</a></li>
            <li><a href="#"> > </a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#"> > </a></li>
            <li><a class="active" href="#">{{$course->id}}</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="irs-ip-details irs-padb-svnty">
    <div class="container">
      <div class="row clearfix">
        <div class="col-sm-12 col-md-8 col-lg-9 clearfix">
          <div class="row">
            <div class="col-lg-12">
              <div class="irs-courses-details-title">
                <h2>{{ $course->name }}</h2>
                <ul class="list-inline irs-cl-teacher-info">
                  <li class="irs-cl-thumb">
                    <img class="avatar-img" src="{{ Storage::url($course->teacher_avatar) }}" alt="s4.png">
                  </li>
                  <li class="irs-cl-info">with
                    <a href="{{ route('teacher-info', ['id' => $course->teacher_id]) }}">
                      <span class="text-thm2"> {{ $course->teacher_name }}</span>
                    </a>
                  </li>
                  <li><span class="text-thm2 flaticon-social-2"></span> {{ $course->buyers }}</li>
                  <li><span class="text-thm2 fa fa-star" aria-hidden="true"></span> {{ number_format($course->avg_rating, 0) }}</li>
                  @if(!auth()->check())
                    <li class="pull-right">
                      <a href="{{ route('enroll-course', ['course' => $course->id]) }}"
                         class="btn btn-default irs-button-styledark">
                        Take This Course
                      </a>
                    </li>
                  @else
                    @if(auth()->user()->id !== $course->teacher_id)
                      @if(auth()->user()->enrolledCourses()->get()->pluck('id')->contains($course->id))
                        <li class="pull-right">
                          <a href="{{ route('user.learn_course', ['course' => $course->id]) }}" class="btn btn-default irs-button-styledark">
                            Enrolled
                          </a>
                        </li>
                      @else
                        <li class="pull-right">
                          <a href="{{ route('enroll-course', ['course' => $course->id]) }}"
                             class="btn btn-default irs-button-styledark">
                            Take This Course
                          </a>
                        </li>
                      @endif
                    @else
                      <li class="pull-right">
                        <a href="#" class="btn btn-default irs-button-styledark disabled">
                          Own course
                        </a>
                      </li>
                    @endif
                  @endif
                </ul>
              </div>
              <div class="irs-courses-details-thumb">
                <img class="img-responsive img-fluid" src="{{ Storage::url($course->cover) }}" alt="cd1.jpg">
                <div class="irs-cdtls-price"><p>${{ $course->cost }}</p></div>
              </div>
            </div>
          </div>
          <div class="row irs-mrngtp-svnty">
            <div class="col-lg-12">
              <div class="irs-courses-details">
                <div class="irs-cdetails-tab">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#description" aria-controls="description" role="tab"
                                                              data-toggle="tab">Description</a></li>
                    <li role="presentation"><a href="#curriculum" aria-controls="curriculum" role="tab"
                                               data-toggle="tab">Lectures</a></li>
                    <li role="presentation"><a href="#teachers" aria-controls="teachers" role="tab" data-toggle="tab">Teacher</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="description">
                      <div class="row">
                        <div class="col-md-5">
                          <div class="irs-cdtls-feture-bot">
                            <ul class="list-group">
                              <li>
                                <a class="list-group-item"><span class="flaticon-business text-thm2"></span> Video
                                  <span class="pull-right"> {{ $course->videos->count() }} </span></a>
                              </li>
                              <li>
                                <a class="list-group-item"><span class="flaticon-pen text-thm2"></span> Project
                                  <span class="pull-right"> {{ $course->projects->count() }} </span></a>
                              </li>
                              <li>
                                <a class="list-group-item"><span class="flaticon-people-1 text-thm2"></span> Students
                                  <span class="pull-right"> {{ $course->buyers }} </span></a>
                              </li>
                              <li>
                                <a class="list-group-item irs-bbn"><span class="flaticon-technology text-thm2"></span>
                                  Assessments <span class="pull-right"> self </span></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="col-md-7">
                          <div class="irs-courses-dtls-second-para">
                            <p>{{ $course->description }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="curriculum">
                      <div class="col-md-12">
                        <div class="irs-cdtls-feture-bot2">
                          <ul class="list-group">
                            @foreach($courseContents as $courseContent)
                              <li>
                                <a class="list-group-item">
                                  <ul class="list-inline">
                                    <li>
                                      <span>#{{ $courseContent->order_in_course}}</span>
                                    </li>
                                    <li>
                                      @if(get_class($courseContent) === \App\Video::class )
                                        <span class="flaticon-business text-thm2"></span> Video
                                      @else
                                        <span class="flaticon-pen text-thm2"></span> Project
                                      @endif
                                    </li>
                                    <li>
                                      <div class="its-tdu">{{$courseContent->name}} </div>
                                    </li>
                                  </ul>
                                </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="teachers">
                      <div class="irs-course-sd-teacher">
                        <div class="row">
                          <div class="col-md-2 irs-mrgnbtm-sxty">
                            <div class="irs-courses-td-sngle">
                              <div class="irs-ctds-thumb">
                                <img class="img-responsive img-fluid" src="{{ Storage::url($course->teacher_avatar) }}" alt="tsm1.png">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-10 irs-mrgnbtm-sxty irs-all-course-bb">
                            <div class="irs-courses-td-sngle-dtls">
                              <ul class="list-unstyled">
                                <li class="irs-name-tdsd">
                                  <h2>{{ $course->teacher_name }}</h2>
                                </li>
                              </ul>
                              <div class="irs-social-icon-td-sngle-dtls pull-right">
                                <ul class="list-inline irs-courses-tdetls">
                                  <li class="fbok"><a href="#"><span class="flaticon-social-3"></span> </a></li>
                                  <li class="twtr"><a href="#"><span class="flaticon-social-4"></span> </a></li>
                                  <li class="gplus"><a href="#"><span class="flaticon-social-media-1"></span> </a></li>
                                  <li class="linkdin"><a href="#"><span class="flaticon-linkedin-logo"></span> </a></li>
                                </ul>
                              </div>

                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <h5>{{ $course->teacher_description }}</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @include('includes.right-sidebar')
      </div>
    </div>
  </section>


  <!-- Social Media Section -->
  <section class="irs-social-media">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 col-sm-6 col-md-6 text-right style2">
          <h3 class="irs-social-media-ttl">Edu Hub Social Networks:</h3>
        </div>
        <div class="col-sm-12 col-sm-6 col-md-6">
          <div class="irs-sm-details">
            <ul class="list-inline">
              <li><a href="#"><span class="flaticon-social-3"></span></a></li>
              <li><a href="#"><span class="flaticon-social-4"></span></a></li>
              <li><a href="#"><span class="flaticon-social-1"></span></a></li>
              <li><a href="#"><span class="flaticon-social-media"></span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection