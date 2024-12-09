@extends('layouts.admin')
@section('title', $category->name . ' - Questions')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                    <a href="{{ route('admin.topic-test.index') }}">
                        <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                    </a>
                </div>
                <h2>{{ $category->name }} - Questions</h2>
            </div> 
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a href="{{ route('admin.topic-test.create', $category->slug) }}"
                            class="nav_link btn">New Questions</a></li>
                    <li class="nav_item import-upload-btn" @if(get_option('topic-test-import-question','')=="started") style="display: none" @endif>
                        <x-ajax-import 
                            :url="route('admin.topic-test.import',$category->slug)" 
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
                    <li class="nav_item import-cancel-btn" @if(get_option('topic-test-import-question-'.$category->slug,'')!=="started") style="display: none" @endif >
                        <a href="{{route('admin.uploadcancel','topic-test-import-question-'.$category->slug)}}">
                            <p id="import-cancel-btn-text">{{ get_option('topic-test-import-question-completed-'.$category->slug) }} % Completed</p>
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
                <div class="card">
                    <div class="card-body">
                        <div class="form">
                            <form action="{{ route('admin.topic-test.updatetime', $category->slug) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="time_of_exam-table-category-form-create">Exam Duration (HH:MM)</label>
                                                    <input type="search" name="time_of_exam" id="time_of_exam-table-category-form-create" value="{{$category->time_of_exam}}" class="form-control ">
                                                    @error('time_of_exam')
                                                    <div class="invalid-feedback" id="time_of_exam-error-table-category-form-create" style="display: block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pt-4">
                                        <button type="submit" class="btn btn-dark ml-1">Save</button>
                                    </div>
                                </div> 
                            </form>
                        </div>

                        <x-ajax-table :bulkaction="true" :order="false" bulkactionlink="{{ route('admin.topic-test.bulkaction', ['category' => $category->slug,'exam'=>$exam->slug]) }}"  tableid="categoryquestiontable"  

                        
                        :bulkotheraction='[
                            ["name"=>"Enable Visible Access","value"=>"visible_status"],
                            ["name"=>"Disable Visible Access","value"=>"visible_status_disable"],
                           
                        ]' 
                        
                        
                        
                        
                        
                        
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Question', 'name' => 'description', 'data' => 'description'],
                            ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                        ]" tableinit="questiontableinit" />
                    </div>
                </div>
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
        function importupdate(){ 
            questiontable.ajax.reload()
        }
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
        $(function() { 


            $('#time_of_exam-table-category-form-create').each(function(){
                var mask = $(this).data('mask');
                var placeholder = $(this).data('placeholder')||" ";
                $(this).inputmask({
                    placeholder:"HH : MM",
                    regex: "^(0[0-9]|1[0-9]|2[0-4]) : [0-5][0-9]$",
                    showMaskOnFocus: false
                });
            })
        })
    </script>
@endpush
