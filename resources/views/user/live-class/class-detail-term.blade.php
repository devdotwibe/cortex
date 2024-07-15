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
                                    <div class="class-term-list">
                                        <div class="class-term">
                                            <div class="class-term-label">
                                                <span>Time Slot </span>  
                                            </div>                                        
                                            <div class="class-term-content"> 
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
                                                <span>  {{$item->meeting_id}}</span>
                                            </div>    
                                        </div>
                                        <div class="class-term">
                                            <div class="class-term-label">
                                                <span>Passcode </span>
                                            </div>
                                            <div class="class-term-content">
                                                <span>  {{$item->passcode}}</span>
                                            </div>    
                                        </div>
                                        <div class="class-term">
                                            <div class="class-term-label">
                                                <span>Zoom Link  </span>
                                            </div>
                                            <div class="class-term-content">
                                                <span>  <a href="{{$item->zoom_link}}" target="_blank" rel="noopener noreferrer">{{$item->zoom_link}}</a> </span>
                                            </div>    
                                        </div>
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