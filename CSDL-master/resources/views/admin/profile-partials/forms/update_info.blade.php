<form role="form"  method="POST" action="{{ route('admin.update_info') }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="page" value="update_info" class="form-control"/>
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label">Full Name</label>
        <input type="text" name="name" value="{{ $admin->name }}" class="form-control"/>
        @if ($errors->has('name'))
            <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('DOB') ? ' has-error' : '' }}">
        <label class="control-label">Date Of Birth</label>
        <input type="text" name="DOB" value="{{ $admin->DOB }}" class="form-control"/>
        @if ($errors->has('DOB'))
            <span class="help-block">
                            <strong>{{ $errors->first('DOB') }}</strong>
                        </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
        <label class="control-label">Gender</label>
        <input type="text" name="gender" value="{{ $admin->gender }}" class="form-control"/>
        @if ($errors->has('gender'))
            <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="control-label">Address</label>
        <input type="text"  name="address" value="{{ $admin->address }}" class="form-control"/>
        @if ($errors->has('address'))
            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
        @endif
    </div>
    <div class="form-group">
        <label class="control-label">About</label>
        <textarea class="form-control" rows="3" name="description">{{ $admin->description }}</textarea>
    </div>
    <div class="margiv-top-10">
        <button type="submit" class="btn green"> Save Changes </button>
    </div>
</form>