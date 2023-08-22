<header class="header">
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}"
                        alt="{{ __($general->sitename) }}">
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        <li class="{{ menuActive('home') }}"><a href="{{ route('home') }}">@lang('Home')</a></li>
                        <li class="{{ menuActive('company.*') }}"><a
                                href="{{ route('company.all') }}">@lang('Institutes ')</a></li>
                        <li class="{{ menuActive('teacher.*') }}"><a
                                href="{{ route('teacher.all') }}">@lang('Teachers')</a></li>        
                        <li class="{{ menuActive('blog') }}"><a href="{{ route('blog') }}">@lang('Blogs')</a></li>
                        @if ($pages)
                            @foreach ($pages as $k => $data)
                                <li>
                                    <a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                                </li>
                            @endforeach
                        @endif
                        @guest
                            <li class="{{ menuActive('contact') }}">
                                <a href="{{ route('contact') }}">@lang('Contact')</a>
                            </li>
                        @endguest
                        @auth
                          
                            
                            <li class="menu_has_children">
                                <a href="javascript:void(0)"> {{ auth()->user()->username }}</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.profile.setting') }}">@lang('My Profile')</a></li>
                                    <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                    <li class="menu_has_children {{ menuActive('user.teacher.*') }} ">
                                        <a href="javascript:void(0)">@lang('My Teacher')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.teacher') }}">@lang('Teacher List')</a></li>
                                            <li><a href="{{ route('user.teacher.create') }}">@lang('Add Teacher')</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu_has_children {{ menuActive('user.company.*') }} ">
                                        <a href="javascript:void(0)">@lang('My Institute')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.company') }}">@lang('Institute List')</a></li>
                                            <li><a href="{{ route('user.company.create') }}">@lang('Add Institute')</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('ticket') }}">@lang('My Support Tickets')</a></li>
                                    <li><a href="{{ route('ticket.open') }}">@lang('Open New Ticket')</a></li>
                                    <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                    <div class="nav-right btn--group">


                      {{--  <select class="langSel d-flex align-items-center mx-2">
                            @foreach ($language as $item)
                                <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>
                                    {{ __($item->name) }}
                                </option>
                            @endforeach
                        </select>  --}}

                        @guest
                            <a href="{{ route('user.login') }}"
                                class="btn btn-md btn--base d-flex align-items-center mx-2">
                                <i class="las la-sign-in-alt fs--18px me-2"></i> @lang('Login')
                            </a>
                            <a href="{{ route('user.register') }}"
                                class="btn btn-md btn--base d-flex align-items-center mx-2">
                                <i class="las la-sign-in-alt fs--18px me-2"></i> @lang('Register')
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('user.home') }}"
                                class="btn btn-md btn--base d-flex align-items-center mx-2 mb-sm-2">
                                <i class="las la-user fs--18px me-2"></i> @lang('Dashboard')
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
