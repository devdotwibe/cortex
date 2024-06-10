@extends('layouts.admin')
@section('title', $category->subject.' - Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$category->subject}} - Questions</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form name="admin.question-bank" :params='[$category->id]' btnsubmit="Save" :fields='[
            ["name"=>"category_id", "value"=>$category->id,"type"=>"hidden"],
            ["name"=>"sub_category_id" ,"label"=>"Sub Category","ajaxurl"=>route("admin.question-bank.create",$category->slug),"type"=>"select"],
            ["name"=>"title","size"=>8], 
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush