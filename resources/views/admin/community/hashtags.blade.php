@extends('layouts.admin')
@section('title', 'Hashtag')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.community.index') }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
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
                                                <input type="text" name="hashtag" id="name-table-category-form-create" data-field-input="hashtag" class="form-control">
                                                <div class="invalid-feedback" data-field="hashtag" id="hashtag-error-table-category-form-create"></div>
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

@push('modals')
<div class="modal fade" id="table_hashtag_delete" tabindex="-1" role="dialog"
aria-labelledby="tbBpi7u1724940550Label" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="tbBpi7u1724940550Lablel">Delete Confirmation Required</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="" id="table-delete-form" method="post">
                @method('DELETE')
                @csrf

                <p>Are you sure you want to delete the record </p>
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button><button
                    type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>

    </div>
</div>
</div>
@endpush


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

     
        // Clear previous error messages and styles
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        $.ajax({
            url: $(this).attr('action'), 
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                  
                    $('#table-category-form-create')[0].reset();

                    $('#table-category-form-submit').text(' Add + ');

                    const actionUrl = "{{ route('admin.community.hashtags.store') }}"; 
            console.log(actionUrl); 
            $('#table-category-form-create').attr('action', actionUrl); 

                
                    $('#table-category-form-clear').hide();

                    $('#table-hashtag').DataTable().ajax.reload();

                    showToast(response.message,'success');
                   
                  
                } 
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;

             
                for (var key in errors) {
                    $('[data-field="' + key + '"]').html(errors[key][0]);
                    $('[data-field-input="' + key + '"]').addClass('is-invalid');
                }
            }
        });
    });

    $('#table-category-form-clear').on('click', function() {
        
        
        $('#table-category-form-create')[0].reset();

       
        $('#table-category-form-submit').text(' Add + ');

       
        $(this).hide();
        console.log("test2");
    });
});


function deleteHashtag(url) 
{

    $('#table-delete-form').attr('action', url);
  
    $('#table_hashtag_delete').modal('show');
}


function editHashtag(url) {
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
          
            $('#name-table-category-form-create').val(data.hashtag);
            
           
            $('#table-category-form-submit').text('Update');
            $('#table-category-form-create').attr('data-save', 'edit');
            $('#table-category-form-create').attr('data-hashtag-id',data.id); 
            $('#table-category-form-clear').show()

           // Correctly construct the action URL
           const actionUrl = "{{ url('admin/community/hashtags') }}/" + data.id; 
            console.log(actionUrl); 
            $('#table-category-form-create').attr('action', actionUrl); 
          
            $('#editHashtagModal').modal('show'); 
        },
        error: function(xhr) {
            alert('Failed to fetch hashtag details.');
        }
    });
}


</script>
@endpush