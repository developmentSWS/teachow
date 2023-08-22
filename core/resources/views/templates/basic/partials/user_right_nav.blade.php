
    <div class="profile-sidebar">
        <div class="profile-widget">
            <div class="thumb">
                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, null, true)}}" />
            </div>
            <h4 class="profile-name text-center mt-4"> {{ __(@ucwords(auth()->user()->fullname)) }} </h4>
            <p class="text-center"><i class="las la-map-marker-alt"></i>
                @if(auth()->user()->address->city)
                {{ __(@ucwords(auth()->user()->address->city)) }},
                @endif
                {{ __(@ucwords(auth()->user()->address->country)) }}
            </p>
            @if(auth()->user()->about)
            <hr>
            <p> {{ __(auth()->user()->about) }} </p>
            @endif
        </div><!-- profile-widget end -->

        <div class="profile-widget mt-5">
            <h5 class="profile-widget__title">@lang('Profile Overview')</h5>
            <ul class="profile-info-list">
                <li><i class="las la-user"></i> @lang('Member since
                    '){{ showDateTime(auth()->user()->created_at, 'Y') }} </li>
                <li><i class="las la-envelope"></i> {{ auth()->user()->email }}</li>

                <li><i class="las la-star"></i> @lang('Total Reviews ')
                    <span class="text--base"> &nbsp; {{ $totalReview }}</span>
                </li>
            </ul>
        </div>
        {{-- Ad-div --}}
        <div class="has--link item--link mt-4">
            @php
                echo getAdvertisement('300x600');
            @endphp
        </div>
    </div>

