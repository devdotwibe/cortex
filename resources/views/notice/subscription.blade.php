@extends('layouts.exam')
@section('title', 'Login')
@section('content')
<section class="exam-container" id="exam-container">
    <div class="container-wrap">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($payment->status=="paid"||$payment->status=="succeeded")
            
            <div class="card">
                <div class="card-header">{{ __('Your Subscription Payment Was Successful!') }}</div>

                <div class="card-body"> 

                    {{ __("We’re excited to let you know that your subscription payment has been processed successfully. Thank you for choosing") }} {{config('app.name')}}
                   
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Close') }}</a>
                    </div>
                </div>
            </div>

            @else

            <div class="card">
                <div class="card-header">{{ __('Action Needed: Subscription Payment Unsuccessful') }}</div>

                <div class="card-body"> 

                    {{ __("We wanted to let you know that we encountered an issue processing your recent subscription payment. Unfortunately, the transaction was unsuccessful.") }}
                   
                </div>
            </div>

            @endif
        </div>
    </div>
</div>

</section>

@endsection

@push('modals')

@endpush

@push('footer-script')


@endpush


