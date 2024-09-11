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
                            {{-- <p>Price ${{ get_option('stripe.subscription.payment.amount-price','0') }}</p>
                            <p>One user</p> --}}
                        </div>
                        <div class="card-footer @if(date('m')>5) disabled-action @endif"> 
                            @auth('web')   
                            <button class="btn btn-danger" @if(date('m')>5) disabled @else data-bs-toggle="modal" data-bs-target="#cortext-subscription-payment-modal"  @endif >Pay</button>
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
                            {{-- <p>Price ${{get_option('stripe.subscription.payment.combo-amount-price','0')}}</p>
                            <p>two user</p> --}}
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


@endsection

@push('modals')
    
    @auth('web')
        @if(date('m')<=5)

        <div class="modal fade" id="cortext-subscription-payment-modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"  aria-labelledby="cortext-subscription-paymentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cortext-subscription-paymentLablel">Subscription</h5> 
                    </div>
                    <div class="modal-body">
                        <div class="btn-group" role="group"> 
                            <input type="radio" class="btn-check" name="tabs1" id="tabs1a" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="tabs1a">Group 1</label>
                    
                            <input type="radio" class="btn-check" name="tabs1" id="tabs1b" autocomplete="off">
                            <label class="btn btn-outline-primary" for="tabs1b">Induvidual</label> 
                        </div>
                        <form action="{{route('pricing.index')}}"  id="cortext-subscription-payment-form" method="POST" >
                            @csrf
                            <input type="hidden" name="year" value="{{date('Y')-1}}-{{date('Y')+0}}" >

                            <input type="hidden" name="plan" value="single"> 
                            <div class="form-group">
                                <label for="coupon">Coupon Code</label>
                                <div class="input-group ">  
                                    <input type="text" name="coupon" id="coupon" placeholder="Enter Coupon Code" class="form-control" />
                                    <button class="btn btn-outline-secondary" type="button" id="coupon-verify-button">Apply</button>
                                    <div class="invalid-feedback" id="error-coupon-message"></div>
                                </div>
                            </div> 

                            <div class="form-group" id="message-area">
                            </div>
                            <div class="form-group mt-2">
                                <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                <button type="button" class="btn btn-dark price-norm" id="cortext-subscription-payment-form-buttom">Pay Now $<span class="amount" id="cortext-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.amount-price','0') }}">{{ get_option('stripe.subscription.payment.amount-price','0') }}</span> </button> 
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @endif

        <div class="modal fade" id="cortext-combo-subscription-payment-modal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"  aria-labelledby="cortext-subscription-paymentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cortext-combo-subscription-paymentLablel">Subscription</h5> 
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> 
                            <div class="form-check">
                                <input type="radio" class="form-check-input" onchange="changetab('#tabs2-tabs2a','.tabs2')"  name="tabs2" id="tabs2a" autocomplete="off" >
                                <label  for="tabs2a" class="form-check-label">Group 1</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" onchange="changetab('#tabs2-tabs2b','.tabs2')"  name="tabs2" id="tabs2b" autocomplete="off" checked>
                                <label  for="tabs2b" class="form-check-label">Induvidual</label> 
                            </div>
                        </div>
                        <div class="tabs2" id="tabs2-tabs2a" style="display: none" >
                            <form action="{{route('pricing.index')}}"  id="cortext-combo-subscription-payment-form"  method="POST">
                                @csrf        
                                <input type="hidden" name="plan" value="combo">
                                <div class="form-group">
                                    <label for="combo-year"> Year</label>                            
                                        @if(date('m')>5)  
                                            <input type="hidden"  id="combo-year" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                                            <input type="text" class="form-control" value="June {{date('Y')+0}} - May {{date('Y')+1}}" readonly>
                                        @else
                                            <select name="year" class="form-control" id="combo-year"> 
                                                <option value="{{date('Y')+0}}-{{date('Y')+1}}" >June {{date('Y')+0}} - May {{date('Y')+1}}</option>
                                                <option value="{{date('Y')-1}}-{{date('Y')+2}}" >June {{date('Y')+1}} - May {{date('Y')+0}}</option>
                                            </select>
                                        @endif
                                        <div class="invalid-feedback" id="error-combo-year-message"></div>
                                </div>  
                                <div class="form-group">
                                    <label for="email-2">Invite User</label>
                                    <div class="input-group ">  
                                        <input type="email" name="email" id="combo-email" placeholder="Enter email address" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="mail-verify-button">Confirm Email</button>
                                        <div class="invalid-feedback" id="error-combo-email-message"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="combo-coupon">Coupon Code</label>
                                    <div class="input-group ">  
                                        <input type="text" name="coupon" id="combo-coupon" placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="combo-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="error-combo-coupon-message"></div>
                                    </div>
                                </div> 
                                <div class="form-group" id="combo-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="hidden" name="verify" value="N" id="verify-mail">
                                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                    <button type="button" class="btn btn-dark" id="cortext-combo-subscription-payment-form-buttom">Pay Now $<span class="amount" id="cortext-combo-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.combo-amount-price','0') }}">{{ get_option('stripe.subscription.payment.combo-amount-price','0') }}</span> </button>
                                </div>
                            </form>
                        </div>
                        <div class="tabs2" id="tabs2-tabs2b">
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
                                    <div class="invalid-feedback" id="error-year-message"></div>
                                </div> 
                                <div class="form-group">
                                    <label for="coupon">Coupon Code</label>
                                    <div class="input-group ">  
                                        <input type="text" name="coupon" id="coupon" placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="error-coupon-message"></div>
                                    </div>
                                </div> 
    
                                <div class="form-group" id="message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                    <button type="button" class="btn btn-dark price-norm" id="cortext-subscription-payment-form-buttom">Pay Now $<span class="amount" id="cortext-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.amount-price','0') }}">{{ get_option('stripe.subscription.payment.amount-price','0') }}</span> </button> 
                                </div>
                            </form>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>


    @endauth

