@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('reset_password.content', true);
@endphp
@section('content')
    <section class="pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-wrapper d-flex flex-wrap">
                        <div class="contact-wrapper__left">

                            <form class="contact-form" action="{{ route('user.password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="row">
                                    <div class="form-group col-sm-12 hover-input-popup">
                                        <label>@lang('Password')<span class="text-danger"> *</span></label>
                                        <input type="password" name="password" autocomplete="off"
                                            class="form--control @error('password') is-invalid @enderror"
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
                                    <div class="form-group col-sm-12">
                                        <label>@lang('Confirm Password')<span class="text-danger"> *</span></label>
                                        <input type="password" name="password_confirmation" autocomplete="off"
                                            class="form--control" placeholder="@lang('Confirm Password')" required>
                                    </div>


                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn--base w-100"><i
                                                class="lab la-telegram-plane"></i> @lang('Reset Password')</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="contact-wrapper__right left bg_img dark--overlay" style="background-image: url('{{ getImage('assets/images/frontend/reset_password/' . @$content->data_values->image, '830x620') }}');">
                            <div class="contact-wrapper__shape-one"></div>
                            <div class="contact-wrapper__shape-two"></div>
                            <div class="left-inner text-center">
                                <h2 class="title text-white">{{ __($content->data_values->heading) }}</h2>
                                <h5 class="mt-3 text--warning">{{ __($content->data_values->subheading) }}</h5>
                            </div>
                        </div>
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
        (function($) {
            "use strict";
            @if ($general->secure_password)
                $('input[name=password]').on('input',function(){
                secure_password($(this));
                });
            @endif
        })(jQuery);
    </script>
@endpush
