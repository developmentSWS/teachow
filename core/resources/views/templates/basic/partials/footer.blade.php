@php
$footerContent = getContent('footer.content', true);
$iconElement = getContent('social_icon.element', false, null, true);
$element = getContent('policy_pages.element');
@endphp
<footer class="footer">
    <div class="shape-one"></div>
    <div class="shape-two"></div>
    <div class="footer__top">
        <div class="container">
            <div class="row gy-sm-4 gy-5 justify-content-between">
                <div class="col-lg-4 col-md-12 col-sm-6">
                    <div class="footer-widget">
                        <a class="site-logo site-title" href="{{ route('home') }}">
                            <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png', '100X100') }}"
                                alt="{{ __($general->sitename) }}">
                        </a>
                        <p class="mt-lg-5">{{ __(shortDescription($footerContent->data_values->description)) }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">@lang("Quick Menu")</h3>
                        <ul class="footer-menu">
                            <li><a href="{{ route('user.login') }}">@lang("Login as User")</a></li>
                            <li><a href="{{ route('user.register') }}">@lang("Crate an Account")</a></li>
                            <li><a href="{{ route('ticket') }}">@lang("Support")</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">@lang("Important Link")</h3>
                        <ul class="footer-menu">
                            @foreach ($element as $page)
                                <li>
                                    <a class="t-link t-link--danger text--white"
                                        href="{{ route('policy.page', [slug($page->data_values->title), $page->id]) }}">{{ @$page->data_values->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">@lang("Site Links")</h3>
                        <ul class="footer-menu">
                            <li><a href="{{ route('home') }}">@lang("Home")</a></li>
                            <li><a href="{{ route('contact') }}">@lang("Contact")</a></li>
                            <li><a href="{{ route('blog') }}">@lang("Blog")</a></li>
                            @if ($pages)
                            @foreach ($pages as $k => $data)
                                <li>
                                    <a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                                </li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="row gy-2 align-items-center">
                <div class="col-md-6 text-md-start text-center">
                    <p class="mb-0 sm-text">
                        @include($activeTemplate.'partials.copyright_text')
                    </p>
                </div>
                <div class="col-md-6">
                    <ul
                        class="social-link d-flex flex-wrap align-items-center justify-content-md-end justify-content-center">
                        @foreach ($iconElement as $icon)
                            <li><a href="{{ @$icon->data_values->url }}" target="_blank">
                                    @php
                                        echo @$icon->data_values->social_icon;
                                    @endphp</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
