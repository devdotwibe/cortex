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
                    <li class="nav_item"><a  class="nav_link btn">+ Add New</a></li>
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