@extends('layouts.admin')
@section('title', 'Term Year')

@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Term Year</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2 categoryclass">
    <div class="container">
        <div class="card">
            <div class="card-body">

                <form id="term-year-form" data-action="{{ route('admin.term_year.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Term Name</label>
                            <input type="text" name="year_name" id="year_name" class="form-control">
                            <div class="invalid-feedback" id="year_name-error"></div>
                        </div>

                        <div class="col-md-4 pt-4">
                            <button type="submit" class="btn btn-dark" id="submit-btn">Add +</button>
                            <button type="button" class="btn btn-secondary d-none" id="clear-btn">Cancel</button>
                        </div>
                    </div>
                </form>

                <table id="termYearTable" class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Term Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</section>
@endsection

@push('modals')


<div class="modal fade show" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-modal="true" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="delete_modalLablel">Delete Confirmation Required</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                     <p>Are you sure you want to delete the record </p>

            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                     Delete
                </button>
            </div>

        </div>
    </div>
</div>


@endpush
@push('footer-script')

<script>

$(document).ready(function () {

    let editId = null;

    const table = $('#termYearTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.term_year.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'year_name' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    $('#term-year-form').on('submit', function (e) {
        e.preventDefault();

        let url = $(this).data('action');
        let formData = new FormData(this);

        if (editId) {
            url = "{{ url('admin/term_year') }}/" + editId;
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                table.ajax.reload();
                resetForm();
                showToast(res.message ?? 'Saved successfully', 'success');
            },
            error: function (xhr) {
                $('.invalid-feedback').hide();
                if (xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('#' + key + '-error').text(value[0]).show();
                    });
                }
            }
        });
    });

    $('#termYearTable').on('click', '.edit-btn', function () {
        editId = $(this).data('id');

        $.get("{{ url('admin/term_year') }}/" + editId + "/edit", function (res) {
            $('#year_name').val(res.year_name);
            $('#submit-btn').text('Update');
            $('#clear-btn').removeClass('d-none');
        });
    });

    // $('#termYearTable').on('click', '.delete-btn', function () {
    //     let id = $(this).data('id');

    //     if (!confirm('Are you sure?')) return;

    //     $.ajax({
    //         url: "{{ url('admin/term_year') }}/" + id,
    //         type: 'POST',
    //         data: {
    //             _token: "{{ csrf_token() }}",
    //             _method: 'DELETE'
    //         },
    //         success: function (res) {
    //             table.ajax.reload();
    //             showToast(res.message ?? 'Deleted successfully', 'success');
    //         }
    //     });
    // });

    let deleteId = null;

    $('#termYearTable').on('click', '.delete-btn', function () {
        deleteId = $(this).data('id');
        $('#delete_modal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function () {

        if (!deleteId) return;

        $.ajax({
            url: "{{ url('admin/term_year') }}/" + deleteId,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                _method: 'DELETE'
            },
            success: function (res) {

                $('#delete_modal').modal('hide');
                deleteId = null;

                table.ajax.reload(null, false);
                showToast(res.message ?? 'Deleted successfully', 'success');
            },
            error: function () {
                showToast('Delete failed', 'error');
            }
        });
    });


    $('#clear-btn').on('click', function () {
        resetForm();
    });

    function resetForm() {
            editId = null;
            $('#term-year-form')[0].reset();
            $('#submit-btn').text('Add +');
            $('#clear-btn').addClass('d-none');
            $('.invalid-feedback').hide();
        }

    });
</script>
@endpush

