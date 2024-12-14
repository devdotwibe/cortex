@extends('layouts.exam')
@section('headerclass','header-class')
@section('title', $homeWorkBook->title)
@section('content') 



    <section class="exam-container questionclass answerclass ">
    <div class="exam-progress">
        <div class="exam-progress-inner">
            <div class="exam-progress-inner-item exam-left">
                <div class="progress-main">

                    <div class="exam-exit ">
                        <a href="{{route('home-work.show',$homeWork->slug)}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                            <img src="{{asset("assets/images/exiticon-wht.svg")}}" alt="exiticon">
                        </a>
                    </div> 
                </div>
            </div>
            <div class="exam-center exam-progress-inner-item">
                <div class="progress-menu">
                    <div class="menu-text">
                        <span id="menu-text" >Question <span> 0 </span>  of <span>0 </span> </span>
                    
                    </div>
                    <div class="menu-icon"> 
                        <a onclick="toglepreviewpage()" >
                            <img src="{{asset("assets/images/menu.svg")}}" alt="menu">
                        </a>
                    </div>
                </div>
            </div>
           
        </div>
        
    </div>
    <div class="container-wrap nopaginationclass" id="question-answer-page">
        <div class="lesson">  
            {{-- <div class="lesson-title">
                <h5><span>{{$homeWorkBook->title}}</span></h5>
            </div> --}}
            <div class="lesson-body"> 
                <div class="row" id="lesson-questionlist-list" style="display: none">
                </div>
            </div>
            {{-- <div class="lesson-footer" id="lesson-footer-pagination"> 
            </div>            --}}
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
                        
                        
                        <span id="flagtext" class="flagclass">Flag</span>
                        <span id="flagimages" class="flagclass" >
                        <img class="active-img" src="{{asset("assets/images/flag-blue.svg")}}" alt="bookmark">
                    
                        <img class="inactive-img" src="{{asset("assets/images/flag-red.svg")}}" alt="bookmark">
                        </span>
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug,'page'=>$i]) }}')">
                                                             
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
    <form action="{{route('home-work.booklet.submit',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug])}}" method="post" id="finish-exam-confirmed-form">
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
                <p style="display:none" class="unfinish-message"> You still have <span class="unfinish-count">0</span> unfinished <span class="question-text"> questions. </p>
                <button type="button" onclick="lessonreviewconfirm()" class="btn btn-dark">Yes</button>
                <button type="button"  data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('footer-script') 
<script>

    function updateUnfinishedMessage(count) {
        const message = document.querySelector('.unfinish-message');
        const countElement = document.querySelector('.unfinish-count');
        const questionText = document.querySelector('.question-text');

        if (count > 0) {
            countElement.textContent = count;
            questionText.textContent = count === 1 ? 'question' : 'questions';
            message.style.display = 'block';
        } else {
            message.style.display = 'none';
        }
    }
