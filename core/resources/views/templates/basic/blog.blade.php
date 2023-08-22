@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-100 pb-100 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="row gy-4 justify-content-center">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-post rounded-3">
                            <div class="blog-post__thumb rounded-2">
                                <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="d-block w-100 h-100">
                                    <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '415x230') }}"
                                        alt="@lang(" Blog")" class="rounded-2">
                                </a>
                                <span class="blog-post__date"><i class="far fa-calendar-alt me-1"></i>
                                    {{ showDateTime($blog->created_at, 'Y-M-d') }}</span>
                            </div>
                            <div class="blog-post__content">
                                <h5 class="blog-post__title">
                                    <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}">
                                        {{ __(shortDescription($blog->data_values->title, 80)) }}</a>
                                </h5>
                                <p class="mt-2">
                                    @php
                                        echo __(shortDescription(strip_tags($blog->data_values->description)));
                                    @endphp
                                </p>
                                <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="blog-post__btn mt-3">
                                    @lang('Read More')
                                    <i class="las la-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($blogs->hasPages())
                    <div class="col-12">
                        <ul class="list list--row justify-content-center align-items-center t-mt-6">
                            {{ paginateLinks($blogs) }}
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
