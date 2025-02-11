@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Users</h2>
        </div>

        <div class="header_content">
            <div class="form-group">
                <select id="user-filter" class="form-control">
                    <option value="">All users</option>
                    <option value="free-users">Free users</option>
                    <option value="paid-users">Paid users</option>
                    <option value="student-users">Student users</option>
                    <option value="non-student-users">None Student users</option>
                </select>
            </div>
        </div>

        <div class="header_content">
            <div class="form-group">
                @if($page_name!='Pending Users')
                <select id="term-list" class="select2 form-control" data-allow-clear="true" onchange="termchange()">
                    <option value="">Select Term</option> 
                    @foreach($terms  as $term)
                        <option value="{{ $term }}">{{ $term }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>

        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{ route('admin.subscriber.index') }}" class="nav_link btn">Subscriber</a></li>
                <button type="button" class="nav_link btn importbutton " data-bs-toggle="modal" data-bs-target="#import_user_modal">Import User</button>

            </ul>
        </div>


        
<div class="modal fade importadmin-user" id="import_user_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog import_user-class">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Import</h4>
             
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body importuser-class" style="max-height: 400px; overflow-y: auto;">


                       

                <form action="#" name="import_user" id="import_user" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group import-class">
                            <div class="form-data import-uclass">
                                <div class="forms-inputs mb-4 import-peoples">
                                    <label for="file_upload" class="file-upload" aria-label="Upload File">
                                        Upload File <br>
                                        <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                    </label>
                                    <input type="file" name="file_upload" id="file_upload" accept=".csv,.xlsx"
                                           class="form-control" style="display: none;"
                                           onchange="document.getElementById('file-name').textContent = this.files[0].name;">
                                    <small class="form-text text-muted">Supported File Types: .csv, .xlsx</small>
                                    <span id="file-name" class="form-text text-success"></span>
                                    @error('file_upload')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
{{--
                            
                      

                        {{-- <div class="text-fields">
                            <label>Name : </label>
                            <select class="form-control import-fields" name="name" id="name" data-value="name" >
                                <option value="">--Select--</option>
                            </select>
                         </div>     --}}

                   <div class="text-fields">
                   <label>First Name : </label>
                   <select class="form-control import-fields" name="first_name" id="first_name" data-value="first_name" >
                       <option value="">--Select--</option>
                   </select>
                </div>
                <div class="text-fields">
                    <label>Last Name : </label>
                    <select class="form-control import-fields" name="last_name" id="last_name" data-value="last_name" >
                        <option value="">--Select--</option>
                    </select>
                 </div>
                
                
                <div class="text-fields">
                   <label>Email Address :</label>
                   <select class="form-control import-fields" name="email" id="email" data-value="email">
                       <option value="">--Select--</option>
                   </select>
                </div>

                <div class="text-fields">
                    <label>Grade :</label>
                    <select class="form-control import-fields" name="grade" id="grade" data-value="grade">
                        <option value="">--Select--</option>
                    </select>
                 </div>
                
                <div class="text-fields">
                    <label>Expiry Date: </label>
                    <input type="text" class="form-control datepicker end-datepicker" name="expiry_date" id="expiry_date" readonly>
                </div>
                

                   <input type="hidden" name="file_path" id="file_path" value="">
                    <input type="hidden" name="id" id="import_user_id" value="">
                    <button class="btn btn-danger" type="submit"  aria-label="Confirm">Import
                        <div class="spinner-border spinner-border-sm text-primary import_load_service" id="import_load_service" role="status" style="display:none;">
                            <span class="sr-only"></span>
                        </div>
                    </button>
                    <button class="btn btn-warning" type="button" data-bs-dismiss="modal" aria-label="Cancel">Cancel</button>
                </form>

            </div>

        </div>
    </div>
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
                <h3>Mail Un-Verifyed  Users</h3> 
                <span class="badge text-success">{{$unverifyuser??0}}</span> 
            </div>
             
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Mail Verifyed  Users</h3> 
                <span class="badge text-success">{{$verifyuser??0}}</span> 
            </div>


            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Free Access  Users</h3> 
                <span class="badge text-success">{{$freeuser??0}}</span> 
            </div>
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Paid  Users</h3> 
                <span class="badge text-success">{{$paiduser??0}}</span> 
            </div>
        </div>
    </div>
</section> --}}
<section class="table-section admin_section">
    <div class="container">
        <div class="row">             
            <x-ajax-table :bulkaction="true" bulkactionlink="{{route('admin.user.bulkaction')}}" 
                :bulkotheraction='[
                    ["name"=>"Enable Free Access","value"=>"enable-free-access"],
                    ["name"=>"Disable Free Access","value"=>"disable-free-access"],
                    ["name"=>"Enable Community","value"=>"enable-community"],
                    ["name"=>"Disable Community","value"=>"disable-community"],
                ]' 
                :coloumns='[
                    ["th"=>"Date","name"=>"created_at","data"=>"date"],
                    ["th"=>"Name","name"=>"name","data"=>"name"],
                    ["th"=>"Email","name"=>"email","data"=>"email"],
                    ["th"=>"Free Access","name"=>"is_free_access","data"=>"is_free_access"],
                    ["th"=>"Email Verification","name"=>"is_user_verfied","data"=>"is_user_verfied"],
                    ["th"=>"Community","name"=>"post_status","data"=>"post_status"],
            ]' tableinit="usertableinit" beforeajax="usertablefilter" tableid="usertable" />
        </div>
    </div>
