@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('breadcrumb.content', true);
@endphp
@section('content')

<style>
    .padding {
        padding: 3rem !important
    }

    .user-card-full {
        overflow: hidden;
    }

    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
        box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
        border: none;
        margin-bottom: 30px;
    }

    .m-r-0 {
        margin-right: 0px;
    }

    .m-l-0 {
        margin-left: 0px;
    }

    .user-card-full .user-profile {
        border-radius: 5px 0 0 5px;
    }

    .bg-c-lite-green {
        background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
        background: linear-gradient(to right, #ee5a6f, #f29263);
    }

    .user-profile {
        padding: 20px 0;
    }

    .card-block {
        padding: 1.25rem;
    }

    .m-b-25 {
        margin-bottom: 25px;
    }

    .img-radius {
        border-radius: 5px;
    }



    h6 {
        font-size: 14px;
    }

    .card .card-block p {
        line-height: 25px;
    }

    @media only screen and (min-width: 1400px) {
        p {
            font-size: 14px;
        }
    }

    .card-block {
        padding: 1.25rem;
    }

    .b-b-default {
        border-bottom: 1px solid #e0e0e0;
    }

    .m-b-20 {
        margin-bottom: 20px;
    }

    .p-b-5 {
        padding-bottom: 5px !important;
    }

    .card .card-block p {
        line-height: 25px;
    }

    .m-b-10 {
        margin-bottom: 10px;
    }

    .text-muted {
        color: #919aa3 !important;
    }

    .b-b-default {
        border-bottom: 1px solid #e0e0e0;
    }

    .f-w-600 {
        font-weight: 600;
    }

    .m-b-20 {
        margin-bottom: 20px;
    }

    .m-t-40 {
        margin-top: 20px;
    }

    .p-b-5 {
        padding-bottom: 5px !important;
    }

    .m-b-10 {
        margin-bottom: 10px;
    }

    .m-t-40 {
        margin-top: 20px;
    }

    .user-card-full .social-link li {
        display: inline-block;
    }

    .user-card-full .social-link li a {
        font-size: 20px;
        margin: 0 10px 0 0;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

</style>

<section class="section--bg pb-100">
    <div class="company-details-bg bg_img d-lg-block d-none"
        style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->image, '1920x840') }}');">
    </div>

    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class=" container d-flex justify-content-center">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-card-full">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-25">
                                        <img src="{{ getImage(imagePath()['company']['path'] . '/' . $teacher->image) }}" class="img-radius"
                                            alt="User-Profile-Image" style="width: 170px; height: auto;">
                                    </div>
                                    <h6 class="f-w-600">{{ $teacher->name }}</h6>
                                    <p>{{ $teacher->address }}</p>
                                    <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <form method="post" action="{{ route('user.saveTeacherClaimFrom', ['id' => $teacher->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Claim This Teacher Profile</h6>
                                        <p class="text-center">
                                            Kindly upload any of the following documents to claim your account: <br>
                                            *your ID shall be auto-deleted
                                        </p>
                                        <p class="text-center" style="font-size: 11px; color:black;"> Aadhar Card / PAN Card / Voter ID / Driving license / Any
                                            other valid govt issued ID</p> 
                                        <div class="form-group">
                                            <label for="document">Upload Document <i class="lab la-help"></i></label>
                                            <input type="file" id="imageInput" name="image" class="form-control"  accept="application/pdf, image/*" required />
                                        </div>
                                     
                                        <input type="submit" name="save" value="Claim Now" style="float:right;" class="btn btn-sm btn-md btn--base d-flex align-items-center mx-2 mb-sm-2"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#imageInput').change(function() {
            var imageInput = this;
            var imageFile = imageInput.files[0];

            if (imageFile) {
                var allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
                var extension = imageFile.name.split('.').pop().toLowerCase();

                if ($.inArray(extension, allowedExtensions) === -1) {
                    alert('Invalid file type. Allowed types: jpg, jpeg, png, webp, pdf');
                    imageInput.value = ''; // Clear the input
                    return;
                }

                var maxSize = 2 * 1024 * 1024; // 1MB
                if (imageFile.size > maxSize) {
                    alert('File size exceeds 2MB.');
                    imageInput.value = ''; // Clear the input
                    return;
                }

                // Validation passed, you can show a success message or perform further actions
            }
        });
    });
</script>
@endpush
