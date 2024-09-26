@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Topic ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container">
    <div class="exam-progress">
        <div class="exam-progress-inner">
            <div class="exam-progress-inner-item exam-left">
                <div class="progress-main">

                    <div class="exam-exit ">
                        <a   href="{{route('question-bank.show',$category->slug)}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                            <img src="{{asset("assets/images/exiticon-wht.svg")}}" alt="exiticon">
                        </a>
                    </div>
                    <div class="timer exam-timer">
                        <div class="minute">
                            <span class="runner">00</span>
                            <span>Mins</span>
                        </div>
                        <div class="seperator">
                            <span>:</span>
                            <span></span>
                        </div>
                        <div class="second">
                            <span class="runner">00</span>
                            <span>Seconds</span>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="exam-center exam-progress-inner-item">
                <div class="progress-menu">
                    <div class="menu-text">
                        <span id="menu-text" >Question 0 of 0</span>
                    </div>
                    <div class="menu-icon"> 
                        <a onclick="toglepreviewpage()" >
                            <img src="{{asset("assets/images/menu.svg")}}" alt="exiticon">
                        </a>
                    </div>
                </div>
            </div>
            {{-- <div class="exam-right exam-progress-inner-item">
                <div class="progress-main">
                    <div class="bookmark">
                        <a class="" id="bookmark-current" >
                            <img class="active-img" src="{{asset("assets/images/bookmark.svg")}}" alt="bookmark">
                            <img class="inactive-img" src="{{asset("assets/images/bookmarkfill.svg")}}" alt="bookmark">
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
        
    </div>
    <div class="container-wrap  mcq-container-wrap question-bank" id="question-answer-page">
        <div class="lesson">  
            {{-- <div class="lesson-title">
                <h3><span>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
            </div> --}}
            <div class="lesson-body"> 
                <div class="row" id="lesson-questionlist-list" style="display: none">
                </div>
            </div>
            <div class="lesson-footer" id="lesson-footer-pagination"> 
            </div>           
        </div>
    </div> 
</section>
<section class="exam-footer"> 
    <div class="lesson-pagination">
        <div class="lesson-left pagination-arrow" style="display: none" >
            <button class="button left-btn"><img src="{{asset('assets/images/leftarrow.svg')}}" alt="<"> Back </button>
        </div>


        <div class="exam-right exam-progress-inner-item">
            <div class="progress-main">
                <div class="bookmark">
                    <a class="" id="bookmark-current" >
                        <img class="active-img" src="{{asset("assets/images/bookmark.svg")}}" alt="bookmark">
                        <img class="inactive-img" src="{{asset("assets/images/bookmarkfill.svg")}}" alt="bookmark">
                    </a>
                </div>
            </div>
        </div>
        
        <div class="lesson-right pagination-arrow" style="display:none">
            <button class="button right-btn"> Next <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
        </div>
        <div class="lesson-finish pagination-arrow" style="display:none">
            <button class="button finish-btn" > Finish Set <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
        </div>  
    </div> 
</section>
 

<section class="modal-expand" id="question-preview-page" style="display: none;">
    <div class="container-wrap">
        <div class="question-preview">  
            <div class="question-preview-title">
                <h3>Progress Summary</h3>
            </div>
            <div class="question-preview-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs question-tab" id="questionPreviewTab" role="tablist">
                            <li class="nav-item" role="presentation"> 
                                <button class="nav-link active" id="show-all-tab" data-bs-toggle="tab" data-bs-target="#show-all" type="button" role="tab" aria-controls="show-all" aria-selected="true"><div class="nav-status status-active"><img src="{{asset('assets/images/showall.svg')}}" alt="all"><span></span></div> Show All</button>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <button class="nav-link" id="answered-tab" data-bs-toggle="tab" data-bs-target="#answered" type="button" role="tab" aria-controls="answered" aria-selected="false"><div class="nav-status status-active" ><span id="answered-nav">0</span></div> Answered</button>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <button class="nav-link" id="not-answered-tab" data-bs-toggle="tab" data-bs-target="#not-answered" type="button" role="tab" aria-controls="not-answered" aria-selected="false"><div class="nav-status status-inactive" ><span id="not-answered-nav">0</span></div> Not Answered</button>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <button class="nav-link" id="not-readed-tab" data-bs-toggle="tab" data-bs-target="#not-readed" type="button" role="tab" aria-controls="not-readed" aria-selected="false"><div class="nav-status"><span  id="not-readed-nav">{{($questioncount??0)}}</span></div> Not Read</button>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <button class="nav-link" id="flagged-tab" data-bs-toggle="tab" data-bs-target="#flagged" type="button" role="tab" aria-controls="flagged" aria-selected="false"><div class="nav-status status-active" ><img src="{{asset('assets/images/flaged.svg')}}" alt="all"><span id="flagged-nav">0</span> </div> Flagged</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="questionPreviewTabContent">
                            <div class="tab-pane fade show active" id="show-all" role="tabpanel" aria-labelledby="show-all-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                        <div class="tabbody">
                                            <div class="question-list">
                                                @for ($i = 1; $i <= ($questioncount??0); $i++)
                                                    <div class="question-item" data-idx="{{$i}}">
                                                        <button class="item-group" onclick="loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'page'=>$i]) }}')">
                                                            <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                            <span>{{$i}}</span> 
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="answered" role="tabpanel" aria-labelledby="answered-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                        <div class="tabbody">
                                            <div class="question-list">
                                                @for ($i = 1; $i <= ($questioncount??0); $i++)
                                                    <div class="question-item" data-idx="{{$i}}">
                                                        <button class="item-group" onclick="loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'page'=>$i]) }}')">
                                                            <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                            <span>{{$i}}</span>
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="not-answered" role="tabpanel" aria-labelledby="not-answered-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                        <div class="tabbody">
                                            <div class="question-list">
                                                @for ($i = 1; $i <= ($questioncount??0); $i++)
                                                    <div class="question-item" data-idx="{{$i}}">
                                                        <button class="item-group" onclick="loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'page'=>$i]) }}')">
                                                            <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                            <span>{{$i}}</span> 
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="not-readed" role="tabpanel" aria-labelledby="not-readed-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                        <div class="tabbody">
                                            <div class="question-list">
                                                @for ($i = 1; $i <= ($questioncount??0); $i++)
                                                    <div class="question-item status-not-read"  data-idx="{{$i}}">
                                                        <button class="item-group" onclick="loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'page'=>$i]) }}')">
                                                            <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                            <span>{{$i}}</span> 
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="flagged" role="tabpanel" aria-labelledby="flagged-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                        <div class="tabbody">
                                            <div class="question-list">
                                                @for ($i = 1; $i <= ($questioncount??0); $i++)
                                                    <div class="question-item" data-idx="{{$i}}">
                                                        <button class="item-group" onclick="loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'page'=>$i]) }}')">
                                                             
                                                                <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                                <span>{{$i}}</span>
                                                             
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div style="display: none;opacity: 0;">
    <form action="{{route('question-bank.set.submit',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug])}}" method="post" id="finish-exam-confirmed-form">
        @csrf
        <input type="hidden" name="timed" id="finish-exam-confirmed-form-timed" value="" >
        <input type="hidden" name="timetaken" id="finish-exam-confirmed-form-timetaken" value="" >
        <input type="hidden" name="flags" id="finish-exam-confirmed-form-flags" value="" >
        <input type="hidden" name="times" id="finish-exam-confirmed-form-times" value="" >
        <input type="hidden" name="passed" id="finish-exam-confirmed-form-passed" value="" > 
    </form>
</div>

@endsection

@push('modals')
<div class="modal fade" id="finish-exam-confirm" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="Lablel">Submit Assessment</h5>
                <button type="button" class="close" data-bs-dismiss="modal"    aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <p>Do you want to submit this assessment ?</p>
                <p style="display:none" class="unfinish-message"> You still have <span class="unfinish-count">0</span> unfinished questions. </p>
                <button type="button" onclick="lessonreviewconfirm()" class="btn btn-dark">Yes</button>
                <button type="button"  data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('footer-script') 

    <script> 
         
        var totalcount={{$questioncount??0}};
        var questionids=[];
        var progressurl="";
        
        var timercurrent={};
        var flagcurrent={};
        var endTime={{$endtime}}*60;
        var countownRunCallbacks={};
        var currentSlug="";
        var countownRunCallbackActive=null;
        var countownSlugActive=""; 
        var flagdx={};
        var verifydx={};
        var cudx=1;

        var answeridx=[];
        var notansweridx=[]; 
        var timerActive=true;
        var examActive=true;
        var timetaken=0;
        function toglepreviewpage(){
            // timerActive=!timerActive; 
            $('#question-preview-page').slideToggle()
            $('#question-answer-page').fadeToggle()
        }
        function d2s(number){
            return (number??0).toLocaleString('en-US', { minimumIntegerDigits: 2 })
        }
        function generateRandomId(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }
        function countownRun(){
            if(timerActive&&examActive){ 
                if(endTime>0){ 
                    var d=endTime;
                    var m=Math.floor(d/60);
                    var s=d-(m*60);
                    $('.exam-timer .minute .runner').text(d2s(m))
                    $('.exam-timer .second .runner').text(d2s(s))
                    if(endTime<=240&&endTime>=230){
                        $('.exam-timer').addClass('time-up');
                    }else if(endTime<=10){
                        $('.exam-timer').addClass('time-up');
                    }else{
                        $('.exam-timer').removeClass('time-up');  
                    }
                    endTime--;
                    timetaken++;
                    timercurrent[currentSlug]=(timercurrent[currentSlug]||0)+1;
                } else{
                    $('.exam-timer .minute .runner').text(d2s(0))
                    $('.exam-timer .second .runner').text(d2s(0))
                    $('.exam-timer').addClass('time-up')
                    examActive=false
                    if((localStorage.getItem("question-bank")||"timed")=="timed"){ 
                        updateandsave(function(){
                            var unfinishcount=totalcount-questionids.length; 
                            if(unfinishcount>0){
                                $('.unfinish-message').show().find('.unfinish-count').text(unfinishcount)
                            }else{
                                $('.unfinish-message').hide().find('.unfinish-count').text(0)
                            }
                            lessonreviewconfirm() 
                        })   
                        if($('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]').length>0){
                            $('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]').prop('disabled',true)
                        }else{
                            $('#lesson-questionlist-list .forms-inputs input[name="answer"]').prop('readonly',true)
                        }
                    }
                }
            }            
        } 
        function getVimeoId(url) {
            // Regular expression to match Vimeo URL format
            const regex = /vimeo\.com\/(?:video\/|)(\d+)/;
            // Extract video ID using match function
            const match = url.match(regex);
            
            if (match) {
                return match[1]; // Return the captured video ID
            } else {
                return url; // Return null if no match found
            }
        } 
        async function verifyquestion(question,ans){
            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            var response=await fetch("{{route('question-bank.set.verify',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug])}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    question:question,
                    answer:ans
                }),
            }); 
            const data = await response.json(); 
            if(data.iscorrect){
                verifydx[question]=true;
            }else{
                delete verifydx[question];
            }
        }
        function refreshstatus(idx,status){
            $(`.question-item[data-idx="${idx}"]`).removeClass('status-not-answered').removeClass('status-answered');
            $(`#show-all .question-item[data-idx="${idx}"]`).addClass(`status-${status}`);
            $(`#${status} .question-item[data-idx="${idx}"]`).addClass(`status-${status}`);
            $(`#not-readed .question-item[data-idx="${idx}"]`).removeClass('status-not-read')

            $('#not-readed-nav').text(totalcount-(answeridx.length+notansweridx.length))
            $('#answered-nav').text(answeridx.length)
            $('#not-answered-nav').text(notansweridx.length)
        }
         function loadlesson(pageurl=null){ 
             
            $.get(pageurl||"{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                timerActive=true;
                $('#question-preview-page').fadeOut()
                $('#question-answer-page').fadeIn()
                const lesseonId=generateRandomId(10);  
                cudx=res.current_page;
                notansweridx.push(cudx) 
                notansweridx = [...new Set(notansweridx)]
                answeridx=answeridx.filter(item => item !== cudx)
                refreshstatus(cudx,'not-answered');
                if(flagdx[cudx]){
                    $("#bookmark-current").addClass('active');
                }else{
                    $("#bookmark-current").removeClass('active');
                }
                $.each(res.data,function(k,v){ 
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="mcq-row" >
                                    <div class="mcq-title">
                                        <span>${v.title||""}</span>
                                    </div>
                                    <div class="mcq-container">
                                        <div class="mcq-group">
                                            <h3><span>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
                                            <div class="mcq-title-text" ${v.title_text?"":'style="display:none"'}>
                                                ${v.title_text||""}
                                            </div>
                                            <div id="mcq-${lesseonId}" class="mcq-description">
                                                ${v.description||""}
                                            </div>
                                        </div>
                                        <div class="mcq-answer">
                                            <div  class="mcq-description">
                                                ${v.sub_question||""}
                                            </div>
                                            <div id="mcq-${lesseonId}-ans" class="form-group" >
                                                <div class="form-data" >
                                                    <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                        
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        if(!timercurrent[v.slug]){ 
                            timercurrent[v.slug]=0; 
                        } 
                        currentSlug=v.slug;
                        $.get(pageurl||"{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug]) }}",{question:v.slug},function(ans){
                            $(`#mcq-${lesseonId}-list`).html('')
                            $.each(ans,function(ai,av){
                                $(`#mcq-${lesseonId}-list`).append(`
                                    <div class="form-check">
                                        <input type="radio" name="answer" data-page="${cudx}" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input"  >        
                                        <label for="user-answer-${lesseonId}-ans-item-${ai}" >${av.title}</label>
                                    </div>  
                                `)
                            })
                            refreshquestionanswer(v.slug,function(data){
                                $(`#mcq-${lesseonId}-list input[value="${data.value}"]`).prop("checked",true)
                                if(data.value){
                                    answeridx.push(cudx) 
                                    answeridx = [...new Set(answeridx)]
                                    notansweridx=notansweridx.filter(item => item !== cudx)
                                    refreshstatus(cudx,'answered');
                                }
                            }) 
                        },'json').fail(function(xhr,status,error){
                            showToast("Error: " + error, 'danger'); 
                        }) 
                }) 
                if(res.next_page_url){ 
                    $('.lesson-right').show().find('button.right-btn').data('pageurl',res.next_page_url);
                }else{
                    $('.lesson-finish').show();
                }
                if(res.prev_page_url){
                    $('.lesson-left').show().find('button.left-btn').data('pageurl',res.prev_page_url);
                }  
                $('#menu-text').text(`Question ${res.current_page} of ${res.total}`)
                 

            },'json').fail(function(xhr,status,error){
                showToast("Error: " + error, 'danger'); 
            })

            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            progressurl=pageurl; 
            fetch("{{route('progress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-set-{{$setname->id}}-progress-url",
                    value:progressurl
                }),
            }); 
                 
         }
         async function updateprogress(callback){  
            try { 
                const csrf= $('meta[name="csrf-token"]').attr('content');  
                var currentprogress=(questionids.length*100/totalcount)
                const response1 = await fetch("{{route('progress')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-set-{{$setname->id}}-progress-ids",
                        value:JSON.stringify(questionids)
                    }),
                });  

                const response2 = await fetch("{{route('progress')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-set-{{$setname->id}}",
                        value:currentprogress
                    }),
                }); 
                if (!response2.ok) {
                    showToast("Error: " + response2.status, 'danger'); 
                }  
                callback()
            } catch (error) { 
                showToast("Error: " + error, 'danger'); 
            }
         }
         async function updatequestionanswer(question,ans){
            questionids.push(question);
            questionids=questionids.filter(function(value, index, array){
                return array.indexOf(value) === index;
            })
            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            const response = await fetch("{{route('progress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-set-{{$setname->id}}-answer-of-"+question,
                    value:ans
                }),
            }); 
         }
         async function refreshquestionanswer(question,callback){
            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            const response = await fetch("{{route('getprogress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-set-{{$setname->id}}-answer-of-"+question,
                    value:''
                }),
            }); 
            if (response.ok) {
                const data = await response.json();
                callback(data);
            }
         } 

         async function lessonreviewconfirm(){
            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            // currentprogress=(questionids.length*100/totalcount)
            await fetch("{{route('progress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-set-{{$setname->id}}-complete-review",
                    value:'pending'
                }),
            }); 
            $('#finish-exam-confirm').modal('hide') 
            var timed=localStorage.getItem("question-bank")||"timed";             
            $('#finish-exam-confirmed-form-timed').val(timed)
            $('#finish-exam-confirmed-form-timetaken').val(timetaken)
            $('#finish-exam-confirmed-form-flags').val(JSON.stringify(flagcurrent))
            $('#finish-exam-confirmed-form-times').val(JSON.stringify(timercurrent))
            $('#finish-exam-confirmed-form-passed').val(Object.keys(verifydx).length); 
            $('#finish-exam-confirmed-form').submit();
            timerActive=false;
            examActive=false; 
         }
         async function updateandsave(callback){ 
            if($('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]').length>0){
                $('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]:checked').each(function(){
                    updatequestionanswer($(this).data('question'),$(this).val());
                    verifyquestion($(this).data('question'),$(this).val());
                    if($(this).val()){
                        answeridx.push(cudx) 
                        answeridx = [...new Set(answeridx)]
                        notansweridx=notansweridx.filter(item => item !== cudx)
                        refreshstatus(cudx,'answered');
                    }else{
                        notansweridx.push(cudx) 
                        notansweridx = [...new Set(notansweridx)]
                        answeridx=answeridx.filter(item => item !== cudx)
                        refreshstatus(cudx,'not-answered');
                    }
                })
            } 
            updateprogress(callback) 
         }
          
         async function exitconfirm(url){
            if(await showConfirm({ 
                title:"Are you sure do you want to exit?" ,
                message: "If you exit in-between the exam, The answered questions will not save and you should need to start the exam from the beginning.",
            })){
                window.location.href=url;
            }
        }
         $(function(){  
            loadlesson() 
            $('.lesson-left button.left-btn,.lesson-right button.right-btn').click(function(){   
                console.log('oooooo')
                const pageurl=$(this).data('pageurl');  
                updateandsave(function(){
                    loadlesson(pageurl)
                })
            });  

            $('.lesson-finish button.finish-btn').click(function(){  
                updateandsave(function(){
                    var unfinishcount=totalcount-questionids.length; 
                    if(unfinishcount>0){
                        $('.unfinish-message').show().find('.unfinish-count').text(unfinishcount)
                    }else{
                        $('.unfinish-message').hide().find('.unfinish-count').text(0)
                    }  
                    $('#finish-exam-confirm').modal('show')
                })
            });
            $('#bookmark-current').click(function(){
                if(flagdx[cudx]){
                    flagdx[cudx]=false;
                    flagcurrent[currentSlug]=true;
                    $("#bookmark-current").removeClass('active');
                    $(`#show-all .question-item[data-idx="${cudx}"]`).removeClass('status-flag')
                    $(`#flagged .question-item[data-idx="${cudx}"]`).removeClass('status-flag')
                }else{
                    flagdx[cudx]=true;
                    flagcurrent[currentSlug]=true;
                    $("#bookmark-current").addClass('active')
                    $(`#show-all .question-item[data-idx="${cudx}"]`).addClass('status-flag')
                    $(`#flagged .question-item[data-idx="${cudx}"]`).addClass('status-flag')
                } 
                var lenflag=0;
                $.each(flagdx,(k,v)=>v?lenflag++:null);

                $('#flagged-nav').text(lenflag)
            }) 
            if((localStorage.getItem("question-bank")||"timed")=="timed"){ 
                $('.timer').show()
            }else{
                $('.timer').hide()
            }
            setInterval(countownRun,1000)

            $('.exam-exit a').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                exitconfirm($(this).attr("href")); 
            }) 
         })
    </script>
@endpush