</section>
@endsection
@push('modals')
   


<div class="modal fade" id="free_access_modal" tabindex="-1" role="dialog" aria-labelledby="user-termLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-termLablel">User Free Access</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form  class="form" id="admin_permission_form" data-save="create" data-action="" data-createurl="" >
                    @csrf                
                    <div class="row"> 

                       <div class="col-md-12" >

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-table-body">

                                    {{-- <tr>
                                        <td>Learn 1 (Critical Reasoning,Logical Reasoning )</td>
                                        <td>
                                            <div class="form-check form-switch">

                                                <input type="checkbox" onchange="UpdateUserAccess(this)" data-name="users" class="form-check-input" name="learn_1" value="learn_1" id="learn_1" role="switch" >
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Learn 2 (Abstract Reasoning ,Numerical Reasoning modules )</td>
                                        <td>
                                            <div class="form-check form-switch">

                                                <input type="checkbox" onchange="UpdateUserAccess(this)" data-name="learn" class="form-check-input" name="learn_2" value="learn_2" id="learn_2" role="switch" >
                                            </div>
                                        </td>
                                    </tr> --}}


                                    @foreach($category as $item) 

                                        <tr>
                                            <td>Learn {{ $item->name }}</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="UpdateUserAccess(this)" data-name="learn" class="form-check-input user_accesss" name="learn_2" value="{{ $item->id }}" id="data_{{ $item->id }}" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach

                                    

                                    <tr>
                                        <td>Question bank</td>
                                        <td>
                                            <div class="form-check form-switch">

                                                <input type="checkbox" onchange="UpdateUserAccess(this)" data-name="options" class="form-check-input user_accesss" name="question_bank" id="data_question_bank" value="question_bank" role="switch" >
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Exam simulator</td>
                                        <td>
                                            <div class="form-check form-switch">

                                                <input type="checkbox" onchange="UpdateUserAccess(this)" data-name="question_bank" class="form-check-input user_accesss" name="exam" id="data_exam_simulator" value="exam_simulator" role="switch" >
                                            </div>
                                        </td>
                                    </tr>

                                   
                                </tbody>

                            </table>

                       </div>

                       <input type="hidden" id="user_access_id" name="user_access_id" >

                    </div> 
                </form>

              
            </div> 
        </div>
    </div>
</div>


