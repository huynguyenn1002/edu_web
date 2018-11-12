@extends('admin.layouts.main')

@section('content')
  <section class="irs-ip-details irs-padb-svnty">
    <div class="row clearfix">
      <div class="col-sm-12 clearfix">
        <div class="row">
          <div class="col-lg-12">
            <div class="container">
              <div class="irs-courses-details-thumb">
                <img class="img-responsive img-fluid" src="{{ Storage::url($course->cover) }}" alt="cd1.jpg">
              </div>
              <div class="irs-courses-details-title">
                <h2>{{ $course->name }}</h2>
                <ul class="list-inline irs-cl-teacher-info">
                  <li class="irs-cl-thumb">
                    <img style="max-height: 50px; max-width: 50px; border-radius: 50%;"
                         src="{{ Storage::url($course->teacher->avatar) }}"
                         alt="s4.png">
                  </li>
                  <li class="irs-cl-info">with
                    <a href="{{ route('teacher-info', ['id' => $course->teacher->id]) }}">
                      <span class="text-thm2"> {{ $course->teacher->name }}</span>
                    </a>
                  </li>
                  @foreach($stud as  $stud)
                  <li>
                    <a type="button"  class="btn btn-success" @if($stud->numb !==0) disabled @endif
                       href="{{ route('admin.course.approve',['course'=>$course->id] ) }}">Approve</a>
                  </li>
                  <li>
                    <button type="button" id="btnReject" class="btn btn-danger" @if($stud->numb !==0) disabled @endif >
                      <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                      Refuse
                    </button>
                  </li>
                  <li>
                  @endforeach
                    <a class="btn btn-primary"
                       href="{{ route('admin.courses') }}">Back</a>
                  </li>
                </ul>
                <p style="margin-top: 50px;">{{ $course->description }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row irs-mrngtp-svnty">
            <div class="col-lg-12">
              <div class="irs-courses-details">
                <div class="irs-cdetails-tab">
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#curriculum" aria-controls="curriculum" role="tab" data-toggle="tab">
                        Lectures
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="curriculum">
                      <div class="col-md-12">
                        <div class="irs-cdtls-feture-bot2">
                          <ul class="list-group">
                            @foreach($courseContents as $courseContent)
                              <li>
                                @if(get_class($courseContent) === \App\Video::class )
                                  <a class="list-group-item"
                                     href="{{ route('admin.watch_video', ['course' => $course->id, 'video' => $courseContent->id]) }}">
                                    <ul class="list-inline">
                                      <li>
                                        <span>#{{ $courseContent->order_in_course }}</span>
                                      </li>
                                      <li>
                                        <span class="flaticon-business text-thm2"></span> Video
                                      </li>
                                      <li>
                                        <div class="its-tdu">{{ $courseContent->name }} </div>
                                      </li>
                                    </ul>
                                  </a>
                                @elseif(get_class($courseContent) === \App\RequiredProject::class )
                                  <a class="list-group-item"
                                     href="{{ route('admin.get_submit_project', ['course' => $course->id, 'project' => $courseContent->id]) }}">
                                    <ul class="list-inline">
                                      <li>
                                        <span>#{{ $courseContent->order_in_course }}</span>
                                      </li>
                                      <li>
                                        <span class="flaticon-pen text-thm2"></span> Project

                                      <li>
                                        <div class="its-tdu">{{ $courseContent->name }} </div>
                                      </li>
                                    </ul>
                                  </a>
                                @endif
                              </li>
                            @endforeach
                          </ul>
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
    <div id="modalConfirmReject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-red-haze font-white text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Reject Student Project</h4>
          </div>
          <form action="{{ route('admin.course.refuse', ['course'=>$course->id] ) }}" class="form-horizontal" method="POST">
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
              <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
              <button type="submit" class="btn btn-primary">Send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
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
