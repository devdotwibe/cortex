
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
                    </div>
                </th>                    
                @endif
                <th data-th="Sl.No">Sl.No</th>
                @foreach ($coloumns as $item)
                    <th data-th="{{ ucfirst($item->th) }}">{{ ucfirst($item->th) }}</th>
                @endforeach
                <th data-th="Action">Action</th>
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
                        <button class="btn btn-danger" name="bulkaction" value="delete">
                            Delete
                        </button>
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
{{-- 
    @if ($ajaxcreate??false)
        

        <div class="modal fade bd-example-modal-lg"  id="table-{{ $tableid }}-static" tabindex="-1" role="dialog" aria-labelledby="table-{{ $tableid }}-createLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="table-{{ $tableid }}-createLabel">{{ $title??"Add" }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body">

                            <div class="row"> 
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{$createurl}}" class="form" id="table-{{ $tableid }}-form-create" method="post">
                                            @csrf 
                            
                                            <div class="row">
                                                @foreach ($fields as $item)
                                                    <div class="col-md-{{$item->size??4}}">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 
                                                                    <label for="{{$item->name}}-table-{{ $tableid }}-form-create">{{ucfirst($item->label??$item->name)}}</label>
                                                                    @switch($item->type??"text")
                                                                        @case('textarea')
                                                                            <textarea name="{{$item->name}}" id="{{$item->name}}-table-{{ $tableid }}-form-create"  class="form-control @error($item->name) is-invalid @enderror "  rows="5" @readonly($item->readonly??false) >{{old($item->name)}}</textarea>
                                                                            @break
                                                                        @case('select')
                                                                            <select name="{{$item->name}}" id="{{$item->name}}-table-{{ $tableid }}-form-create">
                            
                                                                            </select>
                                                                            @break
                                                                        @default
                                                                            <input type="{{$item->type??"text"}}" name="{{$item->name}}" id="{{$item->name}}-table-{{ $tableid }}-form-create" value="{{old($item->name,$item->value??"")}}" class="form-control @error($item->name) is-invalid @enderror " @readonly($item->readonly??false) >        
                                                                    @endswitch
                                                                    
                                                                   
                                                                    <div class="invalid-feedback" id="{{$item->name}}-error-table-{{ $tableid }}-form-create"></div>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                @endforeach
                                                 
                                            </div>
                            
                                            <div class="mb-3"> 
                                                @if(!empty($cancel))
                                                    <a href="{{ $cancel }}"  class="btn btn-secondary">Cancel</a>
                                                @elseif(!empty($onclick))                            
                                                    <a  onclick="{{ $onclick }}" class="btn btn-secondary">Cancel</a>
                            
                                                @endif
                            
                                                    <button type="submit" class="btn btn-dark">{{$btnsubmit}}</button> 
                            
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div> 
                                
                        </div>

                </div>
            </div>
        </div>
    @endif --}}

    <div class="modal fade" id="table-{{ $tableid }}-delete" tabindex="-1" role="dialog"
        aria-labelledby="{{ $tableid }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $tableid }}Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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
 
        $(document).ready(function() {

            $('#table-{{ $tableid }}-bulk-action-form').submit(function(e){
                e.preventDefault();
                $.post($(this).attr('action'),$(this).serialize(),function(res){
                    showToast(res.success??'Records has been successfully deleted', 'success');
                    $('#table-{{ $tableid }}').DataTable().ajax.reload();
                },'json').fail(function(){
                    showToast('Bulk action failed', 'danger');
                })
            })
            /*
            $('#table-{{ $tableid }}-form-create').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    
                    success: function(response) {

                        
                        $('#table-{{ $tableid }}-create').modal('hide');

                        $('#table-{{ $tableid }}-static').modal('hide');

                        $('#table-{{ $tableid }}').DataTable().ajax.reload();
                        showToast('Record has been successfully created', 'success');

                        $('.invalid-feedback').text('');

                        $('#{{$item->name}}-table-{{ $tableid }}-form-create').val('');
                    },

                    error: function(xhr) {

                        var errors = xhr.responseJSON.errors;
                        
                        $.each(errors, function(key, value) {

                            $('#' + key + '-error-table-{{ $tableid }}-form-create').text(value[0]).show();

                        });

                    }
                });
            });
            */
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
            $('#table-{{ $tableid }}-delete-form').submit(function(e){
                e.preventDefault();
                $.post($(this).attr("action"),$(this).serialize(),function(res){ 
                    $('#table-{{ $tableid }}-delete').modal('hide');  
                    $('#table-{{ $tableid }}').DataTable().ajax.reload(); 
                    showToast('Record has been successfully deleted', 'success')  
                    @if(!empty($deletecallbackafter))
                        {{$deletecallbackafter}}()
                    @endif

                    @if(!empty($popupid))

                    $('#{{ $popupid }}').modal('show');

                    @endif
                })
                return false;
            })
            table_{{ $tableid }}=$('#table-{{ $tableid }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ $url }}",
                    data:function(d){
                        @if($bulkaction)
                            d.select_all=$('#table-{{ $tableid }}-bulk').is(':checked')?"yes":"no";
                        @endif

                        @if(isset($beforeajax))
                        return {{$beforeajax}}(d);
                        @else
                        return d;
                        @endif
                    }
                },
                order: [
                    [0, 'DESC']
                ],
                initComplete: function(settings) {
                    var info = this.api().page.info();
                    if (info.pages > 1) {
                        $("#table-{{ $tableid }}_wrapper .dataTables_paginate").show();
                    } else {
                        $("#table-{{ $tableid }}_wrapper .dataTables_paginate").hide();
                    }
                    if (info.recordsTotal > 0) { 
                        $("#table-{{ $tableid }}_wrapper .pagination").show();
                    } else { 
                        $("#table-{{ $tableid }}_wrapper .pagination").hide();
                    }
                    if (info.recordsTotal > 1){
                        $('#table-{{ $tableid }}-bulk-box').show()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').show()
                    }else{
                        $('#table-{{ $tableid }}-bulk-box').hide()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').hide()
                    }
                    @if(!empty($tableinit))
                        {{$tableinit}}(table_{{ $tableid }},info,settings,'table-{{ $tableid }}')
                    @endif
                },
                drawCallback: function() {
                    var info = this.api().page.info();
                    if (info.pages > 1) {
                        $("#table-{{ $tableid }}_wrapper .dataTables_paginate").show();
                    } else {
                        $("#table-{{ $tableid }}_wrapper .dataTables_paginate").hide();
                    }
                    if (info.recordsTotal > 0) {
                        $("#table-{{ $tableid }}_wrapper .pagination").show();
                    } else {
                        $("#table-{{ $tableid }}_wrapper .pagination").hide();
                    }
                    if (info.recordsTotal > 1){
                        $('#table-{{ $tableid }}_wrapper #table-{{ $tableid }}-bulk-box').show()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').show()
                    }else{
                        $('#table-{{ $tableid }}_wrapper #table-{{ $tableid }}-bulk-box').hide()
                        $('#table-{{ $tableid }}_wrapper .selectbox-box').hide()
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
