@extends('layouts.admin')
@section('title', 'Lesson Material -> '.$lession_material->term_name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">

            <h2> Lesson Material -> {{ $lession_material->term_name  }}</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a onclick="CreateForm(event)" class="nav_link btn">Add Lessons</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="container">
        <div class="row">
            <x-ajax-table tableid="sub_lesson_material"   :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Pdf Name","name"=>"pdf_name","data"=>"pdf_name"], 
             
            ]' 
            />
        </div>
    </div>
</section> 
@endsection


@push('modals')

    <div class="modal fade" id="lesson-material-modal" tabindex="-1" role="dialog"
        aria-labelledby="live-class-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    
                    <form action="{{route('admin.lesson-material.store')}}"  id="lesson_material_form" method="post"  enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="lesson_material_id" value="{{$lession_material->id}}">
                         <div class="form-group">
                            <div class="form-data">
                                <div class="forms-inputs mb-8">
                                    <label for="pdf_name">pdf Name</label>
                                    <input type="text" name="pdf_name" id="pdf_name" value="" class="form-control " placeholder="Pdf Name" aria-placeholder="Sub Title" >
                                    <div class="invalid-feedback" id="error-pdf_name">The field is required</div>
                                </div>

                                <div class="forms-inputs mb-8">

                                    <label for="pdf_file">Upload PDF</label>

                                    <input type="file" name="pdf_file" id="pdf_file" value="" class="form-control " placeholder="Passcode" aria-placeholder="Sub Title" >

                                    <div class="invalid-feedback" id="error-pdf_file">The field is required</div>

                                </div>

                            </div>
                         </div>
                        <button type="button" onclick="CancelFrom()" data-bs-dismiss="modal" class="btn btn-secondary mr-1">Cancel</button>
                        <button type="submit" id="lesson_material_btn" class="btn btn-dark ml-1">Save</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endpush

@push('footer-script')
    <script>

        function update_lesson_material(url) {

        $.get(url, function(res) {

            $('#pdf_name').val("");
            $('#pdf_file').val("");
            // $('#term_type_form').text("");

            $('#pdf_name').val(res.pdf_name);
            $('#pdf_file').val(res.pdf_file);

            $('#error-pdf_name').text('').hide();
            $('#error-pdf_file').text('').hide();


            $('#lesson_material_form').attr('action',res.updateUrl);

            $('#lesson_material_btn').text('Update');

            $('#lesson-material-modal').modal('show');

        }, 'json')
        }

        function DeleteClose()
        {

            $('#table-sub_lesson_material-delete').modal('hide');

        }

       function CreateForm(event)
       {
            event.preventDefault();
            event.stopPropagation();
            
            var url ="{{route('admin.lesson-material.store')}}";

            $('#lesson_material_form').attr('action',url);

            $('#lesson-material-modal').modal('show');

            $('.invalid-feedback').hide();
            $('#lesson_material_btn').text('Save');
       }

       function CancelFrom()
       {
            $('#lesson-material-modal').modal('hide');
       }

       $(document).ready(function() {

            $('#lesson_material_form').on('submit', function(event) {

                event.preventDefault(); 
                
                var form = $(this);
                var url = $(this).attr('action');

                var formData = new FormData(this);

                $.ajax({
                    url: url,

                    type: 'POST',

                    data: formData,

                    processData: false,
                    contentType: false,
                
                    success: function(response) {
                    
                        form.trigger('reset');

                        $('#lesson-material-modal').modal('hide');

                        showToast(response.success,'success');  

                        $('#table-sub_lesson_material').DataTable().ajax.reload();

                    },
                    error: function(response) {
                    
                        var errors = response.responseJSON.errors;

                        $('.invalid-feedback').hide();

                        $.each(errors, function(field, message) {
                            $('#error-' + field).text(message[0]).show();
                        });

                    }
                });
            });

            });

    </script>

@endpush