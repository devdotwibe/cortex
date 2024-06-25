
<div class="modal fade" id="modal-confirm-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="Lablel-{{$id}}" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="Lablel-{{$id}}"></h5>
                <button type="button" class="close" data-bs-dismiss="modal"    aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <p id="message-{{$id}}"></p> 
                <button type="button" id="modal-confirm-{{$id}}-yes" class="btn btn-dark">Yes</button>
                <button type="button" id="modal-confirm-{{$id}}-no" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('before-script')

<script> 
        function showConfirm(ctx={title:"Action required",message:"please confirm this action"}){ 
            $('#Lablel-{{$id}}').text(ctx.title);
            $('#modal-confirm-{{$id}}').modal('show');  
            return new Promise((resolve, reject) => { 
                $('#modal-confirm-{{$id}}-yes').on('click',function(){
                    $('#modal-confirm-{{$id}}').modal('hide'); 
                    resolve(true);
                }) 
                $('#modal-confirm-{{$id}}-no').on('click',function(){
                    $('#modal-confirm-{{$id}}').modal('hide'); 
                    resolve(false);
                }) 
            })
        } 
        $(function(){
            $('#modal-confirm-{{$id}}').on("hidden.bs.modal",function(){
                $('#modal-confirm-{{$id}}-yes').off('click')
                $('#modal-confirm-{{$id}}-no').off('click')
            })
        })
</script>
@endpush