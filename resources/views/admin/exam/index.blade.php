@extends('layouts.admin')
@section('title', 'Exams')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Exams</h2>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.exam.create')}}" class="nav_link btn">New Exam</a></li>
            </ul>
        </div>
    </div>
</section>
{{-- <section class="content_section admin_section">
    <div class="container">
        <div class="row">
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Exam attemt</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
             
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Exam pass</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>


            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Exam failed</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Total Exam</h3> 
                <span class="badge text-success">{{$totalexam??0}}</span> 
            </div>
        </div>
    </div>
</section> --}}
<section class="content_section admin_section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Title","name"=>"title","data"=>"title"], 
                ["th"=>"Time Of Exam","name"=>"time_of_exam","data"=>"time_of_exam"], 
            ]' />
        </div>
    </div>
</section>
@endsection

@push('modals')

<div class="modal fade bd-example-modal-lg" id="explanation_video_modal" tabindex="-1" role="dialog"
        aria-labelledby="sub-category-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="sub-category-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sub-category-createLabel"><span id="sub-category-id"></span>Explanation Video</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form  class="form" id="explanation_video_form" method="post" action="{{route('admin.exam.explanation_video')}}" >
                        @csrf                
                        <div class="row"> 

                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-8"> 
                                            <label for="name-table-subcategory-form-create">Vimeo video</label>

                                            <input type="text"  name="explanation_video" id="explanation_video" class="form-control" placeholder="Vimeo Url"  >

                                            <div class="invalid-feedback" id="explanation_video_error"></div>

                                        </div>
                                    </div>
                                </div>    
                            </div>

                            <input type="hidden" id="exam_id" name="exam_id" >

                            <div class="col-md-4 pt-4">  
                                <button type="button" class="btn btn-dark" id="table-subcategory-form-submit" onclick="VideoSubmit()">Save</button>  
                                <button type="button" class="btn btn-secondary" style="display: none" id="table-subcategory-form-clear" >Cancel</button>               
                            </div>
                        </div> 
                    </form>

                </div> 
            </div>
          
        </div>
    </div>

@endpush

@push('footer-script')
    <script>
         

         function UploadVideo(element)
         {
            var exam_slug = $(element).data('id');

            $('#exam_id').val(exam_slug);

            $('#explanation_video_modal').modal('show');

            console.log(exam_slug);

         }

         
         function VideoSubmit() 
            {

                $('.invalid-feedback').html('');

                $('.form-control').removeClass('is-invalid');

                var formElement = $('#explanation_video_form')[0]; 

                var formData = new FormData(formElement);

                $.ajax({
                    url: $('#explanation_video_form').attr('action'),  
                    type: 'POST', 
                    data: formData,  
                    processData: false, 
                    contentType: false, 
                    success: function(response) {
                        
                        if (response.status === 'success') {
                            
                            $('#explanation_video_modal').modal('hide');

                            $('#explanation_video_form')[0].reset();

                            showToast(response.message, 'success',{ autohide: true ,delay:3000 });
                        } 
                    },
                    error: function(xhr) {
                        
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            
                            $.each(errors, function(field, message) {
                                $('#' + field + '_error').html(message);
                                $('#' + field).addClass('is-invalid');
                            });
                        }
                    }
                });
            }



    </script>
@endpush