@extends('layouts.user')
@section('title', 'Live Class')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Live Class</h2>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">

                <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">
                                <div class="category">

                                    <div class="category-image">

                                        @if(!empty($live_class->class_image_1))

                                            <img src="{{ url('d0/' . $live_class->class_image_1) }}">

                                        @else

                                            <img src="{{asset("assets/images/User-red.png")}}">

                                        @endif

                                    </div>

                                    <div class="category-content">
                                    
                                        <h3>@if(!empty($live_class->class_title_1)) {{ $live_class->class_title_1 }} @else Private Class Room @endif</h3>
                                    
                                        <p>
                                            @if(!empty($live_class->class_description_1))

                                            {{ $live_class->class_description_1   }}

                                            @else
                                            Receive a personalised learning experience with regular feedback by entrolling with our tutors Desinged for Year 5 students
                                            
                                            @endif
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">

                                     @if(!empty($live_class->class_image_2))

                                            <img src="{{ url('d0/' . $live_class->class_image_2) }}">

                                        @else

                                            <img src="{{asset("assets/images/User-red.png")}}">

                                        @endif

                                </div>
                                <div class="category-content">
                                
                                    <h3> @if(!empty($live_class->class_title_2)) {{ $live_class->class_title_2 }} @else Intensive Workshop  @endif</h3>

                                    <p>
                                        @if(!empty($live_class->class_description_2))

                                        {{ $live_class->class_description_2 }}

                                        @else
                                        These open group sessions condense the entire Thinking Skills curriculum into ten intensive lessions Designed for Year 6 students 
                                        
                                        @endif
                                    </p>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
           
        </div>
    </div>

</section>

@endsection

@push('modals')
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Enter Card Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closePaymentModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subscribe.handle') }}" method="post" id="payment-form">
                    @csrf
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                    <button type="submit" class="btn btn-primary submit">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>



@push('footer-script')

@endpush
