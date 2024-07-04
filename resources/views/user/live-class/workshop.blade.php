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
                        
                    @else
                    <button class="btn btn-dark m-2">Register</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection