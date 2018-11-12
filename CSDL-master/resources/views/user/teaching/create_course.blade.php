@extends('layouts.dashboard')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/bootstrap-fileinput.css') }}">
  <link rel="shortcut icon" href="favicon.ico"/>

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

    textarea[name^="description"] {
      margin-top: 20px !important;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    @if(count($errors) > 0)
      <div class="alert alert-danger error-msg">
        <strong>Submit failed!</strong> Please try again
      </div>
      <div class="alert alert-danger error-msg">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif
    <div class="portlet light form-fit bordered">
      <div class="portlet-title">
        <div class="caption center-block">
          <i class="icon-settings font-green"></i>
          <span class="caption-subject font-green sbold uppercase">Create Course</span>
        </div>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal form-bordered" enctype="multipart/form-data"
              action="{{ route('user.create_course') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-2">Course Name</label>
              <div class="col-md-9">
                <input class="no-border form-control" type="text" placeholder="JS essentials, PHP, ..."
                       value="{{ old('name') }}"
                       name="name" required/>
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">About this course</label>
              <div class="col-md-9">
              <textarea class="no-border form-control" rows="4" placeholder="The best course ever"
                        name="course_description" required>{{ old('course_description') }}</textarea>
                @if ($errors->has('course_description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('course_description') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group ">
              <label class="control-label col-md-2">Course image</label>
              <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-height: 300px"></div>
                  <div>
                  <span class="btn red btn-outline btn-file">
                      <span class="fileinput-new"> Avatar </span>
                      <span class="fileinput-exists"> Change Avatar </span>
                      <input type="file" name="avatar" required> </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-height: 300px"></div>
                  <div>
                <span class="btn red btn-outline btn-file">
                    <span class="fileinput-new"> Cover </span>
                    <span class="fileinput-exists"> Change Cover </span>
                    <input type="file" name="cover" required> </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                  </div>
                </div>
              </div>
              @if ($errors->has('avatar') || $errors->has('cover'))
                <span class="help-block">
                <strong>{{ $errors->first('avatar') }}</strong>
                <strong>{{ $errors->first('cover') }}</strong>
              </span>
              @endif
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Category</label>
              <div class="col-md-3">
                <select class="form-control" name="category_id" required>
                  <option value="" selected>Your course is about ...</option>
                  @foreach($courseCategories as $courseCategory)
                    <option value="{{ $courseCategory->id }}">{{ $courseCategory->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('category_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Cost</label>
              <div class="col-md-3">
                <div class="input-group">
                  <input class="form-control" type="text" placeholder="0" value="{{ old('cost') }}"
                         name="cost" required/>
                  <span class="input-group-addon">$</span>
                </div>
                @if ($errors->has('cost'))
                  <span class="help-block">
                    <strong>{{ $errors->first('cost') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group mt-element-list last">
              <label class="control-label col-md-2">Course Contents</label>
              <div class="col-md-10 mt-list-container list-simple">
                <ul id="sortable"></ul>
                <button id="btn-add" type="button" class="btn green btn-block margin-top-15">
                  <i class="fa fa-plus"></i> Add content
                </button>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-2 col-md-9">
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
          let countContent = 1;

          $("#sortable").sortable({update: updatePosition});

          $("#sortable").find('select').change(function () {
              changeInputType.call(this);
          });

          $("#sortable").find('.btn-remove').click(function () {
              removeCourseContent.call(this)
          });

          $('#btn-add').click(appendCourseContent);

          function appendCourseContent() {
              let newLi = $(`
                <li class="mt-list-item form-inline">
                  <span data-id="${ countContent }" class="content-order">${ $('.content-order').length + 1 }</span>
                  <select data-id="${ countContent }" class="form-control" name="content_type[]" required>
                    <option value="">Content type</option>
                    <option value="0">Video URL</option>
                    <option value="2">Project</option>
                  </select>
                  <input data-id="${ countContent }" type="text" class="new-course-content form-control" disabled
                         name="title[]" required/>
                  <input data-id="${ countContent }" type="text" class="new-course-content form-control" disabled
                         name="score[]" required/>
                  <input data-id="${ countContent }" type="text" class="new-course-content form-control" disabled
                       name="url[]" required/>
                  <textarea data-id="${ countContent }" rows="4" cols="96" class="form-control" disabled
                       name="description[]" required></textarea>
                  <button type="button" class="btn sbold uppercase btn-outline red-haze pull-right btn-remove">-</button>
                </li>
              `);
              newLi.find('select').change(function () {
                  changeInputType.call(this);
              });
              newLi.find('.btn-remove').click(function () {
                  removeCourseContent.call(this)
              });
              $('#sortable').append(newLi);
              countContent++;
          }

          function updatePosition() {
              $("#sortable").children().each(function (index) {
                  $(this).find('.content-order').html(index + 1)
              });
          }

          function removeCourseContent() {
              $(this).parent().remove();
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
              let scoreEl = $(`input[data-id="${ id }"][name^="score"]`);
              let descEl = $(`textarea[data-id="${ id }"][name^="description"]`);
              if (inputType) {
                  titleEl.prop('disabled', false);
                  urlEl.show();
                  urlEl.prop('disabled', false);
                  descEl.prop('disabled', false);
                  scoreEl.prop('disabled', false);
                  scoreEl.prop('placeholder', 'Score');
              }
              switch (inputType) {
                  case '0':
                      indexEl.css(bgVideoURL);
                      urlEl.attr('type', 'url');
                      urlEl.prop('required', true);
                      urlEl.prop('placeholder', 'Youtube URL');
                      titleEl.prop('placeholder', 'Video Title');
                      descEl.prop('placeholder', 'Video content description');
                      break;
                  case '2':
                      indexEl.css(bgProject);
                      urlEl.prop('required', false);
                      urlEl.hide();
                      titleEl.prop('placeholder', 'Project Title');
                      descEl.prop('placeholder', 'Project requirement description');
                      break;
              }
          }
      });
  </script>

@endsection
