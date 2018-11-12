<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Login Page</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL STYLES -->
  <link href="{{ asset('css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
  <link href="{{ asset('css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- END THEME GLOBAL STYLES -->
  @yield('style')

</head>
<!-- END HEAD -->

<body class="login">

  @yield('content')

  <script src="{{ asset('js/respond.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/excanvas.min.js') }}" type="text/javascript"></script>
  <![endif]-->
  <!-- BEGIN CORE PLUGINS -->
  <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/js.cookie.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery.blockui.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
  <!-- END CORE PLUGINS -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/additional-methods.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery.backstretch.min.js') }}" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL SCRIPTS -->
  <script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>
  <!-- END THEME GLOBAL SCRIPTS -->

  @yield('script')
</body>
</html>