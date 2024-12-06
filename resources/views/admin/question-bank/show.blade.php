@extends('layouts.admin')
@section('title', $category->name.' -> '.$subcategory->name.' -> '.$setname->name.' -> '.' Questions')
@section('content')
<style>
    input[type="image"] {
    display: none;
}
</style>
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.question-bank.subcategory',$sub_category->slug) }}">
                    {{-- <a href="{{ route('admin.home-work.index',$homeWork->slug) }}"> --}}
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>

            
            {{-- <h2>{{$category->name}} -> {{$subcategory->name}} -> {{ $setname->name }} -> Questions</h2> --}}

            {{-- <h2>
                <a href="{{ route('admin.question-bank.index') }}">{{$category->name}}</a> -> 
                <a href="{{ route('admin.question-bank.index', ['id' => $category->slug,'type' =>'subcategory']) }}">{{$subcategory->name}}</a> -> 
                {{ $setname->name }} -> Questions
            </h2> --}}

             <h2>
                <a>{{$category->name}}</a> -> 
                <a>{{$subcategory->name}}</a> -> 
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
            <x-ajax-table :bulkaction="true" bulkactionlink="{{ route('admin.question-bank.bulkaction', ['setname' => $setname->slug]) }}"  tableid="categoryquestiontable"   
            
            :bulkotheraction='[
                ["name"=>"Enable Visible Access","value"=>"visible_status"],
                ["name"=>"Disable Visible Access","value"=>"visible_status_disable"],
               
            ]' 

            
            
            :coloumns='[
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
        // const eventSource = null;
        // var isrefresh=false;
        function questiontableinit(table) {
            questiontable = table

             // Enable state saving to retain page and sort status
             questiontable.state.save();
        }

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
        function importupdate(){
            // isrefresh=true;
            questiontable.ajax.reload()
        }
        // async function loadstatus(){
        //     let response=await fetch("{{route('admin.uploadstatus','question-bank-import-question')}}",{
        //         method: 'GET',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //             'X-Requested-With': 'XMLHttpRequest'
        //         },
        //     })
        //     const message = await response.json();  
        //     if(message.status=="complete"||message.import=="end"||message.import==""||message.import=="stop"){
        //         $('.import-upload-btn').show();
        //         $('.import-cancel-btn').hide()
        //         if(isrefresh){
        //             questiontable.ajax.reload()
        //             isrefresh=false;
        //         }
        //     }else{
        //         $('.import-upload-btn').hide();
        //         $('.import-cancel-btn').show()
        //         $('#import-cancel-btn-text').text(message.completed+"% complete");
        //     }
        //     setTimeout(() => {
        //         loadstatus();
        //     }, 1000);
        // }
        $(function(){
            // loadstatus();
        })
    </script>
    {{-- <script>
        async function loadstatus(){
            
            if(eventSource==null){
                eventSource = new EventSource('{{route('admin.uploadstatus','question-bank-import-question')}}');
                eventSource.onopen = function() {
                    console.log("connected",new Date())
                }
                eventSource.onmessage = function(event) { 
                    console.log("message",new Date())
                    if(typeof event.data=="string"){
                        var message=JSON.parse(event.data);
                    }else{
                        var message=event.data;
                    }

                    if(message.import=="end"){
                        questiontable.ajax.reload()
                    }
                    if(message.status=="complete"||message.import=="end"||message.import==""){
                        $('.import-upload-btn').show();
                        $('.import-cancel-btn').hide()
                    }else{
                        $('.import-upload-btn').hide();
                        $('.import-cancel-btn').show()
                        $('#import-cancel-btn-text').text(message.completed+"% complete");
                    }
                    
                };
                eventSource.onerror = function(error) {
                    eventSource.close();
                    eventSource=null;
                };
            }            
        }
        $(function(){
            loadstatus();
        })
    </script> --}}
@endpush