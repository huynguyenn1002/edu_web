@extends('layouts.dashboard')

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
          <span>Student projects</span>
        </li>
      </ul>
    </div>
    <h3 class="page-title"><strong>Course:</strong> {{ $course->name }} </h3>
    <div class="panel-group col-md-7" id="collapsePanel" role="tablist" aria-multiselectable="true">
      @foreach($projects as $project)
        <div class="panel panel-warning">
          <div class="panel-heading" role="tab" id="heading{{ $project->id }}">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#collapsePanel" href="#collapse{{ $project->id }}"
                 aria-expanded="true" aria-controls="collapse{{ $project->id }}">
                Project: {{ $project->name }}
              </a>
            </h4>
          </div>
          <div id="collapse{{ $project->id }}" class="panel-collapse collapse" role="tabpanel"
               aria-labelledby="heading{{ $project->id }}">
            <div class="panel-body">
              <ul class="list-group">
                @foreach($project->studentProjects as $index => $studentProject)
                  <li class="list-group-item">
                    <span>{{ $index + 1 }}. </span>
                    <a href="{{ route('user.get_check_student_project', ['course' => $course->id,'student_project'=> $studentProject->id]) }}">
                      {{ $studentProject->performer->name }}
                    </a>
                    <span class="badge badge-default"> Submited at: {{$studentProject->updated_at->format('d/m/Y')}} </span>
                    @if($studentProject->status === \App\StudentProject::STATUS_WAITING_FOR_APPROVE)
                      <span class="badge badge-info"> Pending </span>
                    @elseif($studentProject->status === \App\StudentProject::STATUS_PASSED)
                      <span class="badge badge-success"> Passed </span>
                    @elseif($studentProject->status === \App\StudentProject::STATUS_REJECTED)
                      <span class="badge badge-danger"> Rejected </span>
                    @endif
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection