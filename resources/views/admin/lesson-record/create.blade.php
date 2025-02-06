@extends('layouts.admin')
@section('title', 'Lesson Recording -> '.$lessonRecording->term_name.' -> Create')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            {{-- <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.lesson-record.show',$lessonRecording->slug) }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div> --}}


            <h2> Lesson Recording  -> {{ $lessonRecording->term_name  }} -> Create</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form 
            name="admin.lesson-record" 
            :params='[
                "lesson_recording"=>$lessonRecording->slug
            ]' 
            :cancel="route('admin.lesson-record.show',$lessonRecording->slug)"  
            btnsubmit="Save" 
            :fields='[  
                ["name"=>"redirect", "value"=>route("admin.lesson-record.show",$lessonRecording->slug),"type"=>"hidden"],
 
                ["name"=>"title","label"=>"Title","size"=>6,"type"=>"text"],  
                ["name"=>"source_video","label"=>"Video - ( Vimeo ID or Link ,Youtube ID or Link )","placeholder"=>"Video","size"=>6,"type"=>"text"], 
                ["name"=>"video_type","label"=>"Video Type","placeholder"=>"Select Video Type","type"=>"select","size"=>4,"options"=>[["value"=>"vimeo_youtube","text"=>"Vimeo /Youtube"],["value"=>"zoom","text"=>"Zoom"]]], 
            ]' 
        />  
    </div>
</section> 
@endsection
