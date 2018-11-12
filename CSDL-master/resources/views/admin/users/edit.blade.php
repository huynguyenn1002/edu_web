@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h2>Edit User Info</h2>
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form class="form-horizontal" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.users.update', ['user' => $user->id]) }}">
        <div class="form-group">
          <label for="nameTxt" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nameTxt" placeholder="Name" name="name"
                   value="{{ $user->name }}">
          </div>
        </div>

        <div class="form-group">
          <label for="genderTxt" class="col-sm-2 control-label">Gender</label>
          <div class="col-sm-10">
            <select class="form-control" name="gender">
              <option value="{{ \App\User::GENDER_MALE }}">Male</option>
              <option value="{{ \App\User::GENDER_FEMALE }}">Female</option>
              <option value="{{ \App\User::GENDER_OTHER }}">Other</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="emailTxt" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="emailTxt" placeholder="Email" name="email"
                   value="{{ $user->email }}">
          </div>
        </div>

        <div class="form-group">
          <label for="dobTxt" class="col-sm-2 control-label">Date of birth</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="dobTxt" name="birthday" value="{{ $user->DOB }}">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="addressTxt" class="col-sm-2 control-label">Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="addressTxt" placeholder="Address" name="address"
                   value="{{ $user->address }}">
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>

        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script>
      $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
      })
  </script>
@endsection