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
        <x-create-form name="admin.question" :cancel="route('admin.exam-simulator.index',$exam->slug)"  btnsubmit="Save" :fields='[
            ["name"=>"exam_id", "value"=>$exam->id,"type"=>"hidden"], 
            ["name"=>"redirect", "value"=>route("admin.exam-simulator.index",$exam->slug),"type"=>"hidden"],
            ["name"=>"category_id" ,"label"=>"Category","ajaxurl"=>route("admin.exam-simulator.create",$exam->slug),"type"=>"select","size"=>4],
            ["name"=>"duration" ,"label"=>"Duration","placeholder"=>"duration in Minutes","type"=>"select","size"=>4,"options"=>array_map(function($num){ return [ "value"=>"$num minute","text"=>"$num minute" ]; },range(1,10))],
             
            ["name"=>"description","label"=>"Question","size"=>12,"type"=>"editor"], 
            ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>6]
        ]' />  
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush