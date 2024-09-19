@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Topic ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container">
    <div class="container-wrap mcq-container-wrap topic-test-review">
        <div class="lesson">            
            <a class="lesson-exit float-start" href="{{route('topic-test.index')}}">
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a> 
            <div class="lesson-body"> 
                <div class="row" id="lesson-questionlist-list" style="display: none">
                </div>
            </div>
            <div class="lesson-footer" id="lesson-footer-pagination"> 
            </div>           
        </div>
    </div> 
</section> 
@endsection

@push('footer-script') 

<script>
        var useranswers=@json($useranswer);
        function generateRandomId(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }
        function loadlessonreview(reviewurl){ 
            $.get(reviewurl||"{{ route('topic-test.preview',$userExamReview->slug) }}",function(res){
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
                                    <div class="mcq-group">
                                        <h5><span>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h5>
                                        <div class="mcq-title-text" ${v.title_text?"":'style="display:none"'}>
                                            ${v.title_text}
                                        </div>
                                        <div id="mcq-${lesseonId}">
                                            ${v.note||""}
                                        </div>
                                    </div> 
                                    <div class="mcq-group-right">
                                        <div  class="mcq-description">
                                            ${v.sub_question}
                                        </div>
                                        <div id="mcq-${lesseonId}-ans" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                        <div id="mcq-${lesseonId}-explanation"> 
                                            <label>Correct Answer <span id="mcq-${lesseonId}-correct"></span></label>
                                            ${v.explanation||''}
                                        </div>

                                        <div id="mcq-${lesseonId}-ans-progress" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list-progress"> 
                                                    
                                                </div> 
                                            </div>
                                            <div>
                                                <p>You spent ${v.time_taken||0} seconds on this question. The average student spent ${v.total_user_taken_time||0} seconds on this question<p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).fadeIn();
                    $.get("{{ route('topic-test.preview',$userExamReview->slug) }}",{question:v.slug},function(ans){
                        $(`#mcq-${lesseonId}-list`).html('')
                        $(`#mcq-${lesseonId}-list-progress`).html('')
                        $.each(ans,function(ai,av){
                            const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))
                            $(`#mcq-${lesseonId}-list`).append(`
                            <div class="form-check-ans">
                                <span class="question-user-ans ${av.iscorrect?"correct":"wrong"}" data-ans="${av.slug}"></span>
                                <div class="form-check">
                                    <input type="radio" disabled name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input" ${av.user_answer?"checked":""}  >        
                                    <label for="user-answer-${lesseonId}-ans-item-${ai}" >${ letter }. ${av.title}</label>
                                </div>  
                            </div>
                            `)
                            $(`#mcq-${lesseonId}-list-progress`).append(`
                                <div class="form-progress-ans ans-${av.iscorrect?"select":"no-select"}"> 
                                    <div class="form-progress">       
                                        <label for="user-answer-${lesseonId}-ans-progress-item-${ai}" >${ letter }</label>
                                        <progress id="user-answer-${lesseonId}-ans-progress-item-${ai}" max="100" value="${av.total_user_answered||0}"/>
                                    </div>  
                                </div>
                            `)
                            if(av.iscorrect){
                                $(`#mcq-${lesseonId}-correct`).text(`: ${ letter } `)
                            }
                        }) 
                    },'json')
                     
                }) 
                if(res.total>1){
                     $.each(res.links,function(k,v){
                        let linkstatus="";
                        if(k!=0&&k!=res.links.length&&useranswers[k-1]){
                            linkstatus='status-bad';
                            if(useranswers[k-1].iscorrect){
                                linkstatus="status-good";
                                if(useranswers[k-1].time_taken<{{$examtime}}){
                                    linkstatus="status-exelent";
                                }
                            }
                        }
                        if(v.active||!v.url){
                            $('#lesson-footer-pagination').append(`
                                <button class="${linkstatus} btn btn-secondary ${v.active?"active":""}" disabled  >${v.label}</button>
                            `)
                        }else{
                            $('#lesson-footer-pagination').append(`
                                <button class="${linkstatus} btn btn-secondary" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
                            `)
                        }
                     })
                }
 
                $('.lesson-end').show();
            },'json')

         }

         $(function(){
            loadlessonreview()
         })

</script>

@endpush