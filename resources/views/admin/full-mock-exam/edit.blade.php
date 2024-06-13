@extends('layouts.admin')
@section('title', $exam->name.' - Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$exam->name}} - Questions</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container"> 
        @php
            $choices=[];
            foreach ($question->answers as $ans) {
                $choices[]=[
                    "id"=>$ans->id,
                    "value"=>$ans->title,
                    "choice"=>$ans->iscorrect,
            ];
            }
        @endphp
        <x-edit-form name="admin.question" :id="$question->slug" btnsubmit="Save"  :cancel="route('admin.full-mock-exam.index',$exam->slug)" :fields='[
            ["name"=>"exam_type", "value"=>"full-mock-exam","type"=>"hidden"],
            ["name"=>"redirect", "value"=>route("admin.full-mock-exam.index",$exam->slug),"type"=>"hidden"],
            ["name"=>"category_id" ,"label"=>"Category","ajaxurl"=>route("admin.full-mock-exam.create",$exam->slug),"type"=>"select","value"=>$question->category_id,"valuetext"=>optional($question->category)->name,"size"=>4], 
            ["name"=>"duration" ,"label"=>"Duration","placeholder"=>"duration in Minutes","type"=>"select","size"=>4,"value"=>$question->duration,"valuetext"=>$question->duration,"options"=>array_map(function($num){ return [ "value"=>"$num minute","text"=>"$num minute" ]; },range(1,10))],
             
            ["name"=>"description","label"=>"Question","size"=>12,"type"=>"editor","value"=>$question->description], 
            ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>6,"value"=>$choices ]
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush