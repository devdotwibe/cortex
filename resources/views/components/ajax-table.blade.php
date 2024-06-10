<div class="table-outer table-{{ $tableID }}-outer">
    <table class="table" id="table-{{ $tableID }}">
        <thead>
            <tr>
                <th data-th="Sl.No">Sl.No</th>
                @foreach ($coloumns as $item)
                    <th data-th="{{ ucfirst($item->th) }}">{{ ucfirst($item->th) }}</th>
                @endforeach
                <th data-th="Action">Action</th>
            </tr>
        </thead>
        <tbody> 
        </tbody>
    </table>
</div>

@push('modals')
    <div class="modal fade" id="table-{{ $tableID }}-delete" tabindex="-1" role="dialog"
        aria-labelledby="{{ $tableID }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $tableID }}Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action=""  id="table-{{ $tableID }}-delete-form" method="post">
                        @csrf
                        @method("DELETE")
                        <p>Are you sure you want to delete the record </p>
                        <button type="button"  data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button><button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endpush
@push('footer-script')
    <script>
        function deleteRecord(url) {
            $("#table-{{ $tableID }}-delete-form").attr("action",url)
            $('#table-{{ $tableID }}-delete').modal('show')
        } 
        $(function() {
            $('#table-{{ $tableID }}-delete-form').submit(function(e){
                e.preventDefault();
                $.post($(this).attr("action"),$(this).serialize(),function(res){
                    $('#table-{{ $tableID }}').DataTable().ajax.reload();
                    $('#table-{{ $tableID }}-delete').modal('hide')
                })
                return false;
            })
            $('#table-{{ $tableID }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ $url }}",
                },
                order: [
                    [0, 'DESC']
                ],
                initComplete: function(settings) {
                    var info = this.api().page.info();
                    if (info.pages > 1) {
                        $("#table-{{ $tableID }}_wrapper .dataTables_paginate").show();
                    } else {
                        $("#table-{{ $tableID }}_wrapper .dataTables_paginate").hide();
                    }
                    if (info.recordsTotal > 0) {
                        $("#table-{{ $tableID }}_wrapper .pagination").show();
                    } else {
                        $("#table-{{ $tableID }}_wrapper .pagination").hide();
                    }
                },
                drawCallback: function() {
                    var info = this.api().page.info();
                    if (info.pages > 1) {
                        $("#table-{{ $tableID }}_wrapper .dataTables_paginate").show();
                    } else {
                        $("#table-{{ $tableID }}_wrapper .dataTables_paginate").hide();
                    }
                    if (info.recordsTotal > 0) {
                        $("#table-{{ $tableID }}_wrapper .pagination").show();
                    } else {
                        $("#table-{{ $tableID }}_wrapper .pagination").hide();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                    },
                    @foreach ($coloumns as $item)
                        {
                            data: '{{ $item->data }}',
                            name: '{{ $item->name }}',
                            orderable: true,
                            searchable: false,
                        },
                    @endforeach {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
            })
        })
    </script>
@endpush
