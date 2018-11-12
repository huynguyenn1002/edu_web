<!-- Header Styles -->
<div class="header-nav">
  <div class="main-header-nav scrollingto-fixed irs-menu-style-one">
    <div class="container">
      <nav class="navbar navbar-default bootsnav irs-menu-style-one yellow">
        <div class="container irs-pad-zero">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i
                  class="fa fa-bars"></i></button>
            <a class="navbar-brand" href="{{ route('index') }}"><img
                  src="{{ asset('img/logo.png') }}" style="max-width: 161px; max-height: 50px"  class="logo img-responsive" alt="header-logo.png"></a>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-left">
              @if(Auth::guard('admin')->check())
                <ul class="nav navbar-nav navbar-left">
                  <li><a href="{{ route('admin.home') }}">Admin Home</a></li>
                  <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
                  <li><a href="{{ route('admin.categories') }}">Manage Categories</a></li>
                  <li><a href="{{ route('admin.courses') }}">Manage Courses</a></li>
                </ul>
              @endif
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</div>
