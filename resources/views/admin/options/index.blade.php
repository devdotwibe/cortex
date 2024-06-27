@extends('layouts.admin')
@section('title', 'Options')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Options</h2>
        </div>
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
            <div class="container-wrap">
                <div class="row"> 
                    <div class="card">
                        <div class="card-body">
                            <form  class="form" id="table-category-form-create" data-save="create" data-action="{{route('admin.options.store')}}" >
                                @csrf                
                                <div class="row"> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4"> 
                                                    <label for="name-table-category-form-create">Category Name</label>
                                                    <input type="search" name="name" id="name-table-category-form-create" class="form-control "  >
                                                    <div class="invalid-feedback" id="name-error-table-category-form-create"></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-md-4 pt-4">  
                                        <button type="submit" class="btn btn-dark" id="table-category-form-submit"> Add + </button>  
                                        <button type="button" class="btn btn-secondary" style="display: none" id="table-category-form-clear" >Cancel</button>               
                                    </div>
                                </div> 
                            </form>
                            <x-ajax-table tableid="module" title="Add Category" :coloumns='[
                                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                                ["th"=>"Category","name"=>"name","data"=>"name"],
                                ["th"=>"Visible","name"=>"visible_status","data"=>"visibility"],
                            ]'
                            btnsubmit="Add" onclick="CloseModal()" tableinit="cattableinit"
                            :fields='[
                                        ["name"=>"name","label"=>"Category" ,"placeholder"=>"Enter Category Name" ,"size"=>8],

                                    ]'

                            />
                        </div>
                    </div> 
                </div> 
            </div> 

    </div>

    </div>

</section>


@endsection

@push('modals')

    <div class="modal fade bd-example-modal-lg"  id="table-sub_category-create" tabindex="-1" role="dialog" aria-labelledby="table-sub_category-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="table-sub_category-createLabel">Add Sub Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <div class="modal-body">

                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" class="form" id="table-form-sub" method="post">
                                            @csrf

                                            <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">

                                                                    <label for="sub_name">Sub Category</label>

                                                                            <input type="text" name="name" id="sub_name" class="form-control">


                                                                    <div class="invalid-feedback" id="name-error"></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>

                                            <div class="mb-3">

                                                    <a  onclick="CloseSub()" class="btn btn-secondary">Cancel</a>

                                                    <button type="submit" class="btn btn-dark">Save</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <x-ajax-table tableid="sub_category" beforeajax='beforeajaxcallback' :url="route('admin.subcategory_table.show')" tableinit="subcattableinit" :coloumns='[
                                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                                ["th"=>"Sub Category","name"=>"name","data"=>"name"],
                                ["th"=>"Visible","name"=>"visible_status","data"=>"visibility"],

                            ]' />

                        </div>



                    </div>

            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-lg"  id="table-addset-create" tabindex="-1" role="dialog" aria-labelledby="table-addset-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="table-addset-createLabel">Add Set Name</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="CloseSet()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <div class="modal-body">

                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" class="form" id="table-form-addset" method="post">
                                            @csrf

                                            <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">

                                                                    <label for="set_name">Add Set Name</label>

                                                                            <input type="text" name="name" id="set_name" class="form-control">


                                                                    <div class="invalid-feedback" id="set_name-error"></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>
 
                                            <div class="mb-3">

                                                    <a  onclick="CloseSet()" class="btn btn-secondary">Cancel</a>

                                                    <button type="submit" class="btn btn-dark">Save</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <x-ajax-table tableid="addset" beforeajax='beforeajaxcallsub' :url="route('admin.set_table.show')" tableinit="subcatsettableinit"  :coloumns='[
                                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                                ["th"=>"Set Name","name"=>"name","data"=>"name"],
                                ["th"=>"Visible","name"=>"visible_status","data"=>"visibility"],

                            ]' />

                        </div>



                    </div>

            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-lg"  id="table-common-edit" tabindex="-1" role="dialog" aria-labelledby="table-addset-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="table_common_edit_Label"></h5>
                    <button type="button" class="close" data-dismiss="modal" id="common_button" data-button="category" onclick="CloseCommon()"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <div class="modal-body">

                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" class="form" id="table-form-edit-common" method="post">
                                            @csrf

                                        @method('put')

                                            <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">

                                                                    <label for="common_name" id="common_label"></label>

                                                                            <input type="text" name="name" id="common_name" class="form-control">


                                                                    <div class="invalid-feedback" id="common_name-error"></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>

                                            <div class="mb-3">

                                                    <a  onclick="CloseCommon()" class="btn btn-secondary">Cancel</a>

                                                    <button type="submit" class="btn btn-dark">Save</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

            </div>
        </div>
    </div>

