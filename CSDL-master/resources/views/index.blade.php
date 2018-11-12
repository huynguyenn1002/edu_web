@extends('layouts.main')

@section('content')
  @include('includes.slider')
  <section class="irs-courses-one">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div>
            <ul class="nav nav-tabs irs-course-tab clear-fix" role="tablist">
              <li class="irs-course-title pull-left"><h3>Edu Hub Courses</h3></li>
              <li role="presentation">
                <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Top Rated</a>
              </li>
              <li role="presentation">
                <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Most Popular</a>
              </li>
              <li role="presentation" class="active">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Recently Added</a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
                @foreach($r_courses as $course)
                  <div class="col-xs-12 col-sm-6 col-md-3 irs-ext-pad animatedParent">
                    <div class="irs-courses-fstcol animated fadeIn delay-250">
                      <div class="irs-course-thumb">
                        <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                          <img class="img-responsive img-fluid" src="{{ Storage::url($course->avatar) }}" alt="1.jpg">
                        </a>
                      </div>
                      <div class="irs-course-details">
                        <ul class="list-inline">
                          <li class="irs-user">
                            <a href="#"><span class="flaticon-people-1"></span> {{ $course->buyers }}</a></li>
                          <li class="irs-ccomment"><a href="#"><span class="fa fa-star" aria-hidden="true"></span> {{ number_format($course->avg_rating, 0) }}</a></li>
                          <li class="irs-course-price"><a href="#" class="text-thm2"><span class=""></span>
                              ${{ $course->cost }}</a></li>
                        </ul>
                        <h3><a href="{{ route('course-info', ['id' => $course->id ]) }}">{{ $course->name }}</a></h3>
                        <div class="irs-student-info">
                          <div class="irs-studend-thumb"><img class="img-responsive img-circle"
                                                              src="{{ Storage::url($course->teacher_avatar) }}"
                                                              alt="student1.png"></div>
                          <div class="irs-student-name">
                            <a href="{{ route('teacher-info', ['id' => $course->teacher_id]) }}">
                              with <span class="text-thm2">{{ $course->teacher_name }}</span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div role="tabpanel" class="tab-pane" id="profile">
                @foreach($p_courses as $course)
                  <div class="col-xs-12 col-sm-6 col-md-3 irs-ext-pad animatedParent">
                    <div class="irs-courses-fstcol animated fadeIn delay-250">
                      <div class="irs-course-thumb">
                        <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                          <img class="img-responsive img-fluid" src="{{ Storage::url($course->avatar) }}" alt="1.jpg">
                        </a>
                      </div>
                      <div class="irs-course-details">
                        <ul class="list-inline">
                          <li class="irs-user">
                            <a href="#"><span class="flaticon-people-1"></span> {{ $course->buyers }}</a></li>
                          <li class="irs-ccomment"><a href="#"><span class="fa fa-star" aria-hidden="true"></span> {{ number_format($course->avg_rating, 0) }}</a></li>
                          <li class="irs-course-price"><a href="#" class="text-thm2"><span class=""></span>
                              ${{ $course->cost }}</a></li>
                        </ul>
                        <h3><a href="{{ route('course-info', ['id' => $course->id ]) }}">{{ $course->name }}</a></h3>
                        <div class="irs-student-info">
                          <div class="irs-studend-thumb"><img class="img-responsive img-circle"
                                                              src="{{ Storage::url($course->teacher_avatar) }}"
                                                              alt="student1.png"></div>
                          <div class="irs-student-name">
                            <a href="{{ route('teacher-info', ['id' => $course->teacher_id]) }}">
                              with <span class="text-thm2">{{ $course->teacher_name }}</span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div role="tabpanel" class="tab-pane" id="messages">
                @foreach($t_courses as $course)
                  <div class="col-xs-12 col-sm-6 col-md-3 irs-ext-pad animatedParent">
                    <div class="irs-courses-fstcol animated fadeIn delay-250">
                      <div class="irs-course-thumb">
                        <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                          <img class="img-responsive img-fluid" src="{{ Storage::url($course->avatar) }}" alt="1.jpg">
                        </a>
                      </div>
                      <div class="irs-course-details">
                        <ul class="list-inline">
                          <li class="irs-user">
                            <a href="#"><span class="flaticon-people-1"></span> {{ $course->buyers }}</a></li>
                          <li class="irs-ccomment"><a href="#"><span class="fa fa-star" aria-hidden="true"></span> {{ number_format($course->avg_rating, 0) }}</a></li>
                          <li class="irs-course-price"><a href="#" class="text-thm2"><span class=""></span>
                              ${{ $course->cost }}</a></li>
                        </ul>
                        <h3><a href="{{ route('course-info', ['id' => $course->id ]) }}">{{ $course->name }}</a></h3>
                        <div class="irs-student-info">
                          <div class="irs-studend-thumb"><img class="img-responsive img-circle"
                                                              src="{{ Storage::url($course->teacher_avatar) }}"
                                                              alt="student1.png"></div>
                          <div class="irs-student-name">
                            <a href="{{ route('teacher-info', ['id' => $course->teacher_id]) }}">
                              with <span class="text-thm2">{{ $course->teacher_name }}</span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter Section -->
  <section class="irs-newsletter-subscribe">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
          <h2>Get our Edu Hub latest courses & promos on your email:</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="irs-nl-form">
            <form>
              <div class="form-group">
                <input class="form-control" id="email3" placeholder="Your Email Address">
                <button type="submit" class="btn btn-default pull-right"><span class="flaticon-note"></span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('includes.footer')
@endsection

@section('script')
  <script>
      let swiper = new Swiper('.swiper-container', {
          pagination: '.swiper-pagination',
          slidesPerView: 2,
          slidesPerColumn: 2,
          paginationClickable: true,
          spaceBetween: 20,
          mousewheelControl: true
      });
  </script>
@endsection