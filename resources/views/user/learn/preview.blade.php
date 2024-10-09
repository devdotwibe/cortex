@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container">
    <div class="container-wrap">
        <div class="lesson">            
            <a class="lesson-exit float-start" href="{{route('learn.show',$category->slug)}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a>
            <div class="lesson-title">
                <h5><span>{{$exam->subtitle($category->id,"Module ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h5>
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
@endsection

@push('footer-script') 

<script>
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
            $.get(reviewurl||"{{ route('learn.preview',$userExamReview->slug) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                const lesseonId=generateRandomId(10); 
                $.each(res.data,function(k,v){ 
                    if(v.review_type=="short_notes"){
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="note-row" >
                                    <div class="note-title">
                                        <span>${v.title||""}</span>
                                    </div>
                                    <div class="note-container">
                                        <div id="note-${lesseonId}">
                                            ${v.note||""}
                                        </div>
                                        <div id="note-${lesseonId}-ans" class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4"> 
                                                    <input type="text" readonly name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}" value="${v.user_answer}" class="form-control" placeholder="Write your answer hear" aria-placeholder="Write your answer hear" >        
                                                    <div class="invalid-feedback" id="error-answer-field" >The field is required</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="note-currect" id="note-${lesseonId}-answer"> 
                                            <label>Correct Answer </label>
                                            ${v.currect_answer}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();  
                    }
                    if(v.review_type=="mcq"){ 
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="mcq-row" >
                                    <div class="mcq-title">
                                        <span>${v.title||""}</span>
                                    </div>
                                    <div class="mcq-container">
                                        <div id="mcq-${lesseonId}">
                                            ${v.note||""}
                                        </div>
                                        <div id="mcq-${lesseonId}-ans" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                        <div id="mcq-${lesseonId}-explanation"> 
                                            <label>Correct Answer <span id="mcq-${lesseonId}-correct"></span></label>
                                            ${v.explanation}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        $(`#mcq-${lesseonId}-list`).html('')
                        $.get("{{ route('question-bank.preview',$userExamReview->slug) }}",{question:v.slug},function(ans){
                            $(`#mcq-${lesseonId}-list`).html('')
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
                                if(av.iscorrect){
                                    $(`#mcq-${lesseonId}-correct`).text(`: ${ letter } `)
                                }
                            }) 
                        },'json')
                    }
                }) 
                if (res.total > 1) {
            $.each(res.links, function(k, v) {
                        if(v.active||!v.url){
                            $('#lesson-footer-pagination').append(`
                                <button class="btn btn-secondary  ${linkstatus} ${v.active?"active":""}" disabled  >${v.label}</button>
                            `)
                        }else{
                            $('#lesson-footer-pagination').append(`
                                <button class="btn btn-secondary ${linkstatus}" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
                            `)
                        }
                     })
                } 
            },'json')

         }

         $(function(){
            loadlessonreview()
         })

</script>

@endpush