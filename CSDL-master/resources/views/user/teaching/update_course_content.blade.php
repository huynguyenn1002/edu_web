@extends('layouts.dashboard')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/bootstrap-fileinput.css') }}">
  <style>
    .no-border,
    .no-border:focus {
      border: none;
      outline: none;
    }

    .content-order {
      padding: 0 15px;
      margin-right: 15px;
      border-right: solid 1px #ddd;
    }

    textarea {
      margin-top: 10px !important;
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
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>Update course content</span>
        </li>
      </ul>
    </div>
    <h3 class="page-title"><strong>Course:</strong> {{ $course->name }} </h3>
    @if ($errors->has('create_failed'))
      <span class="help-block">
            <strong>{{ $errors->first('create_failed') }}</strong>
        </span>
    @endif
    <div class="portlet light form-fit bordered">
      <div class="portlet-title">
        <div class="caption center-block">
          <i class="icon-settings font-green"></i>
          <span class="caption-subject font-green sbold uppercase">Update Course Contents</span>
        </div>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal form-bordered" novalidate
              action="{{ route('user.post_update_course_contents', ['course' => $course->id]) }}" method="POST">
          {{ method_field('PUT') }}
          {{ csrf_field() }}
          <div class="form-group mt-element-list last">
            <div class="col-md-12 mt-list-container list-simple">
              <ul id="sortable">
                @php
                  $no = 0;
                @endphp
                @foreach($courseContents as $key => $courseContent)
                  @php
                    $no++;
                  @endphp
                  <li class="mt-list-item form-inline">
                    <div class="row">
                      @if(get_class($courseContent) === \App\Video::class)
                        <div class="col-md-8">
                          <span data-id="{{ $no }}" class="content-order"
                                style="background-color: #1BBC9B; color: white;">
                            {{ $no }}
                          </span>
                          <input data-id="{{ $no }}" type="hidden" value="{{ $courseContent->id }}"
                                 name="id[{{ $no }}]">
                          <input data-id="{{ $no }}" type="hidden" value="0" name="old_type[{{ $no }}]">
                          <select data-id="{{ $no }}" class="form-control" name="content_type[{{ $no }}]" required>
                            <option value="">Content type</option>
                            <option value="0" selected>Video URL</option>
                            <option value="2">Project</option>
                          </select>
                          <input data-id="{{ $no }}" type="text"
                                 class="new-course-content form-control"
                                 name="title[{{ $no }}]" value="{{$courseContent->name }}" required/>
                          <input data-id="{{ $no }}" type="text"
                                 class="new-course-content form-control" placeholder="URL"
                                 name="score[{{ $no }}]" value="{{$courseContent->score }}" required/>
                          <textarea data-id="{{ $no }}" rows="1" cols="70" class="form-control"
                                    name="url[{{ $no }}]" required>{{ $courseContent->url }}</textarea>
                          <textarea data-id="{{ $no }}" rows="4" cols="70" class="form-control"
                                    name="description[{{ $no }}]" required>{{ $courseContent->description }}</textarea>
                          <button type="button" class="btn sbold uppercase btn-outline red-haze pull-right btn-remove">
                            -
                          </button>
                        </div>
                        <div class="col-md-4">
                          <iframe src="" frameborder="0"></iframe>
                        </div>
                      @elseif(get_class($courseContent) === \App\RequiredProject::class)
                        <div class="col-md-8">
                          <span data-id="{{ $no }}" class="content-order"
                                style="background-color: #F7CA18; color: white;">
                            {{ $no }}
                          </span>
                          <input data-id="{{ $no }}" type="hidden" value="{{ $courseContent->id }}"
                                 name="id[{{ $no }}]">
                          <input data-id="{{ $no }}" type="hidden" value="2" name="old_type[{{ $no }}]">
                          <select data-id="{{ $no }}" class="form-control" name="content_type[{{ $no }}]" required>
                            <option value="">Content type</option>
                            <option value="0">Video URL</option>
                            <option value="2" selected>Project</option>
                          </select>
                          <input data-id="{{ $no }}" type="text"
                                 class="new-course-content form-control"
                                 name="title[{{ $no }}]" value="{{$courseContent->name }}" required/>
                          <input data-id="{{ $no }}" type="text"
                                 class="new-course-content form-control" placeholder="Score"
                                 name="score[{{ $no }}]" value="{{$courseContent->score }}" required/>
                          <textarea data-id="{{ $no }}" rows="4" cols="70" class="form-control"
                                    name="description[{{ $no }}]" required>{{ $courseContent->description }}</textarea>
                          <button type="button" class="btn sbold uppercase btn-outline red-haze pull-right btn-remove">
                            -
                          </button>
                        </div>
                      @endif
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
            <button id="btn-add" type="button" class="btn yellow-lemon btn-block margin-top-15">
              <i class="fa fa-plus"></i> Add content
            </button>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
                <a href="{{ route('index') }}" class="btn btn-outline grey-salsa">Cancel</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/bootstrap-fileinput.js') }}" type="text/javascript"></script>

  <script>
      $(function () {
          $("#sortable").sortable({update: updatePosition});

          $("#sortable").find('select').change(function () {
              changeInputType.call(this);
          });

          $("#sortable").find('.btn-remove').click(function () {
              removeCourseContent.call(this)
          });

          $('#btn-add').click(appendCourseContent);

          let urlInps = $('textarea[name^="url"]');

          urlInps.each(function (i, urlInp) {
              updateIframeVideo.call(urlInp);
          });

          urlInps.change(function () {
              updateIframeVideo.call(this);
          });

          function appendCourseContent() {
              let countContent = $('.content-order').length + 1;
              let newLi = $(`
                <li class="mt-list-item form-inline">
                  <div class="row">
                    <div class="col-md-8">
                      <span data-id="${ countContent }" class="content-order">${ countContent }</span>
                      <select data-id="${ countContent }" class="form-control" name="content_type[${ countContent }]" required>
                        <option value="">Content type</option>
                        <option value="0">Video URL</option>
                        <option value="2">Project</option>
                      </select>
                      <input data-id="${ countContent }" type="text" class="new-course-content form-control" disabled
                             name="title[${ countContent }]" required/>
                      <input data-id="${ countContent }" type="text" class="new-course-content form-control" disabled
                           name="url[${ countContent }]" required/>
                      <textarea data-id="${ countContent }" rows="4" cols="70" class="form-control" disabled
                           name="description[${ countContent }]" required></textarea>
                      <button type="button" class="btn sbold uppercase btn-outline red-haze pull-right btn-remove">-</button>
                    </div>
                    <div class="col-md-4">
                      <iframe src="" frameborder="0"></iframe>
                    </div>
                  </div>
                </li>
              `);
              newLi.find('select').change(function () {
                  changeInputType.call(this);
              });
              newLi.find('textarea[name^="url"]').change(function () {
                  updateIframeVideo.call(this);
              });
              newLi.find('.btn-remove').click(function () {
                  removeCourseContent.call(this)
              });
              $('#sortable').append(newLi);
              countContent++;
          }

          function updateIframeVideo() {
              let embedLink = getYoutubeEmbedLink($(this).val());
              $(this).closest('li').find('iframe').attr('src', embedLink);
          }

          function getYoutubeEmbedLink(url) {
              return url.replace("watch?v=", "embed/");
          }

          function updatePosition() {
              $("#sortable").children().each(function (index) {
                  $(this).find('.content-order').html(index + 1)
              });
          }

          function removeCourseContent() {
              let li = $(this).closest('li');
              let contentID = li.find('input[name^="id"]').length > 0 ? li.find('input[name^="id"]').val() : null;
              if (contentID) {
                  if (li.find('select[name^="content_type"]').val() === '0') {
                      $('form').append(`
                        <input type="hidden" name="deleted_video[]" value="${ contentID }">
                      `);
                  } else {
                      $('form').append(`
                        <input type="hidden" name="deleted_project[]" value="${ contentID }">
                      `);
                  }

              }

              li.remove();
              updatePosition();
          }

          const bgVideoURL = {
              'background-color': '#1BBC9B',
              'color': 'white'
          };
          const bgProject = {
              'background-color': '#F7CA18',
              'color': 'white'
          };

          function changeInputType() {
              let id = $(this).data('id');
              let inputType = $(this).find('option:selected').val();
              let indexEl = $(`span[data-id="${ id }"]`);
              let titleEl = $(`input[data-id="${ id }"][name^="title"]`);
              let urlEl = $(`input[data-id="${ id }"][name^="url"]`);
              let descEl = $(`textarea[data-id="${ id }"][name^="description"]`);
              if (inputType) {
                  titleEl.prop('disabled', false);
                  urlEl.show();
                  urlEl.prop('disabled', false);
                  descEl.prop('disabled', false);
              }
              switch (inputType) {
                  case '0':
                      indexEl.css(bgVideoURL);
                      urlEl.attr('type', 'url');
                      urlEl.prop('placeholder', 'Youtube URL');
                      titleEl.prop('placeholder', 'Video Title');
                      descEl.prop('placeholder', 'Video content description');
                      break;
                  case '2':
                      indexEl.css(bgProject);
                      urlEl.hide();
                      titleEl.prop('placeholder', 'Project Title');
                      descEl.prop('placeholder', 'Project requirement description');
                      break;
              }
          }
      });
  </script>

@endsection
