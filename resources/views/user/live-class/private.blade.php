@extends('layouts.user')
@section('title', 'Live Class - '.($live_class->class_title_1??' Private Class Room '))
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('live-class.index') }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
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
                  @guest('admin')  <a class="btn btn-outline-warning m-2" href="{{route('live-class.privateclass.form',$user->slug)}}">Register</a> @endguest
                    @elseif($user->privateClass->status!="approved")
                    @if($user->privateClass->status=="pending") <p class="text-warning"> You are under verification, Please wait.</p> @elseif($user->privateClass->status=="rejected") <p class="text-danger" >Your are rejected by admin, Please <a @if(!empty(optional($setting)->emailaddress)) href="mailto:{{optional($setting)->emailaddress}}" @endif >contact Admin {{ optional($setting)->emailaddress }}</a> for further details.</p> @else <span class="btn btn-outline-warning"> {{ucfirst($user->privateClass->status)}} </span> @endif
                    @else
                    <a class="btn btn-warning m-2" href="{{route('live-class.privateclass.room',$user->slug)}}">Enter</a>
                    @endif 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
 