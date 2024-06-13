
<!-- Toasts -->
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer{{$id}}">
    <!-- Toast will be appended here dynamically -->
</div>


@push('before-script')
    <script>

        // Function to show Bootstrap Toasts
        function showToast(message, type, autohide=true) {
            var toastId = 'toast' + Math.random().toString(36).substring(7);
            var toastHTML = `
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="${toastId}">
                    <div class="toast-header bg-${type} text-white">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>`;
            $('#toastContainer{{$id}}').append(toastHTML);
            if(autohide){
                var toastElement = new bootstrap.Toast(document.getElementById(toastId), { autohide: true ,delay:3000 });
                toastElement.show();
            }else{
                var toastElement = new bootstrap.Toast(document.getElementById(toastId), { autohide: false ,delay:-1 });
                toastElement.show();
            }
            return toastId;
        }

        // Function to update Bootstrap Toasts
        function updateToast(toastId, message, type) {
            var toastElement = $('#' + toastId);
            toastElement.find('.toast-header').removeClass('bg-info bg-success bg-danger').addClass('bg-' + type);
            toastElement.find('.toast-body').text(message);
            var toastInstance = new bootstrap.Toast(toastElement[0]);
            toastInstance.show();
        } 
    </script>
@endpush

@push('footer-script')

@session('success')
<script>
    $(function(){
        showToast("{{session('success')}}",'success')
    })
</script>
@endsession

@session('error')
<script>
    $(function(){
        showToast("{{session('error')}}",'danger')
    })
</script>
@endsession

@endpush

