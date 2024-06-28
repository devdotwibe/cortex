@extends('layouts.admin')
@section('title', $category->name.' - Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$category->name}} - Questions</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form name="admin.question" :cancel="route('admin.question-bank.show',$category->slug)"  btnsubmit="Save" :fields='[
            ["name"=>"exam_id", "value"=>$exam->id,"type"=>"hidden"],
            ["name"=>"exam_type", "value"=>"question-bank","type"=>"hidden"],
            ["name"=>"category_id", "value"=>$category->id,"type"=>"hidden"],
            ["name"=>"redirect", "value"=>route("admin.question-bank.show",$category->slug),"type"=>"hidden"],
            ["name"=>"sub_category_id" ,"label"=>"Sub Category","ajaxurl"=>route("admin.question-bank.create",$category->slug),"type"=>"select","child"=>"sub_category_set","size"=>4],
            ["name"=>"sub_category_set" ,"label"=>"Set","ajaxurl"=>route("admin.question-bank.create",$category->slug),"type"=>"select","parent"=>"sub_category_id","size"=>4],
            ["name"=>"duration" ,"label"=>"Duration","placeholder"=>"duration in Minutes","type"=>"select","size"=>4,"options"=>array_map(function($num){ return [ "value"=>"$num minute","text"=>"$num minute" ]; },range(1,10))],
            ["name"=>"description","label"=>"Question","size"=>12,"type"=>"editor"], 
            ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>6],
            ["name"=>"explanation","label"=>"Explanation","size"=>12,"type"=>"editor" ],
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush