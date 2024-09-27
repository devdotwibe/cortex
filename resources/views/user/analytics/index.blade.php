@extends('layouts.user')
@section('title', 'Analytics')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Analytics</h2>
        </div> 
        <div class="header_content">
            <div class="form-group">
                <select class="form-control" onchange="togglegrapg(this.value)">
                    <option value="topic-test-result">Topic Test Result</option>
                    <option value="mock-exam-result">Mock Exam Result</option>
                    <option value="question-bank-result">Question Bank Result</option>
                    <option value="question-bank-timing">Question Bank Timing</option>
                </select>
            </div>
        </div>
    </div>
</section>


<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="analytic-list">
                        <div class="analytic-item active" id="topic-test-result" style="display: block">
                            <div class="row">
                                @foreach ($category as $item)
                                <div class="col-md-6">
                                    <div class="exam-overview"> 
                                        <div class="exam-overview-content">
                                            <div class="overview-title text-center">
                                                <h3>{{ucfirst($item->name)}}</h3>
                                            </div>
                                            <div class="overview-graph">
                                                <div class="overview-graph-body">
                                                    <div class="overview-graph-inner"> 
                                                        <canvas id="topic-test-chart-{{$item->id}}" data-avg="{{$item->getExamAvg('topic-test')}}" data-mrk="{{$item->getExamMark('topic-test',auth()->id())}}" data-max="{{$item->getQuestionCount('topic-test')}}" class="overview-graph-bar overview-graph-bar-topic-test" width="100%" ></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- <div class="analytic-item" id="mock-exam-result" style="display: none">
                            <div class="analytic-exam" id="analytic-exam"> 
                            </div> 
                        </div> --}}

                        <div class="analytic-item" id="mock-exam-result" style="display: none">
                            <div class="form-group">
                                <label for="mock-exam-select">Select Mock Exam:</label>
                                <select class="form-control" id="mock-exam-select" onchange="loadExamGraph(this.value)">
                                    <option value="">-- Select an Exam --</option>
                                    @foreach ($mockExams as $mockExam)
                                        <option value="{{ $mockExam->id }}">{{ $mockExam->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="analytic-exam" id="analytic-exam"> 
                            </div> 
                        </div>

                        
                        <div class="analytic-item" id="question-bank-result" style="display: none">
                            <div class="row">
                                @foreach ($category as $item)
                                <div class="col-md-6">
                                    <div class="exam-overview"> 
                                        <div class="exam-overview-content">
                                            <div class="overview-title text-center">
                                                <h3>{{ucfirst($item->name)}}</h3>
                                            </div>
                                            <div class="overview-graph">
                                                <div class="overview-graph-body">
                                                    <div class="overview-graph-inner"> 
                                                        <canvas id="question-bank-chart-{{$item->id}}" data-avg="{{$item->getExamAvgPercentage('question-bank')}}" data-mrk="{{$item->getExamMarkPercentage('question-bank',auth()->id())}}" data-max="100" class="overview-graph-bar overview-graph-bar-question-bank" width="100%" ></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="analytic-item" id="question-bank-timing" style="display: none">
                            <div class="row">
                                @foreach ($category as $item)
                                <div class="col-md-6">
                                    <div class="exam-overview"> 
                                        <div class="exam-overview-content">
                                            <div class="overview-title text-center">
                                                <h3>{{ucfirst($item->name)}}</h3>
                                            </div>
                                            <div class="overview-graph">
                                                <div class="overview-graph-body">
                                                    <div class="overview-graph-inner"> 
                                                        <canvas id="question-bank-timing-chart-{{$item->id}}" data-avg="{{$item->getExamAvgTime('question-bank')}}" data-mrk="{{$item->getExamTime('question-bank',auth()->id())}}" data-max="{{$item->getExamQuestionTime('question-bank')}}" class="overview-graph-bar overview-graph-bar-question-bank-timing" width="100%" ></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
        function togglegrapg(v){
            $(`.analytic-item.active,#${v}`).slideToggle().toggleClass('active');
            if(v=="mock-exam-result"){
                loadexamgrapg("{{url()->current()}}")
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
        function drowgraph(el,max,label,data){ 
            const ctx = el.getContext('2d');
            const progressBar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Your Score','Student Average'],
                    datasets: [{
                        label: label,
                        data:data,
                        backgroundColor: ['#e37131','#7f7f7f'],  
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: { 
                            grid: {
                                display: false
                            }, 
                        }, 
                        x: {  
                            grid: {
                                display: false
                            }, 
                            max:max
                        },  
                    },
                    plugins: { 
                        legend: {
                            display: false 
                        }
                    }
                },
            });
        }
        async function loadexamgrapg(url){
             await $.get(url,function(res){ 
                const lesseonId=generateRandomId(10); 
                let nextbtn = '';
                let prevbtn = '';
                if(res.next){
                    nextbtn = `<a class="next-btn"  onclick="loadexamgrapg('${res.next}')"><img src="{{asset('assets/images/rightarrows1.svg')}}" alt="next" ></a>`;
                }
                if(res.prev){
                    prevbtn = `<a class="prev-btn"  onclick="loadexamgrapg('${res.prev}')"><img src="{{asset('assets/images/leftarrows1.svg')}}" alt="prev" ></a>`;
                }
                $('#analytic-exam').html(`
                    <div class="row">
                        <div class="col-md-8">
                            <div class="analytic-exam-item" id="analytic-exam-item-${lesseonId}">
                                <div class="exam-overview" > 
                                    <div class="exam-overview-content">
                                        <div class="overview-title text-center">
                                            <div class="overview-left">${prevbtn}</div>
                                            <div class="overview-center"><h3>${res.data.title||''} </h3></div>
                                            <div class="overview-right">${nextbtn}</div>
                                        </div>
                                        <div class="overview-graph">
                                            <div class="overview-graph-body">
                                                <div class="overview-graph-inner"> 
                                                    <canvas id="mock-exam-chart-${lesseonId}" data-avg="${res.data.avg||0}" data-mrk="${res.data.mark||0}" data-max="${res.data.max||0}" class="overview-graph-bar overview-graph-bar-mock-exam" width="100%" ></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="analytic-exam-sidebar" >
                                <div class="analytic-exam-category" id="analytic-exam-category-${lesseonId}">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                `)  
                $.each(res.data.category,function(k,v){
                    $('#analytic-exam-category-'+lesseonId).append(`
                        <div class="analytic-exam-category-item">
                            <div class="exam-overview"> 
                                <div class="exam-overview-content">
                                    <div class="overview-title text-center">
                                        <h3>${v.title}</h3>
                                    </div>
                                    <div class="overview-graph">
                                        <div class="overview-graph-body">
                                            <div class="overview-graph-inner"> 
                                                <canvas id="mock-exam-chart-${lesseonId}-${k}" data-avg="${v.avg||0}" data-mrk="${v.mark||0}" data-max="${v.max||0}" class="overview-graph-bar overview-graph-bar-mock-exam" width="100%" ></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `)
                })                
                $('.overview-graph-bar-mock-exam').each(function(k,v){  
                    const avgmrk = $(this).data('avg')
                    const mrk = $(this).data('mrk')
                    const max = $(this).data('max')
                    drowgraph(this,max,'Mark',[mrk,avgmrk])
                    if(k==0){
                        $('.analytic-exam-category').css('height',$(`.analytic-exam-item`).height())
                    }
                }) 
             },'json')
             
        }

        $(function(){ 
            $('.overview-graph-bar-topic-test').each(function(){
                const avgmrk = $(this).data('avg')
                const mrk = $(this).data('mrk')
                const max = $(this).data('max')
                drowgraph(this,max,'Mark',[mrk,avgmrk])
            }) 
            $('.overview-graph-bar-question-bank').each(function(){
                const avgmrk = $(this).data('avg')
                const mrk = $(this).data('mrk')
                const max = $(this).data('max')
                drowgraph(this,max,'Percentage',[mrk,avgmrk])
            })
            $('.overview-graph-bar-question-bank-timing').each(function(){
                const avgmrk = $(this).data('avg')
                const mrk = $(this).data('mrk')
                const max = $(this).data('max')
                drowgraph(this,max,'Seconds',[mrk,avgmrk])
            })
            loadexamgrapg("{{url()->current()}}")
        })
    </script>
@endpush