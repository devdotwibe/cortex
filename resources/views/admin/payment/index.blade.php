@extends('layouts.admin')
@section('title', 'Payment')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Payment</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2"> 
        <div class="payment-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="card"> 
                        <div class="card-body">
                            <div class="payment-title">
                                <h3>Payment Amount</h3>
                            </div> 
                            <div class="amount-table">
                                <x-ajax-table :coloumns='[
                                    ["th"=>"User","name"=>"user_id","data"=>"username"],
                                    ["th"=>"Date","name"=>"created_at","data"=>"date"],
                                    ["th"=>"Type","name"=>"stype","data"=>"stype"],
                                    ["th" => "Amount", "name" => "amount", "data" => "amount"],
                                    ["th" => "Status", "name" => "status", "data" => "status"],
                                    ["th" => "Payment ID", "name" => "slug", "data" => "slug"],
                                ]' 
                                :action="false" />
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
@endsection