@php
$content = getContent('testimonial.content', true);
$element = getContent('testimonial.element', false, null, true);
@endphp
<section class="pt-100 pb-100 overflow-hidden bg_img"
    style="background-image: url('{{ getImage('assets/images/frontend/testimonial/' . @$content->data_values->image, '1920x840') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-6">
                <div class="section-header text-center wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <div class="section-subtitle border-left-right text--base">
                        {{ __(@$content->data_values->subheading) }}</div>
                    <h2 class="section-title text-white">{{ __(@$content->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="testimonial-slider">
                    @foreach ($element as $item)
                        <div class="single-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-card__thumb">
                                    <img src="{{ getImage('assets/images/frontend/testimonial/' . @$item->data_values->image, '100x100') }}"
                                        alt="{{ __(@$item->data_values->name) }}">
                                </div>
                                <h6 class="testimonial-card__name text-white">{{ __(@$item->data_values->name) }}</h6>
                                <span class="testimonial-card__location">{{ __(@$item->data_values->address) }}</span>
                                <p class="testimonial-card__text">{{ __(@$item->data_values->quote) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
