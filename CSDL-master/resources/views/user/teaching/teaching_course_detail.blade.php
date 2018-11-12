@extends('layouts.dashboard')

@section('style')
  <link href="{{ asset('css/pages/daterangepicker.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/pages/morris.css') }}" rel="stylesheet" type="text/css"/>
  <style>
    .btn-circle {
      max-width: 25px;
      max-height: 25px;
      padding-top: 4px !important;
    }
  </style>

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
        </li>
      </ul>
      <div class="page-toolbar">
        @if($course->buyers()->count() > 0)
          <a href="{{ route('user.show_student_projects', ['course' => $course->id]) }}"
             class="btn blue-steel btn-sm margin-right-10">
            <strong class="margin-right-10">Student projects</strong>
            <span class="btn btn-circle btn-icon-only btn-default font-blue-steel">{{ $studentProjects }}</span>
          </a>
        @else
          <div class="btn-group pull-right">
            <button type="button" class="btn yellow-gold btn-sm btn-outline dropdown-toggle" data-toggle="dropdown">
              Edit course
              <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <li>
                <a href="{{ route('user.get_update_course_info', ['course' => $course->id]) }}">
                  <i class="icon-pencil"></i> Update info</a>
              </li>
              <li>
                <a href="{{ route('user.get_update_course_contents', ['course' => $course->id]) }}">
                  <i class="icon-book-open"></i> Update contents</a>
              </li>
              <li>
                <a href="{{ route('user.delete_course', ['course' => $course->id]) }}">
                <i class="icon-close"></i> Delete course </a>
              </li>
            </ul>
          </div>
        @endif
      </div>
    </div>
    <h3 class="page-title"><strong>Course:</strong> {{ $course->name }}
      <small>dashboard & statistics</small>
      <span class="pull-right font-yellow-gold">${{ $course->cost }}</span>
    </h3>
    @php
      $ratingRank = $course->getRatingRank();
      $buyingRank = $course->getBuyingRank();
    @endphp
    @if ($course->status === \App\Course::STATUS_PENDING)
      <div class="portlet light form-fit bordered">
        <div class="portlet-title">
          <div class="caption center-block">
            <i class="icon-clock font-green"></i>
            <span class="caption-subject font-green sbold uppercase">Your course is now under our censorship!</span>
          </div>
        </div>
      </div>
    @elseif ($course->status === \App\Course::STATUS_REJECTED)
      <div class="portlet light bordered">
        <div class="portlet-title">
          <div class="caption">
            <span class="caption-subject font-red-haze sbold uppercase">Your course is rejected by our admin!</span>
          </div>
        </div>
        <div class="portlet-body">
          <div class="row">
            <h4><i class="icon-speech font-green"> </i> {{ $course->reject_reason }}</h4>
          </div>
        </div>
      </div>
    @elseif ($course->status === \App\Course::STATUS_ACTIVE)
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <a class="dashboard-stat dashboard-stat-v2 yellow-lemon" href="#">
            <div class="visual">
              <i class="fa fa-star-half"></i>
            </div>
            <div class="details">
              <div class="number">
                <span data-counter="counterup" data-value="{{ $ratingRank['avg_rating'] }}">0</span>
              </div>
              <div class="desc">
                Rating point
                <cite>
                  (Rank: <span data-counter="counterup" data-value="{{ $ratingRank['rank'] }}">0</span>)
                </cite>
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
              <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
              <div class="number">
                <span data-counter="counterup" data-value="{{ $buyingRank['buyers'] }}">0</span>
              </div>
              <div class="desc">
                Total Student
                <cite>
                  (Rank: <span data-counter="counterup" data-value="{{ $buyingRank['rank'] }}">0</span>)
                </cite>
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
            <div class="visual">
              <i class="fa fa-globe"></i>
            </div>
            <div class="details">
              <div class="number">
                <span data-counter="counterup" data-value="{{ $course->getTotalBuyers() * $course->cost }}"></span> $
              </div>
              <div class="desc"> Total Profits</div>
            </div>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
              <i class="fa fa-comments"></i>
            </div>
            <div class="details">
              <div class="number">
                <span data-counter="counterup" data-value="{{ $course->getBuyersInPeriod(7) }}">0</span>
              </div>
              <div class="desc"> New Students (this week)</div>
            </div>
          </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <a class="dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
              <div class="number"> +
                <span data-counter="counterup" data-value="{{ $course->getBuyersInPeriod(7) * $course->cost }}">0</span>
                $
              </div>
              <div class="desc"> Week Profits</div>
            </div>
          </a>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-sm-12">
          <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        </div>
      </div>
    @endif
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/pages/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('js/pages/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('js/pages/jquery.canvasjs.min.js') }}"></script>
  <script>
      $(document).ready(function () {
          let options = {
              animationEnabled: true,
              title: {
                  text: "Monthly Sales"
              },
              axisX: {
                  valueFormatString: "DD/MM/YYYY"
              },
              axisY: {
                  title: "Sales (in USD)",
                  prefix: "$",
                  titleFontColor: "#4F81BC",
                  lineColor: "#4F81BC",
                  tickColor: "#4F81BC",
              },
              data: [
                  {
                      yValueFormatString: "$#,###",
                      xValueFormatString: "MM/YYYY",
                      type: "spline",
                      dataPoints: [
                          @foreach($monthlyBuyers as $monthlyBuyer)
                          {
                              x: new Date('{{ $monthlyBuyer->month}}'),
                              y: parseInt({{ $monthlyBuyer->buyers * $course->cost }})
                          },
                        @endforeach
                      ]
                  }
              ]
          };
          $("#chartContainer").CanvasJSChart(options);
      });
  </script>
@endsection