</script>
    <script>  
        var progressurl="{{$user->progress('home-work-'.$homeWork->id.'-booklet-'.$homeWorkBook->id.'-progress-url','')}}"; 
        let storage = JSON.parse(localStorage.getItem("home-work-booklet"))||{
            totalcount:{{$questioncount??0}},
            questionids:[],
            timercurrent:{},
            flagcurrent:{},
            currentSlug:"",
            flagdx:{},
            verifydx:{},
            cudx:1,
            answeridx:[],
            notansweridx:[],
            timerActive:true,
            examActive:true,
            timetaken:0,
        };
        let summery = new Proxy({...storage,save:function(target){ localStorage.setItem("home-work-booklet",JSON.stringify(summery));return true; } }, {
            get: function(target, propertyName) {
                return target[propertyName] || null;
            },
            set: function(target, propertyName, value) {
                target[propertyName] = value; 
                return true;
            }
        });  
        function refreshpreviewstate(){
            
        }
        function toglepreviewpage(){
            summery.timerActive=!summery.timerActive; 
            $('#question-preview-page').slideToggle()
            $('#question-answer-page').fadeToggle()
            summery.save();
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
            var response=await fetch("{{route('home-work.booklet.verify',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug])}}", {
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
                summery.verifydx[question]=true;
            }else{
                delete summery.verifydx[question];
            }
            summery.save();
        }
        function refreshstatus(idx,status){
            $(`.question-item[data-idx="${idx}"]`).removeClass('status-not-answered').removeClass('status-answered');
            $(`#show-all .question-item[data-idx="${idx}"]`).addClass(`status-${status}`);
            $(`#${status} .question-item[data-idx="${idx}"]`).addClass(`status-${status}`);
            $(`#not-readed .question-item[data-idx="${idx}"]`).removeClass('status-not-read')

            $('#not-readed-nav').text(summery.totalcount-(summery.answeridx.length+summery.notansweridx.length))
            $('#answered-nav').text(summery.answeridx.length)
            $('#not-answered-nav').text(summery.notansweridx.length)
        }
         function loadlesson(pageurl=null){ 
             
            $.get(pageurl||"{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                summery.timerActive=true;
                $('#question-preview-page').fadeOut()
                $('#question-answer-page').fadeIn()
                const lesseonId=generateRandomId(10);  
                summery.cudx=res.current_page;
                summery.notansweridx.push(summery.cudx) 
                summery.notansweridx = [...new Set(summery.notansweridx)]
                summery.answeridx=summery.answeridx.filter(item => item !== summery.cudx)
                refreshstatus(summery.cudx,'not-answered');
                if(summery.flagdx[summery.cudx]){
                    $("#bookmark-current").addClass('active');
                    $("#flagtext").text('Unflag');
                }else{
                    $("#bookmark-current").removeClass('active');
                    $("#flagtext").text('Flag');
                }
                summery.save()
                $.each(res.data,function(k,v){ 

                    if(v.home_work_type=="mcq"){

                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="mcq-row" >
                                    <div class="mcq-title">
                                        <span>${v.title||""}</span>
                                    </div>
                                    <div class="mcq-container">
                                        <div id="mcq-${lesseonId}" class="mcq-description">
                                            ${v.description}
                                        </div>
                                        <div class="mcq-answer">
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

                        }
                        if(v.home_work_type=="short_notes"){
                            isVideoType = true;
                            $('#lesson-questionlist-list').html(`
                                <div class="col-md-12">
                                    <div class="note-row" >
                                        <div class="note-title">
                                            <span>${v.title||""}</span>
                                        </div>
                                        <div class="note-container">
                                            <div id="note-${lesseonId}">
                                                ${v.short_question}
                                            </div>
                                            <div id="note-${lesseonId}-ans" class="form-group">
                                                <div class="form-data ">
                                                    <div class="forms-inputs mb-4 answer_type">
                                                        <input type="text" name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}" value="" class="form-control" placeholder="Write your answer here" aria-placeholder="Write your answer here" autocomplete="off" >
                                                        <div class="invalid-feedback" id="error-answer-field" >The field is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `).fadeIn();

                            refreshquestionanswer(v.slug,function(data){
                                $(`#note-${lesseonId}-ans input[name="answer"]`).val(data.value);
                                 if(data.value){
                                    summery.answeridx.push(summery.cudx) 
                                    summery.answeridx = [...new Set(summery.answeridx)]
                                    summery.notansweridx=summery.notansweridx.filter(item => item !== summery.cudx)
                                    summery.save();
                                    refreshstatus(summery.cudx,'answered');
                                }
                            })
                        }

                        if(!summery.timercurrent[v.slug]){ 
                            summery.timercurrent[v.slug]=0; 
                        } 
                        summery.currentSlug=v.slug;
                        summery.save()
                        $.get(pageurl||"{{ route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug]) }}",{question:v.slug},function(ans){
                            $(`#mcq-${lesseonId}-list`).html('')
                            const baseUrl = `{{ asset('d0') }}`;
                            $.each(ans,function(ai,av){

                                const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))

                                const imageHtml = av && av.image
                                                    ? `<img src="${baseUrl}/${av.image}" class="answer-image" />`
                                                    : '';
                                $(`#mcq-${lesseonId}-list`).append(`
                                    <div class="form-check">
                                        <input type="radio" name="answer" data-page="${summery.cudx}" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input"  >        
                                        <label for="user-answer-${lesseonId}-ans-item-${ai}" >${ letter }. ${av.title ||""}</label>
                                         ${imageHtml}
                                    </div>  
                                `)
                            })
                            refreshquestionanswer(v.slug,function(data){
                                $(`#mcq-${lesseonId}-list input[value="${data.value}"]`).prop("checked",true)

                                console.log('anser-data',data.value);

                                if(data.value){
                                    summery.answeridx.push(summery.cudx) 
                                    summery.answeridx = [...new Set(summery.answeridx)]
                                    summery.notansweridx=summery.notansweridx.filter(item => item !== summery.cudx)
                                    summery.save();
                                    refreshstatus(summery.cudx,'answered');
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
            
                $('#menu-text').html(`Question <span> ${res.current_page} </span> of <span> ${res.total}</span>`)
                 

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
                    name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}-progress-url",
                    value:progressurl
                }),
            }); 
                 
         }
         async function updateprogress(callback){  
            try { 
                const csrf= $('meta[name="csrf-token"]').attr('content');  
                // var currentprogress=(summery.questionids.length*100/summery.totalcount)

                var currentprogress=(summery.answeridx.length*100/summery.totalcount)

                const response1 = await fetch("{{route('progress')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}-progress-ids",
                        value:JSON.stringify(summery.questionids)
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
                        name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}",
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
            summery.questionids.push(question);
            summery.questionids=summery.questionids.filter(function(value, index, array){
                return array.indexOf(value) === index;
            })
            summery.save()
            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            const response = await fetch("{{route('progress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}-answer-of-"+question,
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
                    name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}-answer-of-"+question,
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
            // currentprogress=(summery.questionids.length*100/summery.totalcount)
            await fetch("{{route('progress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}-complete-review",
                    value:'pending'
                }),
            }); 
            $('#finish-exam-confirm').modal('hide') 
            var timed="untimed";             
            $('#finish-exam-confirmed-form-timed').val(timed)
            $('#finish-exam-confirmed-form-timetaken').val(summery.timetaken)
            $('#finish-exam-confirmed-form-flags').val(JSON.stringify(summery.flagcurrent))
            $('#finish-exam-confirmed-form-times').val(JSON.stringify(summery.timercurrent))
            $('#finish-exam-confirmed-form-passed').val(Object.keys(summery.verifydx).length); 
            $('#finish-exam-confirmed-form').submit();
            summery.timerActive=false;
            summery.examActive=false;
            summery.save() 
         }
         async function updateandsave(callback){ 


            console.log('yyyy',$('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]').length);

            console.log('ppppp',$('#lesson-questionlist-list .answer_type input[name="answer"]').length);

            if($('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]').length>0){
                $('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]:checked').each(function(){

                    updatequestionanswer($(this).data('question'),$(this).val());
                    verifyquestion($(this).data('question'),$(this).val());
                    if($(this).val()){
                        summery.answeridx.push(summery.cudx) 
                        summery.answeridx = [...new Set(summery.answeridx)]
                        summery.notansweridx=summery.notansweridx.filter(item => item !== summery.cudx)
                        summery.save();
                        refreshstatus(summery.cudx,'answered');

                    }else{
                        summery.notansweridx.push(summery.cudx) 
                        summery.notansweridx = [...new Set(summery.notansweridx)]
                        summery.answeridx=summery.answeridx.filter(item => item !== summery.cudx)
                        summery.save();
                        refreshstatus(summery.cudx,'not-answered');

                     
                    }
                })
            }


            if ($('#lesson-questionlist-list .answer_type input[name="answer"]').length > 0) {
                $('#lesson-questionlist-list .answer_type input[name="answer"]').each(function() {
                const question = $(this).data('question');
                const answer = $(this).val();

                console.log('saved-inputs not cheked',answer);

                updatequestionanswer(question, answer);
                verifyquestion(question, answer);

                // Update summary based on whether an answer is provided
                if (answer) {
                    // Add to answered, remove from not-answered
                    summery.answeridx.push(summery.cudx);
                    summery.answeridx = [...new Set(summery.answeridx)];
                    summery.notansweridx = summery.notansweridx.filter(item => item !== summery.cudx);
                    summery.save();
                    refreshstatus(summery.cudx, 'answered');


                } else {
                    summery.notansweridx.push(summery.cudx);
                    summery.notansweridx = [...new Set(summery.notansweridx)];
                    summery.answeridx = summery.answeridx.filter(item => item !== summery.cudx);
                    summery.save();
                    refreshstatus(summery.cudx, 'not-answered');

                    console.log('short not answerd');

                }
            });
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
            refreshpreviewstate()
            loadlesson(progressurl) 
            $('.lesson-left button.left-btn,.lesson-right button.right-btn').click(function(){  
                const pageurl=$(this).data('pageurl');  
                updateandsave(function(){
                    loadlesson(pageurl)
                })
            });  

            $('.lesson-finish button.finish-btn').click(function(){  
                updateandsave(function(){

                    var unfinishcount=summery.notansweridx.length + summery.totalcount-(summery.answeridx.length+summery.notansweridx.length); 

                    // var unfinishcount=summery.totalcount-summery.notansweridx.length; 

                    console.log(summery.totalcount,'tottal');

                    // console.log(summery.questionids.length,'questno'); //prre update count

                    // console.log(summery.notansweridx.length,'questno');
                    
                    if(unfinishcount>0){
                        $('.unfinish-message').show().find('.unfinish-count').text(unfinishcount)
                    }else{
                        $('.unfinish-message').hide().find('.unfinish-count').text(0)
                    }  
                    $('#finish-exam-confirm').modal('show')
                    updateUnfinishedMessage(unfinishcount);
                })
            });
            $('#bookmark-current').click(function(){
                if(summery.flagdx[summery.cudx]){
                    summery.flagdx[summery.cudx]=false;
                    summery.flagcurrent[summery.currentSlug]=true;
                    summery.save();
                    $("#bookmark-current").removeClass('active');
                    $("#flagtext").text('flag')
                    $(`#show-all .question-item[data-idx="${summery.cudx}"]`).removeClass('status-flag')
                    $(`#flagged .question-item[data-idx="${summery.cudx}"]`).removeClass('status-flag')
                }else{
                    summery.flagdx[summery.cudx]=true;
                    summery.flagcurrent[summery.currentSlug]=true;
                    summery.save();
                    $("#bookmark-current").addClass('active')
                    $("#flagtext").text('Unflag')
                    $(`#show-all .question-item[data-idx="${summery.cudx}"]`).addClass('status-flag')
                    $(`#flagged .question-item[data-idx="${summery.cudx}"]`).addClass('status-flag')
                } 
                var lenflag=0;
                $.each(summery.flagdx,(k,v)=>v?lenflag++:null);

                $('#flagged-nav').text(lenflag)
            })  
            $('.timer').show()
           
            // setInterval(countownRun,1000)

            $('.exam-exit a').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                const csrf= $('meta[name="csrf-token"]').attr('content'); 
                await fetch("{{route('progress')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name:"home-work-{{$homeWork->id}}-booklet-{{$homeWorkBook->id}}-complete-review",
                        value:'complete'
                    }),
                }); 

                localStorage.removeItem("home-work-booklet")
                summery.timerActive=false;
                summery.examActive=false;
                summery.save() 
                exitconfirm($(this).attr("href")); 
            }) 
         })
    </script>
@endpush