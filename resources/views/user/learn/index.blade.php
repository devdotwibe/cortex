@extends('layouts.user')
@section('title', 'Learn')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn</h2>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k => $item)
            <div class="col-md-6">
                @if ($user->progress('cortext-subscription-payment','')=="paid"||$k == 0)
                <a href="{{ route('learn.show', $item->slug) }}">
                @else
                <a data-bs-toggle="modal" data-bs-target="#cortext-subscription-payment-modal">
                @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{ asset("assets/images/User-red.png") }}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{ $item->id }}">
                                            {{ $exam->subtitle($item->id, "Module " . ($item->getIdx() + 1)) }}
                                        </span></h5>
                                    <h3>{{ $item->name }}</h3>
                                    <div class="progress-area">
                                        <progress max="100"
                                            value="{{ $user->progress('exam-' . $exam->id . '-module-' . $item->id, 0) }}">
                                            {{ round($user->progress('exam-' . $exam->id . '-module-' . $item->id, 0), 2) }}%
                                        </progress>
                                        <span>{{ round($user->progress('exam-' . $exam->id . '-module-' . $item->id, 0), 2) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('modals') 
    @if ($user->progress('cortext-subscription-payment','')!="paid")
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
    @endif
@endpush

@push('footer-script') 
 
@endpush
