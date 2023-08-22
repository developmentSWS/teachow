@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-50 pb-50 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <form class="create-company-form" action="{{ route('user.company.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="custom--card">

                            <div class="card-header bg--dark">
                                <h5 class="text-white">@lang('Provide Your Company Information')</h5>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>@lang('Image') <small class="text-danger">*</small></label>
                                            <div class="profile-thumb justify-content-center">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage('', imagePath()['company']['size']) }}');">
                                                    </div>

                                                    <div class="avatar-edit">
                                                        <input type='file' class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" required/>
                                                        <label for="profilePicUpload1" class="btn btn--base mb-0"><i
                                                                class="las la-camera"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Company Name') <small class="text-danger">*</small></label>
                                            <input type="text" name="name" class="form--control" value="{{ old('name') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('Category') <small class="text-danger">*</small></label>
                                            <select name="category" class="form--control" required>
                                                <option value="" disabled selected>@lang('Select One')</option>
                                                @foreach($categories as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label>@lang('URL') </label>
                                        <input type="text" name="url" class="form--control" value="{{ old('url') }}" >
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Email') </label>
                                        <input type="email" name="email" class="form--control" value="{{ old('email') }}" >
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Address') <small class="text-danger">*</small></label>
                                        <input type="text" name="address" class="form--control" value="{{ old('address') }}" required>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Tags') <small class="text-danger">*</small></label>
                                        <select name="tags[]" class="form--control select2-auto-tokenize" multiple="multiple" required>
                                        </select>
                                        <small>@lang('Separate multiple keywords by') <code>,</code>(@lang('comma')) @lang('or') <code>@lang('enter')</code> @lang('key')</small>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Description') <small class="text-danger">*</small></label>
                                        <textarea name="description" class="form--control" required>{{ old('description') }}</textarea>
                                    </div>
                                </div><!-- row end -->
                                <button type="submit" class="btn btn--base w-100"> @lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <!-- select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/select2.min.css') }}">
    <style>
        .select2-selection,
        .select2-selection--multiple {
            padding: 0.625rem 1.25rem;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            -ms-border-radius: 8px;
            -o-border-radius: 8px;
            color: #000;
        }

    </style>
@endpush
@push('script')
    <!-- seldct 2 js -->
    <script src="{{ asset('assets/admin/js/vendor/select2.min.js') }}"></script>
    <script>
        // js for Multiple select-2 with tokenize
        $(".select2-auto-tokenize").select2({
            tags: true,
            tokenSeparators: [',']
        });
        //script
        function companyPP(input) {
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
            companyPP(this);
        });
    </script>
@endpush
