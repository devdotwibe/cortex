@extends('layouts.admin')
@section('title', 'Homework Submission -> '.$homeWork->term_name.' -> Create')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2> Homework Submission  -> {{ $homeWork->term_name  }} -> Create</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form 
            name="admin.home-work" 
            :params='[
                "home_work"=>$homeWork->slug
            ]' 
            :cancel="route('admin.home-work.show',$homeWork->slug)"  
            btnsubmit="Save" 
            :fields='[  
                ["name"=>"redirect", "value"=>route("admin.home-work.show",$homeWork->slug),"type"=>"hidden"],
                ["name"=>"home_work_book_id" ,"label"=>"Week Booklet","ajaxurl"=>route("admin.home-work.create",$homeWork->slug),"type"=>"select","size"=>4],
                
                ["name"=>"description","label"=>"Question","size"=>12,"type"=>"editor"], 
                ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>12],
                ["name"=>"explanation","label"=>"Explanation","size"=>12,"type"=>"editor" ],
            ]' 
        />  
    </div>
</section> 
@endsection
