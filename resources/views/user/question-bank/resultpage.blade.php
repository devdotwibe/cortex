@extends('layouts.exam')
@section('title', 'Congratulation on Completing the Set!')
@section('content')  

<section class="modal-expand modal-expand-result" id="question-complete-page" >
    <div class="container-wrap">
        <div class="question-preview">  
            <div class="question-preview-title">
                <img src="{{asset("assets/images/congratulaton.svg")}}" alt="">
                <h3> Congratulation on Completing the Set! </h3>
            </div>
            <div class="question-preview-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="exam-result">
                            <div class="exam-result-content">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="exam-mark-title">
                                            <div class="title-1">
                                                <span >Your Mark</span>
                                            </div>
                                            <div class="title-2"  id="exam-mark-gained">
                                                <span >{{$passed}}/{{$questioncount??0}}</span>
                                            </div>
                                        </div>
                                        <div class="exam-mark-body">
                                            @if ($timed=="timed")
                                            <div class="mark-label">
                                                <span>Time taken :</span>
                                                <span id="time-taken">{{$attemttime}}</span>
                                            </div>                                                 
                                            @endif
                                            <div class="mark-label">
                                                <span>Attemt Number :</span>
                                                <span>#{{$attemtcount}}</span>
                                            </div> 
                                            <div class="mark-label">
                                                <span>Attemt Date :</span>
                                                <span>{{date('d M Y')}}</span>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
        
                                <p>Next Step: Review and Improve</p>
                                <div class="exam-mark-bottom">
                                    <a class="btn btn-warning btn-lg" id="review-link" href="{{route('question-bank.preview',$userExamReview->slug)}}">Review Set</a>
                                    <a href="{{route('question-bank.show',$category->slug)}}" class="btn btn-outline-dark btn-lg">Exit Set</a>
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
 

@push('footer-script') 

    <script> 
          
    </script>
@endpush