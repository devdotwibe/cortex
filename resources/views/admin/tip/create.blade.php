@extends('layouts.admin')
@section('title', 'Tips n Advice')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Tips And Advice</h2>
        </div>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item">
                    <a href="{{ route('admin.tip.storetip', $tip->id) }}" class="nav_link btn">Add Tips And Advice</a>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section admin_section">
    <div class="container">
        <div class="row">
            <div class="table-outer table-categoryquestiontable-outer">
                <table class="table" id="table_tip" style="width: 100%">
                    <thead>
                        <tr>
                            <th data-th="Sl.No">Sl.No</th>
                            <th data-th="Tip">Tip</th>
                            <th data-th="Advice">Advice</th>
                            <th data-th="Action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- The DataTables will handle the content dynamically --}}
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
        $('#table_tip').DataTable({
            paging: false,
            bAutoWidth: false,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ request()->fullUrl() }}",
                type: 'GET',
                dataSrc: function(json) {
                    return json.data; // Return the data for DataTables
                },
                error: function(xhr, error, thrown) {
                    console.error(xhr.responseText); // Log any errors for debugging
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
                    data: 'tip', 
                    name: 'tip', 
                    orderable: true, 
                    searchable: true,
                    render: function(data, type, row) {
                        return $('<div/>').html(data).text(); // Decode HTML entities for 'tip'
                    }
                },
                { 
                    data: 'advice', 
                    name: 'advice', 
                    orderable: true, 
                    searchable: true,
                    render: function(data, type, row) {
                        return $('<div/>').html(data).text(); // Decode HTML entities for 'advice'
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false }
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
