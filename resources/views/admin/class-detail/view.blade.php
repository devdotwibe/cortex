@extends('layouts.admin')
@section('title', 'Class Details -> '.$class_detail->term_name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">

            <h2> Class Details -> {{ $class_detail->term_name  }}</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a onclick="CreateForm(event)" class="nav_link btn">New Form</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            <x-ajax-table tableid="categoryquestiontable"   :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Question","name"=>"description","data"=>"description"], 
                ["th" => "Visible", "name" => "visible_status", "data" => "visibility"],
            ]' 
            tableinit="questiontableinit" />
        </div>
    </div>
</section> 
@endsection


@push('modals')

    <div class="modal fade" id="class-detail-modal" tabindex="-1" role="dialog"
        aria-labelledby="live-class-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="container">
                        
                        <x-general-form :url="route('profile.edit')" :id="$user->slug" btnsubmit="Save" :cancel="route('profile.view')" :fields='[
                            ["name"=>"first_name", "label"=>"First Name" ,"size"=>6,"value"=>$user->first_name?? $user->name],
                            ["name"=>"last_name","label"=>"Last Name" ,"size"=>6,"value"=>$user->last_name], 
                            ["name"=>"email","label"=>"email", "size"=>6,"value"=>$user->email,"readonly"=>true],
                            ["name"=>"phone", "label"=>"Phone No", "size"=>6,"value"=>$user->phone], 
                            ["name"=>"schooling_year", "label"=>"Current year of schooling", "size"=>6,"value"=>$user->schooling_year], 
                        ]' /> 
                    </div>

                </div>

            </div>
        </div>
    </div>


@push('footer-script')
    <script>


       function CreateForm(event)
       {
            event.preventDefault();
            event.stopPropagation();
            
            $('#class-detail-modal').modal('show');
       }

    </script>

@endpush