@extends('layouts.user')
@section('title', 'Class Details')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('live-class.privateclass.details',$user->slug) }}">
                  
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
            <h2>Class Details1 </h2>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($classdetail as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <a href="{{ route('live-class.privateclass.term', ["live" =>$user->slug,"class_detail"=>$item->slug ]) }}">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{ asset('assets/images/User-red.png') }}">
                                </div> 
                                <div class="category-content">
                                    <div class="class-title">
                                        <h4>{{$item->term_name}}</h4>
                                    </div>
                                    <div class="class-term">
                                        <h3>Term {{$k+1}}</h3> 
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>                
            @endforeach
        </div>
    </div>
</section>
@endsection