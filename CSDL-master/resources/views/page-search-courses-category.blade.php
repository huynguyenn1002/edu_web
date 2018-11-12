@extends('layouts.main')

@section('content')
    <section class="irs-ip-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 text-center">
                    <h1 class="irs-bc-title">Courses</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="irs-ip-brdcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right irs-bb-right">
                    <ul class="list-inline irs-brdcrmb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#"> > </a></li>
                        <li><a href="#">Courses</a></li>
                        <li><a href="#"> > </a></li>
                        <li><a class="active" href="#">{{ $category->name }}</a></li>
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
                            <li><a href="#"><span class="flaticon-squares text-thm2"></span></a></li>
                            <li><a href="#"><span class="flaticon-signs-3"></span></a></li>
                            <li>
                                <a href="#">
                                    Showing {{ ($courses->currentPage()-1)*config('view.paginate') }}-{{ $courses->currentPage()*config('view.paginate') < $courses->total() ? $courses->currentPage()*config('view.paginate'):$courses->total() }} of {{ $courses->total() }} results
                                </a>
                            </li>
                        </ul>
                        <form method="GET" action="{{ route('search.course.category',['category_id'=>$category->id]) }}"">
                        <div class="input-group irs-nav-search-form">

                            <input type="text" class="form-control pull-right" placeholder="Search courses" name="name">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="flaticon-musica-searcher"></span></button>
                            </span>

                        </div><!-- /input-group -->
                        </form>
                    </div>
                    <div class="row irs-all-course-bb clearfix">
                        @foreach($courses as $course)
                            <div class="col-sm-6 col-md-6 col-lg-4 clearfix">
                                <div class="irs-lc-grid style2 text-center">
                                    <div class="irs-lc-grid-thumb">
                                        <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                                            <img class="img-responsive img-fluid" src="{{ Storage::url($course->avatar) }}" alt="5.jpg">
                                            <div class="irs-lc-price">$ {{ $course->cost }}</div>
                                        </a>
                                    </div>
                                    <div class="irs-lc-details">
                                        <div class="irs-lc-teacher-info">
                                            <a href="{{ route('teacher-info', ['id' => $course->teacher_id]) }}">
                                                <div class="irs-lct-thumb">
                                                    <img class="img-responsive img-circle" style="max-height: 50px; max-width: 50px;" src="{{ Storage::url($course->teacher->avatar) }}" alt="s3.png">
                                                </div>
                                                <div class="irs-lct-info">with <span class="text-thm2"> {{ $course->teacher->name }}</span></div>
                                            </a>
                                        </div>
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
                    <div class="text-center">
                        {!! $courses->appends(Request::only('name'))->links() !!}
                    </div>
                </div>
                @include('includes.right-sidebar')
            </div>
        </div>
    </section>
@endsection
