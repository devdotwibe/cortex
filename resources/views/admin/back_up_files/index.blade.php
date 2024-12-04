@extends('layouts.admin')
@section('title', 'Back Up Files')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.tip.index') }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>
            <h2> Back Up Files</h2>
        </div>

    </div>
</section>

<div class="header_content">
    <div class="form-group">
        <select id="subcat-list" class="select2 form-control" data-placeholder="Select a Sub Category" data-allow-clear="true" data-ajax--url="{{ route('admin.learn.create', $category->slug) }}"></select>
    </div>
</div>

<section class="content_section admin_section">
    <div class="container">
        <div class="row">
            <div class="table-outer table-categoryquestiontable-outer">
                <table class="table" id="back_up_table" style="width: 100%">
                    <thead>
                        <tr>
                            <th data-th="Sl.No">Sl.No</th>
                            <th data-th="user">Admin User Name</th>
                            <th data-th="question">Question</th>
                            <th data-th="question">Question Type</th>
                            <th data-th="delted_at">Deleted At</th>
                            <th data-th="Action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal for delete confirmation -->
<div class="modal fade" id="table_faq_delete" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationLabel">Delete Confirmation Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="table-delete-form" method="post">
                    @method('DELETE')
                    @csrf
                    <p>Are you sure you want to delete this record?</p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')
<script>
    $(function() {
        $('#back_up_table').DataTable({
            paging: false,
            bAutoWidth: false,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ request()->fullUrl() }}",
                type: 'GET',
                dataSrc: function(json) {
                    return json.data; 
                },
                error: function(xhr, error, thrown) {
                    console.error(xhr.responseText); 
                }
            },
            initComplete: function(settings) {
                var info = this.api().page.info();
                $(".dataTables_paginate").toggle(info.pages > 1);
                $(".dataTables_info").toggle(info.recordsTotal > 0);
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false },
                { 
                    data: 'admin_user', 
                    name: 'admin_user', 
                    orderable: true, 
                    searchable: true,
                 
                },
                { 
                    data: 'question', 
                    name: 'question', 
                    orderable: true, 
                    searchable: true,
                 
                },
                { 
                    data: 'question_type', 
                    name: 'question_type', 
                    orderable: true, 
                    searchable: true,
                 
                },
                
                { 
                    data: 'deleted_at', 
                    name: 'deleted_at', 
                    orderable: true, 
                    searchable: true,
                 
                },

                {   
                    data: 'action',
                     name: 'action', 
                    orderable: false,
                    searchable: false 
                }
            ]
        });
    });

    function delsubfaq(url) {
        $('#table-delete-form').attr('action', url);
        $('#table_faq_delete').modal('show');
    }

    function updatesubfaq(url) {
        $.get(url, function(res) {
            $('#name-error-table-subcategory-form-create').text("")
            $('#name-table-subcategory-form-create').val(res.question).removeClass("is-invalid")
            $('#name-table-subcategory-form-create-ans').val(res.answer).removeClass("is-invalid")
            $('#subcategory').data('save', "update")
            $('#subcategory').attr('action', res.updateUrl)
            $('#table-subcategory-form-clear').show()
            $('#table-subcategory-form-submit').text(' Update ')
        }, 'json')
    }

</script>
@endpush
