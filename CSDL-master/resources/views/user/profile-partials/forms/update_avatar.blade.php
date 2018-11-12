<form class="form-horizontal form-bordered text-center"
    method="POST" action="{{ route('user.update_ava') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <input type="hidden" name="page" value="update_ava" class="form-control"/>

  <div class="form-group last">
    <h3 class="col-md-12">Choose your avatar</h3>
    <div class="col-md-12">
      <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail" style="width: 300px; height: 300px;">
          <img src="{{ Storage::url($user->avatar) }}" alt="" /> </div>
        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 300px;"> </div>
        <div>
          <span class="btn default btn-file">
          <span class="fileinput-new"> Select image </span>
          <span class="fileinput-exists"> Change </span>
          <input type="file" name="avatar"> </span>
          <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
        </div>
        @if ($errors->has('avatar'))
          <span class="help-block">
            <strong>{{ $errors->first('avatar') }}</strong>
        </span>
        @endif
      </div>
      <div class="margin-top-50">
        <button type="submit" class="btn green"> Save change </button>
      </div>
    </div>
  </div>
</form>