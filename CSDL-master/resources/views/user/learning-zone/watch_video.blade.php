@extends('layouts.main')

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
    <a href="{{ route('user.learn_course', ['course' => $course->id]) }}" class="btn btn-lg">
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
            <a href="{{ route('user.watch_video', ['course' => $course->id, 'video' => $prev->id]) }}"
               class="btn btn-lg" data-toggle="tooltip" title="Prev: {{ $prev->name }} (Video)">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
          @elseif(get_class($prev) === \App\RequiredProject::class)
            <a href="{{ route('user.get_submit_project', ['course' => $course->id, 'project' => $prev->id]) }}"
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
            <a href="{{ route('user.watch_video', ['course' => $course->id, 'video' => $next->id]) }}"
               class="btn btn-lg" data-toggle="tooltip" title="Next: {{ $next->name }} (Video)">
              <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
          @elseif(get_class($next) === \App\RequiredProject::class)
            <a href="{{ route('user.get_submit_project', ['course' => $course->id, 'project' => $next->id]) }}"
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

          $.ajax({
              method: 'GET',
              url: `https://www.googleapis.com/youtube/v3/videos`,
              data: {
                  'id': id,
                  'part': 'contentDetails',
                  'key': 'AIzaSyBJeGkOMO9elCJkQq4UnHTYrrKCc-XRK9w'
              }
          })
              .done(function (data) {
                  let msDuration = getMSDuration(data.items[0].contentDetails.duration);
                  setTimeout(function () {
                      $.ajax({
                          method: 'GET',
                          url: '{{ route('user.earn_video_score', ['course' => $course->id, 'video' => $video->id]) }}'
                      })
                          .done((res) => {
                              if(res.status === 200){
                                  alert('Congratulations! You earned {{ $video->score }} score from this video!');
                              }
                          });
                  }, msDuration);
              });
      });

      function getMSDuration(YTduration) {
          let a = YTduration.match(/\d+/g);
          if (YTduration.indexOf('M') >= 0 && YTduration.indexOf('H') === -1 && YTduration.indexOf('S') === -1) {
              a = [0, a[0], 0];
          }
          if (YTduration.indexOf('H') >= 0 && YTduration.indexOf('M') === -1) {
              a = [a[0], 0, a[1]];
          }
          if (YTduration.indexOf('H') >= 0 && YTduration.indexOf('M') === -1 && YTduration.indexOf('S') === -1) {
              a = [a[0], 0, 0];
          }
          YTduration = 0;
          if (a.length === 3) {
              YTduration = YTduration + parseInt(a[0]) * 3600;
              YTduration = YTduration + parseInt(a[1]) * 60;
              YTduration = YTduration + parseInt(a[2]);
          }
          if (a.length === 2) {
              YTduration = YTduration + parseInt(a[0]) * 60;
              YTduration = YTduration + parseInt(a[1]);
          }
          if (a.length === 1) {
              YTduration = YTduration + parseInt(a[0]);
          }
          return YTduration * 1000;
      }
  </script>
@endsection
