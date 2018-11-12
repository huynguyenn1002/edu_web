@extends('admin.layouts.main')

@section('style')
  <style>
    .video-container {
      display: flex;
      align-items: center;
      text-align: center;
    }

    .video-container .btn {
      background: rgba(0, 0, 0, 0);
      font-size: 50px;
      font-weight: 400;
    }
  </style>
@endsection

@section('content')
  <div class="col-md-12">
    <a href="{{ route('admin.course.request', ['course' => $course->id]) }}" class="btn btn-lg">
      < Back to course
    </a>
  </div>
  <div class="container-fluid">
    <div class="row margin-bottom-20">
      <div class="col-md-8 col-md-offset-2">
        <h1>{{ $video->name }} <small class="pull-right text-thm2">Score: {{ $video->score }}</small></h1>
        <p>{{ $video->description }}</p>
      </div>
    </div>
    <div class="row video-container">
      <div class="col-md-2">
        @if($prev)
          @if(get_class($prev) === \App\Video::class)
            <a href="{{ route('admin.watch_video', ['course' => $course->id, 'video' => $prev->id]) }}"
               class="btn btn-lg" data-toggle="tooltip" title="Prev: {{ $prev->name }} (Video)">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
          @elseif(get_class($prev) === \App\RequiredProject::class)
            <a href="{{ route('admin.get_submit_project', ['course' => $course->id, 'project' => $prev->id]) }}"
               class="btn btn-lg" data-toggle="tooltip" title="Prev: {{ $prev->name }} (Project)">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
          @endif
        @endif
      </div>
      <div class="col-md-8">
        <iframe id="y-video" src="" frameborder="0" height="600px" allowfullscreen></iframe>
      </div>
      <div class="col-md-2">
        @if($next)
          @if(get_class($next) === \App\Video::class)
            <a href="{{ route('admin.watch_video', ['course' => $course->id, 'video' => $next->id]) }}"
               class="btn btn-lg" data-toggle="tooltip" title="Next: {{ $next->name }} (Video)">
              <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
          @elseif(get_class($next) === \App\RequiredProject::class)
            <a href="{{ route('admin.get_submit_project', ['course' => $course->id, 'project' => $next->id]) }}"
               class="btn btn-lg" data-toggle="tooltip" title="Next: {{ $next->name }} (Project)">
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
          let url = '{{ $video->url }}'.replace("watch?v=", "embed/");
          let id = new URL('{{ $video->url }}').searchParams.get('v');
          $('#y-video').attr('src', url);

      });
  </script>
@endsection
