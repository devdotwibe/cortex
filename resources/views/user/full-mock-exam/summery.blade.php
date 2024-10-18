@extends('layouts.exam')
@section('title', $exam->title)
@section('content')
<section class="exam-container topictestclass ">
    <div class="summery-wrap"> 
        <div class="summery-title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('full-mock-exam.index') }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
            <h1>{{get_option('exam_simulator_title')}}</h1>
        </div>
        <div class="summery-title">
            {{$exam->title}}
        </div>
        <div class="summery-content">
            {!! get_option("exam_simulator_description") !!}
        </div>
        <div class="summery-action">
            <a onclick="loadquestions('{{route('full-mock-exam.confirmshow',$exam->slug)}}')" class="btn btn-warning btn-sm"> Ready To Start </a>
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
        localStorage.removeItem("full-mock-exam-summery-retry")

        async function loadquestions(redirect,url=null){
            $('.loading-wrap').show()
            const csrf= $('meta[name="csrf-token"]').attr('content')
            if(url==null){
                url="{{route('full-mock-exam.questions',session('full-mock-exam-attempt'))}}";
            }  
            const response = await fetch(url, {
                method: 'GET',
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }); 
 
            const data = await response.json(); 
            if(data.next_page_url){
                await loadquestions(redirect,data.next_page_url)
            }else{
                window.location.href=redirect;
            }      
        }
    </script>

@endpush