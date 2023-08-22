@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('contact.content', true);
$element = getContent('contact.element', false, null, true);
$iconElement = getContent('social_icon.element', false, null, true);
@endphp
@section('content')
    <section class="pt-100 pb-100 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-wrapper d-flex flex-wrap">
                        <div class="contact-wrapper__left">
                            <form class="contact-form" method="post" action="">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Full Name') <span class="text--danger">*</span></label>
                                        <div class="custom-icon-field">
                                            <i class="las la-user"></i>
                                            <input type="text" name="name" value="{{ old('name') }}" autocomplete="off"
                                                class="form--control" placeholder="@lang('Full name')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Email Address') <span class="text--danger">*</span></label>
                                        <div class="custom-icon-field">
                                            <i class="las la-envelope"></i>
                                            <input type="text" name="email" value="{{ old('email') }}" autocomplete="off"
                                                class="form--control" placeholder="@lang('Email address')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Subject') <span class="text--danger">*</span></label>
                                        <div class="custom-icon-field">
                                            <i class="las la-notes-medical"></i>
                                            <input type="text" name="subject" value="{{ old('subject') }}"
                                                autocomplete="off" class="form--control"
                                                placeholder="@lang('Subject Line')" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Message') <span class="text--danger">*</span></label>
                                        <div class="custom-icon-field">
                                            <i class="las la-comment-alt"></i>
                                            <textarea name="message" autocomplete="off" class="form--control" wrap="off"
                                                placeholder="@lang('Write message')" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn--base w-100"><i
                                                class="lab la-telegram-plane"></i>
                                            @lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="contact-wrapper__right">
                            <div class="contact-wrapper__shape-one"></div>
                            <div class="contact-wrapper__shape-two"></div>
                            <div class="top-part">
                                <h3 class="title text-white">{{ __(@$content->data_values->heading) }}</h3>
                                <ul class="contact-info-list mt-5">
                                    @foreach ($element as $item)
                                        <li>
                                            <div class="icon"> @php echo @$item->data_values->icon @endphp</i></div>
                                            <div class="content">
                                                <p> {{ @$item->data_values->content }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <ul class="social-links d-flex flex-wrap align-items-center">
                                @foreach ($iconElement as $icon)
                                    <li>
                                        <a href="{{ @$icon->data_values->url }}">
                                            @php echo @$icon->data_values->social_icon; @endphp
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div><!-- contact-wrapper end -->
                </div>
            </div>
        </div>

        @if ($sections->secs != null)
            @foreach (json_decode($sections->secs) as $sec)
                @include($activeTemplate.'sections.'.$sec)
            @endforeach
        @endif
    </section>
    <!-- contact section end -->
@endsection
