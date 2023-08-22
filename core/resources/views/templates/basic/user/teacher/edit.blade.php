@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-50 pb-50 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('user.teacher.update', $company->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="custom--card">
                            <div class="card-header bg--dark">
                                <h5 class="text-white">@lang('Update Teacher Information')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Image') </label>
                                            <div class="profile-thumb justify-content-center">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage(imagePath()['company']['path'] . '/' . $company->image, imagePath()['company']['size']) }}');"></div>
                                                    <div class="avatar-edit">
                                                        <input type='file' class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" />
                                                        <label for="profilePicUpload1" class="btn btn--base mb-0"><i class="las la-camera"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($company->image))
                                                <button type="button" onClick="removeImage()" class="btn btn-danger btn-sm" >Remove Image</button>
                                            @endif
                                            <input type="hidden" id="removeImgInput" name="rmimage" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>@lang('Teacher Name')<small class="text-danger">*</small></label>
                                            <input type="text" name="name" class="form--control" value="{{ $company->name }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('Institute')</label>
                                            @php $institutes = explode(',', $company->institute);
                                                   
                                            @endphp
                                            <select name="category[]" class="form--control institute" multiple>
                                                     <option value="kk" {{ in_array('kk', $institutes) ? 'selected' : '' }}>@lang('Other')</option>
                                                <option value="mm" {{ in_array('mm', $institutes) ? 'selected' : '' }}>@lang('Free Lancer')</option>
                                                @forelse($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, $institutes) ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                  
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Email')</label>
                                        <input type="email" name="email" class="form--control"
                                            value="{{ $company->email }}">
                                    </div>
                                   
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Tags')</label>
                                        <select name="tags[]" class="form--control select2-auto-tokenize"
                                            multiple="multiple" >
                                            @if(!empty($company->tags))
                                                @foreach ($company->tags as $item)
                                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                     <div class="col-lg-6 form-group">
                                            <label>@lang('Location') </label>
                                            <input type="text" name="location" class="form--control" value="{{ $company->location }}" >
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Domain')<small class="text-danger">*</small></label>
                                        <input type="text" name="subject" class="form--control"
                                            value="{{ $company->address }}">
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Experience') </label>
                                        <textarea name="experience"
                                            class="form--control">{{ $company->description }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn--base w-100">@lang('Update')</button>
                                </div><!-- row end -->
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
         $(".institute").select2();
    </script>
    
  
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
        
        function removeImage()
        {
            // alert('herere');
             $('#removeImgInput').val('abb');
            // console.log($('.profilePicPreview').css('background-image', 'null'));
            $('.profilePicPreview').css('background-image', 'none');
        }

        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });
        
    </script>
@endpush
