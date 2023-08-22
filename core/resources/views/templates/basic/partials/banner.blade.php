@php
$content = getContent('banner.content', true);
@endphp

<style>
    @media only screen and (max-width: 600px) {
        .hero__search-form button
        {
                height: auto!important;
                top: 55%!important;
        }
    }
</style>

<section class="hero bg_img"
    style="background-image: url('{{ getImage('assets/images/frontend/banner/' . @$content->data_values->image, '1920x840') }}');">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 text-md-start text-center">
                <h2 class="hero__title wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
                    {{ __('An Integrated Platform for Institutes and Teacher Reviews') }}</h2> 
                    
                    <!--$content->data_values->heading-->
                <p class="hero__description mt-2 wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.5s">
                    {{ __($content->data_values->subheading) }}</p>
            </div>
        </div>
        <div class="row mt-lg-5 mt-4">
            <div class="col-lg-6 col-md-8">
                <form action="{{ route('search.company') }}" class="hero__search-form wow fadeInUp"
                    data-wow-duration="0.5" data-wow-delay="0.7s">
                    <div class="row">
                        <div class="col-sm-3">
                            <select name="for" class="form--control" style="padding-right:0!important;">
                                <option value="institution">Institution</option>
                                <option value="teacher" selected>Teacher</option>
                            </select>
                        </div>
                        <div class="col-sm-9">
                        <input type="text" name="search" class="form--control" placeholder="@lang('Search Here...')"
                        required>
                    <button type="submit" class="btn btn--base">@lang('Search')</button>
                        </div>
                    </div>
                   
                   
                </form>
            </div>
        </div>
    </div>
</section>
