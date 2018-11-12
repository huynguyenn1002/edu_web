<form role="form"  method="POST" action="{{ route('user.update_info') }}">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <input type="hidden" name="page" value="update_info" class="form-control"/>
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="control-label">Full Name</label>
    <input type="text" name="name" value="{{ $user->name }}" class="form-control"/>
    @if ($errors->has('name'))
      <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
    <label class="control-label">Gender</label>
    <select class="form-control" name="gender" >
      <option value="{{ \App\User::GENDER_MALE }}" @if($user->gender === \App\User::GENDER_MALE) selected @endif>
        Male
      </option>
      <option value="{{ \App\User::GENDER_FEMALE }}" @if($user->gender === \App\User::GENDER_FEMALE) selected @endif>
        Female
      </option>
      <option value="{{ \App\User::GENDER_OTHER }}" @if($user->gender === \App\User::GENDER_OTHER) selected @endif>
        Other
      </option>
    </select>
    @if ($errors->has('gender'))
      <span class="help-block">
          <strong>{{ $errors->first('gender') }}</strong>
      </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('DOB') ? ' has-error' : '' }}">
    <label class="control-label">Date Of Birth</label>
    <input type="text" name="DOB" value="{{ $user->DOB }}" class="form-control datepicker"/>
    @if ($errors->has('DOB'))
      <span class="help-block">
          <strong>{{ $errors->first('DOB') }}</strong>
      </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
    <label class="control-label">Address</label>
    <input type="text"  name="address" value="{{ $user->address }}" class="form-control"/>
    @if ($errors->has('address'))
      <span class="help-block">
          <strong>{{ $errors->first('address') }}</strong>
      </span>
    @endif
  </div>
  <div class="form-group">
    <label class="control-label">About</label>
    <textarea class="form-control" rows="3" name="description">{{ $user->description }}</textarea>
  </div>
  <div class="margiv-top-10">
    <button type="submit" class="btn green"> Save Changes </button>
  </div>
</form>