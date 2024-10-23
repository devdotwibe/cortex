@extends('layouts.exam')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="exam-container" id="exam-container">
    <div class="container-wrap">
        <div class="lesson">
            <a class="lesson-exit float-start" href="{{route('learn.show',$category->slug)}}" title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip" >
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
<section class="exam-footer examclass criticalclass">
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
            <a class="button end-btn" href="{{route('learn.lesson.submit',['category'=>$category->slug,'sub_category'=>$subCategory->slug])}}" > End Review <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></a>
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


    {{-- <script src="https://player.vimeo.com/api/player.js"></script> --}}
    <script src="{{asset("assets/js/player.js")}}"></script>
    <script>
        var currentprogress={{$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id,0)}};
        var totalcount={{$learncount??0}};
        var questionids={!! $user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id."-progress-ids",'[]') !!};
        var progressurl="{{$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-progress-url','')}}";
        var examPlayers={}; 
        var vimeotime=0;
        var vimeoinput=null;
        var vimeoplay=false;
        let isVideoType = false;

        function learntimer(){
            if(vimeotime>0&&vimeoinput!=null&&vimeoplay){
                if(vimeotime>10){
                    $(`#${vimeoinput}`).val('N')
                }else{
                    $(`#${vimeoinput}`).val('Y')
                }
                vimeotime--;
            }
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
         function loadlesson(pageurl=null){
            $.get(pageurl||"{{ route('learn.lesson.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                $('#exam-container').removeClass('exam-video')
                vimeoinput=null;
                vimeotime=0;
                vimeoplay=false;
                const lesseonId=generateRandomId(10);
                $.each(res.data,function(k,v){
                    if(v.learn_type=="video"){
                        var vimeoid = `${v.video_url}`;
                        if (vimeoid.includes('vimeo.com')) {
                            vimeoid =getVimeoId(vimeoid);
                        }
                        // var hash_parameter=.
                        $('#exam-container').addClass('exam-video')
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="video-row video-box" >
                                    <div class="video-title">
                                        <span>${v.title}</span>
                                    </div>
                                    <div class="video-container">
                                        <div class="videoframe" id="vimo-videoframe-${lesseonId}">
                                            
                                        </div>
                                        <div class="forms-inputs">
                                            <input type="hidden" name="answer" data-question="${v.slug}" value="N"  id="user-answer-${lesseonId}-vimo" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        examPlayers[v.slug]=new Vimeo.Player(`vimo-videoframe-${lesseonId}`,{
                            id: vimeoid,
                            width: "100%",
                            controls: true
                        });
                        vimeoinput=`user-answer-${lesseonId}-vimo`;
                        examPlayers[v.slug].getDuration().then(function(duration) { 
                            vimeotime=duration; 
                        }); 
                        examPlayers[v.slug].on('play', function() { 
                            vimeoplay=true;
                        });
                        examPlayers[v.slug].on('pause', function() { 
                            vimeoplay=false;
                        });
                        /* {{-- <iframe src="https://player.vimeo.com/video/${vimeoid}?byline=0&keyboard=0&dnt=1&app_id=${lesseonId}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="${v.title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> --}} */
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
                                            ${v.note}
                                        </div>
                                        <div class="forms-inputs">
                                            <input type="hidden" name="answer" data-question="${v.slug}" value="Y"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                    }
                    if(v.learn_type=="short_notes"){
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
                                                    <input type="text" name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}" value="" class="form-control" placeholder="Write your answer hear" aria-placeholder="Write your answer hear" autocomplete="off" >
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
                        })
                    }
                    if(v.learn_type=="mcq"){
                        isVideoType = true;
                        $('#lesson-questionlist-list').html(`
                            <div class="col-md-12">
                                <div class="note-row" >
                                    <div class="note-title">
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
                                const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))
                                $(`#mcq-${lesseonId}-list`).append(`
                                    <div class="form-check">
                                        <input type="radio" name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input"  >
                                        <label for="user-answer-${lesseonId}-ans-item-${ai}" >${ letter }. ${av.title}</label>
                                    </div>
                                `)
                            })
                            refreshquestionanswer(v.slug,function(data){
                                $(`#mcq-${lesseonId}-list input[value="${data.value}"]`).prop("checked",true)
                            })
                        },'json').fail(function(xhr,status,error){
                            showToast("Error: " + error, 'danger');
                        })
                    }
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
                    name:"exam-{{$exam->id}}-module-{{$category->id}}-lesson-{{$subCategory->id}}-progress-url",
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
                        name:"exam-{{$exam->id}}-module-{{$category->id}}-lesson-{{$subCategory->id}}-progress-ids",
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
                        name:"exam-{{$exam->id}}-module-{{$category->id}}-lesson-{{$subCategory->id}}",
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
                    name:"exam-{{$exam->id}}-module-{{$category->id}}-lesson-{{$subCategory->id}}-answer-of-"+question,
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
                    name:"exam-{{$exam->id}}-module-{{$category->id}}-lesson-{{$subCategory->id}}-answer-of-"+question,
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
            $.get(reviewurl||"{{ route('learn.lesson.review',['category'=>$category->slug,'sub_category'=>$subCategory->slug]) }}",function(res){
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                const lesseonId=generateRandomId(10);
                $.each(res.data,function(k,v){
                    if(v.learn_type=="short_notes"){
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
                                                    <input type="text" readonly name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}" value="" class="form-control" placeholder="Write your answer hear" aria-placeholder="Write your answer hear" >
                                                    <div class="invalid-feedback" id="error-answer-field" >The field is required</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="note-currect" id="note-${lesseonId}-answer">
                                            <label>Correct Answer </label>
                                            ${v.short_answer}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        refreshquestionanswer(v.slug,function(data){
                            $(`#note-${lesseonId}-ans input[name="answer"]`).val(data.value);
                        })
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
                                        <div id="mcq-${lesseonId}-explanation">
                                            <label>Correct Answer <span id="mcq-${lesseonId}-correct"></span></label>
                                            ${v.explanation}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).fadeIn();
                        $(`#mcq-${lesseonId}-list`).html('')
                        $.each(v.learnanswers,function(ai,av){
                            const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))
                            $(`#mcq-${lesseonId}-list`).append(`
                            <div class="form-check-ans">
                                <span class="question-user-ans ${av.iscorrect?"correct":"wrong"}" data-ans="${av.slug}"></span>
                                <div class="form-check">
                                    <input type="radio" disabled name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input"    >
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
                    }
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
                    name:"exam-{{$exam->id}}-module-{{$category->id}}-lesson-{{$subCategory->id}}-complete-review",
                    value:'pending'
                }),
            });

            if (isVideoType) {
                window.location.href="{{route('learn.lesson.submit',['category'=>$category->slug,'sub_category'=>$subCategory->slug])}}";
            } else {
                window.location.href="{{route('learn.show',$category->slug)}}";
            }
            // loadlessonreview()
         }

         $(function(){
            @if($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-review',"no")=="pending")
            loadlessonreview()
            @else
            loadlesson(progressurl)
            @endif
            $('.lesson-left button.left-btn,.lesson-right button.right-btn').click(function(){
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
                const pageurl=$(this).data('pageurl');
                updateprogress(function(){
                    loadlesson(pageurl)
                })
            });

            $('.lesson-finish button.finish-btn').click(function(){
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

                var unfinishcount=totalcount-questionids.length;
                console.log(unfinishcount)
                if(unfinishcount>0){
                    $('.unfinish-message').show().find('.unfinish-count').text(unfinishcount)
                }else{
                    $('.unfinish-message').hide().find('.unfinish-count').text(0)
                }
                updateprogress(function(){
                    $('#finish-exam-confirm').modal('show')
                })
            });

            setInterval(learntimer, 1000);
         })
    </script>
@endpush
