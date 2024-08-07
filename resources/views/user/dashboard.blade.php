@extends('layouts.user')
@section('title', 'Dashboard')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>My Journey</h2>
        </div> 
        <div class="progress-list">
            <div class="progress-item">
                <div class="progress-body @if($learnprogress>=50) complete @endif"> 
                    <div class="progress-avathar">
                        <img @if($learnprogress>=50)  src="{{asset('assets/images/learn.svg')}}" @else src="{{asset('assets/images/learngreyicon.svg')}}" @endif alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Learn</strong>
                    </div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-body @if($practiceprogress>=50) complete @endif"> 
                    <div class="progress-avathar">
                        <img  @if($practiceprogress>=50)  src="{{asset('assets/images/practice.svg')}}" @else  src="{{asset('assets/images/practicegreyicon.svg')}}" @endif alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Practice</strong>
                    </div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-body @if($simulateprogress>=50) complete @endif"> 
                    <div class="progress-avathar">
                        <img  @if($simulateprogress>=50)  src="{{asset('assets/images/simulate.svg')}}" @else  src="{{asset('assets/images/simulategreyicon.svg')}}" @endif alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Simulate</strong>
                    </div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-body @if($maxretry>=2) complete @endif"> 
                    <div class="progress-avathar">
                        <img  @if($maxretry>=2)  src="{{asset('assets/images/review.svg')}}" @else src="{{asset('assets/images/reviewgreyicon.svg')}}" @endif alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Review</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="row"> 
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Calendar</h3>
                    <div class="calendar">
                        <div class="calendar-title">
                            <strong id="calendar-title"></strong>
                        </div>
                        <div class="calendar-body">
                            <div id="calendar-dashboard"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="overview-graph">
                        <div class="overview-graph-body">
                            <div class="overview-graph-inner"> 
                                <canvas id="myChart" class="overview-graph-bar" width="100%" ></canvas>
                            </div>
                        </div>
                        <div class="overview-graph-footer"> 
                            <div class="graph-filter">
                                <a class="graph-filter-btn graph-filter-all m-1" onclick="updatechart('all')"><span class="filter-text">All</span></a>
                                <a class="graph-filter-btn graph-filter-1week m-1" onclick="updatechart('1week')"><span class="filter-text">1 Week</span></a>
                                <a class="graph-filter-btn graph-filter-1month m-1" onclick="updatechart('1month')"><span class="filter-text">1 Month</span></a>
                                <a class="graph-filter-btn graph-filter-3months m-1" onclick="updatechart('3months')"><span class="filter-text">3 Months</span></a>
                                <a class="graph-filter-btn graph-filter-1year m-1" onclick="updatechart('1year')"><span class="filter-text">1 Year</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section> 
@endsection
@push('modals')

<div class="modal fade" id="exam-reminder" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content" > 
            <div class="modal-header">
                <h5 class="modal-title" id="Lablel">Reminder</h5>
                <button type="button" class="close" data-bs-dismiss="modal"    aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="exam-reminder-view"> 
            </div>
            <div class="modal-body" id="exam-reminder-add"> 
                <div class="form">
                     <form action="{{route('reminder.store')}}" method="post">

                     </form>
                </div>
            </div>
            <div class="modal-body" id="exam-reminder-edit"> 
            </div>
        </div>
    </div>
</div>
@endpush
@push('footer-script')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/main.min.css" rel="stylesheet">
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.9/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.9/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script> 
   let calendar = new FullCalendar.Calendar($("#calendar-dashboard").get(0), {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        weekends: true,
        weekNumbers: false,
        editable: true,
        navLinks: false,
        dayMaxEvents: false,
        displayEventTime: false,
        unselectAuto: true,
        selectable: true, 
        dateClick:function(info){ 
            console.log(info) 
        }, 
        events: function(fetchInfo, successCallback, failureCallback) { 
            $.get("{{route('dashboard',['calendar'=>'Y'])}}",fetchInfo,function(res){
                successCallback(res);
            },'json').fail(function(){
                failureCallback("Network response was not ok")
            }) 
        }, 
        eventClick:function(info){ 
            if(info.event&&info.event.extendedProps){
                $('#calendar-title').text(info.event.extendedProps.elTitle||"")
            }            
        }
    });
    calendar.render(); 
    const ctx = document.getElementById('myChart').getContext('2d');
    const progressBar = new Chart(ctx, {
        type: 'line',
        data: {
            labels:[],
            datasets: [{
                label: 'Mark',
                data:[],
                fill: true,
                borderColor:[],
                backgroundColor:"#8FFFAD",
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, 
                    max:100,
                    grid: {
                        display: false
                    }, 
                }, 
                x: {   
                    display: false
                },  
            },
            plugins: { 
                legend: {
                    display: false 
                }
            }
        },
    });  
    function updatechart(fl) {
        $.get("{{route('dashboard',['chart'=>'Y'])}}",{filter:fl},function(res){
            progressBar.data.labels=res.label||[];
            progressBar.data.datasets[0].data=res.data||[];
            progressBar.data.datasets[0].borderColor=res.borderColor||[];
            progressBar.update();
            $('.graph-filter-btn').removeClass('active')
            $('.graph-filter-'+fl).addClass('active')
        },'json')
    }
    function addreminder(){
        calendar.refetchEvents()
    }
    $(function(){
        updatechart('1week')
    })
</script>
@endpush