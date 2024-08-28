@extends('layouts.app')

@section('content') 

<section class="subsciption-wrapp">
    <div class="container">
        <div class="subsciption-title"><h1>Affordable Pricing</h1></div>
        <div class="subsciption-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-title">
                            <h3>Subscription 1</h3>
                        </div>
                        <div class="card-body">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <p>Price ${{ get_option('stripe.subscription.payment.amount-price','0') }}</p>
                            <p>One user</p>
                        </div>
                        <div class="card-footer"> 
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cortext-subscription-payment-modal">Pay</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-title">
                            <h3>Subscription 2</h3>
                        </div>
                        <div class="card-body">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <p>Price ${{get_option('stripe.subscription.payment.compo-amount-price','0')}}</p>
                            <p>two user</p>
                        </div>
                        <div class="card-footer"> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="modal fade" id="cortext-subscription-payment-modal" tabindex="-1" role="dialog"  aria-labelledby="cortext-subscription-paymentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cortext-subscription-paymentLablel">Subscription</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('payment.subscription')}}"  id="cortext-subscription-payment-form" >
                    <p>The {{config('app.name')}} Subscription Peyment required </p>
                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-dark">Pay Now ${{ get_option('stripe.subscription.payment.amount-price','0') }} </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection