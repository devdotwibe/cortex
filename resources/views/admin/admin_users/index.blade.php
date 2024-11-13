@extends('layouts.admin')
@section('title', 'Category')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Category</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2 categoryclass">
        <div class="container">
            <div class="container-wrap">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" id="table-category-form-create" data-save="create"
                                data-action="{{ route('admin.category.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="name-table-category-form-create">Category Name</label>
                                                    <input type="search" name="name"
                                                        id="name-table-category-form-create" class="form-control ">
                                                    <div class="invalid-feedback"
                                                        id="name-error-table-category-form-create"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <button type="submit" class="btn btn-dark" id="table-category-form-submit"> Add +
                                        </button>
                                        <button type="button" class="btn btn-secondary" style="display: none"
                                            id="table-category-form-clear">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            <x-ajax-table title="Add Category" :coloumns="[
                                ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                                ['th' => 'Category', 'name' => 'name', 'data' => 'name'],
                                ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                            ]"  tableinit="cattableinit"   />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>


@endsection

@push('modals')
    <div class="modal fade bd-example-modal-lg" id="sub-category-create-modal" tabindex="-1" role="dialog"
        aria-labelledby="sub-category-createLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="sub-category-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sub-category-createLabel"><span id="sub-category-id"></span> Sub Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form  class="form" id="table-subcategory-form-create" data-save="create" data-action="" data-createurl="" >
                        @csrf                
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="name-table-subcategory-form-create">Sub Category Name</label>
                                            <input type="search" name="name" id="name-table-subcategory-form-create" class="form-control "  >
                                            <div class="invalid-feedback" id="name-error-table-subcategory-form-create"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-4 pt-4">  
                                <button type="submit" class="btn btn-dark" id="table-subcategory-form-submit"> Add + </button>  
                                <button type="button" class="btn btn-secondary" style="display: none" id="table-subcategory-form-clear" >Cancel</button>               
                            </div>
                        </div> 
                    </form>

                    <x-ajax-table 
                        beforeajax='beforeajaxcallback' 
                        deletecallbackbefore='deletecallbackbefore' 
                        deletecallbackafter='deletecallbackafter' 
                        :url="route('admin.subcategory_table.show')" 
                        tableinit="subcattableinit" 
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Sub Category', 'name' => 'name', 'data' => 'name'],
                            ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                        ]" /> 
                </div> 
            </div>
        
        </div>
    </div>

@endpush

@push('footer-script')
    <script>
       


       

    </script>
@endpush
