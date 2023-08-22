
@php
    $addShowAfterColum = 3;
@endphp

@if($myReview && (request()->page==1 || request()->page==null))
    <div class="customer-review mb-3">
        <div class="customer-review__thumb">
            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$myReview->user->image, null, true) }}" alt="image">
        </div>
        <div class="customer-review__content">
            <div class="customer-review__header">
                <div class="left">
                    <h6>{{ __(@$myReview->user->fullname) }}</h6>
                    <span><i class="las la-map-marker-alt"></i>{{ __(@$myReview->user->address->country) }}</span>
                </div>
                <div class="right">
                    <div class="ratings d-flex align-items-center justify-content-end">
                        @php
                            echo rating(@$myReview->rating);
                        @endphp
                    </div>
                </div>
            </div>
            <div class="customer-review__body">
                <p> {{ __(@$myReview->review) }}</p>
            </div>

            @if (auth()->id() == $myReview->user_id)
                <div class="customer-review__footer">
                    <div class="left">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="edit-review" type="button" data-bs-toggle="modal"
                                    data-bs-target="#reviewUpdateModal" data-id="{{ $myReview->id }}" data-friendliness_teaching="{{ $myReview->friendliness_teaching }}" data-clarity_of_concept="{{ $myReview->clarity_of_concept }}" data-communication="{{ $myReview->communication }}" data-student_engage="{{ $myReview->student_engage }}" data-punctuality="{{ $myReview->punctuality }}" data-content_validity="{{ $myReview->content_validity }}" data-syllabus_completed="{{ $myReview->syllabus_completed }}"  data-review="{{ $myReview->review }}"  data-rating="{{ $myReview->rating }}"><i class="las la-edit"></i>
                                    @lang('Edit Review')
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="delete-review" type="button" data-bs-toggle="modal" data-bs-target="#reviewDeleteModal" data-id="{{ $myReview->id }}"><i class="las la-trash-alt"></i>@lang('Delete')</button>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endif


@forelse ($reviews as $review)
    <div class="customer-review mb-3">
        <div class="customer-review__thumb">
            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$review->user->image, null, true) }}" alt="image">
        </div>
        <div class="customer-review__content">
            <div class="customer-review__header">
                <div class="left">
                    <h6>{{ __(@$review->user->fullname) }}</h6>
                    <span><i class="las la-map-marker-alt"></i>{{ __(@$review->user->address->country) }}</span>
                </div>
                <div class="right">
                    <div class="ratings d-flex align-items-center justify-content-end">
                        @php
                            echo rating(@$review->rating);
                        @endphp
                    </div>
                </div>
            </div>
            <div class="customer-review__body">
                <p> {{ __(@$review->review) }}</p>
            </div>
        </div>
    </div>

    @if ($loop->index + 1 == $addShowAfterColum)
    @php
        $addShowAfterColum += 3;
    @endphp
    <div class="my-3">
        @php
            echo getAdvertisement('728x90');
        @endphp
    </div>
    @endif
@empty
    <div class="review-block">
        <div class="customer-review d-flex justify-content-center">
                <h5>{{ __($emptyMessage) }}</h5>
        </div>
    </div>
@endforelse

<div>
    <ul class="pagination justify-content-end me-3">
        @if ($reviews->hasPages())
            {{ paginateLinks($reviews) }}
        @endif
    </ul>
</div>
