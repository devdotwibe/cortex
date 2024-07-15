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
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                         
                            <div class="category"> 
                                <div class="category-content"> 
                                    <div class="class-term-list">
                                        @foreach ($sloteterms as  $k=>$item)
                                        <div class="class-term" >
                                            <div class="class-term-label">
                                                <span>{{$item['slot']}} </span>  
                                            </div>
                                            <div class="class-term-content">
                                                <div class="zoom-list">
                                                    @foreach ($item['list'] as $slot)
                                                        <div class="zoom-item">
                                                            <div class="zoom-id">
                                                                <span class="zoom-label">Meeting ID </span>
                                                                <span class="zoom-content"> : {{$slot->meeting_id}}</span>
                                                            </div>
                                                            <div class="zoom-id">
                                                                <span class="zoom-label">Passcode</span>
                                                                <span class="zoom-content"> : {{$slot->passcode}}</span>
                                                            </div>
                                                            <div class="zoom-id">
                                                                <span class="zoom-label">Zoom Link </span>
                                                                <span class="zoom-content"> : <a href="{{$slot->zoom_link}}" target="_blank" rel="noopener noreferrer">{{$slot->zoom_link}}</a></span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>           
                                        @endforeach
                                        {{-- <div >
                                            <div class="class-term-label">
                                                <span>Time Slot </span>  
                                            </div>                                        
                                            <div class="class-term-content">
                                                <span> : </span>
                                                <ul>
                                                    @foreach ($item->timeslot??[] as $slt) <li> <span>{{$slt}}</span> </li> @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="class-term">
                                            <div class="class-term-label">
                                                <span>Meeting ID </span>
                                            </div>
                                            <div class="class-term-content">
                                                <span> : {{$item->meeting_id}}</span>
                                            </div>    
                                        </div>
                                        <div class="class-term">
                                            <div class="class-term-label">
                                                <span>Passcode </span>
                                            </div>
                                            <div class="class-term-content">
                                                <span> : {{$item->passcode}}</span>
                                            </div>    
                                        </div>
                                        <div class="class-term">
                                            <div class="class-term-label">
                                                <span>Zoom Link  </span>
                                            </div>
                                            <div class="class-term-content">
                                                <span> : <a href="{{$item->zoom_link}}" target="_blank" rel="noopener noreferrer">{{$item->zoom_link}}</a> </span>
                                            </div>    
                                        </div> --}}
                                    </div>                                    
                                    
                                </div>
                            </div> 
                    </div>
                </div>
            </div>     
        </div>
    </div>
</section>
@endsection