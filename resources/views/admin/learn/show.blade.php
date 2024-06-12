@extends('layouts.admin')
@section('title', $category->name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{ $category->name }}</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
       
        <x-create-form name="admin.learn" :cancel="route('admin.learn.show',$category->slug)"  btnsubmit="Save" :fields='[
            ["name"=>"category_id", "value"=>$category->id,"type"=>"hidden"],
            ["name"=>"redirect", "value"=>route("admin.question-bank.show",$category->slug),"type"=>"hidden"],
            ["name"=>"sub_category_id" ,"label"=>"Sub Category","ajaxurl"=>route("admin.learn.show",$category->slug),"type"=>"select","child"=>"sub_category_set","size"=>4],
            ["name"=>"sub_category_set" ,"label"=>"Set","ajaxurl"=>route("admin.learn.show",$category->slug),"type"=>"select","parent"=>"sub_category_id","size"=>4],
            ["name"=>"learn_type", "event"=>["change"=>"cclickback"] ,"label"=>"Learn Type","placeholder"=>"Select Learn Type","type"=>"select","size"=>4,"options"=>[["value"=>"video","text"=>"Video"],["value"=>"Notes","text"=>"Short Notes"],["value"=>"mcq","text"=>"MCQs"]]],
             
            ["name"=>"video_url", "addclass"="video_section" , "placeholder"=>"Video url","label"=>"Vimeo Video","size"=>12,"type"=>"text"], 
           
        ]' /> 


        
        <div class="form-sections" id="video_section" style="display: none;">

            <x-create-form name="admin.exam" btnsubmit="Save" :fields='[
            
                ["name"=>"video_url", "placeholder"=>"Video url","label"=>"Vimeo Video","size"=>12,"type"=>"text"], 
               
            ]' /> 

        </div>

        <div class="form-sections" id="mcq_section" style="display: none;">

            <x-create-form name="admin.exam" btnsubmit="Save" :fields='[
            
                ["name"=>"description","label"=>"Question","size"=>12,"type"=>"editor"], 
                ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>6]
            ]' /> 

        </div>

    </div>

</section> 
@endsection

@push('footer-script')
    <script>

        function cclickback(e){

            console.log(e.id);
            console.log("Selected value:", e.value);

            if(e.value == 'notes')
            {
                $('#video_section').hide();
                $('#mcq_section').hide();
            }
            else if(e.value == 'mcq')
            {
                $('#video_section').hide();

                $('#mcq_section').show();
            }
            else
            {
                
                $('#video_section').show();

                $('#mcq_section').hide();
            }

         }
         
    </script>
@endpush