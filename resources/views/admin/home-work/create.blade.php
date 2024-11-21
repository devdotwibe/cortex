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

        <x-create-form name="admin.learn" :params="[$homeWork->slug]" :cancel="route('admin.learn.show',$homeWork->slug)" frmID="learnForm" btnsubmit="Save" :fields='[
            ["name"=>"redirect", "value"=>route("admin.home-work.show",$homeWork->slug),"type"=>"hidden"],
             ["name"=>"home_work_book_id" ,"label"=>"Week Booklet","ajaxurl"=>route("admin.home-work.create",$homeWork->slug),"type"=>"select","size"=>4],
            ["name"=>"learn_type","event"=>["change"=>"cclickback"] ,"label"=>"Learn Type","placeholder"=>"Select Learn Type","type"=>"select","size"=>4,"options"=>[["value"=>"short_notes","text"=>"Short Note Questions"],["value"=>"mcq","text"=>"MCQs Questions"]]],
             
           
            ["name"=>"mcq_question", "addclass"=>"mcq_section","display"=>"none" , "label"=>"Question","size"=>12,"type"=>"editor"], 
            ["name"=>"mcq_answer", "addclass"=>"mcq_section" , "display"=>"none", "label"=>"answer" ,"type"=>"choice" ,"size"=>6],
            ["name"=>"explanation", "addclass"=>"mcq_section","display"=>"none" , "label"=>"Explanation","size"=>12,"type"=>"editor" ],
             ["name"=>"short_question", "addclass"=>"short_section","display"=>"none" , "label"=>"Question","size"=>12,"type"=>"editor"],

            ["name"=>"short_answer", "addclass"=>"short_section" ,"display"=>"none" , "placeholder"=>"Type Answer Here","label"=>"Answer","size"=>12,"type"=>"editor"], 

        ]'  /> 


    </div>
</section> 
@endsection

@push('footer-script')
    <script>
        $(function() {
             var value = $("#learn_type-learnForm").val();
             switch (value) {
                
                case 'short_notes':
                        $('.short_section').show();
                    break;
                case 'mcq':
                        $('.mcq_section').show(); 
                    break;
                default:
            }
        });
        function cclickback(e){

            console.log(e.value);

           if(e.value == 'short_notes')
            {
              
                $('.mcq_section').hide();
                $('.short_section').show();
            }
            else(e.value == 'mcq')
            {
                $('.short_section').hide();
                $('.mcq_section').show(); 
            }
         }
         
    </script>
@endpush
