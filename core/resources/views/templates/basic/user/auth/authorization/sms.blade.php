@extends($activeTemplate.'layouts.frontend')
@php
    $content = getContent('mobile_authentication.content', true);
@endphp

@section('content')
    <div class="container">
        <section class="pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact-wrapper d-flex flex-wrap">
                            <div class="contact-wrapper__left">
                                <div class="contact-content-header">
                                    <div class="icon">
                                        <i class="las la-mobile"></i>
                                    </div>
                                    <div class="content">
                                        <p>@lang('Your Mobile Number'):
                                            <strong>{{ auth()->user()->mobile }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <form class="contact-form" action="{{ route('user.verify.sms') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <label>@lang('Verification Code')</label>
                                            <div class="custom-icon-field">
                                                <i class="la la-fingerprint"></i>
                                                <input type="text" name="sms_verified_code" id="code" autocomplete="off" class="form--control" placeholder="@lang('Enter valid code')">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn--base w-100"><i class="lab la-telegram-plane"></i> @lang('Send Code')</button>
                                        </div>

                                        <div class="form-group mt-2">
                                            <p>
                                                @lang('If you don\'t get any code'), <a href="{{ route('user.send.verify.code') }}?type=phone" class="forget-pass"> @lang('Try again')</a></p>
                                            @if ($errors->has('resend'))
                                                <br />
                                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="contact-wrapper__right left bg_img dark--overlay" style="background-image: url('{{ getImage('assets/images/frontend/mobile_authentication/' . @$content->data_values->image, '830x620') }}');">
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
    </div>
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $('#code').on('input change', function() {
                var xx = document.getElementById('code').value;
                $(this).val(function(index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)
    </script>
@endpush
