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
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(document).ready(function () {
        // Show subscribeModal only if session variable indicates it should be shown
        @if(session('showStripePopup'))
        $('#subscribeModal').modal('show');
        $('#subscribeModal').modal('hide');
        @endif
    });

    function closestripe() {
        $('#subscribeModal').modal('hide');
    }

    function closePaymentModal() {
        $('#paymentModal').modal('hide');
    }

    function ShowPaymentModal() {
        $('#subscribeModal').modal('hide');
        $('#paymentModal').modal('show');
    }

    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    const style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            '::placeholder': {
                color: '#aab7c4',
            },
        },
    };

    // Create an instance of the card Element.
    const card = elements.create('card', { style });

    // Add an instance of the card Element into the card-element div.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function (event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    const paymentForm = document.getElementById('payment-form');
    if (paymentForm) {
        paymentForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const { token, error } = await stripe.createToken(card);

            if (error) {
                // Inform the user if there was an error.
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(token);
            }
        });
    }

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        const form = document.getElementById('payment-form');
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>
@endpush
