<div class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}"
    data-background="{{ getImage('assets/admin/images/sidebar/2.jpg', '400x800') }}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('admin.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="@lang('image')"></a>
            <a href="{{ route('admin.dashboard') }}" class="sidebar__logo-shape"><img
                    src="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('admin.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.users*', 3) }}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Manage Users')</span>

                        @if ($banned_users_count > 0 || $email_unverified_users_count > 0 || $sms_unverified_users_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.users*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.users.all') }} ">
                                <a href="{{ route('admin.users.all') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Users')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.users.active') }} ">
                                <a href="{{ route('admin.users.active') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Active Users')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.users.banned') }} ">
                                <a href="{{ route('admin.users.banned') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Banned Users')</span>
                                    @if ($banned_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{ $banned_users_count }}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item  {{ menuActive('admin.users.email.unverified') }}">
                                <a href="{{ route('admin.users.email.unverified') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if ($email_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{ $email_unverified_users_count }}</span>
                                    @endif
                                </a>
                            </li>

                            <!--<li class="sidebar-menu-item {{ menuActive('admin.users.sms.unverified') }}">-->
                            <!--    <a href="{{ route('admin.users.sms.unverified') }}" class="nav-link">-->
                            <!--        <i class="menu-icon las la-dot-circle"></i>-->
                            <!--        <span class="menu-title">@lang('SMS Unverified')</span>-->
                            <!--        @if ($sms_unverified_users_count)-->
                            <!--            <span-->
                            <!--                class="menu-badge pill bg--primary ml-auto">{{ $sms_unverified_users_count }}</span>-->
                            <!--        @endif-->
                            <!--    </a>-->
                            <!--</li>-->


                            <li class="sidebar-menu-item {{ menuActive('admin.users.email.all') }}">
                                <a href="{{ route('admin.users.email.all') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email to All')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.category.list') }}">
                    <a href="{{ route('admin.category.list') }}" class="nav-link ">
                        <i class="menu-icon las la-stamp"></i>
                        <span class="menu-title">@lang('Categories')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.company*', 3) }}">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title">@lang('Institute\'s') </span>
                        @if (0 < $pending_companies_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu {{ menuActive('admin.company*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.company.index') }} ">
                                <a href="{{ route('admin.company.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Institute\'s')</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item {{ menuActive('admin.company.pending') }} ">
                                <a href="{{ route('admin.company.pending') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Institute\'s')</span>
                                    @if($pending_companies_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{ $pending_companies_count }}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.company.approved') }} ">
                                <a href="{{ route('admin.company.approved') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Institute\'s')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.company.rejected') }} ">
                                <a href="{{ route('admin.company.rejected') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Institute\'s')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
               <!--  teacher -->

               <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.teacher*', 3) }}">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title">@lang('Teacher\'s') </span>
                        @if (0 < $pending_companies_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu {{ menuActive('admin.teacher*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.teacher.index') }} ">
                                <a href="{{ route('admin.teacher.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Teacher\'s')</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item {{ menuActive('admin.teacher.pending') }} ">
                                <a href="{{ route('admin.teacher.pending') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Teacher\'s')</span>
                                    @if($pending_companies_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{ $pending_companies_count }}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.teacher.approved') }} ">
                                <a href="{{ route('admin.teacher.approved') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Teacher\'s')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.teacher.rejected') }} ">
                                <a href="{{ route('admin.teacher.rejected') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Teacher\'s')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
               <!-- end teacher -->
                <li class="sidebar-menu-item {{ menuActive('admin.reviews.list') }}">
                    <a href="{{ route('admin.reviews.list') }}" class="nav-link ">
                        <i class="menu-icon las la-comments"></i>
                        <span class="menu-title">@lang('Institute Reviews')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('admin.treviews.list') }}">
                    <a href="{{ route('admin.treviews.list') }}" class="nav-link ">
                        <i class="menu-icon las la-comments"></i>
                        <span class="menu-title">@lang('Teacher Reviews')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ menuActive('admin.claim.list') }}">
                    <a href="{{ route('admin.claim.list') }}" class="nav-link ">
                        <i class="menu-icon las la-comments"></i>
                        <span class="menu-title">@lang('Claim Request')</span>
                        @php $claim = App\Models\Claim::where('status', 0)->count(); @endphp
                          @if ($claim)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    
                   
                </li>
                <li class="sidebar-menu-item {{ menuActive('admin.advertisement.index') }}">
                    <a href="{{ route('admin.advertisement.index') }}" class="nav-link ">
                        <i class="menu-icon las la-ad"></i>
                        <span class="menu-title">@lang('Advertisement')</span>
                    </a>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.ticket*', 3) }}">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                        @if (0 < $pending_ticket_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.ticket*', 2) }} ">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('admin.ticket') }} ">
                                <a href="{{ route('admin.ticket') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.ticket.pending') }} ">
                                <a href="{{ route('admin.ticket.pending') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Ticket')</span>
                                    @if ($pending_ticket_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{ $pending_ticket_count }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.ticket.closed') }} ">
                                <a href="{{ route('admin.ticket.closed') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.ticket.answered') }} ">
                                <a href="{{ route('admin.ticket.answered') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Answered Ticket')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.report*', 3) }}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.report*', 2) }} ">
                        <ul>


                            <li
                                class="sidebar-menu-item {{ menuActive(['admin.report.login.history', 'admin.report.login.ipHistory']) }}">
                                <a href="{{ route('admin.report.login.history') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.report.email.history') }}">
                                <a href="{{ route('admin.report.email.history') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email History')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="sidebar__menu-header">@lang('Settings')</li>

                <li class="sidebar-menu-item {{ menuActive('admin.setting.index') }}">
                    <a href="{{ route('admin.setting.index') }}" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title">@lang('General Setting')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.setting.logo.icon') }}">
                    <a href="{{ route('admin.setting.logo.icon') }}" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title">@lang('Logo & Favicon')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.extensions.index') }}">
                    <a href="{{ route('admin.extensions.index') }}" class="nav-link">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title">@lang('Extensions')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item  {{ menuActive(['admin.language.manage', 'admin.language.key']) }}">
                    <a href="{{ route('admin.language.manage') }}" class="nav-link"
                        data-default-url="{{ route('admin.language.manage') }}">
                        <i class="menu-icon las la-language"></i>
                        <span class="menu-title">@lang('Language') </span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.seo') }}">
                    <a href="{{ route('admin.seo') }}" class="nav-link">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title">@lang('SEO Manager')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.email.template*', 3) }}">
                        <i class="menu-icon la la-envelope-o"></i>
                        <span class="menu-title">@lang('Email Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.email.template*', 2) }} ">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('admin.email.template.global') }} ">
                                <a href="{{ route('admin.email.template.global') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Template')</span>
                                </a>
                            </li>
                            <li
                                class="sidebar-menu-item {{ menuActive(['admin.email.template.index', 'admin.email.template.edit']) }} ">
                                <a href="{{ route('admin.email.template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Templates')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.email.template.setting') }} ">
                                <a href="{{ route('admin.email.template.setting') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Configure')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.sms.template*', 3) }}">
                        <i class="menu-icon la la-mobile"></i>
                        <span class="menu-title">@lang('SMS Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.sms.template*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.sms.template.global') }} ">
                                <a href="{{ route('admin.sms.template.global') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Setting')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.sms.templates.setting') }} ">
                                <a href="{{ route('admin.sms.templates.setting') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Gateways')</span>
                                </a>
                            </li>
                            <li
                                class="sidebar-menu-item {{ menuActive(['admin.sms.template.index', 'admin.sms.template.edit']) }} ">
                                <a href="{{ route('admin.sms.template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Templates')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header">@lang('Frontend Manager')</li>

                <!-- <li class="sidebar-menu-item {{ menuActive('admin.frontend.templates') }}">
                    <a href="{{ route('admin.frontend.templates') }}" class="nav-link ">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Manage Templates')</span>
                    </a>
                </li> -->

                <li class="sidebar-menu-item {{ menuActive('admin.frontend.manage.pages') }}">
                    <a href="{{ route('admin.frontend.manage.pages') }}" class="nav-link ">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Manage Pages')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.frontend.sections*', 3) }}">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Manage Section')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.frontend.sections*', 2) }} ">
                        <ul>
                            @php
                                $lastSegment = collect(request()->segments())->last();
                            @endphp
                            @foreach (getPageSections(true) as $k => $secs)
                                @if ($secs['builder'])
                                    <li class="sidebar-menu-item  @if ($lastSegment == $k) active @endif ">
                                        <a href="{{ route('admin.frontend.sections', $k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{ __($secs['name']) }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach


                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header">@lang('Extra')</li>


                <li class="sidebar-menu-item {{ menuActive('admin.setting.cookie') }}">
                    <a href="{{ route('admin.setting.cookie') }}" class="nav-link">
                        <i class="menu-icon las la-cookie-bite"></i>
                        <span class="menu-title">@lang('GDPR Cookie')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item  {{ menuActive('admin.system.info') }}">
                   <a href="{{ route('admin.system.info') }}" class="nav-link"
                       data-default-url="{{ route('admin.system.info') }}">
                       <i class="menu-icon las la-server"></i>
                       <span class="menu-title">@lang('System Information') </span>
                   </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.setting.custom.css') }}">
                   <a href="{{ route('admin.setting.custom.css') }}" class="nav-link">
                       <i class="menu-icon lab la-css3-alt"></i>
                        <span class="menu-title">@lang('Custom CSS')</span>
                   </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.setting.optimize') }}">
                    <a href="{{ route('admin.setting.optimize') }}" class="nav-link">
                        <i class="menu-icon las la-broom"></i>
                        <span class="menu-title">@lang('Clear Cache')</span>
                    </a>
                </li>

                <!-- <li class="sidebar-menu-item  {{ menuActive('admin.request.report') }}">
                    <a href="{{ route('admin.request.report') }}" class="nav-link"
                        data-default-url="{{ route('admin.request.report') }}">
                        <i class="menu-icon las la-bug"></i>
                        <span class="menu-title">@lang('Report & Request') </span>
                    </a>
                </li> -->
            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{ __('Teachow') }}</span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->
