@extends('layouts.admin')
@section('title', $category->name.' -> '.$subcategory->name.' -> '.$setname->name.' -> '.' Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$category->name}} -> {{$subcategory->name}} -> {{ $setname->name }} -> Questions</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.question-bank.create',$setname->slug)}}" class="nav_link btn">New Questions</a></li>
                {{-- <li class="nav_item"><a  class="nav_link btn">Import</a></li> --}}
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
            questiontable = table
        }

        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (questiontable != null) {
                    questiontable.ajax.reload()
                }
            }, 'json')
        } 
    </script>
@endpush