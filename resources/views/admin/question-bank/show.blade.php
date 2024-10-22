@extends('layouts.admin')
@section('title', $category->name.' -> '.$subcategory->name.' -> '.$setname->name.' -> '.' Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>
                <a href="{{ route('admin.question-bank.index') }}">{{$category->name}}</a> -> 
                <a href="{{ route('admin.question-bank.index', ['id' => $category->slug,'type' =>'subcategory']) }}">{{$subcategory->name}}</a> -> 
                {{ $setname->name }} -> Questions
            </h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.question-bank.create',$setname->slug)}}" class="nav_link btn">New Questions</a></li>
                <li class="nav_item import-upload-btn" @if(get_option('question-bank-import-question','')=="started") style="display: none" @endif>
                    <x-ajax-import 
                        :url="route('admin.question-bank.import',$setname->slug)" 
                        :fields='[
                            ["name"=>"title_text","label"=>"Title Text"], 
                            ["name"=>"description","label"=>"Left Question"], 
                            ["name"=>"sub_question","label"=>"Right Question"], 
                            ["name"=>"answer_1","label"=>"Option A"],
                            ["name"=>"answer_2","label"=>"Option B"],
                            ["name"=>"answer_3","label"=>"Option C"],
                            ["name"=>"answer_4","label"=>"Option D"],
                            ["name"=>"iscorrect","label"=>"Correct Answer"],
                            ["name"=>"explanation","label"=>"Explanation"],
                        ]' onupdate="importupdate" ></x-ajax-import>
                </li> 
                <li class="nav_item import-cancel-btn" @if(get_option('question-bank-import-question','')!=="started") style="display: none" @endif >
                    <a href="{{route('admin.uploadcancel','question-bank-import-question')}}">
                        <p id="import-cancel-btn-text">0 % Complete</p>
                        <span class="btn btn-danger">Cancel</span>
                    </a>
                </li>
            </ul> 
        </div>
    </div>
</section>

<section class="content_section admin_section">
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
    <div class="modal fade" id="import-question-modal" tabindex="-1" role="dialog" aria-labelledby="Label"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="import-question-label"></span></h5>
                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-outer" id="attemt-list">
                                
                            </div>
                        </div>
                    </div>
                    <a type="button" href="" id="restart-btn" class="btn btn-dark">Re-Start Full Mock Exam</a>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('footer-script')
    <script>
        var questiontable = null;

        function questiontableinit(table) {
            questiontable = table;

            // Enable state saving to retain page and sort status
            questiontable.state.save();
        }

        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (questiontable != null) {
                    var currentPage = questiontable.page(); // Store current page

                    // Reload the table but retain the current page
                    questiontable.ajax.reload(function() {
                        questiontable.page(currentPage).draw(false); // Stay on the same page
                    }, false);
                }
            }, 'json');
        }

        function importupdate(){
            questiontable.ajax.reload();
        }
       
        $(function(){
            // Add any additional logic if needed
        });
    </script>
@endpush
