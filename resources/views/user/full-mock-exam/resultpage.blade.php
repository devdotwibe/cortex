@extends('layouts.exam')
@section('title', 'Congratulation on Completing the '.$userExamReview->title)
@section('content')  

<section class="modal-expand modal-expand-result" id="question-complete-page" >
    <div class="container-wrap">
        <div class="result-preview">   
            <div class="result-preview-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="exam-result">
                            <div class="exam-result-content"> 
                                <div class="exam-title">
                                    <h3>{{$userExamReview->title}}</h3>
                                </div>
                                <div class="exam-mark-body">
                                    <div class="mark-title">
                                        <h3>Attempt details</h3>
                                    </div>
                                    <div class="mark-label">
                                        <span>Time taken :</span>
                                        <span id="time-taken">{{$attemttime}}</span>
                                    </div> 
                                    <div class="mark-label">
                                        <span>Attemt Number :</span>
                                        <span>#{{$attemtcount}}</span>
                                    </div> 
                                    <div class="mark-label">
                                        <span>Attemt Date :</span>
                                        <span>{{date('d M Y')}}</span>
                                    </div> 
                                </div>  
        
                                <p>Next Step: Review and Improve</p>
                                <div class="exam-mark-bottom">
                                    <a class="btn btn-warning btn-lg" id="review-link" href="{{route('full-mock-exam.preview',$review->slug)}}">Review Set</a>
                                    <a href="{{route('full-mock-exam.index')}}" class="btn btn-outline-dark btn-lg">Exit Set</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="exam-overview">
                            <div class="vl"></div>
                            <div class="exam-overview-content">
                                <div class="overview-title">
                                    <h3>Result Overview</h3>
                                </div>
                                <div class="overview-table ">
                                    <table class="table table-bordered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Overall</th>
                                                @foreach ($category as $item)
                                                <th>{{ucfirst($item->name)}}</th>                                                     
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Marks</th>
                                                <td>{{$passed}}/{{$questioncount}}</td>
                                                @foreach ($category as $item)
                                                    @if ($review->categoryCount($item->id)>0)
                                                    <td>{{$review->categoryMark($item->id)}}/{{$review->categoryCount($item->id)}}</td>
                                                    @else
                                                    <td></td>
                                                @endif
                                            @endforeach 
                                            </tr>
                                            <tr>
                                                <th>Average</th>
                                                <td>{{$userExamReview->avgMark()}}</td>
                                                @foreach ($category as $item)
                                                <td></td>
                                                @endforeach 
                                            </tr>
                                            <tr>
                                                <th>Average Time <br>Per Question</th>
                                                <td>{{$review->avgTime()}}</td>                                                
                                                @foreach ($category as $item)
                                                    @if ($review->avgTime($item->id)>0)
                                                        <td>{{$review->avgTime($item->id)}}</td>
                                                    @else
                                                        <td></td>
                                                    @endif                                                                                                   
                                                @endforeach 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overview-title">
                                    <h5>Ranking</h5>
                                    <h3>Top {{round($passed*100/$questioncount,2)}}%</h3>
                                </div>
                                <div class="overview-graph">
                                    <div class="overview-graph-body">
                                        <div class="overview-graph-inner"> 
                                            <canvas id="myChart" class="overview-graph-bar" width="100%" ></canvas>
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
 

@push('footer-script')  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script> 
        $(document).ready(function() {

            const ctx = document.getElementById('myChart').getContext('2d');
            const progressBar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartlabel),
                    datasets: [{
                        label: 'Students',
                        data:@json($chartdata),
                        backgroundColor: @json($chartbackgroundColor),  
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            display: false,
                        }, 
                        x: {  
                            grid: {
                                display: false
                            }, 
                        },  
                    },
                    plugins: { 
                        legend: {
                            display: false 
                        }
                    }
                },
            });
        })
    </script>
@endpush