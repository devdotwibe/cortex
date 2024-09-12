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
                            <button class="btn btn-danger" @if(date('m')>5) disabled @else data-bs-toggle="modal" data-bs-target="#tabs1-cortext-subscription-payment-modal"  @endif >Pay</button>
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
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tabs2-cortext-subscription-payment-modal">Pay</button>
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

        <div class="modal fade" id="tabs1-cortext-subscription-payment-modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"  aria-labelledby="tabs1-cortext-subscription-paymentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tabs1-cortext-subscription-paymentLablel">Subscription</h5> 
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> 
                            <div class="form-check">
                                <input type="radio" class="form-check-input" onchange="changetab('#tabs1-tabs1a','.tabs1')"  name="tabs1" id="tabs1a" autocomplete="off" >
                                <label  for="tabs1a" class="form-check-label">Group 1</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" onchange="changetab('#tabs1-tabs1b','.tabs1')"  name="tabs1" id="tabs1b" autocomplete="off" checked>
                                <label  for="tabs1b" class="form-check-label">Induvidual</label> 
                            </div>
                        </div>
                        <div class="tabs1" id="tabs1-tabs1a" style="display: none" >
                            <form action="{{route('pricing.index')}}"  id="tabs1-cortext-combo-subscription-payment-form"  method="POST">
                                @csrf        
                                <input type="hidden" name="plan" value="combo"> 
                                <input type="hidden" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                                <div class="form-group">
                                    <label for="email-2">Invite User</label>
                                    <div class="input-group ">  
                                        <input type="email" name="email" id="tabs1-combo-email" placeholder="Enter email address" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="tabs1-mail-verify-button">Confirm Email</button>
                                        <div class="invalid-feedback" id="tabs1-error-combo-email-message"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="combo-coupon">Coupon Code</label>
                                    <div class="input-group ">  
                                        <input type="text" name="coupon" id="tabs1-combo-coupon" placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="tabs1-combo-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="tabs1-error-combo-coupon-message"></div>
                                    </div>
                                </div> 
                                <div class="form-group" id="tabs1-combo-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="hidden" name="verify" value="N" id="tabs1-verify-mail">
                                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                    <button type="button" class="btn btn-dark" id="tabs1-cortext-combo-subscription-payment-form-buttom">Pay Now $<span class="amount" id="cortext-combo-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.combo-amount-price','0') }}">{{ get_option('stripe.subscription.payment.combo-amount-price','0') }}</span> </button>
                                </div>
                            </form>
                        </div>
                        <div class="tabs1" id="tabs1-tabs1b">
                            <form action="{{route('pricing.index')}}"  id="tabs1-cortext-subscription-payment-form" method="POST" >
                                @csrf    
                                <input type="hidden" name="plan" value="single">
                                <input type="hidden" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                                <div class="form-group">
                                    <label for="coupon">Coupon Code</label>
                                    <div class="input-group ">  
                                        <input type="text" name="coupon" id="tabs1-coupon" placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="tabs1-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="tabs1-error-coupon-message"></div>
                                    </div>
                                </div>     
                                <div class="form-group" id="tabs1-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                    <button type="button" class="btn btn-dark price-norm" id="tabs1-cortext-subscription-payment-form-buttom">Pay Now $<span class="amount" id="tabs1-cortext-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.amount-price','0') }}">{{ get_option('stripe.subscription.payment.amount-price','0') }}</span> </button> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="modal fade" id="tabs2-cortext-subscription-payment-modal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"  aria-labelledby="tabs2-cortext-subscription-paymentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tabs2-cortext-subscription-paymentLablel">Subscription</h5> 
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
                            <form action="{{route('pricing.index')}}"  id="tabs2-cortext-combo-subscription-payment-form"  method="POST">
                                @csrf        
                                <input type="hidden" name="plan" value="combo"> 
                                <input type="hidden" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                                <div class="form-group">
                                    <label for="email-2">Invite User</label>
                                    <div class="input-group ">  
                                        <input type="email" name="email" id="tabs2-combo-email" placeholder="Enter email address" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="tabs2-mail-verify-button">Confirm Email</button>
                                        <div class="invalid-feedback" id="tabs2-error-combo-email-message"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="combo-coupon">Coupon Code</label>
                                    <div class="input-group ">  
                                        <input type="text" name="coupon" id="tabs2-combo-coupon" placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="tabs2-combo-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="tabs2-error-combo-coupon-message"></div>
                                    </div>
                                </div> 
                                <div class="form-group" id="tabs2-combo-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="hidden" name="verify" value="N" id="tabs2-verify-mail">
                                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                    <button type="button" class="btn btn-dark" id="tabs2-cortext-combo-subscription-payment-form-buttom">Pay Now $<span class="amount" id="tabs2-cortext-combo-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.combo-amount-price','0') }}">{{ get_option('stripe.subscription.payment.combo-amount-price','0') }}</span> </button>
                                </div>
                            </form>
                        </div>
                        <div class="tabs2" id="tabs2-tabs2b">
                            <form action="{{route('pricing.index')}}"  id="tabs2-cortext-subscription-payment-form" method="POST" >
                                @csrf    
                                <input type="hidden" name="plan" value="single">
                                <input type="hidden" name="year" value="{{date('Y')+0}}-{{date('Y')+1}}" >
                                <div class="form-group">
                                    <label for="coupon">Coupon Code</label>
                                    <div class="input-group ">  
                                        <input type="text" name="coupon" id="tabs2-coupon" placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button" id="tabs2-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="tabs2-error-coupon-message"></div>
                                    </div>
                                </div>     
                                <div class="form-group" id="tabs2-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button> 
                                    <button type="button" class="btn btn-dark price-norm" id="tabs2-cortext-subscription-payment-form-buttom">Pay Now $<span class="amount" id="tabs2-cortext-subscription-payment-form-buttom-price" data-amount="{{ get_option('stripe.subscription.payment.amount-price','0') }}">{{ get_option('stripe.subscription.payment.amount-price','0') }}</span> </button> 
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
            $('#tabs1-cortext-subscription-payment-modal').on('hidden.bs.modal', function () { 
                $('#tabs1-combo-email').val('')
                $('#tabs1-verify-mail').val('N')
                $('#tabs1-coupon').val('') 
                $('#tabs1-message-area').html('')
                $('#tabs1-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $('#tabs1-cortext-subscription-payment-form-buttom-price').text($('#tabs1-cortext-subscription-payment-form-buttom-price').data("amount"))
            });
            $('#tabs1-cortext-combo-subscription-payment-form-buttom').click(function(e){
                e.preventDefault();
                $('#tabs1-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $.post("{{ route('pricing.index') }}", $('#tabs1-cortext-combo-subscription-payment-form').serialize(), function(res) {
                    if($('#tabs1-verify-mail').val()=="Y"){ 
                        $('#tabs1-cortext-combo-subscription-payment-form').submit()
                    }else{
                        $('#tabs1-combo-message-area').html(`
                            <div class="alert alert-danger" role="alert">
                                Please confirm your inviting friend mail by click on "Confirm Email" button.
                            </div>                        
                        `)
                    }
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#tabs1-error-combo-'+k+'-message').text(v[0]) 
                        $('#tabs1-combo-'+k).addClass('is-invalid')
                    });
                }); 
            })
            $('#tabs1-combo-email').change(function(){
                $('#tabs1-verify-mail').val('N')
            }) 
            $('#tabs1-coupon-verify-button').click(function(e){
                e.preventDefault();
                $('#tabs1-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                var coupen=$('#tabs1-coupon').val();
                if(coupen){
                    $.get('{{route("coupon-verify")}}',{coupon:coupen},function(res){
                        if(res.message){
                            $('#tabs1-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `) 
                        }
                        if(res.pay){
                            $('#tabs1-cortext-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    },'json').fail(function(xhr){
                        $.each(xhr.responseJSON.errors, function(k, v) { 
                            $('#tabs1-error-'+k+'-message').text(v[0]) 
                            $('#tabs1-'+k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#tabs1-combo-coupon-verify-button').click(function(e){
                e.preventDefault();
                $('#tabs1-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                var coupen=$('#tabs1-combo-coupon').val();
                if(coupen){
                    $.get('{{route("coupon-verify")}}',{type:"combo",coupon:coupen},function(res){
                        if(res.message){
                            $('#tabs1-combo-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `) 
                        }
                        if(res.pay){
                            $('#tabs1-cortext-combo-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    },'json').fail(function(xhr){
                        $.each(xhr.responseJSON.errors, function(k, v) { 
                            $('#tabs1-error-combo-'+k+'-message').text(v[0]) 
                            $('#tabs1-combo-'+k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#tabs1-mail-verify-button').click(function(e){
                e.preventDefault();
                $('#tabs1-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $.post("{{route('combo-email')}}",{ email:$('#tabs1-combo-email').val(),year:$('#tabs1-combo-year').val() },function(res){
                    if(res.message){
                        $('#tabs1-combo-message-area').html(`
                            <div class="alert alert-info" role="alert">
                                ${res.message}
                            </div>                        
                        `)
                        $('#tabs1-verify-mail').val('Y')
                    }
                },'json').fail(function(xhr){
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#tabs1-error-combo-'+k+'-message').text(v[0]) 
                        $('#tabs1-combo-'+k).addClass('is-invalid')
                    });
                })
            })
            $('#tabs1-cortext-subscription-payment-form-buttom').click(function(e){
                e.preventDefault();
                $('#tabs1-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                $.post("{{ route('pricing.index') }}", $('#tabs1-cortext-subscription-payment-form').serialize(), function(res) {
                    $('#tabs1-cortext-subscription-payment-form').submit()
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#tabs1-error-'+k+'-message').text(v[0]) 
                        $('#tabs1-'+k).addClass('is-invalid')
                    });
                });
            })



            $('#tabs2-cortext-subscription-payment-modal').on('hidden.bs.modal', function () { 
                $('#tabs2-combo-email').val('')
                $('#tabs2-verify-mail').val('N')
                $('#tabs2-coupon').val('') 
                $('#tabs2-message-area').html('')
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $('#tabs2-cortext-subscription-payment-form-buttom-price').text($('#tabs2-cortext-subscription-payment-form-buttom-price').data("amount"))
            });
            $('#tabs2-cortext-combo-subscription-payment-form-buttom').click(function(e){
                e.preventDefault();
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $.post("{{ route('pricing.index') }}", $('#tabs2-cortext-combo-subscription-payment-form').serialize(), function(res) {
                    if($('#tabs2-verify-mail').val()=="Y"){ 
                        $('#tabs2-cortext-combo-subscription-payment-form').submit()
                    }else{
                        $('#tabs2-combo-message-area').html(`
                            <div class="alert alert-danger" role="alert">
                                Please confirm your inviting friend mail by click on "Confirm Email" button.
                            </div>                        
                        `)
                    }
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#tabs2-error-combo-'+k+'-message').text(v[0]) 
                        $('#tabs2-combo-'+k).addClass('is-invalid')
                    });
                }); 
            })
            $('#tabs2-combo-email').change(function(){
                $('#tabs2-verify-mail').val('N')
            }) 
            $('#tabs2-coupon-verify-button').click(function(e){
                e.preventDefault();
                $('#tabs2-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                var coupen=$('#tabs2-coupon').val();
                if(coupen){
                    $.get('{{route("coupon-verify")}}',{coupon:coupen},function(res){
                        if(res.message){
                            $('#tabs2-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `) 
                        }
                        if(res.pay){
                            $('#tabs2-cortext-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    },'json').fail(function(xhr){
                        $.each(xhr.responseJSON.errors, function(k, v) { 
                            $('#tabs2-error-'+k+'-message').text(v[0]) 
                            $('#tabs2-'+k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#tabs2-combo-coupon-verify-button').click(function(e){
                e.preventDefault();
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                var coupen=$('#tabs2-combo-coupon').val();
                if(coupen){
                    $.get('{{route("coupon-verify")}}',{type:"combo",coupon:coupen},function(res){
                        if(res.message){
                            $('#tabs2-combo-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `) 
                        }
                        if(res.pay){
                            $('#tabs2-cortext-combo-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    },'json').fail(function(xhr){
                        $.each(xhr.responseJSON.errors, function(k, v) { 
                            $('#tabs2-error-combo-'+k+'-message').text(v[0]) 
                            $('#tabs2-combo-'+k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#tabs2-mail-verify-button').click(function(e){
                e.preventDefault();
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid') 
                $.post("{{route('combo-email')}}",{ email:$('#tabs2-combo-email').val(),year:$('#tabs2-combo-year').val() },function(res){
                    if(res.message){
                        $('#tabs2-combo-message-area').html(`
                            <div class="alert alert-info" role="alert">
                                ${res.message}
                            </div>                        
                        `)
                        $('#tabs2-verify-mail').val('Y')
                    }
                },'json').fail(function(xhr){
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#tabs2-error-combo-'+k+'-message').text(v[0]) 
                        $('#tabs2-combo-'+k).addClass('is-invalid')
                    });
                })
            })
            $('#tabs2-cortext-subscription-payment-form-buttom').click(function(e){
                e.preventDefault();
                $('#tabs2-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                $.post("{{ route('pricing.index') }}", $('#tabs2-cortext-subscription-payment-form').serialize(), function(res) {
                    $('#tabs2-cortext-subscription-payment-form').submit()
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) { 
                        $('#tabs2-error-'+k+'-message').text(v[0]) 
                        $('#tabs2-'+k).addClass('is-invalid')
                    });
                });
            })
            
        </script>
    @endauth

@endpush