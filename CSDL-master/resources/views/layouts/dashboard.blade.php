<!DOCTYPE html>

<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>ITE</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css"/>
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css"/>
  <link href="{{ asset('css/plugins-md.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/layout.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
  <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
  @yield('style')

  <style>
    .page-content-wrapper .page-content {
      margin-left: 0;
    }
  </style>

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-md">
@include('includes.dashboard.menu')
<div class="clearfix"></div>

<div class="page-container">
{{--@include('includes.dashboard.left_sidebar')--}}
  <div class="page-content-wrapper">
    <div class="page-content">
      @yield('content')
    </div>
  </div>
  <a href="javascript:;" class="page-quick-sidebar-toggler">
    <i class="icon-login"></i>
  </a>
  <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
  </div>
</div>

<script src="{{ asset('js/respond.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/excanvas.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/layout.min.js') }}" type="text/javascript"></script>
@yield('script')
</body>

</html>