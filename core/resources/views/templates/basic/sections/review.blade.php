@php
$content = getContent('review.content', true);
$reviews = App\Models\Review::with('user', 'company')
         ->orderBy('id', 'DESC')
         ->limit(20)
         ->get();
@endphp
<section class="review-section pt-100 10b-50 section--bg2 overflow-hidden">
    <div class="shape-one"></div>
    <div class="shape-two"></div>
    <div class="shape-three"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-6">
                <div class="section-header text-center wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <h3 class="section-title text-white border--style">{{ __(@$content->data_values->heading ) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="review-slider">
            @forelse ($reviews as $review)
                <div class="single-slide">
                    <div class="review-card">
                        <div class="review-card__top">
                            <div class="thumb">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$review->user->image, null, true) }}"
                                    alt="@lang('Image')">
                                <img />
                            </div>
                            <div class="content">
                                <h6 class="fs--16px"><a href="{{ route('company.details', [$review->company->id, slug($review->company->name)]) }}">{{ @$review->company->name }}</a>
                                </h6>
                                <p class="fs--14px mt-1">@lang('Reviewed by') <a
                                        href="javascript:;" class="text--base"><strong>{{ @$review->user->fullname }}</strong></a>
                                </p>
                            </div>
                        </div>
                        <div class="review-card__ratings text--base">
                            @php
                                echo rating($review->rating);
                            @endphp
                        </div>
                        <p class="review-card__des">{{ __(shortDescription($review->review)) }}</p>
                    </div>
                </div>
            @empty
                <span>@lang('No Review')</span>
            @endforelse
        </div>
    </div>
</section>

@php 
$treviews = App\Models\TeacherReview::with('user', 'teacher')
         ->orderBy('id', 'DESC')
         ->limit(20)
         ->get();
@endphp
<section class="review-section pt-100 10b-50 section--bg2 overflow-hidden">
    <div class="shape-one"></div>
    <div class="shape-two"></div>
    <div class="shape-three"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-6">
                <div class="section-header text-center wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <h3 class="section-title text-white border--style">{{ __("Teacher's Review") }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="review-slider">
            @forelse ($treviews as $review)
                <div class="single-slide">
                    <div class="review-card">
                        <div class="review-card__top">
                            <div class="thumb">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$review->user->image, null, true) }}"
                                    alt="@lang('Image')">
                                <img />
                            </div>
                            <div class="content">
                                <h6 class="fs--16px"><a href="{{ route('teacher.details', [$review->teacher->id, slug($review->teacher->name)]) }}">{{ @$review->teacher->name }}</a>
                                </h6>
                                <p class="fs--14px mt-1">@lang('Reviewed by') <a
                                        href="javascript:;" class="text--base"><strong>{{ @$review->user->fullname }}</strong></a>
                                </p>
                            </div>
                        </div>
                        <div class="review-card__ratings text--base">
                            @php
                                echo rating($review->rating);
                            @endphp
                        </div>
                        <p class="review-card__des">{{ __(shortDescription($review->review)) }}</p>
                    </div>
                </div>
            @empty
                <span>@lang('No Review')</span>
            @endforelse
        </div>
    </div>
</section>
