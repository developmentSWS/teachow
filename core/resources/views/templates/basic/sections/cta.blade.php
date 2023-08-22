@php
$content = getContent('cta.content', true);
$element = getContent('cta.element', false, null, true);
@endphp
{{-- CTA= A call to action (CTA) is a prompt on a website --}}
<section class="cta-section pt-100 pb-100 overflow-hidden">
    <div class="shape-one"></div>
    <div class="shape-two"></div>
    <div class="shape-three"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="section-header wow fadeInLeft" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="mt-3">
                        {{ __(@$content->data_values->subheading) }}
                    </p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-5">
            @foreach ($element as $item)
                <div class="col-md-6 wow fadeInLeft" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <div class="cta-card">
                        <div class="cta-card__icon">
                            @php
                                echo @$item->data_values->icon;
                            @endphp
                        </div>
                        <div class="cta-card__content">
                            <h3 class="cta-card__title">{{ __(@$item->data_values->title) }}</h3>
                            <p class="fs--18px mt-3">{{ __(@$item->data_values->description) }}</p>
                            <a href="{{ @$item->data_values->url }}" class="btn btn--base mt-4">{{ __(@$item->data_values->button_name) }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
