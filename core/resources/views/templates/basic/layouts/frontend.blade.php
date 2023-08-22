<!-- meta tags and other links -->
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

    @stack('style-lib')
    @stack('style')
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
    @include($activeTemplate . 'partials.preloader')
    <!-- preloader end -->

    <!-- header-section start  -->
    @include($activeTemplate . 'partials.header')
    <!-- header-section end  -->

    <div class="main-wrapper">
        @if (!request()->routeIs('home') && !request()->routeIs('user.home') && !request()->routeIs('company.details'))
            @include($activeTemplate . 'partials.breadcrumb')
        @endif

        @yield('content')

    </div><!-- main-wrapper end -->

    <!--Cookie Div -->
    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp

    @if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie-wrapper" id="cookie">
        <div class="container">
            <h5 class="modal-title text-warning">@lang('Cookie Policy')</h5>
            <p>
                @php echo @$cookie->data_values->description @endphp <a href="{{ @$cookie->data_values->link }}" class="text--base" target="_blank">@lang('Read More')</a>
            </p>

            <button class="btn btn--base btn-md mt-3" id="allow-cookie">@lang('Accept Cookie')</button>
        </div>
    </div>
    @endif


    <!-- footer section start -->
    @include($activeTemplate . 'partials.footer')
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


    <script>
        "use strit";
        (function($) {
            //===============here is the update add click value=========
            $(".__add").on('click', function(e) {
                e.preventDefault()
                let id = $(this).data('id');
                let action = "{{ route('add.click', ':id') }}";

                $.ajax({
                    url: action.replace(':id', id),
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    success: function(resp) {

                        console.log(resp);
                        if (resp.data && resp.data.type == 'image' && resp.data.redirect_url != '#') {
                            window.open(resp.data.redirect_url)
                        }
                    }
                });
            })

            //Language
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });


            $('#allow-cookie').on('click', function(){
                var url = `{{ route('cookie.accept') }}`;
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        $('.cookie-wrapper').hide();
                    }
                });
            });

        })(jQuery);
    </script>
</body>

</html>
