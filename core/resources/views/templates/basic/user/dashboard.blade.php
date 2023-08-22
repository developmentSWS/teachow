@extends($activeTemplate.'layouts.auth')
@section('content')
<style>
    .nav-link
    {
        color:black;
    }

    .nav-pills .nav-link.active, .nav-pills .show>.nav-link
    {
        background-color : rgb(var(--r), var(--g), var(--b));
    }
</style>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" data-menu="institute" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Institues Reviews</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-menu="teacher" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Teachers Reviews</button>
  </li>
 
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
  @include($activeTemplate.'partials.reviews')
  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
  @include($activeTemplate.'partials.treview')
  </div>
  
</div>
    <!-- review blade -->
  

@endsection

@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            //update review
            $('.edit-review').on('click', function() {
           
             var result = $(this).data('resource');
                // console.log('result', result);
                $('.edit-id').val(result.id);
                $('.edit-review12').val(result.review);

                $('#reviewUpdateModal').find('input[name=rating]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=teaching_faculty]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=infra_quality]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=technology_friendly]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=counseling_quality]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=operational_manage]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=attitude_management]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=quality_classroom]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=tests]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=quality_study]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=current_affair]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=interview_guidance]').parent('span').removeClass('checked');
                var existRating = result.rating;
                var teaching_faculty = result.teaching_faculty;
                var infra_quality = result.infra_quality;
                var technology_friendly = result.technology_friendly;
                var counseling_quality = result.counseling_quality;
                var operational_manage = result.operational_manage;
                var attitude_management = result.attitude_management;
                var quality_classroom = result.quality_classroom;
                var tests = result.tests;
                var quality_study = result.quality_study;
                var current_affair = result.current_affair;
                var interview_guidance = result.interview_guidance;

                if (existRating == 5) {
                    $('#existed-rating-5').addClass('checked');
                } else if (existRating == 4) {
                    $('#existed-rating-4').addClass('checked');
                } else if (existRating == 3) {
                    $('#existed-rating-3').addClass('checked');
                } else if (existRating == 2) {
                    $('#existed-rating-2').addClass('checked');
                } else {
                    $('#existed-rating-1').addClass('checked');
                }

                if (teaching_faculty == 5) {
                    $('#existed-rating1-5').addClass('checked');
                } else if (teaching_faculty == 4) {
                    $('#existed-rating1-4').addClass('checked');
                } else if (teaching_faculty == 3) {
                    $('#existed-rating1-3').addClass('checked');
                } else if (teaching_faculty == 2) {
                    $('#existed-rating1-2').addClass('checked');
                } else {
                    $('#existed-rating1-1').addClass('checked');
                }

                if (infra_quality == 5) {
                    $('#existed-rating2-5').addClass('checked');
                } else if (infra_quality == 4) {
                    $('#existed-rating2-4').addClass('checked');
                } else if (infra_quality == 3) {
                    $('#existed-rating2-3').addClass('checked');
                } else if (infra_quality == 2) {
                    $('#existed-rating2-2').addClass('checked');
                } else {
                    $('#existed-rating2-1').addClass('checked');
                }

                if (technology_friendly == 5) {
                    $('#existed-rating3-5').addClass('checked');
                } else if (technology_friendly == 4) {
                    $('#existed-rating3-4').addClass('checked');
                } else if (technology_friendly == 3) {
                    $('#existed-rating3-3').addClass('checked');
                } else if (technology_friendly == 2) {
                    $('#existed-rating3-2').addClass('checked');
                } else {
                    $('#existed-rating3-1').addClass('checked');
                }

                if (counseling_quality == 5) {
                    $('#existed-rating4-5').addClass('checked');
                } else if (counseling_quality == 4) {
                    $('#existed-rating4-4').addClass('checked');
                } else if (counseling_quality == 3) {
                    $('#existed-rating4-3').addClass('checked');
                } else if (counseling_quality == 2) {
                    $('#existed-rating4-2').addClass('checked');
                } else {
                    $('#existed-rating4-1').addClass('checked');
                }

                if (operational_manage == 5) {
                    $('#existed-rating5-5').addClass('checked');
                } else if (operational_manage == 4) {
                    $('#existed-rating5-4').addClass('checked');
                } else if (operational_manage == 3) {
                    $('#existed-rating5-3').addClass('checked');
                } else if (operational_manage == 2) {
                    $('#existed-rating5-2').addClass('checked');
                } else {
                    $('#existed-rating5-1').addClass('checked');
                }

                if (attitude_management == 5) {
                    $('#existed-rating6-5').addClass('checked');
                } else if (attitude_management == 4) {
                    $('#existed-rating6-4').addClass('checked');
                } else if (attitude_management == 3) {
                    $('#existed-rating6-3').addClass('checked');
                } else if (attitude_management == 2) {
                    $('#existed-rating6-2').addClass('checked');
                } else {
                    $('#existed-rating6-1').addClass('checked');
                }

                if (quality_classroom == 5) {
                    $('#existed-rating7-5').addClass('checked');
                } else if (quality_classroom == 4) {
                    $('#existed-rating7-4').addClass('checked');
                } else if (quality_classroom == 3) {
                    $('#existed-rating7-3').addClass('checked');
                } else if (quality_classroom == 2) {
                    $('#existed-rating7-2').addClass('checked');
                } else {
                    $('#existed-rating7-1').addClass('checked');
                }

                if (tests == 5) {
                    $('#existed-rating8-5').addClass('checked');
                } else if (tests == 4) {
                    $('#existed-rating8-4').addClass('checked');
                } else if (tests == 3) {
                    $('#existed-rating8-3').addClass('checked');
                } else if (tests == 2) {
                    $('#existed-rating8-2').addClass('checked');
                } else {
                    $('#existed-rating8-1').addClass('checked');
                }

                if (quality_study == 5) {
                    $('#existed-rating9-5').addClass('checked');
                } else if (quality_study == 4) {
                    $('#existed-rating9-4').addClass('checked');
                } else if (quality_study == 3) {
                    $('#existed-rating9-3').addClass('checked');
                } else if (quality_study == 2) {
                    $('#existed-rating9-2').addClass('checked');
                } else {
                    $('#existed-rating9-1').addClass('checked');
                }

                if (current_affair == 5) {
                    $('#existed-rating11-5').addClass('checked');
                } else if (current_affair == 4) {
                    $('#existed-rating11-4').addClass('checked');
                } else if (current_affair == 3) {
                    $('#existed-rating11-3').addClass('checked');
                } else if (current_affair == 2) {
                    $('#existed-rating11-2').addClass('checked');
                } else {
                    $('#existed-rating11-1').addClass('checked');
                }

                if (interview_guidance == 5) {
                    $('#existed-rating12-5').addClass('checked');
                } else if (interview_guidance == 4) {
                    $('#existed-rating12-4').addClass('checked');
                } else if (interview_guidance == 3) {
                    $('#existed-rating12-3').addClass('checked');
                } else if (interview_guidance == 2) {
                    $('#existed-rating12-2').addClass('checked');
                } else {
                    $('#existed-rating12-1').addClass('checked');
                }
            });

            $('.edit-review-teacher').on('click', function() {
                    
                var result = $(this).data('resource');

                // console.log('result', result);
                $('.edit-id1').val(result.id);
                $('.edit-review123').val(result.review);

                $('#reviewUpdateModal12').find('input[name=rating]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=friendliness_teaching]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=clarity_of_concept]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=communication]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=student_engage]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=punctuality]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=content_validity]').parent('span').removeClass('checked');
                $('#reviewUpdateModal12').find('input[name=syllabus_completed]').parent('span').removeClass('checked');
                var existRating = result.rating;
                var teaching_faculty = result.friendliness_teaching;
                var infra_quality = result.clarity_of_concept;
                var technology_friendly = result.communication; 
                var counseling_quality = result.student_engage;
                var operational_manage = result.punctuality;
                var attitude_management = result.content_validity;
                var quality_classroom = result.syllabus_completed;

                if (existRating == 5) {
                    $('#existed1-rating-5').addClass('checked');
                } else if (existRating == 4) {
                    $('#existed1-rating-4').addClass('checked');
                } else if (existRating == 3) {
                    $('#existed1-rating-3').addClass('checked');
                } else if (existRating == 2) {
                    $('#existed1-rating-2').addClass('checked');
                } else {
                    $('#existed1-rating-1').addClass('checked');
                }

                if (teaching_faculty == 5) {
                    $('#existed1-rating1-5').addClass('checked');
                } else if (teaching_faculty == 4) {
                    $('#existed1-rating1-4').addClass('checked');
                } else if (teaching_faculty == 3) {
                    $('#existed1-rating1-3').addClass('checked');
                } else if (teaching_faculty == 2) {
                    $('#existed1-rating1-2').addClass('checked');
                } else {
                    $('#existed1-rating1-1').addClass('checked');
                }

                if (infra_quality == 5) {
                    $('#existed1-rating2-5').addClass('checked');
                } else if (infra_quality == 4) {
                    $('#existed1-rating2-4').addClass('checked');
                } else if (infra_quality == 3) {
                    $('#existed1-rating2-3').addClass('checked');
                } else if (infra_quality == 2) {
                    $('#existed1-rating2-2').addClass('checked');
                } else {
                    $('#existed1-rating2-1').addClass('checked');
                }

                if (technology_friendly == 5) {
                    $('#existed1-rating3-5').addClass('checked');
                } else if (technology_friendly == 4) {
                    $('#existed1-rating3-4').addClass('checked');
                } else if (technology_friendly == 3) {
                    $('#existed1-rating3-3').addClass('checked');
                } else if (technology_friendly == 2) {
                    $('#existed1-rating3-2').addClass('checked');
                } else {
                    $('#existed1-rating3-1').addClass('checked');
                }

                if (counseling_quality == 5) {
                    $('#existed1-rating4-5').addClass('checked');
                } else if (counseling_quality == 4) {
                    $('#existed1-rating4-4').addClass('checked');
                } else if (counseling_quality == 3) {
                    $('#existed1-rating4-3').addClass('checked');
                } else if (counseling_quality == 2) {
                    $('#existed1-rating4-2').addClass('checked');
                } else {
                    $('#existed1-rating4-1').addClass('checked');
                }

                if (operational_manage == 5) {
                    $('#existed1-rating5-5').addClass('checked');
                } else if (operational_manage == 4) {
                    $('#existed1-rating5-4').addClass('checked');
                } else if (operational_manage == 3) {
                    $('#existed1-rating5-3').addClass('checked');
                } else if (operational_manage == 2) {
                    $('#existed1-rating5-2').addClass('checked');
                } else {
                    $('#existed1-rating5-1').addClass('checked');
                }

                if (attitude_management == 5) {
                    $('#existed1-rating7-5').addClass('checked');
                } else if (attitude_management == 4) {
                    $('#existed1-rating7-4').addClass('checked');
                } else if (attitude_management == 3) {
                    $('#existed1-rating7-3').addClass('checked');
                } else if (attitude_management == 2) {
                    $('#existed1-rating7-2').addClass('checked');
                } else {
                    $('#existed1-rating7-1').addClass('checked');
                }

                if (quality_classroom == 5) {
                    $('#existed1-rating6-5').addClass('checked');
                } else if (quality_classroom == 4) {
                    $('#existed1-rating6-4').addClass('checked');
                } else if (quality_classroom == 3) {
                    $('#existed1-rating6-3').addClass('checked');
                } else if (quality_classroom == 2) {
                    $('#existed1-rating6-2').addClass('checked');
                } else {
                    $('#existed1-rating6-1').addClass('checked');
                }
            });

            //delete review
            $('.delete-review').on('click', function() {
                $('.delete-id').val($(this).data('id'));
            });

                // Check Radio-box
                $(".give-rating input:radio").attr("checked", false);

                $(".give-rating input").click(function(e) {
                    $(this).parent().siblings().removeClass("checked");
                    $(this)
                        .parent()
                        .addClass("checked");
                });

                // edit teacher review
                // Check Radio-box
                $(".give-rating1 input:radio").attr("checked", false);

                    $(".give-rating1 input").click(function(e) {
                        $(this).parent().siblings().removeClass("checked");
                        $(this)
                            .parent()
                            .addClass("checked");
                    });
        });

      
    </script>
@endpush
