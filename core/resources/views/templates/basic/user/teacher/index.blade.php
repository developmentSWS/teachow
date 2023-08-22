
@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-50 pb-50 contact-section overflow-hidden section--bg">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="custom--card justify-content-center">
                <div class="table-responsive table-responsive--lg table-responsive--md table-responsive--sm">
                    <table class="table custom--table">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Address')</th>
                                <th>@lang('Rating')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                                <tr>
                                    <td data-label="@lang('S.N.')">{{ $companies->firstItem() + $loop->index }}</td>
                                    <td data-label="@lang('Name')">
                                        <a href="@if (@$company->status == 1) {{ route('teacher.details', [$company->id, $company->name]) }} @endif"
                                            class="text--base">
                                            {{ __(@$company->name) }}
                                        </a>
                                    </td>
                                    <td data-label="@lang('Address')">{{ @$company->address }}</td>

                                    <td data-label="@lang('Rating')">
                                        <span class="text--base">
                                            @php
                                                echo avgRating(@$company->avg_rating);
                                            @endphp
                                        </span>
                                        ({{ @$company->treviews_count }})
                                    </td>

                                    <td data-label="@lang('Status')">
                                        @php echo $company->statusText @endphp
                                        @if($company->admin_feedback && $company->status != 0)
                                            <button class="rounded btn--info feedback" data-bs-toggle="modal" data-bs-target="#companyFeedBackModal" data-feedback="{{ $company->admin_feedback }}">
                                                <i class="las la-info-circle"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('user.teacher.edit', $company->id) }}"
                                            class="btn btn--base btn-sm">
                                            <i class="fa fa-desktop"></i>
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($companies->hasPages())
                    {{ paginateLinks($companies) }}
                @endif
            </div>

            <div class="has--link">
                <div class="d-flex justify-content-center my-3">
                    @php echo getAdvertisement('728x90'); @endphp
                </div>
            </div>
        </div>
    </section>
    {{-- //feedback Modal --}}
    <div class="modal fade" id="companyFeedBackModal" tabindex="-1" aria-labelledby="companyFeedBackModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="companyFeedBackModal"> @lang('Admin Feedback')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body admin-feedback">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn--base" data-bs-dismiss="modal">@lang('Cancel')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            $(".feedback").on('click', function() {
                $(".admin-feedback").text($(this).data('feedback'))
            })
        })
    </script>
@endpush
