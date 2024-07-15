@extends('layouts.admin')
@section('title', 'Homework Submission -> '.$homeWork->term_name.' -> Edit')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2> Homework Submission  -> {{ $homeWork->term_name  }} -> Edit</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">

        @php
            $choices=[];
            foreach ($homeWorkQuestion->answers as $ans) {
                $choices[]=[
                    "id"=>$ans->id,
                    "value"=>$ans->title,
                    "choice"=>$ans->iscorrect,
            ];
            }
        @endphp
        <x-edit-form 
            name="admin.home-work" 
            :id="$homeWorkQuestion->slug"
            :params='["home_work"=>$homeWork->slug,"home_work_question"=>$homeWorkQuestion->slug]' 
            :cancel="route('admin.home-work.show',$homeWork->slug)"  
            btnsubmit="Save" 
            :fields='[  
                ["name"=>"redirect", "value"=>route("admin.home-work.show",$homeWork->slug),"type"=>"hidden"],
                ["name"=>"home_work_book_id" ,"label"=>"Week Booklet","ajaxurl"=>route("admin.home-work.create",$homeWork->slug),"type"=>"select","value"=>$homeWorkQuestion->home_work_book_id,"valuetext"=>optional($homeWorkQuestion->homeWorkBook)->title,"size"=>4],
                
                ["name"=>"description","label"=>"Question","size"=>12,"type"=>"editor","value"=>$homeWorkQuestion->description], 
                ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>12,"value"=>$choices ],
                ["name"=>"explanation","label"=>"Explanation","size"=>12,"type"=>"editor","value"=>$homeWorkQuestion->explanation ],
            ]' 
        />  
    </div>
</section> 
@endsection
