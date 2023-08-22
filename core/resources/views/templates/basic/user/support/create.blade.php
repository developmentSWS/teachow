@extends($activeTemplate.'layouts.frontend')

@section('content')
    <section class="pt-50 pb-50 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="custom--card">
                        <div class="card-header bg--dark">
                            <h5 class="text-white">@lang('My Support Tickets')</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('ticket.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    @auth
                                        <div class="col-lg-6 form-group">
                                            <label>@lang('Full Name')</label>
                                            <div class="custom-icon-field">
                                                <i class="las la-user"></i>
                                                <input type="text" name="name" autocomplete="off" class="form--control" placeholder="@lang('Full name')" value="{{ auth()->user()->fullname }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>@lang('Email Address')</label>
                                            <div class="custom-icon-field">
                                                <i class="las la-envelope"></i>
                                                <input type="text" name="email" autocomplete="off" class="form--control" placeholder="@lang('Email address')" value="{{ auth()->user()->email }}" readonly>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-6 form-group">
                                            <label>@lang('Full Name')</label>
                                            <div class="custom-icon-field">
                                                <i class="las la-user"></i>
                                                <input type="text" name="name" autocomplete="off" class="form--control" placeholder="@lang('Full name')" value="{{ old('name') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>@lang('Email Address')</label>
                                            <div class="custom-icon-field">
                                                <i class="las la-envelope"></i>
                                                <input type="text" name="email" autocomplete="off" class="form--control" placeholder="@lang('Email address')" value="{{ old('email') }}" readonly>
                                            </div>
                                        </div>
                                    @endauth

                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Priority')</label>
                                        <div class="custom-icon-field">
                                            <i class="las la-envelope"></i>
                                            <select name="priority" class="select form--control shadow-none">
                                                <option value="3">@lang('High')</option>
                                                <option value="2">@lang('Medium')</option>
                                                <option value="1">@lang('Low')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Subject')</label>
                                        <div class="custom-icon-field">
                                            <i class="las la-notes-medical"></i>
                                            <input type="text" name="subject" value="{{ old('subject') }}" autocomplete="off"
                                                class="form--control" placeholder="@lang('Write subject')" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Message')</label>
                                        <div class="custom-icon-field">
                                            <i class="las la-comment-alt"></i>
                                            <textarea name="message" autocomplete="off" class="form--control" wrap="off"
                                                placeholder="@lang('Write message')" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row justify-content-between">
                                        <div class="col-lg-12">
                                            <div class="row justify-content-between">
                                                <div class="col-lg-12">
                                                    <label class="my-2 t-heading-font">
                                                        @lang('Attachments')
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="attachments[]" class="form--control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                                        <button type="button" class="input-group-text addFile btn--base border-0">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                    </div>

                                                    <div class="mt-3" id="appendContainer"></div>
                                                    <span class="ticket-attachments-message text-muted">
                                                        @lang('Allowed File Extensions'): .@lang('jpg'),
                                                        .@lang('jpeg'), .@lang('png'), .@lang('pdf'),
                                                        .@lang('doc'), .@lang('docx')
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .select {
            padding: 0.625rem 2.25rem;
        }

    </style>
@endpush

@push('script')
    <script>
        (function($) {

            "use strict";
            $('.addFile').on('click', function(e) {
                e.preventDefault();
                $("#appendContainer").append(`
                    <div class="input-group mb-3">
                        <input type="file" name="attachments[]" class="form--control" required>
                        <button type="button" class="input-group-text btn--danger border-0 remove-btn"> <i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
