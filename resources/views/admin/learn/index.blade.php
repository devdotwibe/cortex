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

                        <x-modal-form name="admin.exam" :url="1" btnsubmit="Add" onclick="CloseModal()" :fields='[
                            ["name"=>"Subject","label"=>"Subject" ,"placeholder"=>"Enter Subject Name" ,"size"=>8],
                             ["name"=>"over_view","label"=>"Over View" ,"placeholder"=>"Over View" ,"size"=>8],
                        
                        ]' /> 
                            
                    </div>
 
            </div>
        </div>
    </div>

@endsection

@push('footer-script')
    <script>
         
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