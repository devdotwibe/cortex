@extends('layouts.admin')
@section('title', 'Faq')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>FAQ</h2>
            </div>
        </div>
    </section>
    <style>
        .limit-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Limits to 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <section class="invite-wrap mt-2">
        <div class="container">
            <div class="container-wrap">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" id="table-category-form-create" data-save="create" method="post"
                                action="{{ route('admin.faq.store') }}">

                                <div class="row tabouter">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="name-table-category-form-create">FAQ Name</label>
                                                    <input type="search" name="name"
                                                        id="name-table-category-form-create" data-field-input="name"
                                                        class="form-control ">
                                                    <div class="invalid-feedback " data-field="name"
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
                            <div class="table-outer table-tbBeGSR1724912703-outer">
                                <table class="table" id="table-faq" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th data-th="Sl.No">Sl.No</th>
                                            <th data-th="Category">Faq</th>

                                            <th data-th="Action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>

@endsection

@push('modals')
    <div class="modal fade bd-example-modal-lg faq-modal" id="sub-category-create-modal" tabindex="-1" role="dialog"
        aria-labelledby="sub-category-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="sub-category-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sub-category-createLabel">Add Questions</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="subcategory" method="post" action="{{ route('admin.faq.subfaq-store') }}">
                        {{-- action="" data-save="create" data-action="" data-createurl="" > --}}
                        @csrf
                        <div class="row faq-form">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4">
                                            <div class="tabfaq">
                                                <label for="name-table-subcategory-form-create">Question</label>
                                                <input type="text" name="question"
                                                    id="name-table-subcategory-form-create" data-field-input="question"
                                                    class="form-control ">

                                                <div class="invalid-feedback" data-update="question"
                                                    id="name-error-table-subcategory-form-create"></div>
                                            </div>
                                            <div class="tabfaq">
                                                <label for="name-table-subcategory-form-create">Answer</label>
                                                <textarea name="answer" id="name-table-subcategory-form-create-ans" class="form-control" data-field-input="answer"
                                                    cols="30" rows="5"></textarea>

                                                <div class="invalid-feedback" data-update="answer"
                                                    id="name-error-table-subcategory-form-create"></div>
                                                {{-- <input type="text" name="name" id="name-table-subcategory-form-create" class="form-control "  > --}}
                                            </div>
                                            <input type="hidden" name="faq_id" id="faq_id" value="">


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pt-4">
                                <button type="submit" class="btn btn-dark" id="table-subcategory-form-submit"> Submit
                                </button>
                                <button type="button" class="btn btn-secondary" style="display: none"
                                    id="table-subcategory-form-clear">Cancel</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-outer">
                        <table class="table" id="subfaq" style="width: 100%">
                            <thead>
                                <tr>
                                    <th data-th="Sl.No">Sl.No</th>
                                    <th data-th="question">Question</th>
                                    <th data-th="answer">Answer</th>
                                    <th data-th="Action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="table_faq_delete" tabindex="-1" role="dialog"
        aria-labelledby="tbBpi7u1724940550Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="tbBpi7u1724940550Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" id="table-delete-form" method="post">
                        @method('DELETE')
                        @csrf

                        <p>Are you sure you want to delete the record </p>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button><button
                            type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endpush


