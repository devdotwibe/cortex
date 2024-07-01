@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Settings</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2">
        <div class="container">
            <div class="container-wrap">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" id="amountform" method="post"
                                action="{{ route('admin.settings.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="name-table-category-form-create">Amount</label>
                                                    <input type="search" name="amount"
                                                        id="name-table-category-form-create" class="form-control ">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <button type="submit" class="btn btn-dark" id="table-category-form-submit"> Add +
                                        </button>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>


@endsection

@push('footer-script')
<script>
    $(function(){
        $('#amountform').on('submit',function(event){
            event.preventDefault();
            let form =$(this);
            let formdata=form.serialize();
            $.ajax({
                url:form.attr('action'),
                method:'POST',
                data:formdata,
                dataType:'json',
                success:function(response){
                    if (response.status=='success'){
                        showToast(response.message,'success')
                    }
                    else {
                            // Handle error case if needed
                            showToast('Error: ' + response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        showToast('AJAX request failed: ' + error, 'error');
                    }
                });
            });
        });


</script>
@endpush





