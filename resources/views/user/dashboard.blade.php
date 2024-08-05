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
                <div class="progress-body">
                    <span class="progress-notification"></span>
                    <div class="progress-avathar">
                        <img src="{{asset('assets/images/lessonmaterial.svg')}}" alt="">
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
                        <img src="{{asset('assets/images/lessonmaterial.svg')}}" alt="">
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
                        <img src="{{asset('assets/images/lessonmaterial.svg')}}" alt="">
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
                        <img src="{{asset('assets/images/lessonmaterial.svg')}}" alt="">
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
                        <div class="calendar-body">
                            <div id="calendar-dashboard"></div>
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
        // selectedDates=[`${info.date.getFullYear()}-${info.date.getMonth()+1}-${info.date.getDate()}`];
        }, 
        events: function(fetchInfo, successCallback, failureCallback) { 
            $.get("{{route('dashboard')}}",fetchInfo,function(res){
                successCallback(res);
            },'json').fail(function(){
                failureCallback("Network response was not ok")
            }) 
        }, 
 
    });
    calendar.render();

})
</script>
@endpush