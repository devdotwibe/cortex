@extends('layouts.admin')
@section('title', $category->name.' - Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$category->name}} - Questions</h2>
        </div>
        <div class="header_content">
            <div class="filter-group">
                <label for="subcategory">Sub Category</label>
                <select name="subcategory" class="form-control" id="subcategory" data-placeholder="Sub Category" ></select>
            </div>

            <div class="filter-group">
                <label for="subcategoryset">Set</label>
                <select name="subcategoryset" class="form-control" id="subcategoryset" data-placeholder="Sub Category Set" ></select>
            </div>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.question-bank.create',$category->slug)}}" class="nav_link btn">New Questions</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            <x-ajax-table tableid="categoryquestiontable" beforeajax="tablefilter" :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Question","name"=>"description","data"=>"description"], 
            ]' />
        </div>
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
        function tablefilter(data){
            data.sub_category_id=$("#subcategory").val();
            data.sub_category_set=$("#subcategoryset").val()
            return data;
        }
         $(function(){
            $("#subcategory").select2({
                allowClear: true,
                ajax:{
                    url: "{{route('admin.question-bank.create',$category->slug)}}",
                    data:function (params) { 
                        params.parent_id=0
                        params.name="sub_category_id";
                        return params;
                    }
                }
            }).change(function(){
                $('#subcategoryset').val('').select2({
                    allowClear: true,
                    ajax:{
                        url: "{{route('admin.question-bank.create',$category->slug)}}",
                        data:function (params) { 
                            params.parent_id=$("#subcategory").val()
                            params.name="sub_category_set";
                            return params;
                        }
                    }
                })
                $('#table-categoryquestiontable').DataTable().ajax.reload()
            })

            $("#subcategoryset").select2({
                allowClear: true,
                ajax:{
                    url: "{{route('admin.question-bank.create',$category->slug)}}",
                    data:function (params) { 
                        params.parent_id=$("#subcategory").val()
                        params.name="sub_category_set";
                        return params;
                    }
                }
            }).change(function(){
                $('#table-categoryquestiontable').DataTable().ajax.reload()
            })
         })
    </script>
@endpush