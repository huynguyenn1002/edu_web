@extends('layouts.main')
@section('style')
  <style>
    .video-container {
      display: flex;
      align-items: center;
      text-align: center;
    }

    .video-container .btn-prev,
    .video-container .btn-next {
      background: rgba(0, 0, 0, 0);
      font-size: 50px;
      font-weight: 400;
    }
    .file-input {
      width: 1px;
      height: 1px;
      overflow: hidden;
    }
    .submit-area {
      border: solid 1px #0F9E5E;
      border-radius: 10px;
      padding-bottom: 20px;
    }

  </style>
@endsection

@section('content')
  <div class="col-md-12">
    <a href="{{ route('user.learn_course', ['course' => $course->id]) }}" class="btn btn-lg">
      < Back to course
    </a>
  </div>
  <div class="container-fluid">
    <div class="row margin-bottom-20">
      <div class="col-md-8 col-md-offset-2">
        <h1>{{ $project->name }} <small class="pull-right text-thm2">Score: {{ $project->score }}</small></h1>
        <p>{{ $project->description }}</p>
      </div>
    </div>
    <div class="row video-container">
      <div class="col-md-2">
        @if($prev)
          @if(get_class($prev) === \App\Video::class)
            <a href="{{ route('user.watch_video', ['course' => $course->id, 'video' => $prev->id]) }}"
               class="btn btn-lg btn-prev" data-toggle="tooltip" title="Prev: {{ $prev->name }} (Video)">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
          @elseif(get_class($prev) === \App\RequiredProject::class)
            <a href="{{ route('user.get_submit_project', ['course' => $course->id, 'project' => $prev->id]) }}"
               class="btn btn-lg btn-prev" data-toggle="tooltip" title="Prev: {{ $prev->name }} (Project)">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
          @endif
        @endif
      </div>
      <div class="col-md-8">
        @if(count($errors) > 0)
          <div class="alert alert-danger error-msg">
            <strong>Submit failed!</strong> Please try again
          </div>
          <div class="alert alert-danger error-msg">
            @foreach($errors->all() as $error)
              {{ $error }}
            @endforeach
          </div>
        @endif
        @if($status === -1 || $status === \App\StudentProject::STATUS_REJECTED)
          <div class="submit-area">
            <h3 style="text-decoration: underline; color: #1BBC9B;">Submit Your Works</h3>
            <hr>
            <form id="mainForm" enctype="multipart/form-data" method="POST"
                  action="{{ route('user.post_submit_project', ['course' => $course->id, 'project' => $project->id]) }}">
              {{ csrf_field() }}
              <ul class="list-group">
              </ul>
              <button id="btnAddFile" type="button" class="btn btn-lg btn-warning">+ Add File</button>
              <button type="submit" class="btn btn-lg btn-success">Submit</button>
            </form>
          </div>
        @endif
        @if($status === \App\StudentProject::STATUS_REJECTED)
          <div class="alert alert-danger error-msg">
            <strong>Your project is rejected by teacher</strong> <br> {{ $reject_reason }}
          </div>
        @elseif($status === \App\StudentProject::STATUS_WAITING_FOR_APPROVE)
          <div class="alert alert-info">
            Your project is now under examination
          </div>
        @elseif($status === \App\StudentProject::STATUS_PASSED)
          <div class="alert alert-success">
            <strong>Exelent!</strong> You passed this lecture
          </div>
        @endif
      </div>
      <div class="col-md-2">
        @if($next)
          @if(get_class($next) === \App\Video::class)
            <a href="{{ route('user.watch_video', ['course' => $course->id, 'video' => $next->id]) }}"
               class="btn btn-lg btn-next" data-toggle="tooltip" title="Next: {{ $next->name }} (Video)">
              <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
          @elseif(get_class($next) === \App\RequiredProject::class)
            <a href="{{ route('user.get_submit_project', ['course' => $course->id, 'project' => $next->id]) }}"
               class="btn btn-lg btn-next" data-toggle="tooltip" title="Next: {{ $next->name }} (Project)">
              <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
          @endif
        @endif
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
      $(document).ready(() => {
          let mainForm = $('#mainForm');
          let fileList = mainForm.find('.list-group');
          let btnAddFile = $('#btnAddFile');
          let index = 0;

          btnAddFile.click(function () {
              appendFileInput();
          });

          function appendFileInput() {
              let inputDiv = $(`
                <li>
                  <div class="form-horizontal">
                      <div class="file-input">
                        <input type="file" name="file[]"  class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2 col-md-offset-2" for="name">File name: </label>
                        <div class="col-sm-6">
                          <input type="text" name="name[]" class="form-control" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2 col-md-offset-2" for="comment">Comment: </label>
                        <div class="col-sm-6">
                          <textarea name="comment[]" class="form-control" placeholder="Content description, implementation, ..."></textarea>
                        </div>
                      </div>
                      <button type="button" class="btn-edit btn btn-sm btn-primary">Change</button>
                      <button type="button" class="btn-delete btn btn-sm btn-danger">Delete</button>
                  </div>
                  <hr>
                </li>
              `);
              inputDiv.find('input[name^="file"]').change(function () {
                  updateFileName.call(this);
              });
              inputDiv.find('.btn-edit').click(function () {
                  inputDiv.find('input[name^="file"]').click();
              });
              inputDiv.find('.btn-delete').click(function () {
                  $(this).parent().parent().remove();
              });
              fileList.append(inputDiv);
              inputDiv.find('input[name^="file"]').click();
          }

          function updateFileName() {
              let parts = $(this).val();
              let ext = parts.split('.')[1];
              let name = parts.split('\\').reverse()[0];
              if (!name || !ext) {
                  return;
              }
              $(this).parent().parent().find('input[name^="name"]').val(name);
          }

          $(document).on('change, click', function () {
              $('.error-msg').fadeOut();
          });
      });
  </script>
@endsection