
@if ($bulkaction)
<form action="{{$bulkactionlink}}" method="post" id="table-{{ $tableid }}-bulk-action-form">
    @csrf
@endif
<div class="table-outer table-{{ $tableid }}-outer">
    <table class="table" id="table-{{ $tableid }}" style="width: 100%">
        <thead>
            <tr>
                @if ($bulkaction)
                <th>
                    <div class="form-check" id="table-{{ $tableid }}-bulk-box">
                        <input type="checkbox" id="table-{{ $tableid }}-bulk" class="form-check-box" name="select_all" value="yes">

                        <input type="hidden" id="select_all_values" name="select_all_values" >
                    </div>
                </th>                    
                @endif
                <th data-th="Sl.No">Sl.No</th>
                @foreach ($coloumns as $item)
                    <th data-th="{{ ucfirst($item->th) }}">{{ ucfirst($item->th) }}</th>
                @endforeach
                @if($action)
                <th data-th="Action">Action</th>
                @endif
            </tr>
        </thead>
        <tbody> 
        </tbody>
        @if ($bulkaction)
        <tfoot>
            <tr> 
                <td colspan="{{count($coloumns)+2}}"></td>

                <td >
                    <div class="selectbox-action" style="display: none"  >
                        @if(!empty($bulkotheraction))
                        <div class="other-actions"> 
                            <div class="form-group">
                                <select name="bulkaction" class="form-control"  >
                                    @foreach ($bulkotheraction as $item)
                                    <option value="{{$item->value}}">{{$item->name}}</option>                                                
                                    @endforeach
                                </select>
                                @error('bulkaction')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-warning" type="button" onclick="return updateaction{{ $tableid }}('updateaction')" >Submit</button> 
                                <button class="btn btn-danger" type="button" onclick="return updateaction{{ $tableid }}('deleteaction')">
                                    Delete All
                                </button>
                            </div> 
                        </div>
                        @else
                        <div class="delete-action">
                            <button class="btn btn-danger" type="button" onclick="return updateaction{{ $tableid }}('deleteaction')">
                                Delete All
                            </button>                            
                        </div>

                        @endif
                        
                        <input type="hidden" name="deleteaction" id="deleteaction{{ $tableid }}" value="" >

                    </div>
                </td>
            </tr>
        </tfoot>  
        @endif
    </table>
</div>

@if ($bulkaction)
</form > 
@endif


@push('modals') 

    <div class="modal fade" id="table-{{ $tableid }}-delete" tabindex="-1" role="dialog"
        aria-labelledby="{{ $tableid }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $tableid }}Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action=""  id="table-{{ $tableid }}-delete-form" method="post">
                        @csrf
                        @method("DELETE")
                        <p>Are you sure you want to delete the record </p>
                        <button type="button" data-bs-dismiss="modal"   class="btn btn-secondary">Cancel</button><button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endpush
