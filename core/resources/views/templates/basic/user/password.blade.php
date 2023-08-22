@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container pt-50 pb-50">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="custom--card">
                    <div class="card-header bg--dark">
                        <h5 class="text-white">@lang('Password Setting')</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="password">@lang('Current Password') <span class="text--danger">*</span></label>
                                <input id="password" type="password" class="form--control" name="current_password"
                                    placeholder="@lang('Current Password')" required autocomplete="current-password">
                            </div>
                            <div class="form-group hover-input-popup">
                                <label for="password">@lang('Password') <span class="text--danger">*</span></label>
                                <input id="password" type="password" class="form--control" name="password"
                                    placeholder="@lang('Password')" required autocomplete="current-password">
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">@lang('Confirm Password') <span class="text--danger">*</span></label>
                                <input id="password_confirmation" type="password" class="form--control"
                                    name="password_confirmation" placeholder="@lang('Confirm Password')" required
                                    autocomplete="current-password">
                            </div>
                            <div class="form-group">
                                <div class="form-group col-12 mb-0">
                                    <button type="submit" class="btn btn--base w-100">@lang('Change Password')</button>
                                </div>
                            </div>
                            <a href="{{ route('user.password.requestnew') }}">Change Password Through OTP</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
