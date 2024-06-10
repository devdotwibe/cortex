@extends('layouts.admin')
@section('title', 'Options')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Options</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">

        <button class="btn btn-success" onclick="AddSubject()">Add Module+</button>

            <x-ajax-table tableid="module" ajaxcreate="true" title="Add Module" :createurl="route('admin.options.store')" :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Module","name"=>"name","data"=>"name"],
               
            ]'
            btnsubmit="Add" onclick="CloseModal()"
            :fields='[
                        ["name"=>"name","label"=>"Module" ,"placeholder"=>"Enter Module Name" ,"size"=>8],
                        
                    ]' 
            
            />

    </div>

    </div>

</section>


@endsection

@push('modals')

    <div class="modal fade bd-example-modal-lg"  id="table-subcategory-create" tabindex="-1" role="dialog" aria-labelledby="table-subcategory-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="table-subcategory-createLabel">Add Topic</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <div class="modal-body">

                            <div class="row"> 
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" class="form" id="table-form-sub" method="post">
                                            @csrf 
                            
                                            <div class="row">
                                               
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 

                                                                    <label for="sub_name">Sub Category</label>
                                                                    
                                                                            <input type="text" name="name" id="sub_name" class="form-control">        
                                                                   
                                                                    
                                                                    <div class="invalid-feedback" id="name-error"></div>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                               
                                                 
                                            </div>
                            
                                            <div class="mb-3"> 
                                                                 
                                                    <a  onclick="CloseSub()" class="btn btn-secondary">Cancel</a>
                    
                                                    <button type="submit" class="btn btn-dark">Save</button> 
                            
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div> 


                            <x-ajax-table tableid="sub_category" beforeajax='beforeajaxcallback' :url="route('admin.sub_category_table.show')" :coloumns='[
                                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                                ["th"=>"Sub Category","name"=>"name","data"=>"name"],
                              
                            ]' />
                                
                        </div>

                      
                            
                    </div>

            </div>
        </div>
    </div>
    
@endpush

@push('footer-script')
    <script>
         

        function AddSubject()
            {
              
                $('#table-module-create').modal('show');
            }

        function CloseModal()
        {
            $('#table-module-create').modal('hide');
        }

        function CloseSub()
        {
            $('#table-subcategory-create').modal('hide');
        }

        function beforeajaxcallback(data)
        {
            data.category= $('#table-sub_category').data('category');
            return data;
        }

        function SubCat(url,slug)
            {
              
                $('#table-subcategory-create').modal('show');

                $('#table-form-sub').attr('action',url);
                $('#table-sub_category').data('category',slug).DataTable().ajax.reload();

            }
        
    
            $(document).ready(function() {

                $('#table-form-sub').on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: $(this).serialize(),
                        
                        success: function(response) {

                            $('#table-subcategory-create').modal('show');

                            $('#table-sub_category').DataTable().ajax.reload();
                            $('#sub_name').val("");

                        },

                        error: function(xhr) {

                            var errors = xhr.responseJSON.errors;
                            
                            $.each(errors, function(key, value) {

                                $('#' + key + '-error').text(value[0]).show();

                            });

                        }
                    });
                });
            });

            
    </script>

@endpush