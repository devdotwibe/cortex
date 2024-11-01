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
                                                <input type="text" name="hashtag" id="name-table-category-form-create" data-field-input="name" class="form-control">
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



@push('footer-script')


<script>



$(function(){
    
    $('#table-hashtag').DataTable({
            // bFilter: false,
            // bLengthChange: false,
            paging: false,
            bAutoWidth: false,
            processing:true,
            serverSide:true,
            order: [[0, 'desc']],
            ajax:{
                url:"{{request()->fullUrl()}}",

          
            },
            initComplete:function(settings){
                var info = this.api().page.info();

                if(info.pages>1){
                    $(".dataTables_paginate").show();
                }else{
                    $(".dataTables_paginate").hide();

                }
                if(info.recordsTotal==0) {
                    $(".dataTables_info").hide();
                }
                else{
                    $(".dataTables_info").show();
                }
            },
            drawCallback:function(){

            },
            columns:[

                {
                    data:'DT_RowIndex',
                    name:'id',
                    orderable: true,
                    searchable: false,
                },
                {
                    data:'hashtag',
                    name:'hashtag',
                    orderable: true,
                    searchable: true,
                },
          
                {
                    data:'action',
                    name:'action',
                    orderable: false,
                    searchable: false,
                },

            ]
    });
});



$(function() {
    console.log('3');

    $('#table-category-form-create').on('submit', function(e) {
        e.preventDefault();

        // Clear previous error messages
        $('.error').html('');
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        $.ajax({
            url: $(this).attr('action'), // Ensure this points to the correct route
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Reset the form fields
                    $('#table-category-form-create')[0].reset();

                    // Reset the button text back to "Add +"
                    $('#table-category-form-submit').text(' Add + ');

                    // Optionally hide the cancel button if it's not needed
                    $('#table-category-form-clear').hide();
console.log("testing2");
                    // Reload the DataTable to show updated data
                    $('#table-hashtag').DataTable().ajax.reload();

                    // Optionally show a success message
                    alert(response.message); // Show success message
                } else {
                    alert('Failed to add hashtag.');
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;

                // Loop through the errors and display them
                for (var key in errors) {
                    $('[data-field="' + key + '"]').html(errors[key][0]);
                    $('[data-field-input="' + key + '"]').addClass('is-invalid');
                }
            }
        });
    });

    $('#table-category-form-clear').on('click', function() {
        // Reset the form fields
        $('#table-category-form-create')[0].reset();

        // Reset the button text back to "Add +"
        $('#table-category-form-submit').text(' Add + ');

        // Optionally hide the cancel button
        $(this).hide();
        console.log("test2");
    });
});



</script>
@endpush