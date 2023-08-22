@extends($activeTemplate.'layouts.auth')
@section('content')
    <form class="edit-profile-form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="custom--card">
            <div class="card-header bg--dark">
                <h5 class="text-white">@lang('Profile Setting')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!--<div class="col-lg-6 form-group">-->
                    <!--    <div class="profile-thumb-wrapper">-->
                    <!--    <label>@lang('Image')</label>-->
                    <!--        <div class="profile-thumb justify-content-center">-->
                    <!--            <div class="avatar-preview">-->
                    <!--                <div class="profilePicPreview" style="background-image: url('{{ getImage(imagePath()['profile']['user']['path'] . '/' . $user->image,imagePath()['profile']['user']['size']) }}');">-->
                    <!--                </div>-->
                    <!--                <div class="avatar-edit">-->
                    <!--                    <input type='file' class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" />-->
                    <!--                    <label for="profilePicUpload1" class="btn btn--base mb-0"><i class="las la-camera"></i></label>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div><!-- profile-thumb-wrapper end -->
                    <!--</div>-->

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>@lang('First Name') </label>
                            <div class="custom-icon-field">
                                <i class="las la-user"></i>
                                <input type="text" name="firstname" class="form--control"
                                    placeholder="{{ __($user->firstname) }}" value="{{ __($user->firstname) }}"
                                    required>
                            </div>
                        </div>
                    </div>   
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>@lang('Last Name')</label>
                            <div class="custom-icon-field">
                                <i class="las la-user"></i>
                                <input type="text" name="lastname" class="form--control"
                                    placeholder="{{ __($user->lastname) }}" value="{{ __($user->lastname) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 form-group">
                        <label>@lang('Email')</label>
                        <div class="custom-icon-field">
                            <i class="las la-envelope"></i>
                            <input type="email" class="form--control" placeholder="{{ __($user->email) }}" value="{{ __($user->email) }}" readonly>
                        </div>
                    </div>

                    <div class="col-lg-6 form-group">
                        <label>@lang('Mobile Number')</label>
                        <div class="custom-icon-field">
                            <i class="las la-phone"></i>
                            <input type="tel" name="#0" class="form--control" placeholder="{{ $user->mobile }}"
                                value="{{ $user->mobile }}" readonly>
                        </div>
                    </div>

                    <!--<div class="col-lg-6 form-group">-->
                    <!--    <label>@lang('Address')</label>-->
                    <!--    <div class="custom-icon-field">-->
                    <!--        <i class="las la-map-marker-alt"></i>-->
                    <!--        <input type="text" name="address" class="form--control"-->
                    <!--            placeholder="{{ __($user->address->address) }}"-->
                    <!--            value="{{ __($user->address->address) }}">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-lg-6 form-group">
                        <label>@lang('Country')</label>
                        <div class="custom-icon-field">
                            <i class="las la-globe"></i>
                            <input type="text" class="form--control" placeholder="{{ __($user->address->country) }}"
                                value="{{ __($user->address->country) }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>@lang('State')</label>
                        <div class="custom-icon-field">
                            <i class="las la-map-signs"></i>
                            <input type="text" name="state" class="form--control"
                                placeholder="{{ __($user->address->state) }}"
                                value="{{ __($user->address->state) }}">
                        </div>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>@lang('City')</label>
                        <div class="custom-icon-field">
                            <i class="las la-map-pin"></i>
                            <input type="text" name="city" class="form--control"
                                placeholder="{{ __($user->address->city) }}"
                                value="{{ __($user->address->city) }}">
                        </div>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>@lang('Zip Code')</label>
                        <div class="custom-icon-field">
                            <i class="las la-location-arrow"></i>
                            <input type="text" name="zip" class="form--control"
                                placeholder="{{ __($user->address->zip) }}" value="{{ __($user->address->zip) }}">
                        </div>
                    </div>

                    <!--<div class="col-lg-12 form-group">-->
                    <!--    <label>@lang('About')</label>-->
                    <!--    <div class="custom-icon-field">-->
                    <!--        <i class="las la-address-card"></i>-->
                    <!--        <textarea name="about" class="form--control"-->
                    <!--            placeholder="@lang('Write about....')">{{ __($user->about) }}</textarea>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <button type="submit" class="btn btn--base w-100"><i class="las la-upload fs--18px"></i>
                        @lang('Update')</button>
                </div><!-- row end -->
            </div>
        </div>
    </form>
@endsection




@push('script')
    <script>
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.profile-thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });

        $(".remove-image").on('click', function() {
            $(".profilePicPreview").css('background-image', 'none');
            $(".profilePicPreview").removeClass('has-image');
        })
    </script>
@endpush
