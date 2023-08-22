@php
    $content = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3, false);
@endphp
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-6">
                <div class="section-header text-center wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <div class="section-subtitle border-left-right text--base">
                        {{ __(@$content->data_values->subheading) }}</div>
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-4">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-post rounded-3">
                        <div class="blog-post__thumb rounded-2">
                            <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="d-block w-100 h-100">
                                <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '415x230') }}"
                                    alt="@lang(" Blog")" class="rounded-2">
                            </a>
                            <span class="blog-post__date">
                                <i class="far fa-calendar-alt me-1"></i> {{ showDateTime($blog->created_at, 'Y-M-d') }}
                            </span>
                        </div>

                        <div class="blog-post__content">
                            <h5 class="blog-post__title">
                                <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}"> {{ __(shortDescription($blog->data_values->title, 80)) }}</a>
                            </h5>
                            <p class="mt-2">
                                @php
                                    echo __(shortDescription(strip_tags($blog->data_values->description)));
                                @endphp
                            </p>
                            <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="blog-post__btn mt-3">
                                @lang('Read More') <i class="las la-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