@push('footer-script')
    <script>
        // function checkLineLimit(textarea, lineLimit) {
        //     let lines = textarea.value.split(/\n/);
        //     if (lines.length > lineLimit) {
        //         // Trim extra lines
        //         textarea.value = lines.slice(0, lineLimit).join("\n");
        //     }
        //     document.getElementById('line-count').textContent = `${lines.length}/${lineLimit} lines`;
        // }


        $(function() {

            console.log('1');
            $('#table-faq').DataTable({
                // bFilter: false,
                // bLengthChange: false,
                paging: false,
                bAutoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ request()->fullUrl() }}",

                    method: 'get',
                    // "data": function ( d ) {


                    //     }
                },
                initComplete: function(settings) {
                    var info = this.api().page.info();

                    if (info.pages > 1) {
                        $(".dataTables_paginate").show();
                    } else {
                        $(".dataTables_paginate").hide();

                    }
                    if (info.recordsTotal == 0) {
                        $(".dataTables_info").hide();
                    } else {
                        $(".dataTables_info").show();
                    }
                },
                drawCallback: function() {

                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },

                ]
            });
        });


        $(function() {

            

            $('#subfaq').DataTable({
                // bFilter: false,
                // bLengthChange: false,
                paging: false,
                bAutoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ route('admin.faq.subfaq_table') }}",
                    data: function(d) {
                        d.faqid = $('#faq_id').val();
                    }
                },
                initComplete: function(settings) {
                    var info = this.api().page.info();

                    if (info.pages > 1) {
                        $(".dataTables_paginate").show();
                    } else {
                        $(".dataTables_paginate").hide();
                    }
                    if (info.recordsTotal == 0) {
                        $(".dataTables_info").hide();
                    } else {
                        $(".dataTables_info").show();
                    }
                },
                drawCallback: function() {

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                    },
                    {
                        data: 'question',
                        name: 'question',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'answer',
                        name: 'answer',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            return `<div class="limit-text">${data}</div>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
        });


        $(function() {

            

            $('#table-category-form-create').on('submit', function(e) {
                e.preventDefault();


                $('.error').html('');
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                      
                        $('#table-category-form-create')[0].reset();

                  
                        $('#table-category-form-submit').text(' Add + ');

                        $('#subcategory').attr('action', '{{ route('admin.faq.store') }}');
                        

                        const actionUrl = "{{ route('admin.faq.store') }}";

                        

                     
                        $('#table-category-form-clear').hide();



                       
                        $('#table-faq').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;

                        for (var key in errors) {
                            $('[data-field="' + key + '"]').html(errors[key][0]);
                            $('[data-field-input="' + key + '"]').addClass('is-invalid');
                        }
                    }
                });
            });

            $('#table-category-form-clear').on('click', function() {


                var storeurl = "{{ route('admin.faq.store') }}";
                // Reset the form fields
                $('#table-category-form-create')[0].reset();

                // Reset the button text back to "Add +"
                $('#table-category-form-submit').text(' Add + ');

                $('#table-category-form-create').attr('action', storeurl)

                // Hide the cancel button
                $(this).hide();
               
            });



        });


        function delfaq(url) 

        {

            $('#table-delete-form').attr('action', url);
            $('#table_faq_delete').modal('show');


        }

        function delsubfaq(url) {

         
            $('#table-delete-form').attr('action', url);

        
            $('#table_faq_delete').modal('show');

           
            $('#table-delete-form').off('submit').on('submit', function(e) {
                e.preventDefault(); 

                var formAction = $(this).attr('action'); 

            
                $.ajax({
                    url: formAction,
                    method: 'POST',
                    data: $(this).serialize(), 
                    success: function(response) {
                       
                        $('#table_faq_delete').modal('hide');
                        $('#subcategory')[0].reset();
                     
                        $('#table-subcategory-form-submit').text(' Submit ');

                    
                        $('#table-subcategory-form-clear').hide();

                      
                        $('#subcategory').data('save', ""); 
                        $('#subcategory').attr('action', '{{ route('admin.faq.subfaq-store') }}');
                        $('#subfaq').DataTable().ajax.reload();

                        // $('#sub-category-create-modal').modal('show');

                     
                    },
                    error: function(xhr) {
                        console.error(xhr);
                       
                    }
                });
            });
        }

        function onDeleteSuccess() {

       
            $('#table_faq_delete').modal('hide');

           
            //$('#nextModalId').modal('show');

           
        }

        var activedata = {};

        function addsubfaq(url, id) {


            $('#faq_id').val(id);
            $('#table-category-form-create').attr('action', url);
            //clearsubcategory();
            $('#sub-category-create-modal').modal('show');

            $('#subfaq').DataTable().ajax.reload();
            //subcattable.ajax.reload()
            //$('#table-faq').ajax.reload(); 
        }

        function updatefaq(url) {

            $.get(url, function(res) {

                $('#name-error-table-category-form-create').text("")
                $('#name-table-category-form-create').val(res.name).removeClass("is-invalid")
                $('#table-category-form-create').data('save', "update")
                $('#table-category-form-create').attr('action', res.updateUrl)
                $('#table-category-form-clear').show()
                //$('#table-category-form-create')[0].reset();
                $('#table-category-form-submit').text(' Update ')
            }, 'json').fail(function(xhr, status, error) {
                console.log(error)
                console.log(xhr, status)

            })
        }

        function updatesubfaq(url) {

            $.get(url, function(res) {
             
                $('#name-error-table-subcategory-form-create').text("");
                $('#name-table-subcategory-form-create').val(res.question).removeClass("is-invalid");
                $('#name-table-subcategory-form-create-ans').val(res.answer).removeClass("is-invalid");

              
                $('#subcategory').data('save', "update");
                $('#subcategory').attr('action', res.updateUrl);

              
                $('#table-subcategory-form-clear').show();
                $('#table-subcategory-form-submit').text(' Update ');

            }, 'json').fail(function(xhr, status, error) {
                console.log(error);
                console.log(xhr, status);
            });
        }


        $('#table-subcategory-form-clear').on('click', function() {

            
            $('#subcategory')[0].reset();
            console.log("test");
           
            $('#name-error-table-subcategory-form-create').text("");
            $('#name-table-subcategory-form-create').removeClass("is-invalid");
            $('#name-table-subcategory-form-create-ans').removeClass("is-invalid");

          
            $('#subcategory').data('save', "create");
            $('#subcategory').attr('action',
            '{{ route('admin.faq.subfaq-store') }}'); 
        
            $('#table-subcategory-form-clear').hide();

         
            $('#table-subcategory-form-submit').text('Submit');
        });
    </script>
@endpush
