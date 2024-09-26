@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Topic ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container">
    <div class="summery-wrap"> 
        <div class="summery-title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('topic-test.index') }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>

            <h1>{{get_option('exam_simulator_title')}}</h1>
        </div>
        <div class="summery-title">
            <h2>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}:{{$category->name}}</h2>
        </div>
        <div class="summery-content">
            {!! get_option("exam_simulator_description") !!}
        </div>
        <div class="summery-action">
            <a href="{{route('topic-test.confirmshow',$category->slug)}}" class="btn btn-warning btn-sm"> Ready To Start </a>
        </div>
    </div> 
</section> 
@endsection

@push('footer-script') 

    <script> 
        let summery = new Proxy({}, {
            get: function(target, propertyName) {
                return target[propertyName] || null;
            },
            set: function(target, propertyName, value) {
                target[propertyName] = value;
                return true;
            }
        });
        summery.totalcount={{$questioncount??0}};
        summery.questionids=[]; 
        summery.timercurrent={};
        summery.flagcurrent={};
        summery.endTime={{$endtime}}*60; 
        summery.currentSlug=""; 
        summery.flagdx={};
        summery.verifydx={};
        summery.cudx=1;

        summery.answeridx=[];
        summery.notansweridx=[]; 
        summery.timerActive=true;
        summery.examActive=true;
        summery.timetaken=0;

        localStorage.setItem("topic-test-summery",JSON.stringify(summery)) 
    </script>

@endpush