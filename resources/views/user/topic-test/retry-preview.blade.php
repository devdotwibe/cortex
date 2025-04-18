@extends('layouts.exam')
@section('headerclass', 'header-class')
@section('title', $exam->subtitle($category->id, 'Topic ' . ($category->getIdx() + 1)) . ':' . $category->name)
@section('content')
    <section class="exam-container questionclass answerclass ">
        <div class="exam-progress quest-progress">
            <div class="exam-progress-inner">
                <div class="exam-progress-inner-item exam-left">
                    <div class="progress-main">
                         <!-- FontAwesome CSS -->
                     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                     <style>
                         #zoom-controls {
                             position: fixed;
                             top: 20px;
                             left: 20px;
                             z-index: 999;
                         }

                         #zoom-controls i {
                             color: #555;
                             transition: color 0.3s;
                         }

                         #zoom-controls i:hover {
                             color: #000;
                         }

                         #zoom-dropdown li:hover {
                             background-color: #f0f0f0;
                             color: #333;
                         }

                     </style>
                     <div id="zoom-controls" style="position: fixed; top: 20px; left: 20px; z-index: 999;">
                         <!-- Magnifier Icon -->
                         <div id="magnifier-icon" style="cursor: pointer; display: inline-block;">
                             <i class="fas fa-search-plus" style="font-size: 24px; color: #333;"></i>
                         </div>
                     
                         <!-- Hidden Dropdown for Zoom Options -->
                         <div id="zoom-dropdown" style="
                             display: none;
                             position: absolute;
                             top: 30px;
                             left: 0;
                             background-color: #f9f9f9;
                             border: 1px solid #ddd;
                             border-radius: 5px;
                             box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
                         ">
                             <ul style="list-style: none; margin: 0; padding: 10px;">
                                <li class="zoom-option" data-zoom="100" style="padding: 5px 10px; cursor: pointer;">100%</li>
                                <li class="zoom-option" data-zoom="140" style="padding: 5px 10px; cursor: pointer;">150%</li>
                                <li class="zoom-option" data-zoom="185" style="padding: 5px 10px; cursor: pointer;">200%</li>
                                <li class="zoom-option" data-zoom="280" style="padding: 5px 10px; cursor: pointer;">300%</li>
                             </ul>
                         </div>
                     </div>
                     <script>
                        document.addEventListener("DOMContentLoaded", function () {
                        const magnifierIcon = document.getElementById("magnifier-icon");
                        const zoomDropdown = document.getElementById("zoom-dropdown");
                        const zoomOptions = document.querySelectorAll(".zoom-option");

                        // Show/hide the zoom dropdown when the icon is clicked
                        magnifierIcon.addEventListener("click", function () {
                            zoomDropdown.style.display = zoomDropdown.style.display === "block" ? "none" : "block";
                        });

                        // Handle zoom option clicks
                        zoomOptions.forEach(option => {
                            option.addEventListener("click", function () {
                                const zoomLevel = this.getAttribute("data-zoom");

                                // Apply zoom to the body
                                document.body.style.zoom = `${zoomLevel}%`;

                                // Hide the dropdown after selection
                                zoomDropdown.style.display = "none";
                            });
                        });

                        // Hide dropdown if clicked outside
                        document.addEventListener("click", function (event) {
                                if (!event.target.closest("#zoom-controls")) {
                                    zoomDropdown.style.display = "none";
                                }
                            });
                        });

                     </script>
                        <div class="exam-exit ">
                            <a href="{{ route('topic-test.index', ['page' => 'back', 'slug' => $userExamReview->slug, 'category' => $category->slug]) }}"
                                title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                                <img src="{{ asset('assets/images/exiticon-wht.svg') }}" alt="exiticon">
                            </a>
                        </div>

                        {{-- <div class="question-number">
                        <span>Question: </span>
                    </div> --}}




                    </div>
                </div>

                <div class="exam-center exam-progress-inner-item">
                    <div class="progress-menu">
                        <div class="menu-text">
                            <span id="menu-text" >Question <span> 0 </span>  of <span>0 </span> </span>

                        </div>
                        <div class="menu-icon">
                            <a onclick="toglepreviewpage()">
                                <img src="{{ asset('assets/images/menu.svg') }}" alt="exiticon">
                            </a>
                        </div>

                    </div>
                </div>
               
                <div class="Review-mode">
                    <span>Review Mode </span>
                </div>

            </div>

        </div>

        <div class="container-wrap mcq-container-wrap topic-test-review">
            <div class="lesson">
                {{-- <a class="lesson-exit float-start" href="{{route('topic-test.index',['page'=>'back','slug'=>$userExamReview->slug,'category'=>$category->slug])}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a>  --}}
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
                <button class="button left-btn"><img src="{{asset('assets/images/leftarrow.svg')}}" alt="<"> Previous </button>
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





            {{-- 
        <div class="lesson-right pagination-arrow" style="display:none">
            <button class="button right-btn"> Next <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
        </div>
        <div class="lesson-finish pagination-arrow" style="display:none">
            <button class="button finish-btn" onclick="window.location.href='{{ route('full-mock-exam.index') }}'"> Finish Set <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
        </div>  --}}



          <div class="lesson-right pagination-arrow" style="display:none">
                <button class="button right-btn"> Next <img src="{{asset('assets/images/rightarrow.svg')}}" alt=">"></button>
            </div>
            <div class="finish-btn" style="display:none">
                <a href="{{ route('topic-test.index', $category->slug) }}" class="button right-btn" title="Next">
                    Finish Set <img src="{{ asset('assets/images/rightarrow.svg') }}" alt=">">
                </a>
            </div>





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
                                <button class="nav-link active" id="show-all-tab" data-bs-toggle="tab"
                                    data-bs-target="#show-all" type="button" role="tab" aria-controls="show-all"
                                    aria-selected="true">
                                    <div class="nav-status status-active"><img
                                            src="{{ asset('assets/images/showall.svg') }}" alt="all"><span></span>
                                    </div> Show All
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="questionPreviewTabContent">
                            <div class="tab-pane fade show active" id="show-all" role="tabpanel"
                                aria-labelledby="show-all-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabheader">
                                            <h3>Questions</h3>
                                            <p>Click a number to go question</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            $.get(reviewurl ||
                "{{ route('topic-test.retry.preview', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $examRetryReview->slug]) }}",
                function(res) {
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
                                           ${v.title_text||""} 
                                        </div>
                                        <div id="mcq-${lesseonId}">
                                            ${v.note||""}
                                        </div>
                                    </div> 
                                    <div class="mcq-answer mcq-group-right">
                                        <div  class="mcq-description">
                                            ${v.sub_question||""} 
                                        </div>
                                        <div id="mcq-${lesseonId}-ans" class="form-group">
                                            <div class="form-data" >
                                                <div class="forms-inputs mb-4" id="mcq-${lesseonId}-list"> 
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                        <div id="mcq-${lesseonId}-explanation" class="correctanswerclass"> 
                                            <label>Correct Answer <span id="mcq-${lesseonId}-correct"></span></label>
                                          
                                        </div>
                                         <p>${v.explanation||''}</p>
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
                        $.get("{{ route('topic-test.retry.preview', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $examRetryReview->slug]) }}", {
                            question: v.slug
                        }, function(ans) {
                            $(`#mcq-${lesseonId}-list`).html('')
                            $(`#mcq-${lesseonId}-list-progress`).html('')
                            const baseUrl = `{{ asset('d0') }}`;
                            $.each(ans, function(ai, av) { console.log(av)
                                const letter = String.fromCharCode(ai + 'A'.charCodeAt(0))
                                const imageHtml = av && av.image ?
                                    `<img src="${baseUrl}/${av.image}" class="answer-image" />` :
                                    '';
                                $(`#mcq-${lesseonId}-list`).append(`
                            <div class="form-check-ans">
                                <span class="question-user-ans ${av.iscorrect?"correct":"wrong"}" data-ans="${av.slug}"></span>
                                <div class="form-check">
                                    <input type="radio" disabled name="answer" data-question="${v.slug}" id="user-answer-${lesseonId}-ans-item-${ai}" value="${av.slug}" class="form-check-input" ${av.user_answer?"checked":""}  >        
                                    <label for="user-answer-${lesseonId}-ans-item-${ai}" >${ letter }. ${av.title ||""}</label>
                                    ${imageHtml}
                                </div>  
                            </div>
                            `)
                                $(`#mcq-${lesseonId}-list-progress`).append(`
                                <div class="form-progress-ans ans-${av.iscorrect?"select":"no-select"}"> 
                                    <div class="form-progress">       
                                        <label for="user-answer-${lesseonId}-ans-progress-item-${ai}" >${ letter }</label>
                                        <progress id="user-answer-${lesseonId}-ans-progress-item-${ai}" max="100" value="${av.total_user_answered||0}"/></progress> <span>${((av.total_user_answered||0)*1).toFixed(2)}%</span>
                                    </div>  
                                </div>
                            `)
                                if (av.iscorrect) {
                                    $(`#mcq-${lesseonId}-correct`).text(`: ${ letter } `)
                                }
                            })
                        }, 'json')

                    })
                    
                    if (res.total > 0) {

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
                            <button class="${linkstatus} btn btn-secondary  {$preclass} ${v.active?"active":""}" onclick="loadlessonreview('${v.url}')"   >${label_name}</button>
                            `)
                            } else {
                                $('#lesson-footer-paginationmobile').append(`
                            <button class="${linkstatus} btn btn-secondary " onclick="loadlessonreview('${v.url}')" >${v.label}</button>
                            `)
                            }
                            if (v.active || !v.url) {
                                $('#lesson-footer-pagination').append(`
                                <button class="${linkstatus} btn btn-secondary ${v.active?"active":""}" onclick="loadlessonreview('${v.url}')"  >${v.label}</button>
                            `)
                            } else {
                                $('#lesson-footer-pagination').append(`
                                <button class="${linkstatus} btn btn-secondary" onclick="loadlessonreview('${v.url}')" >${v.label}</button>
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
                        $('.finish-btn').hide();
                    } else {
                        $('.finish-btn').show();
                    }

                    if (res.prev_page_url) {
                        $('.lesson-left').show()
                            .find('button.left-btn')
                            .data('pageurl', res.prev_page_url)
                            .attr('onclick', `loadlessonreview('${res.prev_page_url}')`); // Adding onclick event
                    }

                    $('#menu-text').html(`Question <span> ${res.current_page} </span> of <span> ${res.total}</span>`)

                }, 'json')

        }

        $(function() {
            loadlessonreview()
        })

        function toglepreviewpage() {
            // timerActive=!timerActive; 
            $('#question-preview-page').slideToggle()
            $('#question-answer-page').fadeToggle()
        }
    </script>
@endpush
