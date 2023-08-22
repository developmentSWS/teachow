@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('verification_code.content', true);
@endphp
@section('content')
    <section class="pt-50 pb-50">
               <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-wrapper d-flex flex-wrap">
                        <div class="contact-wrapper__left">

                            <form class="contact-form" action="{{ route('user.password.verify.codenew') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>@lang('Verification Code')</label>
                                        <input type="text" class="form--control" name="code" id="code"
                                            value="{{ old('code') }}" required autofocus="off">
                                    </div>


                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn--base w-100"> @lang('Verify Code')</button>
                                    </div>

                                    <div class="form-group d-flex justify-content-between align-items-center mt-3">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="contact-wrapper__right left bg_img dark--overlay" style="background-image: url('{{ getImage('assets/images/frontend/verification_code/' . @$content->data_values->image, '830x620') }}');">
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
