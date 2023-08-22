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
                                        <p>@lang('Verification Success'):
                                           
                                        </p>
                                    </div>
                                </div>
                               
                                    <div class="row">
                                        <div class="col-lg-12 form-group text-cente m-3">
                                            <h5>@lang('Username') - {{ Session::get('username') }}</h5>
                                            <h5>@lang('Password') - {{ Session::get('password') }}</h5>
                                        </div>
                                        <div class="col-lg-12">
                                            <a href="{{ route('user.profile.setting') }}" class="btn btn--base w-100"><i class="lab la-telegram-plane"></i> @lang('Go To Dashboard')</a>
                                        </div>
 
                                    </div>
                            </div>

                            <div class="contact-wrapper__right left bg_img dark--overlay" style="background-image: url('{{ getImage('assets/images/frontend/mobile_authentication/' . @$content->data_values->image, '830x620') }}');">
                                <div class="contact-wrapper__shape-one"></div>
                                <div class="contact-wrapper__shape-two"></div>
                                <div class="left-inner text-center ">
                                    <h2 class="title text-white">{{ __('Verification Success') }}</h2>
                                    <h5 class="mt-3 text--warning">{{ __('Login Credentails For Teachow') }}</h5>
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
        setInterval(function() {
            <?php 
                  Session::forget('password'); 
                  Session::get('username');  
            ?>
        }, 5000); 
    </script>
@endpush
