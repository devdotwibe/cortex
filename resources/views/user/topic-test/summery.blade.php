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
            <a onclick="loadquestions('{{route('topic-test.confirmshow',$category->slug)}}')" class="btn btn-warning btn-sm"> Ready To Start </a>
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

        var examWorker=new Worker('{{asset("assets/js/worker.js")}}');
        worker.onmessage = function(e) {
            const { action, data } = e.data;

            switch (action) {
                case 'examInitialized':
                    console.log('Exam data initialized:', data);
                    break;
                case 'error':
                    console.error('Error:', data);
                    break;
                default:
                    console.warn('Unknown action:', action);
            }
        }; 
        worker.onerror = function(error) {
            console.error('Worker error:', error);
        };

        function loadquestions(redirect,url=null){
            const csrf= $('meta[name="csrf-token"]').attr('content')
            if(url==null){
                url="{{route('topic-test.questions',session('topic-test-attempt'))}}";
            } 
            worker.postMessage({ 
                action: 'initExam', 
                data: { 
                    url: url,
                    method: 'GET',
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    } 
                }
            });
 
            // const data = await response.json(); 
            // if(data.data){
            //     $.each(data.data,function(k,v){ 
            //         summery.exam[v.slug]={
            //             slug:v.slug, 
            //             title:v.title,
            //             description:v.description,
            //             duration:v.duration,
            //             title_text:v.title_text,
            //             sub_question:v.sub_question
            //         }
            //     }) 
            //     if(data.next_page_url){
            //         await loadquestions(redirect,data.next_page_url)
            //     }else{
            //         window.location.href=redirect;
            //     }
            // }            
        }
    </script>

@endpush