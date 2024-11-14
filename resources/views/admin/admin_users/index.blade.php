@extends('layouts.admin')
@section('title', 'Category')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Admin User</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2 categoryclass">
        <div class="container">
            <div class="container-wrap">
                <div class="row">
                    <div class="card">
                        <div class="card-body"> 

                            <form class="form" method="post" action="{{ route('admin.admin_user.store') }}" id="admin_user_form" >
                                
                                @csrf
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="email">Email</label>
                                                    <input type="text" name="email"  id="email" class="form-control ">
                                                       
                                                    <div class="invalid-feedback"  id="email_error"></div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="password">Password</label>
                                                    <input type="text" name="password"  id="password" class="form-control ">
                                                       
                                                    <div class="invalid-feedback"  id="password_error"></div>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="conform_password">Conform Password</label>
                                                    <input type="text" name="conform_password"  id="conform_password" class="form-control ">
                                                       
                                                    <div class="invalid-feedback"  id="conform_password_error"></div>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4 pt-4">
                                        <button type="button" class="btn btn-dark" id="admin_user_btn" onclick="SubmitUser()"> Add +
                                        </button>
                                        <button type="button" class="btn btn-secondary" style="display: none"
                                            id="admin_btn">Cancel</button>
                                    </div>
                                </div>
                            </form>

                            <x-ajax-table title="Admin  Users" :coloumns="[
                                ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                                ['th' => 'Email', 'name' => 'email', 'data' => 'email'],
                            ]"     />

                         
                        </div>


                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>


@endsection

@push('modals')

    <div class="modal fade" id="admin_permission_modal" tabindex="-1" role="dialog" aria-labelledby="user-termLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="user-termLablel">Admin Permissions</h5>
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

                                        <tr>
                                            <td>Users</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="users" class="form-check-input" name="users" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Learn</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="learn" class="form-check-input" name="learn" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Options</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="options" class="form-check-input" name="options" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Question Bank</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="question_bank" class="form-check-input" name="question_bank" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Exam Simulator</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="exam_simulator" class="form-check-input" name="exam_simulator" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Live Teaching</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="live_teaching" class="form-check-input" name="live_teaching" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Community</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="community" class="form-check-input" name="community" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>pages</td>
                                            <td>
                                                <div class="form-check form-switch">

                                                    <input type="checkbox" onchange="AddPermission(this)" data-name="pages" class="form-check-input" name="pages" value="Y" role="switch" >
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                           </div>

                           <input type="hidden" id="admin_id" name="admin_id" >

                        </div> 
                    </form>

                  
                </div> 
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="edit_admin_user_modal" tabindex="-1" role="dialog"
        aria-labelledby="sub-category-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="sub-category-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sub-category-createLabel"><span id="sub-category-id"></span>Change Password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form  class="form" id="edit_admin_user_form" data-save="create" data-action="" data-createurl="" >
                        @csrf                
                        <div class="row"> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="name-table-subcategory-form-create">Email</label>
                                            <input type="text" readonly name="email" id="edit_email" class="form-control "  >
                                            <div class="invalid-feedback" id="edit_email_error"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="edit_password">Password</label>
                                            <input type="text" name="password" id="edit_password" class="form-control "  >
                                            <div class="invalid-feedback" id="name-error-table-subcategory-form-create"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="edit_password">Conform Password</label>
                                            <input type="text" name="conform_password" id="edit_conform_password" class="form-control "  >
                                            <div class="invalid-feedback" id="name-error-table-subcategory-form-create"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>

                            <input type="hidden" id="edit_admin_id" name="admin_id" >

                            <div class="col-md-4 pt-4">  
                                <button type="submit" class="btn btn-dark" id="table-subcategory-form-submit">Update</button>  
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
       
             function SubmitUser() 

             {
             
                $('.invalid-feedback').html('');

                $('.form-control').removeClass('is-invalid');

                var formElement = $('#admin_user_form')[0]; 

                var formData = new FormData(formElement);

                $.ajax({
                    url: $('#admin_user_form').attr('action'),  
                    type: 'POST', 
                    data: formData,  
                    processData: false, 
                    contentType: false, 
                    success: function(response) {
                        
                        if (response.status === 'success') {
                           
                            alert('User added successfully!');
                        
                            $('#admin_user_form')[0].reset();
                        } else {
                           
                            alert('Something went wrong, please try again.');
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

            function ShowAdmin(element) 
            {
                var id = $(element).data('id');

                $('#admin_id').val(id);

                $.ajax({
                    url: '{{route('admin.admin_user.get_permission')}}',  
                    method: 'get',
                    data: {
                        id: id,
                    }, 
                    success: function(response) {
                        
                        $.each($('[data-name]'), function(k, v) {
                    
                            $.each(response.data, function(field_name, value) {
                               
                                if ($(v).data('name') === field_name) {
                                  
                                    if (value === 'Y') {
                                        $(v).prop('checked', true);
                                    } else {
                                        $(v).prop('checked', false);
                                    }
                                }
                            });
                        });


                        $('#admin_permission_modal').modal('show');
                    },
                    error: function(xhr) {
                        
                        // var errors = xhr.responseJSON.errors;
                        // if (errors) {
                        
                        // }
                    }
                });

            }

            function AddPermission(element) 
            {
                var admin_id = $('#admin_id').val();

                var field_name = $(element).data('name');

                var value = $(element).val();

                value = $(element).is(':checked') ? value : '';

                console.log(admin_id,field_name,value);

                $.ajax({
                    url: '{{route('admin.admin_user.save_permission')}}',  
                    method: 'POST',
                    data: {
                        id: admin_id,
                        field_name: field_name,
                        value: value,
                    }, 
                    success: function(response) {
                    
                        console.log(response);
                    },
                    error: function(xhr) {
                        
                        // var errors = xhr.responseJSON.errors;
                        // if (errors) {
                        
                        // }
                    }
                });
            }

            function EditAdmin(element) 
            {
                var id = $(element).data('id');

                $.ajax({
                    url: '{{route('admin.admin_user.get_permission')}}',  
                    method: 'get',
                    data: {
                        id: id,
                    }, 
                    success: function(response) {
                        
                        $('#edit_email').val(response.data.email);

                        $('#edit_admin_id').val(response.data.id);

                        $('#edit_admin_user_modal').modal('show');
                    },

                    error: function(xhr) {
                        
                        // var errors = xhr.responseJSON.errors;
                        // if (errors) {
                        
                        // }
                    }
                });

            }


       

    </script>
@endpush
