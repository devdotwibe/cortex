@extends('layouts.admin')
@section('title', 'Payment')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Price Change History</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2"> 
        <div class="payment-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-boy">
                            <x-ajax-table :coloumns='[ 
                                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                                ["th"=>"Type","name"=>"name","data"=>"name"],
                                ["th" => "Amount", "name" => "amount", "data" => "amount"], 
                                ["th" => "Stripe ID", "name" => "stripe_id", "data" => "stripe_id"],
                            ]' 
                            :action="false" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection