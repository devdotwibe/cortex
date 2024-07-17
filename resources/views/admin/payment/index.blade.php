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
                            <div class="amout-item">
                                <div class="amout-item-title">
                                    <span>Subscription Amount</span>
                                </div>
                                <div class="amout-item-content">
                                    <div class="form">
                                        <form action="{{route('admin.payment.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="name" value="stripe.subscription.payment.amount">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-data">
                                                            <div class="forms-inputs mb-4"> 
                                                                @if(!empty(old('subscription-payment-form-submit')))
                                                                    <input type="text" name="amount" placeholder="Subscription Amount"  class="form-control @error('amount') is-invalid @enderror"  value="{{old('amount',get_option('stripe.subscription.payment.amount-price',''))}}" >
                                                                    @error('amount')
                                                                    <div class="invalid-feedback"  >{{$message}}</div>                                                                    
                                                                    @enderror
                                                                @else
                                                                <input type="text" name="amount" placeholder="Subscription Amount" class="form-control"  value="{{get_option('stripe.subscription.payment.amount-price','')}}" >
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-dark" name="subscription-payment-form-submit" value="Save" id="subscription-payment-form-submit"> Save</button> 
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="amout-item">
                                <div class="amout-item-title">
                                    <span>Intensive Workshop Amount</span>
                                </div>
                                <div class="amout-item-content">
                                    <div class="form">
                                        <form action="{{route('admin.payment.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="name" value="stripe.workshop.payment.amount">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-data">
                                                            <div class="forms-inputs mb-4"> 
                                                                @if(!empty(old('workshop-payment-form-submit')))
                                                                    <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Workshop Amount" value="{{old('amount',get_option('stripe.workshop.payment.amount-price',''))}}">
                                                                    @error('amount')
                                                                    <div class="invalid-feedback"  >{{$message}}</div>                                                                    
                                                                    @enderror
                                                                @else
                                                                <input type="text" name="amount" class="form-control " placeholder="Workshop Amount" value="{{get_option('stripe.workshop.payment.amount-price','')}}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-dark" id="workshop-payment-form-submit" name="workshop-payment-form-submit" value="Save"> Save</button> 
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="amount-item">
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