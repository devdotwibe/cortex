@extends('layouts.exam')
@section('title', $homeWorkBook->title)
@section('content') 


<section class="exam-container">
    <div class="exam-progress">
        <div class="exam-progress-inner">
            <div class="exam-progress-inner-item exam-left">
                <div class="progress-main">

                    <div class="exam-exit ">
                        <a href="{{route('home-work.show',$homeWork->slug)}}">
                            <img src="{{asset("assets/images/exiticon-wht.svg")}}" alt="exiticon">
                        </a>
                    </div> 
                </div>
            </div>
            <div class="exam-center exam-progress-inner-item">
                <div class="progress-menu">
                    <div class="menu-text">
                        <span id="menu-text" >Question 0 of 0</span>
                    </div>
                    <div class="menu-icon"> 
                        <a onclick="toglepreviewpage()" >
                            <img src="{{asset("assets/images/menu.svg")}}" alt="exiticon">
                        </a>
                    </div>
                </div>
            </div>
            <div class="exam-right exam-progress-inner-item">
                <div class="progress-main">
                    <div class="bookmark">
                        <a class="" id="bookmark-current" >
                            <img class="active-img" src="{{asset("assets/images/bookmark.svg")}}" alt="bookmark">
                            <img class="inactive-img" src="{{asset("assets/images/bookmarkfill.svg")}}" alt="bookmark">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="container-wrap" id="question-answer-page">
        <div class="lesson">  
            <div class="lesson-title">
                <h3><span>{{$homeWorkBook->title}}</span></h3>
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('full-mock-exam.confirmshow',['exam'=>$exam->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('full-mock-exam.confirmshow',['exam'=>$exam->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('full-mock-exam.confirmshow',['exam'=>$exam->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('full-mock-exam.confirmshow',['exam'=>$exam->slug,'page'=>$i]) }}')">
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
                                                        <button class="item-group" onclick="loadlesson('{{ route('full-mock-exam.confirmshow',['exam'=>$exam->slug,'page'=>$i]) }}')">
                                                             
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
@endsection