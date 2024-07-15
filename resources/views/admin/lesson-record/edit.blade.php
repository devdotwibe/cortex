@extends('layouts.admin')
@section('title', 'Lesson Recording -> '.$lessonRecording->term_name.' -> Edit')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2> Lesson Recording  -> {{ $lessonRecording->term_name  }} -> Edit</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <x-edit-form 
            name="admin.lesson-record" 
            :id="$recordVideo->id"
            :params='[
                "lesson_recording"=>$lessonRecording->slug,"record_video"=>$recordVideo->slug
            ]' 
            :cancel="route('admin.lesson-record.show',$lessonRecording->slug)"  
            btnsubmit="Save" 
            :fields='[  
                ["name"=>"redirect", "value"=>route("admin.lesson-record.show",$lessonRecording->slug),"type"=>"hidden"],
 
                ["name"=>"title","label"=>"Title","size"=>6,"type"=>"text","value"=>$recordVideo->title],  
                ["name"=>"source_video","label"=>"Video - ( Vimeo ID or Link ,Youtube ID or Link )","placeholder"=>"Video","size"=>6,"type"=>"text","value"=>$recordVideo->source_video],  
            ]' 
        />  
    </div>
</section> 
@endsection
