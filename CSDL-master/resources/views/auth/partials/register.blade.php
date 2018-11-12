<form class="register-form" action="{{ route('register') }}" method="post">
  {{ csrf_field() }}
  <h3>Sign Up</h3>
  <p> Enter your personal details below: </p>
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="control-label visible-ie8 visible-ie9">Full Name</label>
    <div class="input-icon">
      <i class="fa fa-font"></i>
      <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus/> </div>
      @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
      @endif
  </div>
  <div class="form-group">
    <label class="control-label visible-ie8 visible-ie9">Gender</label>
    <div class="input-icon">
      <i class="fa fa-user"></i>
      <select class="form-control" name="gender" >
        <option value="{{ \App\User::GENDER_MALE }}">Male</option>
        <option value="{{ \App\User::GENDER_FEMALE }}">Female</option>
        <option value="{{ \App\User::GENDER_OTHER }}">Other</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label visible-ie8 visible-ie9">Address</label>
    <div class="input-icon">
      <i class="fa fa-check"></i>
      <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" /> </div>
  </div>
  <p> Enter your account details below: </p>
  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="control-label visible-ie8 visible-ie9">Email</label>
    <div class="input-icon">
      <i class="fa fa-envelope"></i>
      <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" value="{{ old('email') }}" required/> </div>
    @if ($errors->has('email'))
      <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label class="control-label visible-ie8 visible-ie9">Password</label>
    <div class="input-icon">
      <i class="fa fa-lock"></i>
      <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" required/> </div>
      @if ($errors->has('password'))
        <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
      @endif
  </div>
  <div class="form-group">
    <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
    <div class="controls">
      <div class="input-icon">
        <i class="fa fa-check"></i>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="password_confirmation" required/> </div>

    </div>
  </div>
  <div class="form-actions">
    <button id="register-back-btn" type="button" class="btn red btn-outline"> Back </button>
    <button type="submit" id="register-submit-btn" class="btn green pull-right"> Sign Up </button>
  </div>
</form>