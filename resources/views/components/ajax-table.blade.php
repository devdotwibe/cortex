<div class="table-outer table-{{ $tableid }}-outer">
    <table class="table" id="table-{{ $tableid }}">
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
    @endif

    <div class="modal fade" id="table-{{ $tableid }}-delete" tabindex="-1" role="dialog"
        aria-labelledby="{{ $tableid }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $tableid }}Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close"  onclick="DeleteClose('{{ $tableid }}')" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action=""  id="table-{{ $tableid }}-delete-form" method="post">
                        @csrf
                        @method("DELETE")
                        <p>Are you sure you want to delete the record </p>
                        <button type="button" onclick="DeleteClose('{{ $tableid }}')"   class="btn btn-secondary">Cancel</button><button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endpush
@push('footer-script')
   
    <script>

        function DeleteClose(modal)
        {
            console.log(modal);
            $('#table-'+modal+'-delete').modal('hide');

            $('#table-'+modal+'-create').modal('show');
        }

        $(document).ready(function() {

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
                    showToast('Record has been successfully created', 'success', false);

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
        });


        
        $(function() {
            $(document).on('click','#table-{{ $tableid }} .dlt_btn',function(e){
                var url = $(this).data("delete");
                $("#table-{{ $tableid }}-delete-form").attr("action",url);

                $('#table-{{ $tableid }}-create').modal('hide');

                $('#table-{{ $tableid }}-delete').modal('show');

                // console.log('#table-{{ $tableid }}');

            }) 
            $('#table-{{ $tableid }}-delete-form').submit(function(e){
                e.preventDefault();
                $.post($(this).attr("action"),$(this).serialize(),function(res){

                    $('#table-{{ $tableid }}-delete').modal('hide');

                    $('#table-{{ $tableid }}-create').modal('show');

                    $('#table-{{ $tableid }}').DataTable().ajax.reload();

                    showToast('Record has been successfully deleted', 'success', false)
  
                })
                return false;
            })
            $('#table-{{ $tableid }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ $url }}",
                    @if(isset($beforeajax))
                    data:{{$beforeajax}}
                    @endif
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
