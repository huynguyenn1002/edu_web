<!DOCTYPE html>
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if gt IE 9]>
<html lang="en" class="ie"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edu Hub</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <style>
    .header-nav {
      position: static;
    }

    .pagination-links {
      text-align: center;
      margin-top: 100px;
    }

    .avatar-img {
      max-height: 50px;
      max-width: 50px;
      border-radius: 50%;
    }
  </style>
  @yield('style')
  <script src="{{ asset('js/html5shiv.min.js') }}"></script>
  <script src="{{ asset('js/respond.min.js') }}"></script>
</head>
<body>
<div class="wrapper">
  @include('admin.includes.header-nav')

  @yield('content')

  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a></div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootsnav.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scrollto.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-scrolltofixed-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-SmoothScroll-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.counterup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/fancybox.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.masonry.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fitvids.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/css3-animate-it.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/swiper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/flipclock.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>

@yield('script')

</body>
</html>