<div class="modal fade" id="password-reset-modal" tabindex="-1" role="dialog" aria-labelledby="password-resetLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="password-resetLablel">User Password Update</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action=""  id="user-password-reset-form" method="post">
                    @csrf 
                    <div class="form-group">
                        <div class="form-data">
                            <div class="forms-inputs mb-4">
                                <label for="user-password">Password</label>
                                <input type="password" name="password" id="user-password" value="" class="form-control password-reset-field" placeholder="Password" aria-placeholder="Password" >        
                                <div class="invalid-feedback password-reset-error" id="error-password-field" >The field is required</div>
                            </div>
                            <div class="forms-inputs mb-4">
                                <label for="user-re_password">Confirm Password</label>
                                <input type="password" name="re_password" id="user-re_password" value="" class="form-control  password-reset-field" placeholder="Confirm Password" aria-placeholder="Confirm Password" >        
                                <div class="invalid-feedback password-reset-error" id="error-re_password-field" >The field is required</div>
                            </div>
                        </div>                        
                     </div>
                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-dark">Update Password</button>
                </form>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="user_access-usertableinit" tabindex="-1" role="dialog" aria-labelledby="user-termLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-termLablel">User Free Access</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form  class="form" id="bulk_user_permisson" data-save="create" data-action="" data-createurl="" >
                    @csrf                
                    <div class="row"> 

                       <div class="col-md-12" >

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-table-body">

                                    @foreach($category as $item) 

                                        <tr>
                                            <td>Learn {{ $item->name }}</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox"data-name="learn" class="form-check-input user_accesss" name="user_access[]" value="{{ $item->id }}" id="bulk_{{ $item->id }}" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach

                                    

                                    <tr>
                                        <td>Question bank</td>
                                        <td>
                                            <div class="form-check form-switch">

                                                <input type="checkbox" data-name="options" class="form-check-input user_accesss" name="user_access[]" id="bulk_question_bank" value="question_bank" role="switch" >
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Exam simulator</td>
                                        <td>
                                            <div class="form-check form-switch">

                                                <input type="checkbox"  data-name="question_bank" class="form-check-input user_accesss" name="user_access[]" id="bulk_exam_simulator" value="exam_simulator" role="switch" >
                                            </div>
                                        </td>
                                    </tr>

                                   
                                </tbody>

                            </table>

                       </div>

                    
                    </div> 


                    <button type="button"  data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                    <button type="button" id="submit_user_access_bulk" onclick="BulkUserAccess()" class="btn btn-dark">Submit</button>


                </form>

              
            </div> 
        </div>
    </div>
</div>



