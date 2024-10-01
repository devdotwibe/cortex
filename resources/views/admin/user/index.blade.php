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
                <li class="nav_item import-upload-btn" @if(get_option('user-import', '') == "started") style="display: none" @endif>
                    <x-ajax-import 
                        :url="route('admin.import')" 
                        :fields='[
                            ["name"=>"first_name","label"=>"First Name"], 
                            ["name"=>"last_name","label"=>"Last Name"], 
                            ["name"=>"email_address","label"=>"Email Address"], 
                            {{-- ["name"=>"expiry_date","label"=>"Expiry Date in Calendar"], --}}
                        ]' onupdate="importupdate"></x-ajax-import>
                </li> 
                <li class="nav_item import-cancel-btn" @if(get_option('user-import', '') !== "started") style="display: none" @endif>
                    <a href="{{ route('admin.uploadcancel', 'user-import') }}">
                        <p id="import-cancel-btn-text">0 % Complete</p>
                        <span class="btn btn-danger">Cancel</span>
                    </a>
                </li>
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
@endpush