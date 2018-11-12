@extends('layouts.main')

@section('content')

  <!-- Breadcrumbs Styles -->
  <section class="irs-ip-breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3 text-center">
          <h1 class="irs-bc-title">Teacher</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Breadcrumbs html -->
  <section class="irs-ip-brdcrumb">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-right irs-bb-right">
          <ul class="list-inline irs-brdcrmb">
            <li><a href="#">Home</a></li>
            <li><a href="#"> > </a></li>
            <li><a href="#">Teacher Information</a></li>
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
            <div class="col-md-4 irs-mrgnbtm-sxty">
              <div class="irs-courses-td-sngle">
                <div class="irs-ctds-thumb">
                  <img class="img-responsive img-fluid" src="{{ \Storage::url($teacher->avatar) }}" alt="tmd1.png">
                </div>
              </div>
            </div>
            <div class="col-md-8 irs-mrgnbtm-sxty">
              <div class="irs-courses-td-sngle-dtls irs-all-course-bb">
                <h2>{{ $teacher->name }}</h2>
                <p style="color: grey"><i class="fa fa-birthday-cake" aria-hidden="true"></i> {{ $teacher->DOB }}</p>
                <h3>Teaching score:</h3>
                <p><i style="color: gold" class="fa fa-trophy" aria-hidden="true"></i> {{ $teacher->teaching_score }}
                </p>

              </div>
              <ul class="list-inline irs-tctt">
                <li><span class="text-thm2 flaticon-key-1"></span> {{ $teacher->address }}</li>
                <li><span class="text-thm2 flaticon-multimedia"></span> {{ $teacher->email }}</li>
              </ul>
              <div class="irs-social-icon-td-sngle-dtls">
                <ul class="list-inline irs-courses-tdetls style2">
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
              <div class="irs-cdtls-ttbg2">
                <h3>Teaching Courses</h3>
                <div class="irs-td-carousel">
                  @foreach($teacher->teachingCourses as $course)
                  <div class="item">
                    <div class="irs-lc-grid style2 text-center">
                      <div class="irs-lc-grid-thumb">
                        <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                          <img class="img-responsive img-fluid" src="{{ Storage::url($course->avatar) }}" alt="5.jpg">
                          <div class="irs-lc-price">$ {{ $course->cost }}</div>
                        </a>
                      </div>
                      <div class="irs-lc-details">
                        <h4><a href="{{ route('course-info', ['id' => $course->id ]) }}">{{ $course->name }}</a></h4>
                      </div>

                      <div class="irs-lc-footer">
                        <div class="irs-lc-normal-part">
                          <ul class="list-inline">
                            <li><a href="{{ route('course-info', ['id' => $course->id ]) }}"><i class="fa fa-users"></i> {{ $course->buyers->count() }}</a></li>
                            <li class="irs-ccomment">
                              <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                                <span class="fa fa-star" aria-hidden="true"></span> {{ number_format($course->avg_rating, 0) }}
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="irs-lc-hover-part">See Course</div>
                      </div>

                    </div>
                  </div>
                  @endforeach
                </div>
              </div>

            </div>
          </div>
        </div>
        @include('includes.right-sidebar')
      </div>
    </div>
  </section>

  @include('includes.footer')
@endsection
