@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Topic ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container">
    <div class="exam-progress">
        <div class="exam-progress-inner">
            <div class="exam-progress-inner-item exam-left">
                <div class="progress-main">

                    <div class="exam-exit ">
                        <a   href="{{route('question-bank.show',$category->slug)}}">
                            <img src="{{asset("assets/images/exiticon-wht.svg")}}" alt="exiticon">
                        </a>
                    </div>
                    <div class="timer">
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
                <a >
                    <img src="{{asset("assets/images/menu.svg")}}" alt="exiticon">
                </a>
            </div>
            <div class="exam-right exam-progress-inner-item">
                <div class="progress-main">
                    <div class="bookmark">
                        <a >
                            <img src="{{asset("assets/images/bookmark.svg")}}" alt="bookmark">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="container-wrap">
        <div class="lesson">            
            
            <div class="lesson-title">
                <h3><span>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
            </div>
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
        <div class="lesson-right pagination-arrow" style="display:none">
            <button class="button right-btn"> Next <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
        </div>
        <div class="lesson-finish pagination-arrow" style="display:none">
            <button class="button finish-btn" > Finish Lesson <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
        </div> 
        <div class="lesson-end pagination-arrow" style="display:none">
            <a class="button end-btn" href="{{route('question-bank.set.submit',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug])}}" > End Review <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></a>
        </div>
    </div> 
