<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}"/>

    @yield('styles')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'ITE') }}
                    </a>
                    @if(Auth::guard('admin')->check())
                        <ul class="nav navbar-nav navbar-left">
                            <li><a href="{{ route('admin.home') }}">Home</a></li>
                            <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
                            <li><a href="{{ route('admin.categories') }}">Manage Categories</a></li>
                            <li><a href="{{ route('admin.courses') }}">Manage Courses</a></li>
                        </ul>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->

                        @if(!Auth::guard('admin')->check())
                            <li><a href="{{ route('admin.get_login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a  href="{{ route('admin.profile',['admin'=>Auth::guard('admin')->user()->id]) }}">Profile</a>

                                    </li>
                                    <li>
                                        <a  href="{{ route('admin.create_admin') }}">Create Admin</a>

                                    </li>
                                    <li>
                                        <a href="{{ route('admin.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready( function () {
            let cols = $('.data-table').find('th').length;

            $('table.data-table').DataTable({
                "lengthMenu": [
                    [6, 10, 20, -1],
                    [6, 10, 20, "All"] // change per page values here
                ],
                "pageLength": parseInt('{{ config('view.paginate') }}'),
                "columnDefs": [{  // set default column settings
                    'orderable': false,
                    'targets': [0, cols - 1]
                }, {
                    "searchable": false,
                    "targets": [0, cols - 1]
                }]
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
