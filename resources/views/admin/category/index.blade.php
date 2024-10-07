@extends('layouts.admin')
@section('title', 'Category')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Category</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2">
        <div class="container">
            <div class="container-wrap">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" id="table-category-form-create" data-save="create"
                                data-action="{{ route('admin.category.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="name-table-category-form-create">Category Name</label>
                                                    <input type="search" name="name"
                                                        id="name-table-category-form-create" class="form-control ">
                                                    <div class="invalid-feedback"
                                                        id="name-error-table-category-form-create"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <button type="submit" class="btn btn-dark" id="table-category-form-submit"> Add +
                                        </button>
                                        <button type="button" class="btn btn-secondary" style="display: none"
                                            id="table-category-form-clear">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            <x-ajax-table title="Add Category" :coloumns="[
                                ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                                ['th' => 'Category', 'name' => 'name', 'data' => 'name'],
                                ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                            ]"  tableinit="cattableinit"   />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>


@endsection

@push('modals')
    <div class="modal fade bd-example-modal-lg" id="sub-category-create-modal" tabindex="-1" role="dialog"
        aria-labelledby="sub-category-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="sub-category-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sub-category-createLabel">Add Sub Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form  class="form" id="table-subcategory-form-create" data-save="create" data-action="" data-createurl="" >
                        @csrf                
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="name-table-subcategory-form-create">Sub Category Name</label>
                                            <input type="search" name="name" id="name-table-subcategory-form-create" class="form-control "  >
                                            <div class="invalid-feedback" id="name-error-table-subcategory-form-create"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-4 pt-4">  
                                <button type="submit" class="btn btn-dark" id="table-subcategory-form-submit"> Add + </button>  
                                <button type="button" class="btn btn-secondary" style="display: none" id="table-subcategory-form-clear" >Cancel</button>               
                            </div>
                        </div> 
                    </form>

                    <x-ajax-table 
                        beforeajax='beforeajaxcallback' 
                        deletecallbackbefore='deletecallbackbefore' 
                        deletecallbackafter='deletecallbackafter' 
                        :url="route('admin.subcategory_table.show')" 
                        tableinit="subcattableinit" 
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Sub Category', 'name' => 'name', 'data' => 'name'],
                            ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                        ]" /> 
                </div> 
            </div>
            {{-- <div class="modal-content" id="sub-category-set-modal-content" style="display:none">
                <div class="modal-header">
                    <h5 class="modal-title" id="sub-category-set-createLabel">Add Set</h5>
                    <button type="button" class="close" onclick="closesubcategorysetlist()"  >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form  class="form" id="table-subcategoryset-form-create" data-save="create" data-action="" data-createurl="" >
                        @csrf                
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="name-table-subcategoryset-form-create">Set Name</label>
                                            <input type="search" name="name" id="name-table-subcategoryset-form-create" class="form-control "  >
                                            <div class="invalid-feedback" id="name-error-table-subcategoryset-form-create"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-4 pt-4">  
                                <button type="submit" class="btn btn-dark" id="table-subcategoryset-form-submit"> Add + </button>  
                                <button type="button" class="btn btn-secondary" style="display: none" id="table-subcategoryset-form-clear" >Cancel</button>               
                            </div>
                        </div> 
                    </form>
                    <x-ajax-table 
                        beforeajax='beforeajaxcallsub'
                        deletecallbackbefore='deletecallbackbefore' 
                        deletecallbackafter='deletecallbackafter' 
                        :url="route('admin.set_table.show')"
                        tableinit="subcatsettableinit" 
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Set Name', 'name' => 'name', 'data' => 'name'],
                            ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                        ]" />
                </div>
            </div> --}}
        </div>
    </div>

@endpush

