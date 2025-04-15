@extends('layouts.user')
@section('title', 'Live Class - '.($live_class->class_title_1??' Private Class Room '))
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Live Class - {{($live_class->class_title_1??' Private Class Room ')}}</h2>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="private-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="private-content"> 
                    {{-- ["name"=>"phone","label"=>"Phone Number *","placeholder"=>"Phone Number","type"=>"text","size"=>12], --}}
                    {{-- <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfc-gOkpIRCfsvQjUjwPuVdj9lCnzcvNGjatEbWsgdxCUjXJQ/viewform?embedded=true" width="100%" height="1084" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe> --}}
                    <x-general-form 
                        :url="route('live-class.privateclass.form',$user->slug)" 
                        :cancel="route('live-class.privateclass', $user->slug)"
                        :fields='[
                            ["name"=>"email","label"=>"Email *","placeholder"=>"Email","type"=>"text","size"=>12],
                            ["name"=>"full_name","label"=>"Student Full Name *","placeholder"=>"Student Full Name","type"=>"text","size"=>12],
                            ["name"=>"parent_name","label"=>"Parent Name *","placeholder"=>"Parent Name","type"=>"text","size"=>12],
                           
                            ["name"=>"timeslot","label"=>"Select a class time (you can choose more than one) *","options"=>{!! json_encode($time_array) !!},"type"=>"checkboxgroup","size"=>12],
                        ]' 
                        btnsubmit="Register"
                    ></x-general-form>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection