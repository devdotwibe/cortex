@extends('layouts.admin')
@section('title', 'Hashtag')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Hashtag</h2>
        </div>
    </div>
</section>
{{-- <style>
    .limit-text {
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Limits to 3 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style> --}}
<section class="invite-wrap mt-2">
    <div class="container">
        <div class="container-wrap">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form class="form" id="table-category-form-create" data-save="create" method="post" action="{{ route('admin.community.hashtags.store') }}">
                            @csrf
                            <div class="row tabouter">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-data">
                                            <div class="forms-inputs mb-4">
                                                <label for="name-table-category-form-create">Hashtag Name</label>
                                                <input type="text" name="name" id="name-table-category-form-create" data-field-input="name" class="form-control">
                                                <div class="invalid-feedback" data-field="name" id="name-error-table-category-form-create"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pt-4">
                                    <button type="submit" class="btn btn-dark" id="table-category-form-submit">Add +</button>
                                    <button type="button" class="btn btn-secondary" style="display: none" id="table-category-form-clear">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-outer table-tbBeGSR1724912703-outer">
                            <table class="table" id="table-hashtag" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th data-th="Sl.No">Sl.No</th>
                                        <th data-th="Hashtag">Hashtag</th>
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
</section>
@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#table-faq').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.hashtag.index') }}", // URL to fetch the data
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // For serial number
                { data: 'name', name: 'name' }, // Assuming 'name' is the column in the hashtags table
                { data: 'action', name: 'action', orderable: false, searchable: false }, // For action buttons
            ],
            order: [[0, 'asc']], // Default ordering by the first column
            pageLength: 10, // Number of rows per page
            lengthMenu: [10, 25, 50, 100], // Page length options
        });

        // Function to handle deleting a hashtag
        window.deleteHashtag = function(url) {
            if (confirm('Are you sure you want to delete this hashtag?')) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function(response) {
                        table.ajax.reload(); // Reload the DataTable
                        alert(response.success); // Show success message
                    },
                    error: function(xhr) {
                        alert('Error deleting hashtag: ' + xhr.responseText);
                    }
                });
            }
        };

        // Function to handle editing a hashtag
        window.editHashtag = function(url) {
            window.location.href = url; // Redirect to the edit page
        };
    });
</script>
@endsection

