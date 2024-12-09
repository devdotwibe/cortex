@extends('layouts.admin')
@section('title', 'Homework Submission-'.$homeWork->term_name)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">

        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.home-work.index',$homeWork->slug) }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>

            <h2> Homework Submission -> {{ $homeWork->term_name  }} -> {{ $homeWorkBook->title }}</h2>
        </div>
        {{-- <div class="header_content">
             <div class="form-group">
                <select  id="booklet-list" class="select2 form-control" data-placeholder="Select an Booklet" data-allow-clear="true" data-ajax--url="{{route('admin.home-work.create',$homeWork->slug)}}"></select>
             </div>
        </div> --}}
         
        <div class="header_right">
            <ul class="nav_bar">
                {{-- <li class="nav_item"><a class="nav_link btn"  data-bs-toggle="modal" data-bs-target="#user-acces-modal" data-target="#user-acces-modal" >User Access</a></li> --}}
                <li class="nav_item"><a href="{{route('admin.home-work.create',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug])}}"  class="nav_link btn">Add Homework</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section admin_section"> 
    <div class="container">
        <div class="row">
            <x-ajax-table :bulkaction="true" bulkactionlink="{{ route('admin.home-work.bulkaction', ['home_work' => $homeWork->slug,'home_work_book'=>$homeWorkBook->slug]) }}"  tableid="categoryquestiontable"   
            
                :bulkotheraction='[
                    ["name"=>"Enable Visible Access","value"=>"visible_status"],
                    ["name"=>"Disable Visible Access","value"=>"visible_status_disable"],
                   
                ]' 
            :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Question","name"=>"question","data"=>"question"], 
                ["th" => "Visible", "name" => "visible_status", "data" => "visibility"],
            ]' 
            tableinit="questiontableinit" beforeajax="questionbeforeajax" />
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
                <x-ajax-table :url="route('admin.user-access.index',['type'=>'home-work','term'=>$homeWork->slug])"   :coloumns='[
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

$(function() {
    setTimeout(function() {
        $('table tr td p img').hide(); 
    }, 500); 
});



function OrderChange(element)

    {
        var id = $(element).attr('data-id');

        var value = $(element).val();

        var exam_id = $(element).attr('data-exam');

        var category_id = $(element).attr('data-category');

        var subcategory_id = $(element).attr('data-subcategory');

        var subcategoryset = $(element).attr('data-subcategoryset');

        var type = $(element).attr('data-type');

        var home_work_book = $(element).attr('data-homeworkbook');

        console.log(value,id);

        var url = '{{route('admin.order_change')}}';

        $.ajax({
            url: url,

            method: 'POST',
            data: {
                id: id,
                value: value,
                exam_id: exam_id,
                category_id: category_id,
                subcategory_id: subcategory_id,
                subcategoryset: subcategoryset,
                type: type,
                home_work_book: home_work_book,
            },
            success: function(res) {

                console.log(res);
                $('#table-categoryquestiontable').DataTable().ajax.reload(); 

            }

        });

    }
    
        var questiontable = null;
        function questiontableinit(table) {
            questiontable = table
        }
        function questionbeforeajax(data){
            data.booklet=$('#booklet-list').val()||null;
            return data;
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

        $(function(){
            $('.select2').select2().change(function(){
                if (questiontable != null) {
                    questiontable.ajax.reload()
                }
            })
        })
    </script>
@endpush