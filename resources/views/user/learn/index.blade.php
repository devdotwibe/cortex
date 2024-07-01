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
            @foreach ($categorys as $k=> $item)
            <div class="col-md-6">
                  @if($k ==1)
                  <a href ="#" onclick="stripemodal()" data-toggle="modal" data-target="#subscribeModal">
                @endif
                <a href="{{route('learn.show',$item->slug)}}">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{$item->id}}"> {{$exam->subtitle($item->id,"Module ".($item->getIdx()+1))}} </span></h5>
                                    <h3>{{$item->name}}</h3>
                                    <div class="progress-area">
                                        <progress max="100" value="{{$user->progress('exam-'.$exam->id.'-module-'.$item->id,0)}}">{{round($user->progress('exam-'.$exam->id.'-module-'.$item->id,0),2)}}%</progress>
                                        <span>{{round($user->progress('exam-'.$exam->id.'-module-'.$item->id,0),2)}}%</span>
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
@if(session('showStripePopup'))
<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscribeModalLabel">Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closestripe()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subscribe.handle') }}" method="post" id="payment-form">
                    @csrf
                    <div class="form-group">
                        <div id ="amount">
                            <h1>Amount :
                        {{-- <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div> --}}
                    <button type="submit" class="btn btn-primary submit">Submit Payment</button>
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
    @if(session('showStripePopup'))
    $(document).ready(function() {
        $('#subscribeModal').modal('show');

    });
    @endif
        function closestripe() {
         $('#subscribeModal').modal('hide');
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
