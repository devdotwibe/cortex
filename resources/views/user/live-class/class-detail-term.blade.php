@extends('layouts.user')
@section('title', 'Class Details')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Term {{$classDetail->getIdx()+1}} : Class Details </h2>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($terms as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                         
                            <div class="category"> 
                                <div class="category-content"> 
                                    <div class="class-term">
                                        <span>Meeting ID : {{$item->meeting_id}}</span>
                                    </div>
                                    <div class="class-term">
                                        <span>Passcode : {{$item->passcode}}</span>
                                    </div>
                                    <div class="class-term">
                                        <span>Zoom Link : <a href="{{$item->zoom_link}}" target="_blank" rel="noopener noreferrer">{{$item->zoom_link}}</a> </span>
                                    </div>
                                    <div class="class-term">
                                        <span>Time Slot : {!! implode(",<br>",$item->timeslot??[]) !!}</span>
                                    </div>
                                    
                                </div>
                            </div> 
                    </div>
                </div>
            </div>                
            @endforeach
        </div>
    </div>
</section>
@endsection