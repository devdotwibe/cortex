@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Users</h2>
        </div>
        {{-- <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.user.create')}}" class="nav_link btn">Invite</a></li>
            </ul>
        </div> --}}
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>New  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
             
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Verifyed  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>


            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Trial  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Paid  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
        </div>
    </div>
</section>
<section class="table-section">
    <div class="container">
        <div class="row">
            <x-ajax-table :bulkaction="true" bulkactionlink="{{route('admin.user.bulkaction')}}" :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Name","name"=>"name","data"=>"name"],
                ["th"=>"Email","name"=>"email","data"=>"email"],
                ["th"=>"Community","name"=>"post_status","data"=>"post_status"],
            ]' />
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