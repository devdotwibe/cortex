@extends('layouts.exam')
@section('headerclass','header-class')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container questionclass answerclass">

    <div class="exam-progress quest-progress">
        <div class="exam-progress-inner">
            <div class="exam-progress-inner-item exam-left">
                <div class="progress-main">

                    <div class="exam-exit ">
                        <a   href="{{route('learn.show',$category->slug)}}"   title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                            <img src="{{asset("assets/images/exiticon-wht.svg")}}" alt="exiticon">
                        </a>
                    </div>

                    {{-- <div class="question-number">
                        <span>Question: </span>
                    </div> --}}
    
                   

                    
                </div>
            </div>
           
            <div class="question-header question-number">
                <div class="progress-menus">
                    <div class="menu-text">
                        <span id="menu-text" >Question <span> 0 </span>   <span>0 </span> </span>
                      
                    </div>
                    <div class="menu-icon"> 
                        <a onclick="toglepreviewpage()" >
                            {{-- <img src="{{asset("assets/images/menu.svg")}}" alt="exiticon"> --}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="Review-mode">
                <span>Review Mode: </span>
            </div>
           
        </div>
        
    </div>
    <div class="container-wrap">
        <div class="lesson">            
            {{-- <a class="lesson-exit float-start" href="{{route('learn.show',$category->slug)}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a> --}}
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

<section class="exam-footer"> 
    <div class="lesson-pagination">
        <div class="lesson-left pagination-arrow" style="display: none" >
            <button class="button left-btn"><img src="{{asset('assets/images/leftarrow.svg')}}" alt="<"> Back </button>
        </div>


        <div class="exam-right exam-progress-inner-item">

            <div class="progress-main">

                
                {{-- <div class="bookmark">
                    
                    <a class="" id="bookmark-current" >
                        
                        <span id="flagtext" class="flagclass">Flag</span>
                        <span id="flagimages" class="flagclass" >
                        <img class="active-img" src="{{asset("assets/images/flag-blue.svg")}}" alt="bookmark">
                    
                        <img class="inactive-img" src="{{asset("assets/images/flag-red.svg")}}" alt="bookmark">
                        </span>
                    </a>
                </div> --}}
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
                let linkstatus="";
                console.log(res.links.length);
                        if(k!=0&&k!=res.links.length&&useranswers[k-1]){
                            linkstatus='status-bad';
                            console.log(res.data.review_type,'yuyuyuy');

                            if (res.data.review_type == 'short_notes') {
                            // If the review type is 'short_notes', assign 'status-grey'
                            linkstatus = "status-grey";
                        } 
                            if(useranswers[k-1].iscorrect){

                            
                                linkstatus="status-good";


                                
                            }

                            
                        }
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


                
                $('.lesson-end').show();


                if (res.next_page_url) { 
    $('.lesson-right').show()
        .find('button.right-btn')
        .data('pageurl', res.next_page_url)
        .attr('onclick', `loadlessonreview('${res.next_page_url}')`); // Adding onclick event
} else {
    $('.lesson-finish').show();
}

if (res.prev_page_url) {
    $('.lesson-left').show()
        .find('button.left-btn')
        .data('pageurl', res.prev_page_url)
        .attr('onclick', `loadlessonreview('${res.prev_page_url}')`); // Adding onclick event
}

$('#menu-text').html(`Question <span> ${res.current_page} </span> `)

            },'json')


           

         }



         $(function(){
            loadlessonreview()
         })

         function toglepreviewpage(){
            // timerActive=!timerActive; 
            $('#question-preview-page').slideToggle()
            $('#question-answer-page').fadeToggle()
        }

</script>


@endpush