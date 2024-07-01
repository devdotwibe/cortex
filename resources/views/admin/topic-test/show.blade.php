@extends('layouts.admin')
@section('title', $category->name . ' - Questions')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>{{ $category->name }} - Questions</h2>
            </div>
            <div class="header_content">
                <div class="filter-group">
                    <label for="subcategory">Sub Category</label>
                    <select name="subcategory" class="form-control" id="subcategory" data-placeholder="Sub Category"></select>
                </div>
            </div>
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a href="{{ route('admin.topic-test.create', $category->slug) }}"
                            class="nav_link btn">New Questions</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="content_section">
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
                                                    <div class="invalid-feedback" id="time_of_exam-error-table-category-form-create"></div>
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

                        <x-ajax-table tableid="categoryquestiontable" beforeajax="tablefilter" :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Question', 'name' => 'description', 'data' => 'description'],
                            ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                        ]"  tableinit="questiontableinit" />
                    </div>
                </div>
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

        function tablefilter(data) {
            data.sub_category_id = $("#subcategory").val();
            data.sub_category_set = $("#subcategoryset").val()
            return data;
        }
        $(function() {
            $("#subcategory").select2({
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.question-bank.create', $category->slug) }}",
                    data: function(params) {
                        params.parent_id = 0
                        params.name = "sub_category_id";
                        return params;
                    }
                }
            }).change(function() {
                $('#subcategoryset').val('').select2({
                    allowClear: true,
                    ajax: {
                        url: "{{ route('admin.question-bank.create', $category->slug) }}",
                        data: function(params) {
                            params.parent_id = $("#subcategory").val()
                            params.name = "sub_category_set";
                            return params;
                        }
                    }
                })
                $('#table-categoryquestiontable').DataTable().ajax.reload()
            })

            $("#subcategoryset").select2({
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.question-bank.create', $category->slug) }}",
                    data: function(params) {
                        params.parent_id = $("#subcategory").val()
                        params.name = "sub_category_set";
                        return params;
                    }
                }
            }).change(function() {
                $('#table-categoryquestiontable').DataTable().ajax.reload()
            })


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