@endpush

@push('scripts')
        
    @auth('web')
        <script>
            function changetab(e,o){
                $(o).hide()
                $(e).fadeIn()
            }
            $('#cortext-subscription-payment-modal').on('hidden.bs.modal', function () { 
                $('#coupon').val('') 
                $('#message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $('#cortext-subscription-payment-form-buttom-price').text($('#cortext-subscription-payment-form-buttom-price').data("amount"))
            });
             $('#cortext-combo-subscription-payment-modal').on('hidden.bs.modal', function () { 
                $('#combo-email').val('')
                $('#verify-mail').val('N')
                $('#combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $('#cortext-combo-subscription-payment-form-buttom-price').text($('#cortext-combo-subscription-payment-form-buttom-price').data("amount"))
            });
            $('#cortext-combo-subscription-payment-form-buttom').click(function(e){
                e.preventDefault();
                $('#combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $.post("{{ route('pricing.index') }}", $('#cortext-combo-subscription-payment-form').serialize(), function(res) {
                    if($('#verify-mail').val()=="Y"){ 
                        $('#cortext-combo-subscription-payment-form').submit()
                    }else{
                        $('#combo-message-area').html(`
                            <div class="alert alert-danger" role="alert">
                                Please confirm your inviting friend mail by click on "Confirm Email" button.
                            </div>                        
                        `)
                    }
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#error-combo-'+k+'-message').text(v[0]) 
                        $('#combo-'+k).addClass('is-invalid')
                    });
                }); 
            })
            $('#combo-email').change(function(){
                $('#verify-mail').val('N')
            }) 
            $('#coupon-verify-button').click(function(e){
                e.preventDefault();
                $('#message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                var coupen=$('#coupon').val();
                if(coupen){
                    $.get('{{route("coupon-verify")}}',{coupon:coupen},function(res){
                        if(res.message){
                            $('#message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `) 
                        }
                        if(res.pay){
                            $('#cortext-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    },'json').fail(function(xhr){
                        $.each(xhr.responseJSON.errors, function(k, v) { 
                            $('#error-'+k+'-message').text(v[0]) 
                            $('#'+k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#combo-coupon-verify-button').click(function(e){
                e.preventDefault();
                $('#combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                var coupen=$('#combo-coupon').val();
                if(coupen){
                    $.get('{{route("coupon-verify")}}',{type:"combo",coupon:coupen},function(res){
                        if(res.message){
                            $('#combo-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `) 
                        }
                        if(res.pay){
                            $('#cortext-combo-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    },'json').fail(function(xhr){
                        $.each(xhr.responseJSON.errors, function(k, v) { 
                            $('#error-combo-'+k+'-message').text(v[0]) 
                            $('#combo-'+k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#mail-verify-button').click(function(e){
                e.preventDefault();
                $('#combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $.post("{{route('combo-email')}}",{ email:$('#combo-email').val(),year:$('#combo-year').val() },function(res){
                    if(res.message){
                        $('#combo-message-area').html(`
                            <div class="alert alert-info" role="alert">
                                ${res.message}
                            </div>                        
                        `)
                        $('#verify-mail').val('Y')
                    }
                },'json').fail(function(xhr){
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#error-combo-'+k+'-message').text(v[0]) 
                        $('#combo-'+k).addClass('is-invalid')
                    });
                })
            })

            $('#cortext-subscription-payment-form-buttom').click(function(e){
                e.preventDefault();
                $('#message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                $.post("{{ route('pricing.index') }}", $('#cortext-subscription-payment-form').serialize(), function(res) {
                    $('#cortext-subscription-payment-form').submit()
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#error-'+k+'-message').text(v[0]) 
                        $('#'+k).addClass('is-invalid')
                    });
                });
            })
        </script>
    @endauth

@endpush