<div class="modal fade" id="user_time_slote-usertableinit" tabindex="-1" role="dialog" aria-labelledby="password-resetLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="password-resetLablel">Resgister User</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action=""  id="time_slote_form" method="post">
                    @csrf 
                  
                        <div class="form-group">
                            <div class="form-data">
                                <div class="forms-inputs mb-4"> 
                                    <label for="time_slot_action">Select your available timeslot (you can choose more than one) *</label>
                                    <div class="check-group form-control ">
                                                   
                                        <input type="hidden" name="time_slot_action" id="time_slot_action" value="">

                                        <input type="hidden" name="user_id_slug" id="user_id_slug" value="">

                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-0" value="Monday 6:30 p.m. (Online) - Year 6" >
                                                <label for="check-group-timeslot-0">Monday 6:30 p.m. (Online) - Year 6</label>
                                            </div>                                                            
                                            
                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-1" value="Wednesday 6:30 p.m. (Online) - Year 5" >
                                                <label for="check-group-timeslot-1">Wednesday 6:30 p.m. (Online) - Year 5</label>
                                            </div>                                                            
                                            
                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-2" value="Thursday 6:30 p.m. (Online) - Year 6" >
                                                <label for="check-group-timeslot-2">Thursday 6:30 p.m. (Online) - Year 6</label>
                                            </div>                                                            
                                            
                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-3" value="Saturday 9:30 a.m. (F2F) - Year 5" >
                                                <label for="check-group-timeslot-3">Saturday 9:30 a.m. (F2F) - Year 5</label>
                                            </div>  
                                            
                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-4" value="Saturday 12 p.m. (F2F) - Year 5" >
                                                <label for="check-group-timeslot-4">Saturday 12 p.m. (F2F) - Year 5</label>
                                            </div> 
                                            
                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-5" value="Saturday 2:30 p.m. (F2F) - Year 6" >
                                                <label for="check-group-timeslot-4">Saturday 2:30 p.m. (F2F) - Year 6</label>
                                            </div>  

                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-6" value="Sunday 9:30 a.m. (F2F) - Year 5" >
                                                <label for="check-group-timeslot-4">Sunday 9:30 a.m. (F2F) - Year 5</label>
                                            </div>

                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-6" value="Sunday 12 p.m. (F2F) - Year 5" >
                                                <label for="check-group-timeslot-4">Sunday 12 p.m. (F2F) - Year 5</label>
                                            </div>

                                            <div class="form-check">
                                                <input type="checkbox" name="user_time_slot[]" class="form-check-input"  id="check-group-timeslot-6" value="Sunday 2:30 p.m. (F2F) - Year 6" >
                                                <label for="check-group-timeslot-4">Sunday 2:30 p.m. (F2F) - Year 6</label>
                                            </div>

                                            <div class="invalid-feedback password-reset-error" id="error-user_time_slot-field" >Atleast one is field is required</div>

                                            <div class="note-text alert alert-warning" id="note_text" style="display:none;">Some users are already registered.</div>
                                    </div>                                                      
                                </div>
                            </div>
                        </div>    
                    

                    <button type="button"  data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                    <button type="button" id="submit_user_slot" onclick="SubmitTimeSolt()" class="btn btn-dark">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endpush
