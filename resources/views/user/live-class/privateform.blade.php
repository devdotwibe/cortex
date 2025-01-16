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
                    {{-- <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfc-gOkpIRCfsvQjUjwPuVdj9lCnzcvNGjatEbWsgdxCUjXJQ/viewform?embedded=true" width="100%" height="1084" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe> --}}
                    <x-general-form 
                        :url="route('live-class.privateclass.form',$user->slug)" 
                        :cancel="route('live-class.privateclass', $user->slug)"
                        :fields='[
                            ["name"=>"email","label"=>"Email *","placeholder"=>"Email","type"=>"text","size"=>12],
                            ["name"=>"full_name","label"=>"Student Full Name *","placeholder"=>"Student Full Name","type"=>"text","size"=>12],
                            ["name"=>"parent_name","label"=>"Parent Name *","placeholder"=>"Parent Name","type"=>"text","size"=>12],
                            ["name"=>"phone","label"=>"Phone Number *","placeholder"=>"Phone Number","type"=>"text","size"=>12],
                            ["name"=>"timeslot","label"=>"Select your available timeslot (you can choose more than one) *","options"=>[["text"=>"Monday 6:30 p.m. (Online)","value"=>"Monday 6:30 p.m. (Online)"],["text"=>"Wednesday 6:30 p.m. (Online)","value"=>"Wednesday 6:30 p.m. (Online)"],["text"=>"Thursday 6:30 p.m. (Online)","value"=>"Thursday 6:30 p.m. (Online)"],["text"=>"Saturday 9:30 a.m. (F2F)","value"=>"Saturday 9:30 a.m. (F2F)"],["text"=>"Saturday 12 p.m. (F2F)","value"=>"Saturday 12 p.m. (F2F)"],["text"=>"Saturday 2:30 p.m. (F2F)","value"=>"Saturday 2:30 p.m. (F2F)"],["text"=>"Sunday 9:30 a.m. (F2F)","value"=>"Sunday 9:30 a.m. (F2F)"],["text"=>"Sunday 12 p.m. (F2F)","value"=>"Sunday 12 p.m. (F2F)"],["text"=>"Sunday 2:30 p.m. (F2F)","value"=>"Sunday 2:30 p.m. (F2F)"]],"type"=>"checkboxgroup","size"=>12],
                        ]' 
                        btnsubmit="Register"
                    ></x-general-form>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection