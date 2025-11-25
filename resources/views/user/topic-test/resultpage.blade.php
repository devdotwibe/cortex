@extends('layouts.exam')
@section('headerclass', 'top-barhide')
@section('bodyclass', 'bartop-hide')
@section('title', 'Congratulation on Completing the Topic!')
@section('content')

<section class="modal-expand modal-expand-result" id="question-complete-page" >
    <div class="container-wrap">
        <div class="question-preview">
            <div class="question-preview-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="exam-result">
                            <div class="exam-result-content">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="exam-mark-body">
                                            <div class="mark-title">
                                                <h3>Attempt details</h3>
                                            </div>
                                            <div class="mark-label">
                                                <span>Time taken :</span>
                                                <span id="time-taken">{{$attemttime}}</span>
                                            </div>
                                            <div class="mark-label">
                                                <span>Attempt Number :</span>
                                                <span>#{{$attemtcount}}</span>
                                            </div>
                                            <div class="mark-label">
                                                <span>Attempt Date :</span>
                                                <span>@if(!empty($userExamReview->created_at)) {{$userExamReview->created_at->format('d M Y')}} @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p>Next Step: Review and Improve</p>
                                <div class="exam-mark-bottom">
                                    @if (session("exam-retry-".$userExamReview->id))
                                        <a class="btn btn-warning btn-lg"   href="{{route('topic-test.retry',$userExamReview->slug)}}">Retry In-Correct</a>
                                    @endif
                                    <a class="btn btn-warning btn-lg" id="review-link" href="{{route('topic-test.preview',$userExamReview->slug)}}">Review Set</a>
                                    <a href="{{route('topic-test.index')}}" class="btn btn-outline-dark btn-lg">Exit Set</a>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-9">
                        <div class="exam-overview">
                            <div class="vl"></div>
                            <div class="exam-overview-content">
                                <div class="topictest-overview">
                                <div class="overview-title">
                                    <h3>Result Overview</h3>
                                </div>
                                <div class="overview-table ">
                                    <table class="table table-bordered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Overall</th>
                                                @foreach ($categorylist as $item)
                                                <th>{{ucfirst($item->name)}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Marks</th>
                                                <td>{{$passed}}/{{$questioncount}}</td>
                                                @foreach ($categorylist as $item)
                                                    @if ($userExamReview->categoryCount($item->id)>0)
                                                    <td>{{$userExamReview->categoryMark($item->id)}}/{{$userExamReview->categoryCount($item->id)}}</td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>Average</th>
                                                <td>{{$userExamReview->avgMark()}}</td>
                                                @foreach ($categorylist as $item)
                                                <td></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>Average Time <br>Per Question</th>
                                                <td>{{$userExamReview->avgTime()}}</td>
                                                @foreach ($categorylist as $item)
                                                    @if ($userExamReview->avgTime($item->id)>0)
                                                        <td>{{$userExamReview->avgTime($item->id)}}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="topic-overview">
                                <div class="overview-title">
                                    <h5>Ranking</h5>

                                    @if($questioncount != 0)

                                        <h3>Top {{round($passed*100/$questioncount,2)}}%</h3>
                                    @else

                                        <h3>Top 0%</h3>

                                    @endif

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
    </div>
</section>

@endsection



@push('footer-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        localStorage.removeItem("topic-test-summery-retry")


        $(document).ready(function() {
            let chartInstance = null;
            let aggregatedData = {};
            let currentOffset = 0;
            const passedScore = {{ $passed }};

            function initChart() {
                $('#chart-loader').hide();
                $('#myChart').show();

                const ctx = document.getElementById('myChart').getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Students',
                            data: [],
                            backgroundColor: []
                        }]
                    },
                    options: {
                        animation: { duration: 200 },
                        scales: {
                            y: { beginAtZero: true, display: false },
                            x: { grid: { display: false } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            function updateChart(markData) {
                // Merge new data
                for (let mark in markData) {
                    if (aggregatedData[mark]) {
                        aggregatedData[mark] += markData[mark];
                    } else {
                        aggregatedData[mark] = markData[mark];
                    }
                }

                // Sort marks
                const sortedMarks = Object.keys(aggregatedData).sort((a, b) => parseInt(a) - parseInt(b));

                // Update chart
                chartInstance.data.labels = sortedMarks;
                chartInstance.data.datasets[0].data = sortedMarks.map(mark => aggregatedData[mark]);
                chartInstance.data.datasets[0].backgroundColor = sortedMarks.map(mark =>
                    parseInt(mark) === passedScore ? "#ef9b10" : "#dfdfdf"
                );
                chartInstance.update();
            }

            function loadChartData() {
                $.ajax({
                    url: "{{ route('topic-test.chart-data-incremental', $userExamReview->slug) }}",
                    method: 'GET',
                    data: { offset: currentOffset },
                    success: function(response) {
                        if (!chartInstance) {
                            initChart();
                        }

                        updateChart(response.markData);

                        // Update progress
                        const progress = Math.min(100, ((currentOffset + response.limit) / response.total) * 100);
                        $('#chart-loader').find('.progress-text').text(`Loading ${Math.round(progress)}%...`);

                        if (response.hasMore) {
                            currentOffset += response.limit;
                            loadChartData(); // Load next batch
                        } else {
                            $('#chart-loader').hide();
                        }
                    },
                    error: function() {
                        $('#chart-loader').html('<p class="text-danger">Failed to load chart.</p>');
                    }
                });
            }

            // Start loading
            loadChartData();
        });




        //  $(document).ready(function() {

        //     $.ajax({
        //         url: "{{ route('topic-test.chart-data', $userExamReview->slug) }}",
        //         method: 'GET',
        //         success: function(response) {

        //             $('#chart-loader').hide();
        //             $('#myChart').show();

        //             const ctx = document.getElementById('myChart').getContext('2d');
        //             const progressBar = new Chart(ctx, {
        //                 type: 'bar',
        //                 data: {
        //                     labels: response.labels,
        //                     datasets: [{
        //                         label: 'Students',
        //                         data: response.data,
        //                         backgroundColor: response.backgroundColor,
        //                     }]
        //                 },
        //                 options: {
        //                     scales: {
        //                         y: {
        //                             beginAtZero: true,
        //                             display: false,
        //                         },
        //                         x: {
        //                             grid: {
        //                                 display: false
        //                             },
        //                         },
        //                     },
        //                     plugins: {
        //                         legend: {
        //                             display: false
        //                         }
        //                     }
        //                 },
        //             });
        //         },
        //         error: function(xhr, status, error) {
        //             $('#chart-loader').html('<p class="text-danger">Failed to load chart data. Please refresh the page.</p>');
        //             console.error('Chart data loading error:', error);
        //         }
        //     });
        // });




    </script>
@endpush
