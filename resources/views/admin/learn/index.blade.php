@extends('layouts.admin')
@section('title', 'Learn')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">

        <button class="btn btn-success" onclick="AddSubject()">Add Subject+</button>

            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Subject","name"=>"subject","data"=>"subject"],
               
            ]' />

    </div>

    </div>

</section>


    <div class="modal fade bd-example-modal-lg"  id="add_subject_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
                    <button type="button" onclick="CloseModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <x-modal-form  :url="route('admin.learn.store',)" btnsubmit="Add" onclick="CloseModal()" :fields='[
                            ["name"=>"subject","label"=>"Subject" ,"placeholder"=>"Enter Subject Name" ,"size"=>8],
                            
                        ]' /> 
                            
                    </div>
 
            </div>
        </div>
    </div>

@endsection

@push('footer-script')
    <script>
         
         @error('subject')
             
           $(document).ready(function()
            {
                AddSubject();
            });

         @enderror

        function AddSubject()
            {
                $('#add_subject_modal').modal('show');
            }

        function CloseModal()
        {
            $('#add_subject_modal').modal('hide');
        }
            
    </script>
@endpush