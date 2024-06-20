@extends('layouts.user')
@section('title', 'Question Bank')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Question Bank</h2>
        </div> 
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k=> $item)
            <div class="col-md-6">

                <a href="{{route('question-bank.show',$item->slug)}}">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{$item->id}}"> {{$exam->subtitle($item->id,"Topic ".($item->getIdx()+1))}} </span></h5>
                                    <h3>{{$item->name}}</h3>
                                    <div class="progress-area">
                                        <progress max="100" value="{{$user->progress('exam-'.$exam->id.'-topic-'.$item->id,0)}}">{{round($user->progress('exam-'.$exam->id.'-topic-'.$item->id,0),2)}}%</progress>
                                        <span>{{round($user->progress('exam-'.$exam->id.'-topic-'.$item->id,0),2)}}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                </a>
                
            </div>
            @endforeach  
        </div>
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush