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
       
        <x-create-form name="admin.learn" :params="[$category->slug]" :cancel="route('admin.learn.show',$category->slug)"  btnsubmit="Save" :fields='[
            ["name"=>"category_id", "value"=>$category->id,"type"=>"hidden"],
            ["name"=>"redirect", "value"=>route("admin.learn.show",$category->slug),"type"=>"hidden"],
            ["name"=>"sub_category_id" ,"label"=>"Sub Category","ajaxurl"=>route("admin.learn.show",$category->slug),"type"=>"select","child"=>"sub_category_set","size"=>4],
             ["name"=>"title", "placeholder"=>"Title","label"=>"Title","size"=>4,"type"=>"text"], 
            ["name"=>"learn_type", "event"=>["change"=>"cclickback"] ,"label"=>"Learn Type","placeholder"=>"Select Learn Type","type"=>"select","size"=>4,"options"=>[["value"=>"video","text"=>"Video"],["value"=>"notes","text"=>"Note"],["value"=>"short_notes","text"=>"Short Note Questions"],["value"=>"mcq","text"=>"MCQs Questions"]]],
             
            ["name"=>"video_url", "addclass"=>"video_section" ,"display"=>"none" , "placeholder"=>"Video url","label"=>"Vimeo Video","size"=>12,"type"=>"text"], 
           
            ["name"=>"mcq_question", "addclass"=>"mcq_section","display"=>"none" , "label"=>"Question","size"=>12,"type"=>"editor"], 
            ["name"=>"mcq_answer", "addclass"=>"mcq_section" , "display"=>"none", "label"=>"answer" ,"type"=>"choice" ,"size"=>6],
            ["name"=>"explanation", "addclass"=>"mcq_section","display"=>"none" , "label"=>"Explanation","size"=>12,"type"=>"editor" ],
             ["name"=>"short_question", "addclass"=>"short_section","display"=>"none" , "label"=>"Question","size"=>12,"type"=>"editor"],

            ["name"=>"short_answer", "addclass"=>"short_section" ,"display"=>"none" , "placeholder"=>"Type Answer Here","label"=>"Answer","size"=>12,"type"=>"editor"], 

            ["name"=>"note", "addclass"=>"note_section","display"=>"none" , "label"=>"Note","size"=>12,"type"=>"editor"],


        ]' /> 


        </div>

    </div>

</section> 
@endsection

@push('footer-script')
    <script>

        function cclickback(e){

            if(e.value == 'notes')
            {
                $('.video_section').hide();
                $('.mcq_section').hide();
                $('.short_section').hide();
                $('.note_section').show();
            }
            else if(e.value == 'short_notes')
            {
                $('.video_section').hide();
                $('.mcq_section').hide();
                $('.short_section').show();
                $('.note_section').hide();
            }
            else if(e.value == 'mcq')
            {
                $('.video_section').hide();
                $('.short_section').hide();
                $('.mcq_section').show(); 
                $('.note_section').hide();
            }
            else
            {
                $('.mcq_section').hide();
                $('.short_section').hide();
                $('.video_section').show();
                $('.note_section').hide();
            }

         }
         
    </script>
@endpush