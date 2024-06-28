@extends('layouts.admin')
@section('title', $category->name.' - '.$subcategory->name.' - '.$setname->name.' - '.' Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$category->name}} - {{$subcategory->name}} - {{ $setname->name }} - Questions</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.question-bank-new.create',$setname->slug)}}" class="nav_link btn">New Questions</a></li>
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