@extends('layouts.auth')
@section('title', 'Login')
@section('content')  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, 
                    <a href="{{ route('verification.resend') }}" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</a>.

                    <br><br>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Back to Dashboard') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
