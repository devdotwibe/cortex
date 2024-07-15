@extends('layouts.user')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="container">
    <div class="container-wrap">
        <div class="lesson">
            <div class="lesson-title">
                <h3><span>{{$exam->subtitle($category->id,"Module ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
            </div>
            <div class="lesson-body">
                <div class="row" id="lesson-list">
                    @forelse ($lessons as $k => $item)
                    <div class="col-md-6"> 
                            <a @if ($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id.'-complete-review',"no") == "yes") 
                                
                                @elseif ($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id.'-complete-date',"") == "")
                                @guest('admin')   href="{{ route('learn.lesson.show', ["category" => $category->slug, "sub_category" => $item->slug]) }}" @endguest
                               @else
                                   href="#" onclick="loadlessonreviews('{{ route("learn.lesson.history", ["category" => $category->slug, "sub_category" => $item->slug]) }}', {{$k+1}}); return false;"
                               @endif> 

                        <div class="lesson-row">
                            <div class="lesson-row-title">
                                <span>Lesson {{$k+1}}</span>
                                <span>: {{ $item->name }} </span>
                            </div>
                            <div class="lesson-row-subtitle">
                                <span>{{ round($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id,0), 2) }}%</span>
                            </div>
                        </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <div class="empty-row">
                            <span class="text-muted">Empty item</span>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('modals')

<div class="modal fade" id="review-history-modal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lesson <span id="review-history-label"></span></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-outer">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Progress</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="attemt-list">
                                    <!-- Content dynamically loaded via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @guest('admin') <a type="button" href="" id="restart-btn" class="btn btn-dark">Re-Start Lesson</a> @endguest
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscribeModalLabel">Subscribe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closestripe()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
@endpush

@push('footer-script')
<script src="https://js.stripe.com/v3/"></script>
<script>
        function stripemodal() {
         $('#subscribeModal').modal('show');
        }
        function closestripe() {
         $('#subscribeModal').modal('hide');
        }

    function loadlessonreviews(url, i) {
        $('#attemt-list').html('');
        $.get(url, function(res) {
            $.each(res.data, function(k, v) {
                $('#attemt-list').append(`
                    <tr>
                        <td>${v.date}</td>
                        <td>${v.progress}%</td>
                        <td><a type="button" href="${v.url}" class="btn btn-warning btn-sm">Review</a></td>
                    </tr>
                `);
            });
            $('#restart-btn').attr('href', res.url);
            $('#review-history-label').html(` ${i} : ${res.name} `);
            $('#review-history-modal').modal('show');
        }, 'json');
    }
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
    // Stripe payment handling
</script>
@endpush
