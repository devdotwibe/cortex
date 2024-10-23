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
                </select>
            </div>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{ route('admin.subscriber.index') }}" class="nav_link btn">Subscriber</a></li>
                <button type="button" class="close" data-bs-toggle="modal" data-bs-target="#import_user_modal">Import User</button>

            </ul>
        </div>


        
<div class="modal fade" id="import_user_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Import</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{asset('assets/images/x-circle.svg')}}" alt="">
                </button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">


                        <div class="col-md-12 d-flex justify-content-end">
                            {{-- <form id="import_users" name="import_users" method="POST"  enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf --}}

                <form action="#" name="import_user" id="import_user" method="post"  enctype="multipart/form-data">
                    @csrf
                                <div class="col-md-8">
                                    <input type="file" accept=".csv,.xlsx" name="file_upload" id="file_upload" class="form-control">
                                </div>
{{--
                            </form> --}}
                        </div>

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
                    ["th"=>"Community","name"=>"post_status","data"=>"post_status"],
            ]' tableinit="usertableinit" beforeajax="usertablefilter" />
        </div>
    </div>
</section>
@endsection
@push('modals')
    
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
@endpush
@push('footer-script')


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>

        var usertable = null;
        function usertableinit(table) {
            usertable = table
        }
        function usertablefilter(d){
            d.usertype=$('#user-filter').val()
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




{{-- 
<script>
    $(document).on("change", "#file_upload", function() {
        console.log("on cjhash");
        var formData = new FormData();
        var fileInput = $('#file_upload')[0];
    
        if (fileInput.files.length > 0) {
            formData.append('file_upload', fileInput.files[0]);
    
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
                    // Assuming response is an array of strings
                    $(".import-fields").empty();
                    $(".import-fields").append("<option value=''>--Select--</option>");
                    //$("select").append("<option value=''>__empty__</option>");
    
    
                   // $("#file_upload").val('');
                    response["data"][0].forEach(function(data) {
    
                        $(".import-fields").append("<option value='"+data+"'>" + data + "</option>");
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            console.log('No file selected.');
        }
    });
    
    
        $(document).on("click",".option-btn", function() { 
     
            $(this).hide(); 
            $(this).siblings('.btn-inner').show();
        });
       
        $(document).on("click", function(event) {
            if (!$(event.target).closest(".btn-inner, .option-btn").length) {
                $(".btn-inner").hide();
                $(".option-btn").show(); 
            }
        });
    
        // $(document).ready(function() {
        // $(".option-btn").hover(
        //     function() {
        //         console.log("Button hovered");
        //         console.log("Siblings:", $(this).siblings());
        //         $(this).hide();
        //         $(this).siblings('.btn-inner').show();
        //     },
        //         function() {
        //             $(this).show();
        //             $(this).siblings('.btn-inner').hide();
        //         }
        //     );
        // });
    
    
    
    
    
    </script>
{{--     
    <script>
    $(document).on("submit", "#import_user", function(e) {
        e.preventDefault();
        $("#import_load_servimport-fieldsice").css("display","block");
    
        var formData = new FormData(this);
        var datas = {};
    
        $('.import-fields').each(function() {
            var fieldName = $(this).attr('name');
            console.log(fieldName);
            var selectedValue = $(this).val();
            console.log(selectedValue);
    
            if (fieldName && selectedValue) {
                datas[fieldName] = selectedValue;
            }
        });
        var endplan =  $("#expiry_date").val();

        var path = $("#file_path").val();
        console.log(path);
        var path = $("#file_path").val();
    var requestData = new FormData();
    
    requestData.append('path', path);

    requestData.append('endplan', endplan);
    
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
    
                $('#user-table').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    

    $('.end-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });
    </script> --}}















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

                         usertableinit(); 
       
                        usertablefilter();
         


                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('.end-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });

        </script>
@endpush