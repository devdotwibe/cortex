@extends('layouts.admin')
@section('title', 'Lesson Recording -> '.$lessonRecording->term_name)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.live-class.private_class_create') }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>

            <h2> Lesson Recording  -> {{ $lessonRecording->term_name  }}</h2>
        </div>
         
        <div class="header_right">
            <ul class="nav_bar">
                {{-- <li class="nav_item"><a class="nav_link btn"  data-bs-toggle="modal" data-bs-target="#user-acces-modal" data-target="#user-acces-modal" >User Access</a></li> --}}
                <li class="nav_item"><a href="{{route('admin.lesson-record.create',$lessonRecording->slug)}}"  class="nav_link btn">Add Record</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section admin_section"> 
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Title","name"=>"title","data"=>"title"], 
                ["th"=>"Video Type","name"=>"video_type","data"=>"video_type"], 
                ["th" => "Visible", "name" => "visible_status", "data" => "visibility"],
            ]' 
            tableinit="questiontableinit" />
        </div>
    </div>
</section>
@endsection

@push('modals')
{{-- <div class="modal fade" id="user-acces-modal" tabindex="-1" role="dialog"  aria-labelledby="live-class-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" >User Access</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <x-ajax-table :url="route('admin.user-access.index',['type'=>'lesson-record','term'=>$lessonRecording->slug])"   :coloumns='[
                    ["th"=>"Name","name"=>"name","data"=>"name"],                      
                ]' 
                tableinit="usertableinit"  />
            </div>

        </div>
    </div>
</div> --}}
@endpush

@push('footer-script')
    <script>
        var questiontable = null;
        function questiontableinit(table) {
            questiontable = table
        }

        // var usertable = null;
        // function usertableinit(table) {
        //     usertable = table
        // }
        // function changeactivestatus(url){
        //     $.get(url,function(res){
        //         if (usertable != null) {
        //             usertable.ajax.reload()
        //         }
        //     })
        // }

        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (questiontable != null) {
                    questiontable.ajax.reload()
                }
            }, 'json')
        }
    </script>
@endpush