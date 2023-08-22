@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('company_list_section.content', true);
@endphp
@section('content')
    <section class="pt-50 pb-50 section--bg">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-3">
                    <button
                        class="action-sidebar-open d-flex justify-content-between align-items-center w-100">@lang('Filter')
                        <i class="las la-sliders-h"></i>
                    </button>
                    <div class="action-sidebar">
                        <button class="action-sidebar-close"><i class="las la-times"></i></button>
                        <div class="action-widget pt-0">
                            <h4 class="action-widget__title">@lang('Institute or Tag')</h4>
                            <div class="action-widget__body">
                                <form class="search-form-inline" onsubmit='return false'>
                                    <input type="text" name="search" autocomplete="off" value="" class="form--control form-control-sm" placeholder="@lang('Search here')...">
                                    <button type="submit" class="search-form-inline__btn search"><i class="las la-search"></i></button>
                                </form>
                            </div>
                        </div><!-- action-widget end -->
                       
                        <!--<div class="action-widget">-->
                        <!--    <h4 class="action-widget__title">@lang('By Categories')</h4>-->
                        <!--    <div class="action-widget__body">-->
                        <!--        <ul class="sidebar-category">-->
                        <!--            <li class="sidebar-category__single active">-->
                        <!--                <a href="javascript:void(0)" class="category" data-id="0">-->
                        <!--                    <span class="caption fw-bold">@lang('All')</span>-->
                        <!--                    <span class="value">{{ $companies->total() }}</span>-->
                        <!--                </a>-->
                        <!--            </li>-->

                        <!--            @foreach ($categories as $category)-->
                        <!--                <li class="sidebar-category__single">-->
                        <!--                    <a href="javascript:void(0)" class="category"-->
                        <!--                        data-id="{{ $category->id }}">-->
                        <!--                        <span class="caption">{{ __($category->name) }}</span>-->
                        <!--                        <span class="value">{{ $category->company->where('status',1)->count() }}</span>-->
                        <!--                    </a>-->
                        <!--                </li>-->
                        <!--            @endforeach-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!-- action-widget end -->
                     
                        <div class="action-widget">
                            <h4 class="action-widget__title">@lang('By Rating')</h4>
                            <div class="action-widget__body">

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" value="" type="radio" name="rating_filter"
                                            id="ratings-0" checked>
                                        <label class="form-check-label fw-bold" for="ratings-0">
                                            @lang('All')
                                        </label>
                                    </div>
                                </div>

                                @for ($i = 5; $i >= 1; $i--)
                                    <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                        <div class="left">
                                            <input class="form-check-input" value="{{ $i }}" type="radio"
                                                name="rating_filter" id="ratings-{{ $i }}">
                                            <label class="form-check-label" for="ratings-{{ $i }}">
                                                {{ $i }} <span class="text--base">

                                                    @for ($star = 1; $star <= $i; $star++)
                                                        <i class="las la-star"></i>
                                                    @endfor
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div><!-- action-widget end -->

                        <div class="action-widget">
                            <h4 class="action-widget__title">@lang('By Review Time')</h4>
                            <div class="action-widget__body">
                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" type="radio" name="review_time" value=""
                                            id="reviews-0" checked>
                                        <label class="form-check-label fw-bold" for="reviews-0">@lang('All')</label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" type="radio" name="review_time" value="1"
                                            id="reviews-1">
                                        <label class="form-check-label" for="reviews-1">
                                            @lang('Last month')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" type="radio" name="review_time" value="2"
                                            id="radio-2">
                                        <label class="form-check-label" for="radio-2">
                                            @lang('Last 2 months')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" type="radio" name="review_time" value="3"
                                            id="radio-3">
                                        <label class="form-check-label" for="radio-3">
                                            @lang('Last 3 months')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" type="radio" name="review_time" value="6"
                                            id="radio-4">
                                        <label class="form-check-label" for="radio-4">
                                            @lang('Last 6 months')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input" type="radio" name="review_time" value="12"
                                            id="radio-5">
                                        <label class="form-check-label" for="radio-5">
                                            @lang('Last year')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><!-- action-widget end -->

                        <div class="action-widget">
                            <h4 class="action-widget__title">@lang('By Registered Period')</h4>
                            <div class="action-widget__body"> 

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input status" type="radio" name="companyStatus"
                                            id="company-status-0" checked>
                                        <label class="form-check-label fw-bold" for="company-status-0">
                                            @lang('All')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input status" type="radio" name="companyStatus"
                                            data-endyear="1" id="company-status-1">
                                        <label class="form-check-label" for="company-status-1">
                                            @lang('Below 1 year')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input status" type="radio" name="companyStatus"
                                            data-startyear="1" data-endyear="3" id="company-status-2">
                                        <label class="form-check-label" for="company-status-2">
                                            @lang('1 - 3 years')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input status" type="radio" name="companyStatus"
                                            data-startyear="3" data-endyear="6" id="company-status-3">
                                        <label class="form-check-label" for="company-status-3">
                                            @lang('3 - 6 years')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input status" type="radio" name="companyStatus"
                                            data-startyear="6" data-endyear="10" id="company-status-4">
                                        <label class="form-check-label" for="company-status-4">
                                            @lang('6 - 10 years')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input status" type="radio" name="companyStatus"
                                            data-startyear="10" id="company-status-5">
                                        <label class="form-check-label" for="company-status-5">
                                            @lang('Over 10 years')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!Auth::check())  
                        <div class="action-widget bg--base mt-4 text-center rounded-3 p-4">
                            <h4 class="text-white">{{ __(@$content->data_values->title) }}</h4>
                            <a href="{{ route('user.login') }}"
                                class="btn bg-white mt-4">{{ __(@$content->data_values->button_name) }}</a>
                        </div>
                        @endif
                        {{-- //Advertise-div --}}
                        <div class="has--link item--link mt-4">
                            @php
                                echo getAdvertisement('300x600');
                            @endphp
                        </div>

                        <div class="has--link mt-4">
                            @php
                                echo getAdvertisement('300x250');
                            @endphp
                        </div>
                        {{-- //End Advertise-div --}}
                    </div>
                </div>
                <div class="col-xl-9 ps-xxl-5">
                    <div class="row gy-4" id="showCompanies">
                        @include($activeTemplate . 'company.companies')
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>
    <!-- review search section end -->
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';
            let data = {};
            data.category_d = 0;
            data.rating = null;
            data.review_time = null;
            data.reg_start = null;
            data.reg_end = null;
            data.search_key = null;

            $(document).on('change', "input[type=radio]:checked", function() {
                data.rating = $("input[name='rating_filter']:checked").val();
                data.review_time = $("input[name='review_time']:checked").val();
                data.reg_start = $(this).data('startyear');
                data.reg_end = $(this).data('endyear');
                filterCompanies();
            });

            $(document).on('click', ".category", function() {
                $('.sidebar-category__single').removeClass('active');
                $(this).parent().addClass('active');

                data.category_id = $(this).data('id');
                filterCompanies();
            });

            $(document).on('click', ".search", function() {
                data.search_key = $('input[name=search]').val();
                filterCompanies();
            });

            //paginate
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                filterCompanies(page);
            });
            //end paginate

            function filterCompanies(page) {
                $.ajax({
                    url: "{{ route('company.filter') }}?page=" + page,
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        $('#showCompanies').html(response)
                        $(".countResult").removeClass('d-none') //

                    },
                });
            }


            $('.action-widget__title').each(function() {
                let widget = $(this).siblings('.action-widget__body');
                $(this).on('click', function() {
                    widget.slideToggle();
                });
            });

            $('ul.sidebar-category').each(function() {
                var length = $(this).find('li').length;
                if (length > 5) {
                    $('li', this).eq(4).nextAll().hide().addClass('toggleable');
                    $(this).append('<li class="more">@lang("See More")...</li>');
                }
            });

            $('ul.sidebar-category').on('click', '.more', function() {
                if ($(this).hasClass('less')) {
                    $(this).text('@lang("See More...")').removeClass('less');
                } else {
                    $(this).text('@lang("See Less")...').addClass('less');
                }
                $(this).siblings('li.toggleable').slideToggle();
            });
        })(jQuery);
    </script>
@endpush
