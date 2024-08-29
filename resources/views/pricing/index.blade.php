@extends('layouts.app')

@section('content') 

<section class="subsciption-wrapp">
    <div class="container">
        <div class="subsciption-title"><h1>Affordable Pricing</h1></div>
        @if(session('subscribe'))
            <div class="alert alert-danger" role="alert">
                <span>{{ session('subscribe') }}</span>
            </div>
        @endif
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
                            @auth('web')
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cortext-subscription-payment-modal">Pay</button>
                            @else
                            <a href="{{route('login')}}" class="btn btn-danger">Pay</a>
                            @endauth
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
                            <p>Price ${{get_option('stripe.subscription.payment.combo-amount-price','0')}}</p>
                            <p>two user</p>
                        </div>
                        <div class="card-footer"> 
                            @auth('web')
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cortext-combo-subscription-payment-modal">Pay</button>
                            @else
                            <a href="{{route('login')}}" class="btn btn-danger">Pay</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@auth('web')
    

<div class="modal fade" id="cortext-subscription-payment-modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"  aria-labelledby="cortext-subscription-paymentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cortext-subscription-paymentLablel">Subscription</h5> 
            </div>
            <div class="modal-body">
                <form action="{{route('pricing.index')}}"  id="cortext-subscription-payment-form" method="POST" >
                    @csrf

                    <input type="hidden" name="plan" value="single">
                    <div class="form-group">
                        <label for="year-1"> Year </label>
                        @if(date('m')>5)  
                            <input type="text" id="year-1" class="form-control" value="June {{date('Y')+0}} - May {{date('Y')+1}}" readonly>
                            <input type="hidden" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                        @else
                            <select name="year" class="form-control" id="year-1"> 
                                <option value="{{date('Y')+0}}-{{date('Y')+1}}" >June {{date('Y')+0}} - May {{date('Y')+1}}</option>
                                <option value="{{date('Y')-1}}-{{date('Y')+2}}" >June {{date('Y')+1}} - May {{date('Y')+0}}</option>
                            </select>
                        @endif
                    </div> 

                    <div class="form-group mt-2">
                        <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                        <button type="button" class="btn btn-dark" id="cortext-subscription-payment-form-buttom">Pay Now ${{ get_option('stripe.subscription.payment.amount-price','0') }} </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="cortext-combo-subscription-payment-modal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"  aria-labelledby="cortext-subscription-paymentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cortext-combo-subscription-paymentLablel">Subscription</h5> 
            </div>
            <div class="modal-body">
                <form action="{{route('pricing.index')}}"  id="cortext-combo-subscription-payment-form"  method="POST">
                    @csrf        
                    
                    <input type="hidden" name="plan" value="combo">
                    <div class="form-group">
                        <label for="year-2"> Year</label>                            
                            @if(date('m')>5)  
                                <input type="text" id="year-2" class="form-control" value="June {{date('Y')+0}} - May {{date('Y')+1}}" readonly>
                                <input type="hidden" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                            @else
                                <select name="year" class="form-control" id="year-2"> 
                                    <option value="{{date('Y')+0}}-{{date('Y')+1}}" >June {{date('Y')+0}} - May {{date('Y')+1}}</option>
                                    <option value="{{date('Y')-1}}-{{date('Y')+2}}" >June {{date('Y')+1}} - May {{date('Y')+0}}</option>
                                </select>
                            @endif
                    </div>  
                    <div class="form-group">
                        <label for="email-2">Invite User</label>
                        <input type="email" name="email" id="email-2" class="form-control" />
                    </div>
                    <div class="form-group mt-2">
                        <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                        <button type="button" class="btn btn-dark" id="cortext-combo-subscription-payment-form-buttom">Pay Now ${{ get_option('stripe.subscription.payment.combo-amount-price','0') }} </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    
</script>


@endauth


@endsection