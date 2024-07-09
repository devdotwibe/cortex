@extends('layouts.user')
@section('title', 'Live Class - '.($live_class->class_title_2??' Intensive Workshop '))
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Live Class - {{($live_class->class_title_2??' Intensive Workshop ')}}</h2>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="workshop-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="workshop-content">  
                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfyk2g0VkuQshszXyye_C6GYHhsEhZWoEL8cRbs1Hv0ZPNvFw/viewform?embedded=true" width="100%" height="1084" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection