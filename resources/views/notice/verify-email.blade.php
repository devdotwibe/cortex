@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container" id="exam-container">
    <div class="container-wrap">
        <div class="lesson">
            <a class="lesson-exit float-start" href="{{route('learn.show',$category->slug)}}" title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip" >
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a>
            <div class="lesson-title">
                <h5><span>{{$exam->subtitle($category->id,"Module ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h5>
            </div>
            <div class="lesson-body">
                <div class="row" id="lesson-questionlist-list" style="display: none">
                </div>
            </div>
            <div class="lesson-footer" id="lesson-footer-pagination">
            </div>
        </div>
    </div>
</section>

@endsection

@push('modals')

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

@endpush

@push('footer-script')


@endpush
