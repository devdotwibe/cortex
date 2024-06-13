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
             
            ["name"=>"redirect", "value"=>route("admin.full-mock-exam.index",$exam->slug),"type"=>"hidden"],
            ["name"=>"sub_category_id" ,"label"=>"Sub Category","ajaxurl"=>route("admin.full-mock-exam.create",$exam->slug),"type"=>"select","child"=>"sub_category_set","value"=>$question->sub_category_id,"valuetext"=>optional($question->subCategory)->name,"size"=>4],
            ["name"=>"sub_category_set" ,"label"=>"Set","ajaxurl"=>route("admin.full-mock-exam.create",$exam->slug),"type"=>"select","parent"=>"sub_category_id","value"=>$question->sub_category_set,"valuetext"=>optional($question->setname)->name,"size"=>4],
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