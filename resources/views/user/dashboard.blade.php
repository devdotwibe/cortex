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
                    <span class="progress-notification"></span>
                    <div class="progress-avathar">
                        <img src="{{asset('assets/images/learn.svg')}}" alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Learn</strong>
                    </div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-body">
                    <span class="progress-notification"></span>
                    <div class="progress-avathar">
                        <img src="{{asset('assets/images/practice.svg')}}" alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Practice</strong>
                    </div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-body">
                    <span class="progress-notification"></span>
                    <div class="progress-avathar">
                        <img src="{{asset('assets/images/simulate.svg')}}" alt="">
                    </div>
                    <div class="progress-title">
                        <strong>Simulate</strong>
                    </div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-body">
                    <span class="progress-notification"></span>
                    <div class="progress-avathar">
                        <img src="{{asset('assets/images/review.svg')}}" alt="">
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
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section> 
@endsection

@push('footer-script')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/main.min.css" rel="stylesheet">
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.9/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.9/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function(){
        
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
            $.get("{{route('dashboard')}}",fetchInfo,function(res){
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
            labels: @json($chartlabel),
            datasets: [{
                label: 'Mark',
                data:@json($chartdata),
                fill: true,
                borderColor:@json($chartbackgroundColor),
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