@push('footer-script')
    <script>
        var cattable = null;
        var subcattable = null;
        var subcatsettable = null;

        var activedata = {};


        function cattableinit(table) {
            cattable = table
        }
        function deletecallbackbefore(){
            console.log("called")
            $('#sub-category-create-modal').modal('hide');
        }
        function deletecallbackafter(){
            $('#sub-category-create-modal').modal('show');
        }

        function subcattableinit(table, info, config, tableid) {
            subcattable = table
            subcattableID = tableid
        }

        function subcatsettableinit(table) {
            subcatsettable = table
        }

        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (cattable != null) {
                    cattable.ajax.reload()
                }
            }, 'json')
        }

        function subcatvisiblechangerefresh(url) {
            $.get(url, function() {
                if (subcattable != null) {
                    subcattable.ajax.reload()
                }
            }, 'json')
        }

        function subcatsetvisiblechangerefresh(url) {
            $.get(url, function() {
                if (subcatsettable != null) {
                    subcatsettable.ajax.reload()
                }
            }, 'json')
        }

        function beforeajaxcallback(data) {
            data.category = activedata['category'] || "";
            return data;
        }

        function beforeajaxcallsub(data) {
            data.subcategory = activedata['subcategory']||"";
            return data;
        }

        function updatecategory(url) {
            $.get(url, function(res) {
                $('#name-error-table-category-form-create').text("")
                $('#name-table-category-form-create').val(res.name).removeClass("is-invalid")
                $('#table-category-form-create').data('save', "update")
                $('#table-category-form-create').data('action', res.updateUrl)
                $('#table-category-form-clear').show()
                $('#table-category-form-submit').text(' Update ')
            }, 'json')
        }

        function clearcategory() {
            $('#name-error-table-category-form-create').text("")
            $('#name-table-category-form-create').val('').removeClass("is-invalid")
            $('#table-category-form-create').data('save', "create")
            $('#table-category-form-create').data('action', "{{ route('admin.category.store') }}")
            $('#table-category-form-clear').hide()
            $('#table-category-form-submit').text(' Add + ')
        }

        function subcategorylist(url, slug) {
            activedata['category'] = slug; 
            $('#table-subcategory-form-create').data('createurl', url);
            var cat = $(this).data('id');
            console.log(cat);

            $('#sub-category-createLabel').text(cat);
            clearsubcategory();
            $('#sub-category-create-modal').modal('show');
            subcattable.ajax.reload() 
        }

        function updatesubcategory(url) {
            $.get(url, function(res) {
                $('#name-error-table-subcategory-form-create').text("")
                $('#name-table-subcategory-form-create').val(res.name).removeClass("is-invalid")
                $('#table-subcategory-form-create').data('save', "update")
                $('#table-subcategory-form-create').data('action', res.updateUrl)
                $('#table-subcategory-form-clear').show()
                $('#table-subcategory-form-submit').text(' Update ')
            }, 'json')
        }

        function clearsubcategory() {
            $('#name-error-table-subcategory-form-create').text("")
            $('#name-table-subcategory-form-create').val('').removeClass("is-invalid")
            $('#table-subcategory-form-create').data('save', "create")
            $('#table-subcategory-form-create').data('action', $('#table-subcategory-form-create').data('createurl'))
            $('#table-subcategory-form-clear').hide()
            $('#table-subcategory-form-submit').text(' Add + ')
        }
        function closesubcategorysetlist(){
            // $('#sub-category-set-modal-content').hide();
            // $('#sub-category-modal-content').fadeIn();
            // subcattable.ajax.reload() 
        }

        function subcategorysetlist(url, slug) {
            // activedata['subcategory'] = slug; 
            // $('#table-subcategoryset-form-create').data('createurl', url);
            // clearsubcategoryset();
            // $('#sub-category-modal-content').hide();
            // $('#sub-category-set-modal-content').fadeIn();
            // subcatsettable.ajax.reload() 
        }

        function updatesubcategoryset(url) {
            $.get(url, function(res) {
                $('#name-error-table-subcategoryset-form-create').text("")
                $('#name-table-subcategoryset-form-create').val(res.name).removeClass("is-invalid")
                $('#table-subcategoryset-form-create').data('save', "update")
                $('#table-subcategoryset-form-create').data('action', res.updateUrl)
                $('#table-subcategoryset-form-clear').show()
                $('#table-subcategoryset-form-submit').text(' Update ')
            }, 'json')
        }

        function clearsubcategoryset() {
            $('#name-error-table-subcategoryset-form-create').text("")
            $('#name-table-subcategoryset-form-create').val('').removeClass("is-invalid")
            $('#table-subcategoryset-form-create').data('save', "create")
            $('#table-subcategoryset-form-create').data('action', $('#table-subcategoryset-form-create').data('createurl'))
            $('#table-subcategoryset-form-clear').hide()
            $('#table-subcategoryset-form-submit').text(' Add + ')
        }
        $(function() {
            $('#table-category-form-clear').click(clearcategory);
            $('#table-category-form-create').on('submit', function(e) {
                e.preventDefault();
                $('#name-error-table-category-form-create').text("")
                $('#name-table-category-form-create').removeClass("is-invalid")
                if ($(this).data('save') == "create") {
                    $.post($(this).data('action'), {
                        name: $('#name-table-category-form-create').val()
                    }, function(res) {
                        cattable.ajax.reload()
                        clearcategory()
                        showToast(res.success??'Category has been successfully added', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-table-category-form-create').text(errors.name[0])
                            $('#name-table-category-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else if ($(this).data('save') == "update") {
                    $.post($(this).data('action'), {
                        _method: "PUT",
                        name: $('#name-table-category-form-create').val()
                    }, function(res) {
                        cattable.ajax.reload()
                        clearcategory()
                        showToast(res.success??'Category has been successfully updated', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-table-category-form-create').text(errors.name[0])
                            $('#name-table-category-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else {
                    $('#name-error-table-category-form-create').text("Invalid form")
                    $('#name-table-category-form-create').addClass("is-invalid")
                }
            })

            $('#table-subcategory-form-clear').click(clearsubcategory);
            $('#table-subcategory-form-create').on('submit', function(e) {
                e.preventDefault();
                $('#name-error-table-subcategory-form-create').text("")
                $('#name-table-subcategory-form-create').removeClass("is-invalid")
                if ($(this).data('save') == "create") {
                    $.post($(this).data('action'), {
                        name: $('#name-table-subcategory-form-create').val()
                    }, function(res) {
                        subcattable.ajax.reload()
                        clearsubcategory()
                        showToast(res.success??'Sub Category has been successfully added', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-table-subcategory-form-create').text(errors.name[0])
                            $('#name-table-subcategory-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else if ($(this).data('save') == "update") {
                    $.post($(this).data('action'), {
                        _method: "PUT",
                        name: $('#name-table-subcategory-form-create').val()
                    }, function(res) {
                        subcattable.ajax.reload()
                        clearsubcategory()
                        showToast(res.success??'Sub Category has been successfully updated', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-table-subcategory-form-create').text(errors.name[0])
                            $('#name-table-subcategory-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else {
                    $('#name-error-table-subcategory-form-create').text("Invalid form")
                    $('#name-table-subcategory-form-create').addClass("is-invalid")
                }
            })

            $('#table-subcategoryset-form-clear').click(clearsubcategoryset);
            $('#table-subcategoryset-form-create').on('submit', function(e) {
                e.preventDefault();
                $('#name-error-table-subcategoryset-form-create').text("")
                $('#name-table-subcategoryset-form-create').removeClass("is-invalid")
                if ($(this).data('save') == "create") {
                    $.post($(this).data('action'), {
                        name: $('#name-table-subcategoryset-form-create').val()
                    }, function(res) {
                        subcatsettable.ajax.reload()
                        clearsubcategoryset()
                        showToast(res.success??'Sub Category has been successfully added', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-table-subcategoryset-form-create').text(errors.name[0])
                            $('#name-table-subcategoryset-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else if ($(this).data('save') == "update") {
                    $.post($(this).data('action'), {
                        _method: "PUT",
                        name: $('#name-table-subcategoryset-form-create').val()
                    }, function(res) {
                        subcatsettable.ajax.reload()
                        clearsubcategoryset()
                        showToast(res.success??'Sub Category has been successfully updated', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-table-subcategoryset-form-create').text(errors.name[0])
                            $('#name-table-subcategoryset-form-create').addClass("is-invalid")
                        } catch (error) {

                        }
                    })
                } else {
                    $('#name-error-table-subcategoryset-form-create').text("Invalid form")
                    $('#name-table-subcategoryset-form-create').addClass("is-invalid")
                }
            })



        })





















 

        // function CloseCommon() {
        //     $('#table-common-edit').modal('hide');

        //     var commonedit = $('#common_button').data('button');
        //     console.log(commonedit);

        //     if (commonedit == 'subcategory') {
        //         $('#table-sub_category-create').modal('show');
        //     } else if (commonedit == 'set') {
        //         $('#table-addset-create').modal('show');
        //     } else {

        //     }
        // }

 

        // function CloseSet() {
        //     $('#table-addset-create').modal('hide');

        //     $('#table-sub_category-create').modal('show');

        //     // beforeajaxcallback(data);

        //     $('#table-sub_category').DataTable().ajax.reload();
        // }





        // function EditSub(url, slug, type) {

        //     $('#table-form-edit-common').attr('action', url);

        //     var route = "{{ route('admin.get_edit_details') }}";

        //     $.ajax({

        //         url: route,
        //         method: "get",
        //         data: {
        //             slug: slug,
        //             type: type,

        //         },

        //         success: function(response) {



        //             if (type == 'category') {

        //                 $('#table_common_edit_Label').text("Edit Category");

        //                 $('#common_label').text('Category');

        //                 $('#common_button').data('button', 'category');

        //             } else if (type == 'subcategory')

        //             {

        //                 $('#table-sub_category-create').modal('hide');

        //                 $('#table_common_edit_Label').text("Edit Sub Category");

        //                 $('#common_label').text('Subcategory');

        //                 $('#common_button').data('button', 'subcategory');
        //             } else {
        //                 $('#table-addset-create').modal('hide');

        //                 $('#table_common_edit_Label').text("Edit Set Name");

        //                 $('#common_label').text('Set Name');

        //                 $('#common_button').data('button', 'set');

        //             }


        //             $('#table-common-edit').modal('show');

        //             $('#common_name').val(response.name);

        //             $('.invalid-feedback').text('');

        //         },

        //         error: function(xhr) {

        //             var errors = xhr.responseJSON.errors;

        //             console.log(errors);

        //         }
        //     });

        // }

        // function SubCat(url, slug) {

        //     $('#table-sub_category-create').modal('show');

        //     $('.invalid-feedback').text('');

        //     $('#table-form-sub').attr('action', url);
        //     $('#table-sub_category').data('category', slug).DataTable().ajax.reload();

        // }

        // function AddSet(url, slug) {
        //     console.log(url);
        //     $('#table-sub_category-create').modal('hide');

        //     $('#table-addset-create').modal('show');

        //     $('.invalid-feedback').text('');

        //     $('#table-form-addset').attr('action', url);
        //     $('#table-addset').data('set_name', slug).DataTable().ajax.reload();

        // }

        // $(document).ready(function() {

        //     $('#table-form-edit-common').on('submit', function(e) {
        //         e.preventDefault();

        //         $.ajax({
        //             url: $(this).attr('action'),
        //             method: $(this).attr('method'),
        //             data: $(this).serialize(),

        //             success: function(response) {

        //                 $('#table-common-edit').modal('hide');

        //                 if (response.type == 'category') {
        //                     $('#table-module').DataTable().ajax.reload();
        //                 } else if (response.type == 'subcategory') {
        //                     $('#table-sub_category-create').modal('show');

        //                     $('#table-sub_category').DataTable().ajax.reload();
        //                 } else {
        //                     $('#table-addset-create').modal('show');

        //                     $('#table-addset').DataTable().ajax.reload();
        //                 }

        //                 console.log(response.type);

        //                 $('#common_name').val("");

        //                 $('.invalid-feedback').text('');

        //             },

        //             error: function(xhr) {

        //                 var errors = xhr.responseJSON.errors;

        //                 $.each(errors, function(key, value) {

        //                     $('#common_name-error').text(value[0]).show();

        //                 });

        //             }
        //         });
        //     });
        // });

        // $(document).ready(function() {

        //     $('#table-form-sub').on('submit', function(e) {
        //         e.preventDefault();

        //         $.ajax({
        //             url: $(this).attr('action'),
        //             method: $(this).attr('method'),
        //             data: $(this).serialize(),

        //             success: function(response) {

        //                 $('#table-sub_category-create').modal('show');

        //                 $('#table-sub_category').DataTable().ajax.reload();
        //                 $('#sub_name').val("");

        //                 $('.invalid-feedback').text('');

        //             },

        //             error: function(xhr) {

        //                 var errors = xhr.responseJSON.errors;

        //                 $.each(errors, function(key, value) {

        //                     $('#' + key + '-error').text(value[0]).show();

        //                 });

        //             }
        //         });
        //     });
        // });


        // $(document).ready(function() {

        //     $('#table-form-addset').on('submit', function(e) {
        //         e.preventDefault();

        //         $.ajax({
        //             url: $(this).attr('action'),
        //             method: $(this).attr('method'),
        //             data: $(this).serialize(),

        //             success: function(response) {

        //                 $('#table-addset-create').modal('show');

        //                 $('#table-addset').DataTable().ajax.reload();
        //                 $('#set_name').val("");

        //                 $('.invalid-feedback').text('');

        //             },

        //             error: function(xhr) {

        //                 var errors = xhr.responseJSON.errors;

        //                 $.each(errors, function(key, value) {

        //                     $('#' + key + 'set_name-error').text(value[0]).show();

        //                 });

        //             }
        //         });
        //     });
        // });
    </script>
@endpush
