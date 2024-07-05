@extends('layouts.user')
@section('title', 'Live Class - '.($live_class->class_title_2??' Intensive Workshop '))
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Live Class - {{($live_class->class_title_2??' Intensive Workshop ')}}</h2>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="workshop-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="workshop-content">
                    {!! $live_class->intensive_class??""!!}
                </div>
                <div class="workshop-action">
                    @if ($user->progress('intensive-workshop-payment','')=="paid")
                        <a class="btn btn-dark m-2" href="{{route('live-class.workshop.form',$user->slug)}}">Register</a>
                    @else
                        <button class="btn btn-dark m-2" data-bs-toggle="modal" data-bs-target="#intensive-workshop-payment-modal" >Register</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('modals')
    @if ($user->progress('intensive-workshop-payment','')!="paid")
    <div class="modal fade" id="intensive-workshop-payment-modal" tabindex="-1" role="dialog"  aria-labelledby="intensive-workshop-paymentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="intensive-workshop-paymentLablel">Live Class</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('payment.workshop')}}"  id="intensive-workshop-payment-form" >
                            <p>The Live Class - {{($live_class->class_title_2??' Intensive Workshop ')}} Register Peyment required </p>
                            <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-dark">Pay Now ${{ get_option('stripe.workshop.payment.amount-price','0') }} </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endpush