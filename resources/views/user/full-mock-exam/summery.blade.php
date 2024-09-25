@extends('layouts.exam')
@section('title', $exam->title)
@section('content')
<section class="exam-container">
    <div class="summery-wrap"> 
        <div class="summery-title">
            <h1>{{get_option('exam_simulator_title')}}</h1>
        </div>
        <div class="summery-title">
            {{$exam->title}}
        </div>
        <div class="summery-content">
            {!! get_option("exam_simulator_description") !!}
        </div>
        <div class="summery-action">
            <a href="{{route('full-mock-exam.confirmshow',$exam->slug)}}" class="btn btn-warning btn-sm"> Ready To Start </a>
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

        localStorage.setItem("full-mock-exam-summery",JSON.stringify(summery)) 
    </script>

@endpush