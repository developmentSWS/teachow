@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('forgot_password.content', true);
@endphp
@section('content')
    <section class="pt-50 pb-50">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-wrapper d-flex flex-wrap">
                        <div class="contact-wrapper__left">
                            <form class="contact-form" action="{{ route('user.password.email') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>@lang('Select One')</label>
                                        <select name="type" class="select form--control" required>
                                            <option value="email">@lang('E-Mail Address')</option>
                                            <option value="username">@lang('Username')</option>
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="my_value"></label>
                                        <input type="text" class="form--control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">
                                        @error('value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="contact-wrapper__right left bg_img dark--overlay" style="background-image: url('{{ getImage('assets/images/frontend/forgot_password/' . @$content->data_values->image, '830x620') }}');">
                            <div class="contact-wrapper__shape-one"></div>
                            <div class="contact-wrapper__shape-two"></div>
                            <div class="left-inner text-center">
                                <h2 class="title text-white">{{ __($content->data_values->heading) }}</h2>
                                <h5 class="mt-3 text--warning">{{ __($content->data_values->subheading) }}</h5>
                            </div>
                        </div>
                    </div><!-- contact-wrapper end -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        console.log(100);
        (function($) {

            myVal();
            $('select[name=type]').on('change', function() {
                myVal();
                console.log(100);
            });

            function myVal() {
                $('.my_value').text($('select[name=type] :selected').text());
            }
        })(jQuery)
    </script>
@endpush
