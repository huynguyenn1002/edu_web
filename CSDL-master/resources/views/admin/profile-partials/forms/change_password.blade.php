<form method="POST" action="{{ route('user.change_password') }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="page" value="change_password" class="form-control"/>
    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
        <label class="control-label">Current Password</label>
        <input type="password" name="old_password" required class="form-control"/>
        @if ($errors->has('old_password'))
            <span class="help-block">
          <strong>{{ $errors->first('old_password') }}</strong>
      </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label">New Password</label>
        <input type="password" class="form-control" name="password" required/>
        @if ($errors->has('password'))
            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="control-label">Re-type New Password</label>
        <input type="password" class="form-control" name="password_confirmation" required/>
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
        @endif
    </div>
    <div class="margin-top-10">
        <button type="submit" class="btn btn-primary">
            Change Password
        </button>
    </div>
</form>