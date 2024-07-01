@extends('layouts.user')

@section('title', 'Subscribe')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Subscribe</h2>
                    <p>Amount: ${{ number_format($amount / 100, 2) }}</p>
                    <p>Expires on : {{$expires_on}}</p>
                    <form action="{{ route('subscribe.handle') }}" method="post" id="payment-form">
                        @csrf
                        <div class="form-group">
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <button type="submit" class="btn btn-primary submit">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Set up Stripe.js and Elements to use in checkout form
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

        // Add an instance of the card Element into the `card-element` div.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
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
