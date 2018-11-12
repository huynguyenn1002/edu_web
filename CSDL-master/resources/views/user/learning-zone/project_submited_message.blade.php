<!doctype html>

<html>
<head>
  <title>Course created</title>
  <style>
    .message {
      padding: 50px 100px;
    }
  </style>
</head>
<body>
<div class="message">
  <p>Your project has been submited. Waiting for teacher to examine it. Hope you a great day!</p>
  <p>You will be redirected back to your learning zone in <span id="count-down">5</span></p>
  <small>
    <cite>
      If it take too long. Please
      <a href="{{ route('user.get_submit_project', ['course' => $course_id, 'project' => $project_id]) }}">Click here</a>
    </cite>
  </small>
</div>

<script>
    window.onload = function(){
        let i = 5;
        setInterval(function(){
            document.getElementById('count-down').innerHTML = '' + --i;
            if(i === 0){
                window.location.replace('{{ route('user.get_submit_project', ['course' => $course_id, 'project' => $project_id]) }}');
            }
        }, 1000);
    }
</script>
</body>
</html>