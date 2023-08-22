@extends($activeTemplate.'layouts.master')
@php
$content = getContent('register.content', true);
$element = getContent('policy_pages.element');
@endphp
@section('content')
    <section class="account-section style--two">
        <div class="left bg_img"
            style="background-image: url('{{ getImage('assets/images/frontend/register/' . @$content->data_values->image, '1920x1280') }}');">
            <div class="left-inner text-center">
                <h6 class="text--base">{{ __('Welcome to') }} {{ __($general->sitename) }}</h6>
                <h2 class="title text-white">{{ __(@$content->data_values->heading) }}</h2>
                <p class="mt-3">@lang('Have an account?') <a href="{{ route('user.login') }}" class="text--base">@lang('Login Now')</a></p>
            </div>
        </div>

        <div class="right">
            <div class="top w-100 text-center">
                <a class="account-logo" href="{{ route('home') }}">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="{{ __($general->sitename) }}">
                </a>
            </div>
            <div class="middle w-100">
                <form class="account-form" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>@lang('First Name') <span class="text--danger">*</span></label>
                            <input type="text" name="firstname" value="{{ old('firstname') }}" autocomplete="off"
                                class="form--control" placeholder="@lang('First Name')" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>@lang('Last Name') <span class="text--danger">*</span></label>
                            <input type="text" name="lastname" value="{{ old('lastname') }}" autocomplete="off"
                                class="form--control" placeholder="@lang('Last Name')" required>
                        </div>
                        <!-- <div class="form-group col-sm-6">
                            <label>@lang('Username') <span class="text--danger">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" autocomplete="off"
                                class="form--control checkUser" placeholder="@lang('Username')" required>
                        </div> -->
                        <div class="form-group col-sm-6">
                            <label>@lang('Phone Number') <span class="text--danger">*</span></label>
                            <div class="input-group">
                                <!-- <span class="input-group-text bg--base text-white mobile-code border-0"></span>  -->
                                <input type="hidden" name="mobile_code" value="91">
                                <input type="hidden" name="country_code" value="IN">
                                <input type="tel" maxlength="10" pattern="[9876][0-9]{9}" name="mobile" value="{{ old('mobile') }}" class="form--control checkUser" placeholder="@lang('Phone Number')" required>
                            </div>
                            <small class="text--danger mobileExist"></small>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>@lang('Email') <span class="text--danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" autocomplete="off"
                                class="form--control checkUser" placeholder="@lang('Email Address')" required>
                        </div>
                        {{-- <div class="form-group col-sm-6">
                            <label>@lang('Country')<span class="text--danger"> *</span></label>
                            <select name="country" id="country" class="select text-white form--control" required>
                                @foreach ($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}"
                                        value="{{ $country->country }}" data-code="{{ $key }}">
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                       

                        <div class="form-group col-sm-6 hover-input-popup">
                            <label>@lang('Password') <span class="text--danger">*</span></label>
                            <input type="password" name="password" autocomplete="off" class="form--control "
                                placeholder="@lang('Password')" required>
                            @if ($general->secure_password)
                                <div class="input-popup">
                                    <small class="error lower">@lang('1 small letter minimum')</small>
                                    <small class="error capital">@lang('1 capital letter minimum')</small>
                                    <small class="error number">@lang('1 number minimum')</small>
                                    <small class="error special">@lang('1 special character minimum')</small>
                                    <small class="error minimum">@lang('6 character password')</small>
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label>@lang('Confirm Password') <span class="text--danger">*</span></label>
                            <input type="password" name="password_confirmation" autocomplete="off" class="form--control"
                                placeholder="@lang('Confirm Password')" required>
                        </div> --}}

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
                                                <input class="form-check-input" type="checkbox" name="student" id="student"
                                                    {{ old('student') ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="student" style="margin-bottom: 0;">
                                                    @lang('I have been a student of the teacher/institution')
                                                </label>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="honest_review" id="honest_review"
                                                    {{ old('honest_review') ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="honest_review" style="margin-bottom: 0;">
                                                    @lang('I am giving an honest review from my experience as a student')
                                                </label>
                                            </div>
                                        </div>



                        @if ($general->agree)
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input custom-form-check-input" type="checkbox" name="agree"
                                        {{ old('agree') ? 'checked' : '' }} required />
                                    <label class="form-check-label t-heading-font">
                                        @lang('I agree with')
                                        @foreach ($element as $page)
                                            <a class="text--base" href="{{ route('policy.page', [slug($page->data_values->title), $page->id]) }}">{{ @$page->data_values->title }}</a>@if (!$loop->last),
                                            @endif
                                        @endforeach
                                        <span class="text--danger">*</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-12 mb-0">
                            <button type="submit" id="registerSubmitButton" class="btn btn--base w-100">{{ !empty($content->data_values->register_button_name) ? $content->data_values->register_button_name : 'Register' }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bottom w-100 text-center">
                <p class="mb-0 sm-text text-center">
                    @include($activeTemplate.'partials.copyright_text')
                </p>
            </div>
        </div>
        {{-- Exist Modal --}}
        <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="existModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with
                            '){{ __($general->sitename) }}</h5>
                        <button type="button" class="btn-close text--danger" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">@lang('You already have an account please Sign in !')</h6>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('user.login') }}"
                            class="btn btn--base w-100">{{ !empty($content->data_values->login_button_name) ? $content->data_values->login_button_name : 'Login' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text--danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        (function($) {
            @if ($mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input',function(){
                secure_password($(this));
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response['data'] && response['type'] == 'email') {
                        $('#existModalCenter').modal('show');
                        // $('#registerSubmitButton').
                    } else if (response['data'] != null) {
                        $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                    } else {
                        $(`.${response['type']}Exist`).text('');
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