@endpush

@push('footer-script')
    <script>

         var cattable=null;
         var subcattable=null;
         var subcatsettable=null;
        function cattableinit(table){
            cattable=table
        }
        function subcattableinit(table){
            subcattable=table
        }
        function subcatsettableinit(table){
            subcatsettable=table
        }
        function visiblechangerefresh(url){
            $.get(url,function(){
                if(cattable!=null){
                    cattable.ajax.reload()
                }
            },'json')
        }
        function subcatvisiblechangerefresh(url){
            $.get(url,function(){
                if(subcattable!=null){
                    subcattable.ajax.reload()
                }
            },'json')
        }

        function subcatsetvisiblechangerefresh(url){
            $.get(url,function(){
                if(subcatsettable!=null){
                    subcatsettable.ajax.reload()
                }
            },'json')
        }
        function AddSubject()
            {

                $('#table-module-static').modal('show');

                $('.invalid-feedback').text('');
            }

        function CloseModal()
        {
            $('#table-module-static').modal('hide');
        }

        function CloseCommon()
        {
            $('#table-common-edit').modal('hide');

            var commonedit = $('#common_button').data('button');
            console.log(commonedit);

            if(commonedit == 'subcategory')
            {
                $('#table-sub_category-create').modal('show');
            }
            else if(commonedit == 'set')
            {
                $('#table-addset-create').modal('show');
            }
            else
            {

            }
        }


        function CloseSub()
        {
            $('#table-sub_category-create').modal('hide');
        }

        function CloseSet()
        {
            $('#table-addset-create').modal('hide');

            $('#table-sub_category-create').modal('show');

            // beforeajaxcallback(data);

            $('#table-sub_category').DataTable().ajax.reload();
        }

        function beforeajaxcallback(data)
        {
            data.category= $('#table-sub_category').data('category');
            return data;
        }

        function beforeajaxcallsub(data)
        {
            data.set_name= $('#table-addset').data('set_name');
            return data;
        }




            function EditSub (url,slug,type)
            {

                $('#table-form-edit-common').attr('action',url);

                var route ="{{ route('admin.get_edit_details') }}";

                $.ajax({

                        url: route,
                        method: "get",
                        data:{
                            slug: slug,
                            type: type,

                        },

                        success: function(response) {



                            if(type =='category')
                            {

                                $('#table_common_edit_Label').text("Edit Category");

                                $('#common_label').text('Category');

                                $('#common_button').data('button','category');

                            }else if(type =='subcategory')

                            {

                                $('#table-sub_category-create').modal('hide');

                                $('#table_common_edit_Label').text("Edit Sub Category");

                                $('#common_label').text('Subcategory');

                                $('#common_button').data('button','subcategory');
                            }
                            else
                            {
                                $('#table-addset-create').modal('hide');

                                $('#table_common_edit_Label').text("Edit Set Name");

                                $('#common_label').text('Set Name');

                                $('#common_button').data('button','set');

                            }


                            $('#table-common-edit').modal('show');

                            $('#common_name').val(response.name);

                            $('.invalid-feedback').text('');

                        },

                        error: function(xhr) {

                            var errors = xhr.responseJSON.errors;

                            console.log(errors);

                        }
                    });

            }

        function SubCat(url,slug)
            {

                $('#table-sub_category-create').modal('show');

                $('.invalid-feedback').text('');

                $('#table-form-sub').attr('action',url);
                $('#table-sub_category').data('category',slug).DataTable().ajax.reload();

            }

            function AddSet(url,slug)
            {
                console.log(url);
                $('#table-sub_category-create').modal('hide');

                $('#table-addset-create').modal('show');

                $('.invalid-feedback').text('');

                $('#table-form-addset').attr('action',url);
                $('#table-addset').data('set_name',slug).DataTable().ajax.reload();

            }

            $(document).ready(function() {

                $('#table-form-edit-common').on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: $(this).serialize(),

                        success: function(response) {

                            $('#table-common-edit').modal('hide');

                            if(response.type == 'category')
                            {
                                $('#table-module').DataTable().ajax.reload();
                            }
                            else if(response.type == 'subcategory')
                            {
                                $('#table-sub_category-create').modal('show');

                                $('#table-sub_category').DataTable().ajax.reload();
                            }
                            else
                            {
                                $('#table-addset-create').modal('show');

                                $('#table-addset').DataTable().ajax.reload();
                            }

                            console.log(response.type);

                            $('#common_name').val("");

                            $('.invalid-feedback').text('');

                        },

                        error: function(xhr) {

                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                $('#common_name-error').text(value[0]).show();

                            });

                        }
                    });
                });
            });

            
            function updatecategory(url){
                $.get(url,function(res){
                    $('#name-error-table-category-form-create').text("")
                    $('#name-table-category-form-create').val(res.name).removeClass("is-invalid")
                    $('#table-category-form-create').data('save',"update")
                    $('#table-category-form-create').data('action',res.updateUrl)
                    $('#table-category-form-clear').show()
                    $('#table-category-form-submit').text(' update ')
                },'json') 
            }
            function clearcategory(){
                $('#name-error-table-category-form-create').text("")
                $('#name-table-category-form-create').val('').removeClass("is-invalid")
                $('#table-category-form-create').data('save',"create")
                $('#table-category-form-create').data('action',"{{route('admin.options.store')}}")
                $('#table-category-form-clear').hide()
                $('#table-category-form-submit').text(' Add + ')
            }

            $(document).ready(function() {
                $('#table-category-form-clear').click(clearcategory);
                $('#table-category-form-create').on('submit', function(e) {
                    e.preventDefault();
                    $('#name-error-table-category-form-create').text("")
                    $('#name-table-category-form-create').removeClass("is-invalid")
                    if($(this).data('save')=="create"){
                        $.post($(this).data('action'),{name:$('#name-table-category-form-create').val()},function(res){
                            cattable.ajax.reload()
                            clearcategory()
                        }).fail(function(xhr){
                            try {
                                var errors = xhr.responseJSON.errors;
                                $('#name-error-table-category-form-create').text(errors.name[0])
                                $('#name-table-category-form-create').addClass("is-invalid")                                
                            } catch (error) {
                                
                            }                            
                             
                        })
                    }else if($(this).data('save')=="update"){
                        $.post($(this).data('action'),{_method:"PUT",name:$('#name-table-category-form-create').val()},function(res){
                            cattable.ajax.reload()
                            clearcategory()
                        }).fail(function(xhr){
                            try {
                                var errors = xhr.responseJSON.errors;
                                $('#name-error-table-category-form-create').text(errors.name[0])
                                $('#name-table-category-form-create').addClass("is-invalid")                                
                            } catch (error) {
                                
                            }                            
                             
                        })
                    }else{
                        $('#name-error-table-category-form-create').text("Invalid form")
                        $('#name-table-category-form-create').addClass("is-invalid")
                    }
                }) 

                $('#table-form-sub').on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: $(this).serialize(),

                        success: function(response) {

                            $('#table-sub_category-create').modal('show');

                            $('#table-sub_category').DataTable().ajax.reload();
                            $('#sub_name').val("");

                            $('.invalid-feedback').text('');

                        },

                        error: function(xhr) {

                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                $('#' + key + '-error').text(value[0]).show();

                            });

                        }
                    });
                });
                });


            $(document).ready(function() {

                $('#table-form-addset').on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: $(this).serialize(),

                        success: function(response) {

                            $('#table-addset-create').modal('show');

                            $('#table-addset').DataTable().ajax.reload();
                            $('#set_name').val("");

                            $('.invalid-feedback').text('');

                        },

                        error: function(xhr) {

                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                $('#' + key + 'set_name-error').text(value[0]).show();

                            });

                        }
                    });
                });
            });


    </script>

@endpush
