@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container">
    <div class="container-wrap">
        <div class="lesson">
            <div class="lesson-title">
                <h3><span>{{$exam->subtitle($category->id,"Module ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
            </div>
            <div class="lesson-body"> 
                <div class="row" id="lesson-questionlist-list" style="display: none">
                </div>
            </div>
            <div class="lesson-footer">
                <div class="lesson-pagination">
                    <div class="lesson-left pagination-arrow" style="display: none" >
                        <button class="left-btn"><img src="{{asset('assets/images/leftarrow.svg')}}" alt="<"> Back </button>
                    </div>
                    <div class="lesson-right pagination-arrow" style="display:none">
                        <button class="right-btn"> Next <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
                    </div>
                </div>
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
            $.get(pageurl||"{{ route('learn.lesson.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                const lesseonId=generateRandomId(10); 
                $.each(res.data,function(k,v){
                    if(v.learn_type=="video"){
                        var vimeoid = `${v.video_url}`; 
                        if (vimeoid.includes('vimeo.com')) {
                            vimeoid =getVimeoId(vimeoid);
                        }
                        var hash_parameter=
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="video-row" >
                                    <div class="video-title">
                                        <span>${v.title}</span>
                                    </div>
                                    <div class="video-container">
                                        <div id="vimo-videoframe-${lesseonId}">
                                            <iframe src="https://player.vimeo.com/video/${vimeoid}?h=${lesseonId}" width="100%" height="500" frameborder="0" title="${v.title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                    }
                    if(v.learn_type=="notes"){
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="note-row" >
                                    <div class="note-title">
                                        <span>${v.title}</span>
                                    </div>
                                    <div class="note-container">
                                        <div id="note-${lesseonId}">
                                            ${v.short_question}
                                        </div>
                                        <div id="note-${lesseonId}-ans" class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4"> 
                                                    <input type="text" name="answer" id="user-answer-${lesseonId}" value="" class="form-control" placeholder="Write your answer hear" aria-placeholder="Write your answer hear" >        
                                                    <div class="invalid-feedback" id="error-answer-field" >The field is required</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                    }
                    if(v.learn_type=="mcq"){
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="mcq-row" >
                                    <div class="mcq-title">
                                        <span>${v.title}</span>
                                    </div>
                                    <div class="mcq-container">
                                        <div id="mcq-${lesseonId}">
                                            ${v.mcq_question}
                                        </div>
                                        <div id="mcq-${lesseonId}-ans" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        $.get(pageurl||"{{ route('learn.lesson.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug]) }}",{question:v.slug},function(ans){
                            $(`#mcq-${lesseonId}-list`).html('')
                            $.each(ans,function(ai,av){
                                $(`#mcq-${lesseonId}-list`).append(`
                                    <div clas="form-check">
                                        <input type="radio" name="answer" id="user-answer-${lesseonId}-ans-item-${ai}" value="${v.slug}" class="form-check-input"  >        
                                        <label for="user-answer-${lesseonId}-ans-item-${ai}" >${av.title}</label>
                                    </div>  
                                `)
                            })
                        },'json').fail(function(xhr,status,error){
                            showToast("Error: " + error, 'danger'); 
                        })
                    }
                }) 
                if(res.next_page_url){ 
                    $('.lesson-right').show().find('button.right-btn').data('pageurl',res.next_page_url);
                }
                if(res.prev_page_url){
                    $('.lesson-left').show().find('button.left-btn').data('pageurl',res.prev_page_url);
                } 
                

            },'json').fail(function(xhr,status,error){
                showToast("Error: " + error, 'danger'); 
            })
         }
         $(function(){
            loadlesson()
            $('.lesson-left button.left-btn,.lesson-right button.right-btn').click(function(){ 
                loadlesson($(this).data('pageurl'))
            });
         })
    </script>
@endpush