@extends('layouts.exam')
@section('title', $homeWorkBook->title)
@section('content')
<section class="exam-container">
    <div class="container-wrap">
        <div class="lesson">            
            <a class="lesson-exit float-start" href="{{route('home-work.show',$homeWork->slug)}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a>
            <div class="lesson-title">
                <h5><span>{{$homeWorkBook->title}}</span></h5>
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
            $.get(reviewurl||"{{ route('home-work.preview',$homeWorkReview->slug) }}",function(res){
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
                                        ${v.explanation||''}
                                    </div> 
                                </div>
                            </div>
                        </div>
                    `).fadeIn();
                    $.get("{{ route('home-work.preview',$homeWorkReview->slug) }}",{question:v.slug},function(ans){
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
                            // $(`#mcq-${lesseonId}-list-progress`).append(`
                            //     <div class="form-progress-ans ans-${av.iscorrect?"select":"no-select"}"> 
                            //         <div class="form-progress">       
                            //             <label for="user-answer-${lesseonId}-ans-progress-item-${ai}" >${ letter }</label>
                            //             <progress id="user-answer-${lesseonId}-ans-progress-item-${ai}" max="100" value="${av.total_user_answered||0}"/>
                            //         </div>  
                            //     </div>
                            // `)
                            if(av.iscorrect){
                                $(`#mcq-${lesseonId}-correct`).text(`: ${ letter } `)
                            }
                        }) 
                    },'json')
                     
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

         $(function(){
            loadlessonreview()
         })

</script>

@endpush