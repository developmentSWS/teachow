<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
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

</head>

<body>
    <!-- scroll-to-top start -->
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="las la-arrow-up"></i>
        </span>
    </div>
    <!-- scroll-to-top end -->

    <!-- preloader start -->
    @include($activeTemplate."partials.preloader")
    <!-- preloader end -->

    <!-- header-section start  -->
    @include($activeTemplate."partials.header")
    <!-- header-section end  -->

    @php
        $content = getContent('breadcrumb.content', true);
    @endphp

    <div class="main-wrapper">
        <div class="profile-bg bg_img" style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->image, '1920x840') }}');">
        </div>
        <div class="profile-header">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-8">
                        <nav class="profile-nav">
                            <ul class="profile-menu">
                                @if(auth()->user()->reviews->count() || auth()->user()->treviews->count())
                                <li class="profile-menu__item {{ menuActive('user.home') }}">
                                    <a href="{{ route('user.home') }}" class="profile-menu__link">
                                        <i class="las la-star"></i> @lang("Reviews")
                                    </a>
                                </li>
                                @endif
                                <li class="profile-menu__item {{ menuActive('user.profile.setting') }}">
                                    <a href="{{ route('user.profile.setting') }}" class="profile-menu__link">
                                        <i class="las la-user-cog"></i> @lang("Profile")
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div><!-- profile-header end -->

        <div class="pt-50 pb-50 section--bg">
            <div class="container">
                <div class="row justify-content-between flex-row-reverse">
                    <div class="col-xl-3 col-lg-4 order-1">
                        @include($activeTemplate."partials.user_right_nav")
                    </div>
                    <div class="col-xl-9 col-lg-8 order-0">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- dashboard section end -->
    </div><!-- main-wrapper end -->

    <!-- footer section start -->
    @include($activeTemplate."partials.footer")
    <!-- footer section end -->

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

</body>
</html>
