@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('breadcrumb.content', true);
@endphp
@section('content')
    <!-- Blog -->
    <section class="pt-100 pb-100 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="row gy-5 gy-lg-0">
                <div class="col-lg-8">
                    <div class="blog-post">
                        <img src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '830x460') }}"
                            alt="viserfly" class="img-fluid w-100" />
                        <div class="blog-post__body">

                            <h4 class="mt-4 fw-md">
                                {{ __(@$blog->data_values->title) }}
                            </h4>
                            <span class="fs--14px my-2"><i class="far fa-calendar-alt me-1"></i>
                                {{ showDateTime($blog->created_at, 'Y-M-d') }}</span>
                            <p class="mt-3">
                                @php echo @$blog->data_values->description @endphp
                            </p>

                            <div class="mt-4 mb-2">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <span>@lang('Share'):</span>
                                            <a class="t-link social-icon--alt"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                target="_blank">
                                                <span class="btn btn-sm badge badge--base mx-1">
                                                    <i class="fab fa-facebook-f"></i>
                                                </span>
                                            </a>
                                            <a class="t-link social-icon--alt"
                                                href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"
                                                target="_blank">
                                                <span class="btn btn-sm badge badge--base mx-1">
                                                    <i class="fab fa-twitter"></i>
                                                </span>
                                            </a>
                                            <a class="t-link social-icon--alt"
                                                href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary"
                                                target="_blank">
                                                <span class="btn btn-sm badge badge--base mx-1">
                                                    <i class="fab fa-linkedin"></i>
                                                </span>
                                            </a>
                                            <a class="t-link social-icon--alt"
                                                href="https://plus.google.com/share?url={{ urlencode(url()->current()) }}"
                                                target="_blank">
                                                <span class="btn btn-sm badge badge--base mx-1">
                                                    <i class="fab fa-google"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside id="sidebar">
                        <ul class="list list--column blog-list">
                            <li class="blog-list__item">
                                <div class="widget bg--alpha">
                                    <div class="bg--white p-0">
                                        <h4 class="latest-blog-title content widget__title">
                                            @lang('Latest Posts')
                                        </h4>
                                    </div>
                                    <ul class="list list--column widget-category">
                                        @foreach ($latestPosts as $blog)
                                            <li class="latest-blog-item">
                                                <div class="has--link">
                                                    <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}"
                                                        class="item--link"></a>
                                                    <div class="company-review__top">
                                                        <div class="thumb">
                                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '415x230') }}"
                                                                alt="@lang('Image')">
                                                            <img />
                                                        </div>
                                                        <div class="content">
                                                            <h5 class="fs--14px mt-1">
                                                                {{ __(shortDescription($blog->data_values->title, 70)) }}
                                                            </h5>
                                                            <span class="date text--base fs--14px mt-2">{{ showDateTime($blog->created_at, 'Y-M-d') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
