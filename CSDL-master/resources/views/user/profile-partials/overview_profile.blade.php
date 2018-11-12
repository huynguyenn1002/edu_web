<div class="col-md-6 profile-info">
  @php
    if($user->gender === \App\User::GENDER_MALE){
      $genderIcon = 'fa-mars';
    } elseif ($user->gender === \App\User::GENDER_FEMALE) {
      $genderIcon = 'fa-venus';
    } else {
      $genderIcon = 'fa-genderless';
    }
  @endphp

  <h1 class="font-green sbold uppercase">{{ $user->name }} <i class="fa {{ $genderIcon }}"></i></h1>
  <h4> {{ $user->description }} </h4>
  <p class="list-inline"><i class="fa fa-map-marker"></i> {{ $user->address }} </p>
  <ul class="list-inline">
    <li data-toggle="tooltip" title="Date of birth">
      <i class="fa fa-birthday-cake"></i> {{ $user->DOB ? $user->DOB : 'No data' }}
    </li>
    <li data-toggle="tooltip" title="Balance">
      <i class="fa fa-money"></i> {{ $user->balance ? $user->balance : 0 }}
    </li>
    <li data-toggle="tooltip" title="Learning score">
      <i class="fa fa-graduation-cap"></i> {{ $user->learning_score }}
    </li>
    <li data-toggle="tooltip" title="Teaching score">
      <i class="fa fa-trophy"></i> {{ $user->teaching_score }}
    </li>
  </ul>
</div>