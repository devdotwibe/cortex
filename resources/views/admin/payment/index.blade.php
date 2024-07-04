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
                                    <span>Workshop Amount</span>
                                </div>
                                <div class="amout-item-content">
                                    <div class="form">
                                        <form action="{{route('admin.payment.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="name" value="stripe.workshop.payment.amount">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-data">
                                                            <div class="forms-inputs mb-4"> 
                                                                <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Workshop Amount" value="{{old('amount',get_option('stripe.workshop.payment.amount-price',''))}}">
                                                                @error('amount')
                                                                <div class="invalid-feedback"  >{{$message}}</div>                                                                    
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-dark" id="workshop-payment-form-submit"> Save</button> 
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
    </section>
@endsection