</section>
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
        var currentprogress={{$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id,0)}};
        var totalcount={{$questioncount??0}};
        var questionids={!! $user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id."-progress-ids",'[]') !!};
        var progressurl="{{$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-progress-url','')}}";
        var timerinterval=null;
        var timercurrent=Math.floor(Date.now() /1000);
        function generateRandomId(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }
        function countownTimer(callback){
            var current=Math.floor(Date.now() /1000);
            console.log(timercurrent)
            if(timercurrent<current&&timerinterval!=null){
                clearInterval(timerinterval);
                timerinterval=null;
                callback()
            }else{
                var differece=timercurrent-current;
                var minute=Math.floor(differece/60);
                var second=differece-(minute*60);
                $('.timer .minute .runner').text(minute)
                $('.timer .second .runner').text(second)
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
         function loadlesson(pageurl=null){ 
            $.get(pageurl||"{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                const lesseonId=generateRandomId(10); 
                $.each(res.data,function(k,v){ 
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
                        var currentdate=new Date();
                        currentdate.setMinutes(currentdate.getMinutes()+parseInt(v.duration));
                        timercurrent=Math.floor(currentdate.getTime() /1000)
                        $.get(pageurl||"{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug]) }}",{question:v.slug},function(ans){
                            $(`#mcq-${lesseonId}-list`).html('')
                            $.each(ans,function(ai,av){
                                $(`#mcq-${lesseonId}-list`).append(`
                                    <div class="form-check">
                                        <input type="radio" name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input"  >        
                                        <label for="user-answer-${lesseonId}-ans-item-${ai}" >${av.title}</label>
                                    </div>  
                                `)
                            })
                            refreshquestionanswer(v.slug,function(data){
                                $(`#mcq-${lesseonId}-list input[value="${data.value}"]`).prop("checked",true)
                            })
                            var istimed=localStorage.getItem("question-bank")||"timed"
                            if(istimed=="timed"){
                                if(timerinterval!=null){
                                    clearInterval(timerinterval);
                                    timerinterval=null;
                                }
                                timerinterval=setInterval(()=>{
                                    countownTimer(()=>{
                                        if(res.next_page_url){
                                            updateandsave(function(){
                                                loadlesson(res.next_page_url)
                                            })
                                        }else{
                                            var unfinishcount=totalcount-questionids.length; 
                                            if(unfinishcount>0){
                                                $('.unfinish-message').show().find('.unfinish-count').text(unfinishcount)
                                            }else{
                                                $('.unfinish-message').hide().find('.unfinish-count').text(0)
                                            }  
                                            updateandsave(function(){
                                                $('#finish-exam-confirm').modal('show')
                                            })
                                        }
                                    })
                                }, 1000);
                                
                            }
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
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-progress-url",
                    value:progressurl
                }),
            }); 
         }
         async function updateprogress(callback){  
            try { 
                const csrf= $('meta[name="csrf-token"]').attr('content'); 
                currentprogress=(questionids.length*100/totalcount)
                const response1 = await fetch("{{route('progress')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-progress-ids",
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
                        name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}",
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
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-answer-of-"+question,
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
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-answer-of-"+question,
                    value:''
                }),
            }); 
            if (response.ok) {
                const data = await response.json();
                callback(data);
            }
         }
         function loadlessonreview(reviewurl){
            $('#finish-exam-confirm').modal('hide')
            $.get(reviewurl||"{{ route('question-bank.set.review',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                const lesseonId=generateRandomId(10); 
                $.each(res.data,function(k,v){  
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="mcq-row" >
                                    <div class="mcq-title">
                                        <span>${v.title}</span>
                                    </div>
                                    <div class="mcq-container">
                                        <div id="mcq-${lesseonId}">
                                            ${v.description}
                                        </div>
                                        <div id="mcq-${lesseonId}-ans" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                        <div id="mcq-${lesseonId}-explanation"> 
                                            <label>Correct Answer <span id="mcq-${lesseonId}-correct"></span></label>
                                            ${v.explanation||""}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        $(`#mcq-${lesseonId}-list`).html('')
                        $.each(v.answers,function(ai,av){
                            const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))
                            $(`#mcq-${lesseonId}-list`).append(`
                            <div class="form-check-ans">
                                <span class="question-user-ans ${av.iscorrect?"correct":"wrong"}" data-ans="${av.slug}"></span>
                                <div class="form-check">
                                    <input type="radio" disabled name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input" ${av.iscorrect?"checked":""}  >        
                                    <label for="user-answer-${lesseonId}-ans-item-${ai}" >${ letter }. ${av.title}</label>
                                </div>  
                            </div>
                            `)
                            if(av.iscorrect){
                                $(`#mcq-${lesseonId}-correct`).text(`: ${ letter } `)
                            }
                        })
                        refreshquestionanswer(v.slug,function(data){
                            $(`#mcq-${lesseonId}-list input[value="${data.value}"]`).prop("checked",true)
                        }) 
                }) 
                if(res.total>1){
                     $.each(res.links,function(k,v){
                        if(v.active||!v.url){
                            $('#lesson-footer-pagination').append(`
                                <button class="btn btn-secondary ${v.active?"active":""}" disabled  >${v.label}</button>
                            `)
                        }else{
                            $('#lesson-footer-pagination').append(`
                                <button class="btn btn-secondary" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
                            `)
                        }
                     })
                }
 
                $('.lesson-end').show();
            },'json')

         }

         async function lessonreviewconfirm(){
            const csrf= $('meta[name="csrf-token"]').attr('content'); 
            currentprogress=(questionids.length*100/totalcount)
            await fetch("{{route('progress')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name:"exam-{{$exam->id}}-topic-{{$category->id}}-lesson-{{$subCategory->id}}-complete-review",
                    value:'pending'
                }),
            }); 
            loadlessonreview()
         }
         async function updateandsave(callback){ 
            if($('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]').length>0){
                $('#lesson-questionlist-list .forms-inputs .form-check input[name="answer"]:checked').each(function(){
                    updatequestionanswer($(this).data('question'),$(this).val());
                })
            }else if($('#lesson-questionlist-list .forms-inputs input[name="answer"]').length>0){
                $('#lesson-questionlist-list .forms-inputs input[name="answer"]').each(function(){
                    var qnswr=$(this).val()||""; 
                    if(qnswr!=""){ 
                        updatequestionanswer($(this).data('question'),$(this).val());
                    }
                })
            }
            updateprogress(callback) 
         }
          
         $(function(){ 
            @if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-complete-review',"no")=="pending")
            loadlessonreview()
            @else
            loadlesson(progressurl)
            @endif  
            $('.lesson-left button.left-btn,.lesson-right button.right-btn').click(function(){   
                const pageurl=$(this).data('pageurl');  
                updateandsave(function(){
                    loadlesson(pageurl)
                })
            });  

            $('.lesson-finish button.finish-btn').click(function(){  
                var unfinishcount=totalcount-questionids.length;
                console.log(unfinishcount)
                if(unfinishcount>0){
                    $('.unfinish-message').show().find('.unfinish-count').text(unfinishcount)
                }else{
                    $('.unfinish-message').hide().find('.unfinish-count').text(0)
                }  
                updateandsave(function(){
                    $('#finish-exam-confirm').modal('show')
                })
            }); 
         })
    </script>
@endpush