<div class="page-header navbar navbar-fixed-top">
  <div class="container">
  <div class="page-header-inner ">
    <div class="page-logo">
      <a href="{{ route('index') }}">
        <img src="{{ asset('img/logo.png') }}" style="max-width: 161px; max-height: 50px; margin: 0; padding: 10px 0;" alt="logo" class="logo-default"/>
      </a>
    </div>
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
       data-target=".navbar-collapse">
      <span></span>
    </a>
    <div class="top-menu">
      <ul class="nav navbar-nav pull-right">
        @php
          $user = auth()->user();
        @endphp
        <li class="dropdown dropdown-user">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
             data-close-others="true">
            <img alt="" class="img-circle" src="{{ Storage::url($user->avatar) }}"/>
            <span class="username username-hide-on-mobile"> {{ $user->name }} </span>
            <i class="fa fa-angle-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-default">
            <li>
              <a href="{{ route('profile') }}">
                My profile <i class="fa fa-user-circle-o" aria-hidden="true"></i>
              </a>
            </li>
            <li>
              <a href="{{ route('user.enrolled_courses') }}">
                Enrolled courses <i class="fa fa-graduation-cap" aria-hidden="true"></i>
              </a>
            </li>
            <li>
              <a href="{{ route('profile') }}#tabTeachingCourse">
                Teaching courses <i class="fa fa-line-chart" aria-hidden="true"></i>
              </a>
            </li>
            <li>
              <a href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>

          </ul>
        </li>
      </ul>
    </div>
  </div>
  </div>
</div>