@extends('layouts.admin')
@section('title', 'Homework Submission -> '.$homeWork->term_name.' -> Edit')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.home-work.show',$homeWork->slug) }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>
            <h2> Homework Submission  -> {{ $homeWork->term_name  }} -> Edit</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $choices=[];
            if(!empty($homeWorkQuestion->answers) && isset($homeWorkQuestion->answers))
            foreach ($homeWorkQuestion->answers as $ans) {
                $choices[]=[
                    "id"=>$ans->id,
                    "value"=>$ans->title,
                    "choice"=>$ans->iscorrect,
                    "image"=>$ans->image ? asset('d0').'/'.$ans->image : Null,

            ];
            }
        @endphp
      
        <x-edit-form  id="c" name="admin.home-work" :params='["home_work"=>$homeWork->slug,"home_work_question"=>$homeWorkQuestion->slug]'  :cancel="route('admin.home-work.show',$homeWork->slug)"   frmID="learnForm" btnsubmit="Save" :fields='[
            ["name"=>"redirect", "value"=>route("admin.home-work.show",$homeWork->slug),"type"=>"hidden"],

              ["name"=>"home_work_book_id" ,"label"=>"Week Booklet","ajaxurl"=>route("admin.home-work.show",$homeWork->slug),"type"=>"select", "size"=>4 ,"value"=>$homeWorkQuestion->home_work_book_id,"valuetext"=>$homeWorkQuestion->homeWorkBook->title],
            ["name"=>"title", "placeholder"=>"Title","label"=>"Title","size"=>4,"type"=>"text","value"=>$homeWorkQuestion->title], 
            ["name"=>"home_work_type","event"=>["change"=>"cclickback"] ,"label"=>"Home Work Type","placeholder"=>"Select Home Work Type","type"=>"select","size"=>4,"value"=>$homeWorkQuestion->home_work_type,"options"=>[["value"=>"short_notes","text"=>"Short Note Questions"],["value"=>"mcq","text"=>"MCQs Questions"]]],
             
           
             ["name"=>"description", "addclass"=>"mcq_question","display"=>"block" , "label"=>"Question","size"=>12,"type"=>"editor","value"=>$homeWorkQuestion->description], 
             ["name"=>"answer", "addclass"=>"mcq_question","display"=>"block" ,"label"=>"answer" ,"type"=>"choice" ,"size"=>12 ,"value"=>$choices],
             ["name"=>"explanation", "addclass"=>"mcq_question","display"=>"block" , "label"=>"Explanation","size"=>12,"type"=>"editor" ,"value"=>$homeWorkQuestion->explanation ],

             ["name"=>"short_question", "addclass"=>"short_section","display"=>"none" , "label"=>"Question","size"=>12,"type"=>"editor" ,"value"=>$homeWorkQuestion->short_question],

            ["name"=>"short_answer", "addclass"=>"short_section" ,"display"=>"none" , "placeholder"=>"Type Answer Here","label"=>"Answer","size"=>12,"type"=>"editor" ,"value"=>$homeWorkQuestion->short_answer,], 

        ]'  />
    </div>
</section> 
@endsection


@push('footer-script')
    <script>
        $(function() {
             var value = $("#home_work_type-learnForm").val();
             switch (value) {
                
                case 'short_notes':
                        $('.short_section').show();
                    break;
                case 'mcq':
                        $('.mcq_question').show(); 
                    break;
                default:
            }
        });
        function cclickback(e){

            console.log($(e).val());

           if($(e).val() == 'short_notes')
            {
              
                $('.mcq_question').hide();
                $('.short_section').show();
            }
            else
            {
                $('.short_section').hide();
                $('.mcq_question').show(); 
            }
         }
         
    </script>
@endpush
