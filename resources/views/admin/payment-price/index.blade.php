@extends('layouts.admin')
@section('title', 'Payment')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Payment Price</h2>
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
                                <h3>Subscription Base Plan</h3>
                            </div>
                            <div class="amount-form">
                                <div class="amout-item">
                                    <div class="amout-item-content">
                                        <div class="form">
                                            <form action="{{route('admin.payment-price.store')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="name" value="stripe.subscription.payment.amount">
                                                <div class="row">
                                                    <div class="col-md-8">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card"> 
                        <div class="card-body">
                            <div class="payment-title">
                                <h3>Subscription Combo Plan</h3>
                            </div>
                            <div class="amount-form"> 
                                <div class="amout-item">
                                    <div class="amout-item-content">
                                        <div class="form">
                                            <form action="{{route('admin.payment-price.store')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="name" value="stripe.subscription.payment.combo-amount">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 
                                                                    @if(!empty(old('combo-subscription-payment-form-submit')))
                                                                        <input type="text" name="amount" placeholder="Subscription Amount"  class="form-control @error('amount') is-invalid @enderror"  value="{{old('amount',get_option('stripe.subscription.payment.combo-amount-price',''))}}" >
                                                                        @error('amount')
                                                                        <div class="invalid-feedback"  >{{$message}}</div>                                                                    
                                                                        @enderror
                                                                    @else
                                                                    <input type="text" name="amount" placeholder="Subscription Amount" class="form-control"  value="{{get_option('stripe.subscription.payment.combo-amount-price','')}}" >
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-dark" name="combo-subscription-payment-form-submit" value="Save" id="subscription-payment-form-submit"> Save</button> 
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection