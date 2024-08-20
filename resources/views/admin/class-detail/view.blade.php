@extends('layouts.admin')
@section('title', 'Class Details -> '.$class_detail->term_name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">

            <h2> Class Details -> {{ $class_detail->term_name  }}</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a class="nav_link btn"  data-bs-toggle="modal" data-bs-target="#user-acces-modal" data-target="#user-acces-modal" >User Access</a></li>
                <li class="nav_item"><a onclick="CreateForm(event)" class="nav_link btn">New Form</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="container">
        <div class="row">
            <x-ajax-table tableid="sub_class_detail"   :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Meeting ID","name"=>"meeting_id","data"=>"meeting_id"], 
             
            ]' 
            />
        </div>
    </div>
</section> 
@endsection


@push('modals')

    <div class="modal fade" id="class-detail-modal" tabindex="-1" role="dialog"
        aria-labelledby="live-class-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    
                    <form action="{{route('admin.class-detail.store')}}"  id="class_detail_form" method="post">
                        @csrf

                        <input type="hidden" name="class_detail_id" value="{{$class_detail->id}}">
                         <div class="form-group">
                            <div class="form-data">
                                <div class="forms-inputs mb-4">
                                    <label for="meeting_id">Meeting ID</label>
                                    <input type="text" name="meeting_id" id="meeting_id" value="" class="form-control " placeholder="Meeting ID" aria-placeholder="Sub Title" >
                                    <div class="invalid-feedback" id="error-meeting_id">The field is required</div>
                                </div>

                                <div class="forms-inputs mb-4">
                                    <label for="passcode">Passcode</label>
                                    <input type="text" name="passcode" id="passcode" value="" class="form-control " placeholder="Passcode" aria-placeholder="Sub Title" >
                                    <div class="invalid-feedback" id="error-passcode">The field is required</div>
                                </div>

                                <div class="forms-inputs mb-4">
                                    <label for="zoom_link">Zoom Link</label>
                                    <input type="text" name="zoom_link" id="zoom_link" value="" class="form-control " placeholder="Zoom Link" aria-placeholder="Sub Title" >
                                    <div class="invalid-feedback" id="error-zoom_link">The field is required</div>
                                </div>

                                <div class="forms-inputs mb-4">
                                    <label for="timeslote">Time Slot</label> 
                                    <div class="check-group form-control @error('timeslote') is-invalid  @enderror">
                                        <div class="form-check">
                                            <input type="checkbox" name="timeslote[]" class="form-check-input timeslote"  id="check-group-timeslote-1" value="Saturday 9:30 - 11:30 a.m (Online)"  >
                                            <label for="check-group-timeslote-1">Saturday 9:30 - 11:30 a.m (Online)</label>
                                        </div> 
                                        <div class="form-check">
                                            <input type="checkbox" name="timeslote[]" class="form-check-input timeslote"  id="check-group-timeslote-1" value="Saturday 12 - 2 p.m"  >
                                            <label for="check-group-timeslote-1">Saturday 12 - 2 p.m</label>
                                        </div> 
                                        <div class="form-check">
                                            <input type="checkbox" name="timeslote[]" class="form-check-input timeslote"  id="check-group-timeslote-1" value="Sunday 9:30 - 11:30 a.m"  >
                                            <label for="check-group-timeslote-1">Sunday 9:30 - 11:30 a.m</label>
                                        </div> 
                                        <div class="form-check">
                                            <input type="checkbox" name="timeslote[]" class="form-check-input timeslote"  id="check-group-timeslote-1" value="Sunday 12 - 2 p.m"  >
                                            <label for="check-group-timeslote-1">Sunday 12 - 2 p.m</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback" id="error-timeslote">The field is required</div>
                                </div>
                            </div>
                         </div>
                        <button type="button" onclick="CancelFrom()" data-bs-dismiss="modal" class="btn btn-secondary mr-1">Cancel</button>
                        <button type="submit" id="sub_class_btn" class="btn btn-dark ml-1">Save</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="user-acces-modal" tabindex="-1" role="dialog"  aria-labelledby="live-class-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" >User Access</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <x-ajax-table :url="route('admin.user-access.index',['type'=>'class-detail','term'=>$class_detail->slug])"   :coloumns='[
                        ["th"=>"Name","name"=>"name","data"=>"name"],                      
                    ]' 
                    />
                </div>

            </div>
        </div>
    </div>
@endpush

@push('footer-script')
    <script>

        function update_sub_class(url) {

        $.get(url, function(res) {

            $('#meeting_id').val("");
            $('#passcode').val("");
            $('#zoom_link').val("");
            $('.timeslote').prop('checked',false)
            // $('#term_type_form').text("");

            $('#meeting_id').val(res.meeting_id);
            $('#passcode').val(res.passcode);
            $('#zoom_link').val(res.zoom_link);

            $('.timeslote').each(function(){
                if ((res.timeslot||[]).indexOf($(this).val()) !== -1) {
                    $(this).prop('checked',true)
                }
            })

            $('#error-meeting_id').text('').hide();
            $('#error-passcode').text('').hide();
            $('#error-zoom_link').text('').hide();


            $('#class_detail_form').attr('action',res.updateUrl);

            $('#sub_class_btn').text('Update');

            $('#class-detail-modal').modal('show');

        }, 'json')
        }

        function DeleteClose()
        {

            $('#table-sub_class_detail-delete').modal('hide');

        }

       function CreateForm(event)
       {
            event.preventDefault();
            event.stopPropagation();
            
            var url ="{{route('admin.class-detail.store')}}";

            $('#class_detail_form').attr('action',url);

            $('#class-detail-modal').modal('show');

            $('.invalid-feedback').hide();
            $('#sub_class_btn').text('Save');
            $('.timeslote').prop('checked',false)
       }

       function CancelFrom()
       {
            $('#class-detail-modal').modal('hide');
       }

       $(document).ready(function() {

            $('#class_detail_form').on('submit', function(event) {

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

                        $('#class-detail-modal').modal('hide');

                        showToast(response.success,'success');  

                        $('#table-sub_class_detail').DataTable().ajax.reload();

                    },
                    error: function(response) {
                    
                        var errors = response.responseJSON.errors;

                        $.each(errors, function(field, message) {
                            $('#error-' + field).text(message[0]).show();
                        });

                    }
                });
            });

            });

    </script>

@endpush