@push('footer-script')


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>

        var usertable = null;
        function usertableinit(table) {
            usertable = table
        }
        function termchange()
    {
        if (usertable != null) {
            
            usertable.ajax.reload()
        }
    }

    function UserAccess(slug,element)
    {
        $('#user_access_id').val(slug);

        $('#free_access_modal').modal('show');

        var access = $(element).data('access');

        if (access) {
          
            var accessArray = access.split(',');

            $.each(accessArray, function(index, value) {
                $('#data_' + value).prop('checked', true);
            });
        }

        console.log(access);

    }

    function UpdateUserAccess(element)
    {
        // var user_access = [];

        // var accessTypes = [
        //     { id: 'learn_1', name: 'learn1' },
        //     { id: 'learn_2', name: 'learn2' },
        //     { id: 'question_bank', name: 'question_bank' },
        //     { id: 'exam_simulator', name: 'exam_simulator' }
        // ];

        var user_access = [];

        $.each($('.user_accesss'), function(i, v) {
          
            if ($(this).prop("checked")) {
                user_access.push({
                    value: $(this).val()
                });
            }
        });

        // accessTypes.forEach(function(access) {
        //     var isChecked = $('#' + access.id).prop("checked");
        //     user_access.push({
        //         name: access.name,
        //         value: isChecked ? $('#' + access.id).val() : null
        //     });
        // });

        let data = {
            user_access: user_access,
            user_slug: $('#user_access_id').val()
        };

        let url = "{{ route('admin.user.freeaccess') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: function(response) {
                console.log("Success:", response);
                if (usertable !== null) {
                    usertable.ajax.reload();
                }
            },
        });

    }


        function usertablefilter(d){
            d = d || {}; 
            d.usertype=$('#user-filter').val();
            d.termname=$('#term-list').val();
            
            return d;
        }
        function changeactivestatus(url){
            $.get(url,function(res){
                if (usertable != null) {
                    usertable.ajax.reload()
                }
            })
        }
        $('#user-filter').change(function(){
            if (usertable != null) {
                usertable.ajax.reload()
            }
        })
        function resetpassword(url){
            $('#user-password-reset-form').attr('action',url)
            $('.password-reset-field').val('').removeClass('is-invalid')
            $('.password-reset-error').text("")
            $('#password-reset-modal').modal('show')
        } 
        function SubmitTimeSolt()
        {
            var userTimeSlots = [];

            $('input[name="user_time_slot[]"]:checked').each(function() {
                userTimeSlots.push($(this).val());
            });

            $('#error-user_time_slot-field').hide();

            if(userTimeSlots.length ===0 )
            {
                $('#error-user_time_slot-field').show();
                return false;
            }

            var element = $('#table-usertable-bulk-action-form');

            if ($(element).length === 0) {
                showToast('Form not found!', 'danger');
                return;
            }
            $('#time_slot_action').val('user_register');

            var formData = $(element).serializeArray();
    
            formData.push({ name: 'time_slot_action', value: $('#time_slot_action').val() });

            formData.push({ name: 'user_time_slot', value: userTimeSlots });

            $.post($(element).attr('action'), formData, function(res) {

                    showToast(res.success ?? 'User Registered Successfully', 'success');

                    $('#user_time_slote-usertableinit').modal('hide');

                    $('#table-usertable').DataTable().ajax.reload();
                    $('.other-actions').hide();
                    location.reload();
                   
            }, 'json').fail(function() {
                showToast('User Not Registered', 'danger');
            })

        }

        function BulkUserAccess()
        {
            var user_access = [];

            $('input[name="user_access[]"]:checked').each(function() {
                user_access.push($(this).val());
            })
    
            var element = $('#table-usertable-bulk-action-form');

            if ($(element).length === 0) {
                showToast('Form not found!', 'danger');
                return;
            }
    

            var formData = $(element).serializeArray();
    
            formData.push({ name: 'user_access', value:user_access });

            $.post($(element).attr('action'), formData, function(res) {

                    showToast(res.success ?? 'User Access Successfully', 'success');

                    $('#user_access-usertableinit').modal('hide');

                    $('#table-usertable').DataTable().ajax.reload();
                    $('.other-actions').hide();
                    location.reload();
                   
            }, 'json').fail(function() {
                showToast('User Access Not Updated', 'danger');
            })

        }

        function UpgradeUser(slug)
        {
            console.log(slug);

            $('#user_id_slug').val(slug);

            $('#submit_user_slot').attr('onclick','UpgradeUserSubmit()');

            $('#user_time_slote-usertableinit').modal('show');
        }

        function UpgradeUserSubmit() {

            var userTimeSlots = [];

            var slug =  $('#user_id_slug').val();

            $('input[name="user_time_slot[]"]:checked').each(function() {
                userTimeSlots.push($(this).val());
            });

            $('#error-user_time_slot-field').hide();

            if (userTimeSlots.length === 0) {
                $('#error-user_time_slot-field').show();
                return false;
            }

            $.post("{{ route('admin.user.upgrade_user') }}", { user_time_slot: userTimeSlots,slug:slug }, function(res) {
     
                showToast(res.success ?? 'User Registered Successfully', 'success');

                $('#user_time_slote-usertableinit').modal('hide');

                $('#table-usertable').DataTable().ajax.reload();
                $('.other-actions').hide();
                location.reload();

            }, 'json').fail(function() {
                showToast('User Not Registered', 'danger');
            });
        }


       

        $(function(){
            $('#user-password-reset-form').submit(function(e){
                e.preventDefault();
                var form=this;
                $('.password-reset-field').removeClass('is-invalid')
                $.post($(form).attr('action'),$(form).serialize(),function(res){
                    form.reset() 
                    $('#password-reset-modal').modal('hide')
                    showToast(res.success||'Password has been successfully updated', 'success');
                },'json').fail(function(xhr, status, error){ 
                    try {
                        var res = JSON.parse(xhr.responseText);
                        $.each(res.errors,function(k,v){
                            $(`#error-${k}-field`).text(v[0])
                            $(`#user-`+k).addClass('is-invalid')
                        })
                    } catch (error) {
                        showToast("Error: " + error, 'danger'); 
                    }
                    $('#question-bank-category-title').addClass('is-invalid')
                }).always(function(){

                })
            })
        })
    </script>




