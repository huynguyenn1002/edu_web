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
          <span>Student project</span>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>{{ $studentProject->id }}</span>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>files</span>
        </li>
      </ul>
    </div>
    <h3 class="page-title"><strong>Course:</strong> {{ $course->name }} </h3>
    <div class="panel-group" id="collapsePanel" role="tablist" aria-multiselectable="true">
      @foreach($files as $file)
        <div class="portlet light bordered">
          <div class="portlet-title">
            <div class="caption">
              <a target="_blank"
                 href="{{ route('user.download_project_file', ['course' => $course->id, 'student_project' => $studentProject->id, 'file' => $file->id]) }}">
                <i class="icon-doc font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">{{ $file->name }}</span>
                <small>Download file to see detail</small>
              </a>
            </div>
            <div class="actions">
              <a class="btn btn-circle btn-icon-only btn-default" target="_blank"
                 href="{{ route('user.download_project_file', ['course' => $course->id, 'student_project' => $studentProject->id, 'file' => $file->id]) }}">
                <i class="icon-cloud-download"></i>
              </a>
            </div>
          </div>
          <div class="portlet-body">
            <p>{{ $file->description }}</p>
          </div>
        </div>
      @endforeach

      <div class="text-center">
        <a href="{{ route('user.approve_student_project', ['course' => $course->id, 'student_project' => $studentProject->id]) }}"
           class="btn btn-lg btn-success margin-right-10">
          <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          Good
        </a>
        <button type="button" id="btnReject" class="btn btn-lg btn-danger">
          <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
          Bad
        </button>
      </div>
    </div>
  </div>
  <div id="modalConfirmReject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-red-haze font-white text-center">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Reject Student Project</h4>
        </div>
        <form action="{{ route('user.reject_student_project', ['course' => $course->id, 'student_project' => $studentProject->id]) }}" class="form-horizontal" method="POST">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="form-group">
              <label for="inpRejectReason" class="col-md-3">Reject reason: </label>
              <div class="col-md-9">
                <textarea id="inpRejectReason" name="reject_reason" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn default" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button type="submit" class="btn blue">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function(){
      $('#btnReject').click(function(){
         $('#modalConfirmReject').modal('show');
      });
    });
  </script>
@endsection