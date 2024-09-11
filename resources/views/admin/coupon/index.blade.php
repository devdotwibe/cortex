@extends('layouts.admin')
@section('title', 'Coupon')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Coupon</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2"> 
        <div class="coupon-wrap">
            <div class="row">                
                <x-ajax-table  :coloumns='[
                    ["th"=>"Date","name"=>"created_at","data"=>"date"],
                    ["th"=>"Offer Name","name"=>"name","data"=>"name"],
                    ["th"=>"Amount","name"=>"amount","data"=>"amount"], 
                    ["th"=>"Expire","name"=>"expire","data"=>"expire"],  
                ]' />
            </div>
        </div>
    </section>
@endsection