@push('footer-script')
   
    <script>
        async function updateaction{{ $tableid }}(v){
            if(v==='deleteaction'){
                $('#deleteaction{{ $tableid }}').val('deleteaction')
                if (await showConfirm({
                    title: "Are you sure you want to delete these records?"
                })) { 
                    $(`#table-{{ $tableid }}-bulk-action-form`).submit()
                }
            }else{
                $('#deleteaction{{ $tableid }}').val('')
                if (await showConfirm({
                    title: "Are you sure you want to take action on these records?"
                })) { 
                    $(`#table-{{ $tableid }}-bulk-action-form`).submit()
                }
            }
            return false;
        }
 
        $(document).ready(function() {
            $('#table-{{ $tableid }}-delete').on('hidden.bs.modal', function (e) {
                
            }).on('shown.bs.modal', function (e) {
             
            });

            $('#table-{{ $tableid }}-bulk-action-form').submit(function(e){
                e.preventDefault();  
                $.post($(this).attr('action'),$(this).serialize(),function(res){
                    showToast(res.success??'Records has been successfully deleted', 'success');
                    $('#table-{{ $tableid }}').DataTable().ajax.reload();
                    @if ($bulkaction)

                    $('.other-actions').hide();

                    location.reload();
                    
                    @endif

                },'json').fail(function(){
                    showToast('Bulk action failed', 'danger');
                })
            })
            
        });


        
        $(function() {
            $(document).on('click','#table-{{ $tableid }} .dlt_btn',function(e){
                @if(!empty($deletecallbackbefore))
                    {{$deletecallbackbefore}}()
                @endif
                var url = $(this).data("delete");

                @if(!empty($popupid))

                $('#{{ $popupid }}').modal('hide');

                @endif
              
                $("#table-{{ $tableid }}-delete-form").attr("action",url);  
                $('#table-{{ $tableid }}-delete').modal('show'); 
            }) 
            $('#table-{{ $tableid }}-bulk').change(function(){

                let isChecked = $('#table-{{ $tableid }}-bulk').is(":checked");
            $('#table-{{ $tableid }} .selectbox').prop('checked', isChecked);

            // Collect all selected values into an array
            let selectedValues = [];
            if (isChecked) {
                $('#table-{{ $tableid }} .selectbox').each(function () {
                    selectedValues.push($(this).val());
                });
            }

            // Store the array as a string in the hidden input
            $('#select_all_values').val(JSON.stringify(selectedValues));

                if($('#table-{{ $tableid }}-bulk').is(":checked")){
                    $('#table-{{ $tableid }} .selectbox-action').show()
                }else{
                    $('#table-{{ $tableid }} .selectbox-action').hide()
                }
                $('#table-{{ $tableid }}').DataTable().ajax.reload(); 
            })
            $(document).on('change','#table-{{ $tableid }} .selectbox',function(e){
                if(!$(this).is(":checked")){
                    $('#table-{{ $tableid }}-bulk').prop("checked",false);
                }
                if($('#table-{{ $tableid }}-bulk').is(":checked")){
                    $('#table-{{ $tableid }} .selectbox-action').show()
                }else{
                    if($('#table-{{ $tableid }} .selectbox:checked').length>1){
                        $('#table-{{ $tableid }} .selectbox-action').show()
                    }else{
                        $('#table-{{ $tableid }} .selectbox-action').hide()
                    }
                }
            })
            $('#table-{{ $tableid }}-delete-form').submit(async function(e){
                e.preventDefault();  
                $.post($(this).attr("action"),$(this).serialize(),function(res){ 
                    $('#table-{{ $tableid }}-delete').modal('hide');  
                    $('#table-{{ $tableid }}').DataTable().ajax.reload(); 
                    showToast(res.success||'Record has been successfully deleted', 'success')  
                    @if(!empty($deletecallbackafter))
                        {{$deletecallbackafter}}()
                    @endif

                    @if(!empty($popupid))

                    $('#{{ $popupid }}').modal('show');

                    @endif
                })
                return false;
            })
            let start = 0; 
                let limit = 10; 
            table_{{ $tableid }}=$('#table-{{ $tableid }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ $url }}",
                    data:function(d){
                        @if($bulkaction)
                            d.select_all=$('#table-{{ $tableid }}-bulk').is(':checked')?"yes":"no";
                            d.select_all_values = $('#select_all_values').val();
                        @endif

                        @if(isset($beforeajax))
                        return {{$beforeajax}}(d);
                        @else
                        return d;
                        @endif

                        d.start = d.start || 0; 
                        d.limit = d.length || 10;
                    }
                },

               
                info: false, // Disable the "Showing x to y of z entries"
                order: [
                    [0, 'DESC']
                ],
               
                   @if(!empty($hidepagination))
                   drawCallback: function(settings) {
               // Hide the pagination controls on every redraw
                   $('.dataTables_paginate').hide();
               @endif
                 }
                initComplete: function(settings) {
                    var info = this.api().page.info();
                    if (info.pages > 1) {
                        $("#table-{{ $tableid }}_wrapper .pagination").show();
                    } else {
                        $("#table-{{ $tableid }}_wrapper .pagination").hide();
                    }
                    if (info.recordsTotal > 0) { 
                        $("#table-{{ $tableid }}_wrapper .table_info").show();
                    } else { 
                        $("#table-{{ $tableid }}_wrapper .table_info").hide();
                    }
                    if (info.recordsTotal > 1){
                        $('#table-{{ $tableid }}-bulk-box').show()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').show()
                    }else{
                        $('#table-{{ $tableid }}-bulk-box').hide()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').hide()
                    }

                    if($('#table-{{ $tableid }}-bulk').is(":checked")){
                        $('#table-{{ $tableid }} .selectbox-action').show()
                    }else{
                        $('#table-{{ $tableid }} .selectbox-action').hide()
                    }
                    @if(!empty($tableinit))
                        {{$tableinit}}(table_{{ $tableid }},info,settings,'table-{{ $tableid }}')
                    @endif
                },
                drawCallback: function() {
                    var info = this.api().page.info();
                    if (info.pages > 1) {
                        $("#table-{{ $tableid }}_wrapper .pagination").show();
                    } else {
                        $("#table-{{ $tableid }}_wrapper .pagination").hide();
                    }
                    if (info.recordsTotal > 0) {
                        $("#table-{{ $tableid }}_wrapper .table_info").show();
                    } else {
                        $("#table-{{ $tableid }}_wrapper .table_info").hide();
                    }
                    if (info.recordsTotal > 1){
                        $('#table-{{ $tableid }}_wrapper #table-{{ $tableid }}-bulk-box').show()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').show()
                    }else{
                        $('#table-{{ $tableid }}_wrapper #table-{{ $tableid }}-bulk-box').hide()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').hide()
                    }
                    if($('#table-{{ $tableid }}-bulk').is(":checked")){
                        $('#table-{{ $tableid }} .selectbox-action').show()
                    }else{
                        $('#table-{{ $tableid }} .selectbox-action').hide()
                    }
                },
                columns: [
                    @if($bulkaction)
                    {
                        data: 'selectbox',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                    },
                    @endif

                    {
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
                            searchable: true,
                        },
                    @endforeach 
                    @if($action)
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                    },
                    @endif
                ],
            })


            @if(!empty($hidepagination))

                // Load More Button Event
                $('#loadMore').on('click', function() {
                console.log('y');
                start += limit; 
                $.ajax({
                url: "{{ $url }}",
                method: 'GET',
                data: {
                    start: start,
                    limit: limit
                },
                success: function(response) {
                    // Append new rows to the table
                    response.data.forEach(function(row) {
                        table_{{ $tableid }}.row.add(row).draw(false);
                    });

                    // Hide the button if no more data
                    if (response.data.length < limit) {
                        $('#loadMore').hide();
                    }
                }
                });
                });


                @endif


        })



    </script>
@endpush
