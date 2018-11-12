<form class="login-form" action="{{ route('login') }}" method="post">
  {{ csrf_field() }}
  <h3 class="form-title">Login to your account</h3>
  <div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    <span> Enter any username and password. </span>
  </div>
  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="control-label visible-ie8 visible-ie9">Email</label>
    <div class="input-icon">
      <i class="fa fa-user"></i>
      <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
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
      <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
      @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
      @endif
  </div>
  <div class="form-actions">
    <label class="rememberme mt-checkbox mt-checkbox-outline">
      <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="1" /> Remember me
      <span></span>
    </label>
    <button type="submit" class="btn green pull-right"> Login </button>
  </div>
  <div class="login-options">
    <h4>Or login with</h4>
    <ul class="social-icons">
      <li>
        <a class="facebook" data-original-title="facebook" href="javascript:;"> </a>
      </li>
      <li>
        <a class="twitter" data-original-title="Twitter" href="javascript:;"> </a>
      </li>
      <li>
        <a class="googleplus" data-original-title="Goole Plus" href="javascript:;"> </a>
      </li>
      <li>
        <a class="linkedin" data-original-title="Linkedin" href="javascript:;"> </a>
      </li>
    </ul>
  </div>
  <div class="forget-password">
    <h4>Forgot your password ?</h4>
    <p> no worries, click
      <a href="javascript:;" id="forget-password"> here </a> to reset your password. </p>
  </div>
  <div class="create-account">
    <p> Don't have an account yet ?&nbsp;
      <a href="javascript:;" id="register-btn"> Create an account </a>
    </p>
  </div>
</form>