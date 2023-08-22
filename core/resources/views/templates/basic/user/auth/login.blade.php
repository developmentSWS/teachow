@extends($activeTemplate.'layouts.master')
@php
$loginContent = getContent('login.content', true);
@endphp
@section('content')
    <section class="account-section">
        <div class="left bg_img"
            style="background-image: url('{{ getImage('assets/images/frontend/login/' . @$loginContent->data_values->image, '1920x1080') }}');">
            <div class="left-inner text-center">
               
                <h6 class="text--base">{{ __(@$loginContent->data_values->greeting) }} {{ __($general->sitename) }}</h6>
                <h2 class="title text-white">{{ __(@$loginContent->data_values->heading) }}</h2>
                <p class="mt-3">@lang("Don't have an account?") <a href="{{ route('user.register') }}" class="text--base">@lang('Create Now')</a></p>
               
            </div>
        </div>

        <div class="right">
            <div class="top w-100 text-center">
                <a class="account-logo" href="{{ route('home') }}">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="{{ __($general->sitename) }}">
                </a>
            </div>
            <div class="middle w-100 mt-5">
                <form class="account-form" method="POST" action="{{ route('user.login') }}"
                    onsubmit="return submitUserForm();">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Username or Email')</label>
                        <input type="text" name="username" autocomplete="off" class="form--control" placeholder="@lang('Username or Email')" required>
                    </div>

                    <div class="form-group">
                        <label>@lang('Password')</label>
                        <div class="input-group">
                            <input type="password" name="password" autocomplete="off" class="form--control" placeholder="@lang('Password')" required>
                            <button type="button" class="input-group-text border-0 bg--base text-white toggle-password">
                                <i class="la la-eye"></i>
                            </button>
                        </div>
                    </div>

                  
                    @include($activeTemplate . 'partials.custom_captcha')

                    @php
                        $captcha = loadReCaptcha();
                    @endphp

                    @if($captcha)
                        <div class="form-group col-12">
                            @php echo $captcha @endphp
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @lang('Remember Me')
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Login')</button>
                    </div>
                    <div class="form-group">
                        <a class=" btn-link text-decoration-none text--base" href="{{ route('user.password.request') }}">
                            @lang('Forgot Password?')
                        </a>
                    </div>
                </form>
                <div class="text-center">
                    <p >or login using -</p>
                    <a href="{{ url('authorized/google') }}">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" style="width: 30px;" class="m-2">
                    </a>
                    <a href="{{ url('redirect') }}"  id="btn-fblogin">
                    <img src="https://cdn-icons-png.flaticon.com/512/3536/3536394.png" style=" width: 30px;" class="m-2">
                    </a>
                    <a  href="{{ url('auth/linkedin') }}">
                    <img src="https://freeiconshop.com/wp-content/uploads/edd/linkedin-flat.png" style=" width: 30px;" class="m-2"> 
                    </a>
                </div>    
            </div>
            <div class="bottom w-100 text-center">
                <p class="mb-0 sm-text text-center">
                    @include($activeTemplate.'partials.copyright_text')
                </p>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        //ShowHide-password//
        $(".toggle-password").on('click', function() {
            $(this).find('i').toggleClass("las la-eye-slash");
            var input = $(this).siblings('input');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush
