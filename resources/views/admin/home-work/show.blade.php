@extends('layouts.admin')
@section('title', 'Homework Submission -> '.$homeWork->term_name)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">

            <h2> Homework Submission  -> {{ $homeWork->term_name  }}</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.home-work.create',$homeWork->slug)}}"  class="nav_link btn">Add Homework</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section"> 
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
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
    </script>
@endpush