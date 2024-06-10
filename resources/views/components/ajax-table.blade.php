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

@push('modals')
    

<div class="modal fade"  id="table-{{$tableID}}-delete" tabindex="-1" role="dialog" aria-labelledby="{{$tableID}}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="{{$tableID}}Lablel">Delete Record</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

                <div class="modal-body">

                    <x-modal-form  :url="route('admin.learn.store',)" btnsubmit="Add" onclick="CloseModal()" :fields='[
                        ["name"=>"subject","label"=>"Subject" ,"placeholder"=>"Enter Subject Name" ,"size"=>8],
                        
                    ]' /> 
                        
                </div>

        </div>
    </div>
</div>
@endpush
@push('footer-script')
    <script>
        function deleteRecord(url){
            
        } 
        function deleteRecordConfirm(url){
            
        } 
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