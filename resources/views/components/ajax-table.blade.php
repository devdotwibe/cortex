<div class="table-outer table-{{$tableID}}-outer">
    <table class="table" id="table-{{$tableID}}">
        <thead>
            <tr>
                <th data-th="Sl.No">Sl.No</th>
                @foreach ($coloumns as $item)
                <th data-th="{{ucfirst($item->th)}}">{{ucfirst($item->th)}}</th>                    
                @endforeach
                <th data-th="Action">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- 
            <tr>
                <td>1</td>
                <td>2023-11-03</td>
                <td>Amal</td>
                <td>Aluva</td>
                <td>
                    <a href="" class="btn btn-icons view_btn"><img
                            src="./assets/images/view.svg" alt=""></a>
                    <a href="" class="btn btn-icons edit_btn"><img
                            src="./assets/images/edit.svg" alt=""></a>
                    <a href="" class="btn btn-icons dlt_btn"><img
                            src="./assets/images/delete.svg" alt=""></a>
                </td>
            </tr> 
            --}}
        </tbody>
    </table>
</div>

@push('footer-script')
    <script>
        $(function(){
            $('#table-{{$tableID}}').DataTable({
                processing:true,
                serverSide:true,
                ajax:{
                    url:"{{$url}}",
                },
                order:[[0,'DESC']],
                initComplete:function(settings){
                    var info = this.api().page.info(); 
                    if(info.pages>1){
                        $("#table-{{$tableID}}_wrapper .dataTables_paginate").show();
                    }else{
                        $("#table-{{$tableID}}_wrapper .dataTables_paginate").hide();
                    }
                    if(info.recordsTotal>0) {
                        $("#table-{{$tableID}}_wrapper .pagination").show();
                    }
                    else{
                        $("#table-{{$tableID}}_wrapper .pagination").hide();
                    }
                },
                drawCallback:function(){
                    var info = this.api().page.info(); 
                    if(info.pages>1){
                        $("#table-{{$tableID}}_wrapper .dataTables_paginate").show();
                    }else{
                        $("#table-{{$tableID}}_wrapper .dataTables_paginate").hide();
                    }
                    if(info.recordsTotal>0) {
                        $("#table-{{$tableID}}_wrapper .pagination").show();
                    }
                    else{
                        $("#table-{{$tableID}}_wrapper .pagination").hide();
                    }
                },
                columns:[
                    {
                        data:'DT_RowIndex',
                        name:'id',
                        orderable: true,
                        searchable: false,
                    },
                    @foreach ($coloumns as $item)
                    {
                        data:'{{$item->data}}',
                        name:'{{$item->name}}',
                        orderable: true,
                        searchable: false,
                    },
                    @endforeach
                    {
                        data:'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
            })
        })
    </script>
@endpush