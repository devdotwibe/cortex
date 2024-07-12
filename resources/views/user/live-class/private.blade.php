@extends('layouts.user')
@section('title', 'Live Class - '.($live_class->class_title_1??' Private Class Room '))
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Live Class - {{($live_class->class_title_1??' Private Class Room ')}}</h2>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="workshop-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="workshop-content">
                    {!! $live_class->private_class??""!!}
                </div>
                <div class="workshop-action"> 
                    @if (empty($user->privateClass))
                    <a class="btn btn-outline-warning m-2" href="{{route('live-class.privateclass.form',$user->slug)}}">Register</a>
                    @elseif($user->privateClass->status!="approved")
                    <span class="btn btn-outline-warning">{{ucfirst($user->privateClass->status)}}</span>
                    @else
                    <a class="btn btn-warning m-2" href="{{route('live-class.privateclass.room',$user->slug)}}">Enter</a>
                    @endif 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
 