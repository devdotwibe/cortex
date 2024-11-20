@extends('layouts.exam')
@section('headerclass', 'header-class')
@section('title', $exam->subtitle($category->id, 'Topic ' . ($category->getIdx() + 1)) . ':' . $category->name)
@section('content')

    <section class="exam-container questionclass answerclass ">
        <div class="exam-progress quest-progress">
            <div class="exam-progress-inner">
                <div class="exam-progress-inner-item exam-left">
                    <div class="progress-main">

                        <div class="exam-exit ">
                            <a href="{{ route('question-bank.show', $category->slug) }}" title="Exit" data-title="Exit"
                                aria-label="Exit" data-toggle="tooltip">
                                <img src="{{ asset('assets/images/exiticon-wht.svg') }}" alt="exiticon">
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
                            <span id="menu-text">Question <span> 0 </span> <span>0 </span> </span>

                        </div>

                    </div>
                </div>


                <div class="menu-icon modecolor">
                    <a onclick="toglepreviewpage()">
                        <img src="{{ asset('assets/images/menu.svg') }}" alt="exiticon">
                    </a>
                </div>

                <div class="Review-mode">
                    <span>Review Mode </span>
                </div>

            </div>

        </div>



        {{-- <div class="container-wrap mcq-container-wrap question-bank-review">
            <div class="lesson">

                <div class="lesson-body">
                    <div class="row" id="lesson-questionlist-list" style="display: none">
                    </div>
                </div>
                <div class="lesson-footer" id="lesson-footer-pagination">
                </div>
            </div>
        </div> --}}

    </section>

    <section class="exam-footer">
        <div class="lesson-pagination">
            <div class="lesson-left pagination-arrow" style="display: none">
                <button class="button left-btn"><img src="{{ asset('assets/images/leftarrow.svg') }}" alt="<"> Previous
                </button>
            </div>
            {{-- <div class="lesson-left">
                <a href="{{ route('question-bank.set.complete', $userExamReview->slug) }}" class="button left-btn"
                    title="Back">
                    <img src="{{ asset('assets/images/leftarrow.svg') }}" alt="<"> Back
                </a>
            </div> --}}
            <div class="exam-right exam-progress-inner-item">
                <div class="progress-main">
                </div>
            </div>


    
            <div class="lesson-right pagination-arrow" style="display:none">
                <button class="button right-btn"> Next <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
            </div>
            <div class="lesson-finish pagination-arrow" style="display:none">
                <button class="button finish-btn" onclick="window.location.href='{{ route('question-bank.show', $category->slug) }}'"> Finish Set <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
            </div> 
            {{-- <div class="finish-btn">
                <a href="" class="button right-btn" title="Next">
                    Finish Set <img src="{{ asset('assets/images/rightarrow.svg') }}" alt=">">
                </a>
            </div> --}}


        </div>
    </section>


    <section class="modal-expand" id="question-preview-page" style="display: none;">
        <div class="container-wrap">

            <div class="question-preview-title">
                <h3>Review Summary</h3>
            </div>
            <div class="question-preview-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs question-tab" id="questionPreviewTab" role="tablist">
                            <li class="nav-item" role="presentation"> 
                                <button class="nav-link active" id="show-all-tab" data-bs-toggle="tab" data-bs-target="#show-all" type="button" role="tab" aria-controls="show-all" aria-selected="true"><div class="nav-status status-active"><img src="{{asset('assets/images/showall.svg')}}" alt="all"><span></span></div> Show All</button>
                            </li>
                            {{-- <li class="nav-item" role="presentation"> 
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
                            </li> --}}
                        </ul>
                        <div class="tab-content" id="questionPreviewTabContent">
                            <div class="tab-pane fade show active" id="show-all" role="tabpanel" aria-labelledby="show-all-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                        {{-- <div class="tabbody">
                                            <div class="question-list">
                                                @for ($i = 1; $i <= ($questioncount??0); $i++)
                                                    <div class="question-item" data-idx="{{$i}}">
                                                        <button class="item-group" onclick="updateandsave(function(){loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'user_exam'=>$slug,'page'=>$i]) }}');})">
                                                            <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                            <span>{{$i}}</span> 
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="answered" role="tabpanel" aria-labelledby="answered-tab">
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
                                                        <button class="item-group" onclick="updateandsave(function(){loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'user_exam'=>$slug,'page'=>$i]) }}');})">
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
                                                        <button class="item-group" onclick="updateandsave(function(){loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'user_exam'=>$slug,'page'=>$i]) }}');})">
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
                                                        <button class="item-group" onclick="updateandsave(function(){loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'user_exam'=>$slug,'page'=>$i]) }}');})">
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
                                                        <button class="item-group" onclick="updateandsave(function(){loadlesson('{{ route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug,'user_exam'=>$slug,'page'=>$i]) }}');})">
                                                             
                                                                <img src="{{asset('assets/images/flaged.svg')}}" alt="all">
                                                                <span>{{$i}}</span>
                                                             
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="lesson-footer" id="lesson-footer-paginationmobile">                
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    <script>
        var useranswers = @json($useranswer);

        console.log(useranswers);
        
        var timelist = @json(json_decode($user->progress('exam-reviewed-' . $userExamReview->id . '-times', '[]')));

        function generateRandomId(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }

        function loadlessonreview(reviewurl) {
            $.get(reviewurl || "{{ route('question-bank.preview', $userExamReview->slug) }}", function(res) {
                $('.pagination-arrow').hide();
                $('#lesson-footer-pagination').html('')
                $('#lesson-footer-paginationmobile').html('')

                $('#question-preview-page').fadeOut()
                $('#question-answer-page').fadeIn()

                const lesseonId = generateRandomId(10);


                $.each(res.data, function(k, v) {
                    $('#lesson-questionlist-list').html(`
                        <div class="col-md-12">
                            <div class="mcq-row" >
                                <div class="mcq-title">
                                    <span>${v.title||""}</span>
                                </div>
                                <div class="mcq-container">
                                    <div class="mcq-group">
                                     
                                        <div class="mcq-title-text" ${v.title_text?"":'style="display:none"'}>
                                            <p>${v.title_text||""}</p>
                                        </div>
                                        <div id="mcq-${lesseonId}">
                                          <p>  ${v.note||""}</p>
                                        </div>
                                    </div>
                                    <div class="mcq-answer mcq-group-right">
                                        <div  class="mcq-description">
                                           <p> ${v.sub_question||""}</p>
                                        </div>
                                        <div id="mcq-${lesseonId}-ans" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                        <div id="mcq-${lesseonId}-explanation" class="mcq-explanation"> 
                                            <label>Correct Answer <span id="mcq-${lesseonId}-correct"></span></label>
                                          
                                        </div>
                                         <p>${v.explanation||''}</p>
                                        <div id="mcq-${lesseonId}-ans-progress" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list-progress"> 
                                                    
                                                </div> 
                                            </div>
                                            <div>
                                                <p>You spent <strong>${v.time_taken||0} seconds</strong> on this question. The average student spent <strong>${v.total_user_taken_time||0} seconds</strong> on this question<p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    `).fadeIn();

                    $.get("{{ route('question-bank.preview', $userExamReview->slug) }}", {
                        question: v.slug
                    }, function(ans) {
                        $(`#mcq-${lesseonId}-list`).html('')
                        $(`#mcq-${lesseonId}-list-progress`).html('')
                        const baseUrl = `{{ asset('d0') }}`;
                        $.each(ans, function(ai, av) {
                            const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))
                            const imageHtml = av && av.image ?
                                `<img src="${baseUrl}/${av.image}" class="answer-image" />` :
                                '';
                            $(`#mcq-${lesseonId}-list`).append(`
                            <div class="form-check-ans">
                                <span class="question-user-ans ${av.iscorrect?"correct":"wrong"}" data-ans="${av.slug}"></span>
                                <div class="form-check">
                                    <input type="radio" disabled name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input" ${av.user_answer?"checked":""}  >        
                                    <label for="user-answer-${lesseonId}-ans-item-${ai}" >${ letter }. ${av.title || ''}</label>
                                    ${imageHtml}
                                </div>  
                            </div>
                            `)
                            $(`#mcq-${lesseonId}-list-progress`).append(`
                                <div class="form-progress-ans ans-${av.iscorrect?"select":"no-select"}"> 
                                    <div class="form-progress">       
                                        <label for="user-answer-${lesseonId}-ans-progress-item-${ai}" >${ letter }</label>
                                        <progress id="user-answer-${lesseonId}-ans-progress-item-${ai}" max="100" value="${av.total_user_answered||0}"></progress> <span>${((av.total_user_answered||0)*1).toFixed(2)}%</span>
                                    </div>  
                                </div>
                            `)
                            if (av.iscorrect) {
                                $(`#mcq-${lesseonId}-correct`).text(`: ${ letter } `)
                            }
                        })
                    }, 'json')

                })


                // if (res.total > 1) {
                //     $.each(res.links, function(k, v) {
                //         let linkstatus = 'status-bad mob-view';
                //         if (k != 0 && k != res.links.length && useranswers[k - 1]) {
                //             linkstatus = 'status-bad mob-view';
                //             if (useranswers[k - 1].iscorrect) {


                //                 linkstatus = "status-good mob-view";


                //                 if (useranswers[k - 1].time_taken < {{ $examtime }}) {
                //                     linkstatus = "status-exelent mob-view";
                //                 }
                //             }
                //         }
                //         // if (v.active || !v.url) {

                //         //     var label_name = v.label;

                //         //     if (v.label == '« Previous') {
                //         //         var label_name = "<";
                //         //     }
                //         //     $('#lesson-footer-pagination').append(`
                //     //         <button class="${linkstatus} btn btn-secondary ${v.active?"active":""}" disabled  >${label_name}</button>
                //     //     `)
                //         // } else {
                //         //     $('#lesson-footer-pagination').append(`
                //     //         <button class="${linkstatus} btn btn-secondary" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
                //     //     `)
                //         // }
                //         if (v.active || !v.url) {

                //             var preclass = "";
                //             if (k == 0 || k == res.links.length) {
                //                 preclass = "prevnxtclass";
                //             }
                //             $('#lesson-footer-pagination').append(`
                //                 <button class="${linkstatus} btn btn-secondary  ${preclass} ${v.active?"active":""}" disabled  >${v.label} </button>
                //             `)
                //         } else {
                //             var preclass = "";
                //             if (k == 0 || k == res.links.length - 1) {
                //                 preclass = "prevnxtclass";
                //             }

                //             $('#lesson-footer-pagination').append(`
                //                 <button class="${linkstatus} btn btn-secondary ${preclass}" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
                //             `)
                //         }
                //     })
                // }

                console.log(res.total);
                
                if (res.total > 1) {

                    var total_time = "{{ $examtime }}";

                    $.each(res.links, function(k, v) {

                        let linkstatus =  'status-bad';
                        
                        if (k != 0 && k != res.links.length ) {

                            $.each(useranswers, function(i, j) {

                                if(v.ans_id == j.id)
                                {
                                    linkstatus = 'status-bad';
                                    if (j.iscorrect) {
                                        linkstatus = "status-good";
                                        if (j.time_taken < {{ $examtime }}) {
                                            linkstatus = "status-exelent";
                                        }
                                    } 
                                }
                            });
                           
                    
                        }
                        
                        if (v.active || !v.url) {
                            var label_name = v.label;
                            if (v.label == '« Previous') {
                                var label_name = "<";
                            }
                            var preclass = "";
                            if (k == 0) {
                                preclass = "preclass";
                            }
                            $('#lesson-footer-paginationmobile').append(`
                                <button class="${linkstatus} btn btn-secondary  ${preclass} ${v.active?"active":""}" disabled   >${label_name}</button>
                            `)
                        } else {
                            $('#lesson-footer-paginationmobile').append(`
                                <button class="${linkstatus} btn btn-secondary  ${total_time}" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
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
                        $('.lesson-finish').hide();
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

            }, 'json')

        }

        $(function() {
            loadlessonreview()
            $('.lesson-left button.left-btn,.lesson-right button.right-btn').click(function() {
                const pageurl = $(this).data();

                loadlessonreview(pageurl)
            });
        })

        function toglepreviewpage() {
            // timerActive=!timerActive; 
            $('#question-preview-page').slideToggle()
            $('#question-answer-page').fadeToggle()
        }
    </script>
@endpush
