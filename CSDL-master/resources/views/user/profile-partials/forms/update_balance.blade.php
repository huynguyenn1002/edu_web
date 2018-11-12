<form method="POST" action="{{ route('user.update_balance') }}">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <input type="hidden" name="page" value="update_balance" class="form-control"/>
  <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
    <label class="control-label">New Balance</label>
    <input type="text" name="balance" required class="form-control" maxlength="12"/>
    @if ($errors->has('balance'))
      <span class="help-block">
          <strong>{{ $errors->first('balance') }}</strong>
      </span>
    @endif
  </div>
  <div class="margin-top-10">
    <button type="submit" class="btn btn-primary">
      Update balance
    </button>
  </div>
</form>