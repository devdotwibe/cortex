@extends('layouts.admin')
@section('title', 'Lesson Recording -> '.$lessonRecording->term_name)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">

            <h2> Lesson Recording  -> {{ $lessonRecording->term_name  }}</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.lesson-record.create',$lessonRecording->slug)}}"  class="nav_link btn">Add Record</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section"> 
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Title","name"=>"title","data"=>"title"], 
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