<script>


jQuery(document).on("change", "#file_upload", function() {
    console.log("on change");

    var fileInput = $('#file_upload')[0];

    if (fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = new Uint8Array(e.target.result); 
            var workbook = XLSX.read(data, { type: 'array' }); 
            var firstSheet = workbook.Sheets[workbook.SheetNames[0]]; 
            var parsedData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 }); 
            parsedData = parsedData.filter(function(v,k){
                const uniqueArray = [...new Set(v)];
                return uniqueArray.length > 1;
            }); 
            var upfile=new Blob([JSON.stringify(parsedData)], { type: 'application/json' })
            const newfile = new File([upfile], 'ib-import.json', { type:'application/json' });

           
        var formData = new FormData();
      
            formData.append('file_upload', newfile);

            $.ajax({
                url: '{{ route('admin.import_users_from_csv')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,

                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $("#file_path").val(response["filepath"]);
                  
                    $("select.import-fields").empty();
                    $("select.import-fields").append("<option value=''>--Select--</option>");
                  
                    response["data"].forEach(function(data) {

                        $("select.import-fields").append("<option value='"+data+"'>" + data + "</option>");
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            }); 
        };

        // Read the file as binary
        reader.readAsArrayBuffer(file);
    } else {
        console.log('No file selected.');
    }
  })


        jQuery(document).on("submit", "#import_user", function(e) {

                e.preventDefault();

                var formData = new FormData(this);
                var datas = {};

                 var endplan =  $("#expiry_date").val();

                $('select').each(function() {
                    var fieldName = $(this).attr('name');
                    console.log(fieldName);
                    var selectedValue = $(this).val();
                    console.log(selectedValue);

                    if (fieldName && selectedValue) {
                        datas[fieldName] = selectedValue;
                    }
                });
              
                var path = $("#file_path").val();

                console.log(path);
            
            var requestData = new FormData();

            requestData.append('endplan', endplan);

            requestData.append('path', path);

            requestData.append('datas', JSON.stringify(datas));


            for (var pair of formData.entries()) {
                requestData.append(pair[0], pair[1]);

            }
           

                $.ajax({
                    url: '{{ route('admin.import_users_from_csv_submit')}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:requestData,

                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // console.log(response);
                        $(".import-fields").val('');
                        $("#import_user_modal").modal("hide");
                        $("#load_service").css("display","none");
                        $("#import_load_service").css("display","none");

                        showToast('Successfully imported', 'success');
                         usertableinit(); 

                         setTimeout(function() {
                            location.reload();
                         }, 350); 
        
       
                        usertablefilter();

                    },

                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
             
                $(".error-message").remove();
                
             
                $.each(xhr.responseJSON.errors, function(key, messages) {
                    
                    var field = $('[name="' + key + '"]');

                   
                    field.after('<div class="error-message" style="color: red;">' + messages.join(', ') + '</div>');
                });
            }
                    }



                });
            });

            $(document).ready(function() {
    $('.end-datepicker').datepicker({
        dateFormat: 'yy-mm-dd', 
      
        minDate: 0, 
        maxDate: null, 
        changeMonth: true, 
        changeYear: true,
        showButtonPanel: true, 
    });
});


        </script>

<script>
    // Optional: Additional JavaScript to improve UX
    document.getElementById('file_upload').addEventListener('change', function() {
        let fileName = this.files.length ? this.files[0].name : '';
        document.getElementById('file-name').textContent = fileName;
    });
</script>
@endpush