@extends('layouts.admin')
@section('title', $exam->title.' - Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.exam.index') }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>
            <h2>{{$exam->title}} - Questions</h2>
        </div>
        <div class="header_content">
             <div class="form-group">
                <select  id="cat-list" class="select2 form-control" data-placeholder="Select an Category" data-allow-clear="true" data-ajax--url="{{route("admin.full-mock-exam.create",['exam'=>$exam->slug,"parent_id"=>0,"name"=>"category_id"])}}"></select>
             </div>
        </div>      
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.full-mock-exam.create',$exam->slug)}}" class="nav_link btn">New Questions</a></li>
                <li class="nav_item import-upload-btn" @if(get_option('full-mock-exam-import-question-'.$exam->slug,'')=="started") style="display: none" @endif>
                    <x-ajax-import 
                        :url="route('admin.full-mock-exam.import',$exam->slug)" 
                        :fields='[ 
                        ["name"=>"category","label"=>"Category"], 
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
                <li class="nav_item import-cancel-btn" @if(get_option('full-mock-exam-import-question-'.$exam->slug,'')!=="started") style="display: none" @endif >
                    <a href="{{route('admin.uploadcancel','full-mock-exam-import-question-'.$exam->slug)}}">
                        <p id="import-cancel-btn-text">{{ get_option('full-mock-exam-import-question-completed-'.$exam->slug) }} % Completed</p>
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
            <x-ajax-table :bulkaction="true" :beforeajax="true" bulkactionlink="{{route('admin.full-mock-exam.bulkaction', ['exam'=>$exam->slug] )}}"
            
            tableid="categoryquestiontable"
             
            :bulkotheraction='[
                ["name"=>"Enable Visible Access","value"=>"visible_status"],
                ["name"=>"Disable Visible Access","value"=>"visible_status_disable"],
               
            ]' 
            
            
            :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Question","name"=>"description","data"=>"description"], 
                ["th" => "Visible", "name" => "visible_status", "data" => "visibility"],
            ]' 
            tableinit="questiontableinit"  beforeajax="questionbeforeajax" />
        </div>
    </div>
</section> 
@endsection

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
            questiontable.state.save();
        }
         
        // function visiblechangerefresh(url) {
        //     $.get(url, function() {
        //         if (questiontable != null) {
        //             questiontable.ajax.reload()
        //         }
        //     }, 'json')
        // }

        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (questiontable != null) {
                    var currentPage = questiontable.page(); // Store current page
                    // questiontable.ajax.reload()
                     // Reload the table but retain the current page
                     questiontable.ajax.reload(function() {
                        questiontable.page(currentPage).draw(false); // Stay on the same page
                    }, false);
                }
            }, 'json');
        }
 
        function questionbeforeajax(data){
            data.category=$('#cat-list').val()||null;
            console.log(data)
            return data;
        }

        function importupdate(){ 
            questiontable.ajax.reload()
        } 

        $(function(){
            $('.select2').select2().change(function(){
                if (questiontable != null) {
                    questiontable.ajax.reload()
                }
                $('#cat_id').val($('#cat-list').val())
            })
        })
    </script>
@endpush