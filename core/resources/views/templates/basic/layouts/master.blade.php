<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>

    <link rel="icon" type="image/png" href=" {{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}" sizes="16x16" alt="{{ __($general->sitename) }}">
    <!--CSS Blade Section-->
   <!-- bootstrap 5  -->
   <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
   <!-- slick slider css -->
   <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
   <!-- main css -->
   <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <!--End CSS Blade Section-->

    <!-- preloader start -->
    @include($activeTemplate . 'partials.preloader')
    <!-- preloader end -->

</head>
</head>

<body>
    <!--Main Content Section-->
    @yield('content')
    <!--End Main Content Section-->


    @include('partials.notify')

    @include('partials.plugins')

    <!-- jQuery library -->
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset($activeTemplateTrue . 'js/bootstrap.bundle.min.js') }}"></script>
    <!-- slick slider js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- wow js  -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/bootstrap-fileinput.js') }}"></script>

    @stack('script-lib')

    @stack('script')

    <script>
        (function($) {
            "use strict";
            $('form').on('submit', function() {
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            });
        })(jQuery);
    </script>
</body>

</html>
