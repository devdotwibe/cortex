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
        <x-create-form name="admin.question" :cancel="route('admin.full-mock-exam.index',$exam->slug)"  btnsubmit="Save" :fields='[
            ["name"=>"exam_id", "value"=>$exam->id,"type"=>"hidden"], 
            ["name"=>"exam_type", "value"=>"full-mock-exam","type"=>"hidden"],
            ["name"=>"redirect", "value"=>route("admin.full-mock-exam.index",$exam->slug),"type"=>"hidden"],
            ["name"=>"category_id" ,"label"=>"Category","ajaxurl"=>route("admin.full-mock-exam.create",$exam->slug),"type"=>"select","size"=>4],
            
            
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