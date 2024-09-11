@extends('layouts.admin')
@section('title', 'Coupon')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Coupon</h2>
            </div>
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a data-bs-toggle="modal" data-bs-target="#coupen-modal" class="nav_link btn">+ Add New</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2"> 
        <div class="coupon-wrap">
            <div class="row">                
                <div class="col-md-12">
                    <x-ajax-table  :coloumns='[
                        ["th"=>"Date","name"=>"created_at","data"=>"date"],
                        ["th"=>"Offer Name","name"=>"name","data"=>"name"],
                        ["th"=>"Amount","name"=>"amount","data"=>"amount"], 
                        ["th"=>"Expire","name"=>"expire","data"=>"expire"],  
                    ]' />
                </div>
            </div>
        </div>
    </section>
@endsection
@push('modals')
<div class="modal fade" id="coupen-modal" tabindex="-1" role="dialog" aria-labelledby="coupenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coupenLablel">Add Coupon</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form action="" method="post" id="coupen-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label for=""></label>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Close</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Save</button> 
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
@endpush