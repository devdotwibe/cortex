@extends('layouts.admin')
@section('title', 'Coupon'.'Settings')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Settings</h2>
            </div>
            <div class="header_right">
              
            </div>
        </div>
    </section>



       <!-- Settings Section -->
       <section class="settings-wrap mt-4">
        <div class="header_wrapp">
            {{-- <div class="header_title">
                <h2>Settings</h2>
            </div>
             --}}
        </div>
        <div class="settings-content">
            <form action="{{ route('admin.coupon.setting') }}" method="post" id="settings-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="emailaddress">Email Address</label>
                            <input type="email" name="emailaddress" value="{{ old('emailaddress', optional($setting)->emailaddress) }}" class="form-control" id="emailaddress">
                            @error('emailaddress')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                            <div id="email_address-error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-dark m-1">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Coupon</h2>
                <li class="nav_item"><a data-bs-toggle="modal" data-bs-target="#coupen-modal" class="nav_link btn">+ Add
                    New</a></li>
            </div>
            
        </div>
    </section>
    
    <section class="invite-wrap mt-2">
        <div class="coupon-wrap">
            <div class="row">
                <div class="col-md-12">
                    <x-ajax-table :coloumns="[
                        ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                        ['th' => 'Offer Name', 'name' => 'name', 'data' => 'name'],
                        ['th' => 'Amount', 'name' => 'amount', 'data' => 'amount'],
                        ['th' => 'Expire', 'name' => 'expire', 'data' => 'expire'],
                    ]" tableinit="coupentableinit" />
                </div>
            </div>
        </div>
    </section>

    
    
@endsection
@push('modals')
    <div class="modal fade" id="coupen-modal" tabindex="-1" role="dialog" aria-labelledby="coupenLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coupenLablel">Add Coupon</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="coupen-add-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Offer Name</label>
                                    <input type="text" name="name" value="" class="form-control"
                                        id="coupen-add-form-name">
                                    <div id="coupen-add-form-name-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" value="" class="form-control"
                                        id="coupen-add-form-amount">
                                    <div id="coupen-add-form-amount-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="expire">Expire</label>
                                    <input type="text" name="expire" value="" class="form-control datepicker"
                                        id="coupen-add-form-expire" readonly>
                                    <div id="coupen-add-form-expire-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-dark m-1" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-dark m-1"> + Add </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="coupen-edit-modal" tabindex="-1" role="dialog" aria-labelledby="coupen-editLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coupen-editLablel">Update Coupon</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="coupen-edit-form">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Offer Name</label>
                                    <input type="text" name="name" value="" class="form-control"
                                        id="coupen-edit-form-name">
                                    <div id="coupen-edit-form-name-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" value="" class="form-control"
                                        id="coupen-edit-form-amount">
                                    <div id="coupen-edit-form-amount-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="expire">Expire</label>
                                    <input type="text" name="expire" value="" class="form-control datepicker"
                                        id="coupen-edit-form-expire" readonly>
                                    <div id="coupen-edit-form-expire-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-dark m-1" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-dark m-1"> Update </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    


  



    
@endpush

    

@push('footer-script')

<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js" integrity="sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=" crossorigin="anonymous"></script>
    <script>
        let coupentable = null;
        function coupentableinit(table){
            coupentable = table
        }
        function editcoupon(url){
            $.get(url,function(res){
                $('#coupen-edit-form-name').val(res.name);
                $('#coupen-edit-form-amount').val(res.amount);
                $('#coupen-edit-form-expire').val(res.expire);
                $('#coupen-edit-form').attr('action',res.updateUrl);
                $('#coupen-edit-modal').modal('show');
            },'json')
        }
        $(function(){
            $('.datepicker').datepicker({
                dateFormat:'yy-mm-dd',
                minDate:0
            });
            $('#coupen-modal').on('hidden.bs.modal', function(){
                $('#coupen-add-form').get(0).reset()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
            });
            $('#coupen-edit-modal').on('hidden.bs.modal', function(){
                $('#coupen-edit-form').get(0).reset()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
            });
            $('#coupen-add-form').submit(function(e){
                e.preventDefault()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
                $.post("{{ route('admin.coupon.store') }}", $(this).serialize(), function(res){
                    coupentable.ajax.reload()
                    $('#coupen-modal').modal('hide')
                    showToast(res.success || 'Coupon has been successfully added', 'success');
                }, 'json').fail(function(xhr) {
                    try {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(k, v) {
                            $(`#coupen-add-form-${k}-error`).text(v[0])
                            $(`#coupen-add-form-${k}`).addClass('is-invalid')
                        })
                    } catch (error) {

                    }
                });
                return false;
            })
            $('#coupen-edit-form').submit(function(e){
                e.preventDefault()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    coupentable.ajax.reload()
                    $('#coupen-edit-modal').modal('hide')
                    showToast(res.success || 'Coupon has been successfully updated', 'success');
                }, 'json').fail(function(xhr) {
                    try {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(k, v) {
                            $(`#coupen-edit-form-${k}-error`).text(v[0])
                            $(`#coupen-edit-form-${k}`).addClass('is-invalid')
                        })
                    } catch (error) {

                    }
                });
                return false;
            })
        });
    </script>
@endpush
