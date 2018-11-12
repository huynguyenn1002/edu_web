<form method="POST" action="{{ route('test.post') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <img src="{{ Storage::url('public/users/avatars/1') }}" alt="img">
  <input type="file" name="avatar">
  <button type="submit">Submit</button>
</form>