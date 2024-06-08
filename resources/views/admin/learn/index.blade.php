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

        <div class="form-fields" id="show_field">

            <x-create-form name="admin.exam" btnsubmit="Add" :fields='[
                ["name"=>"Subject","label"=>"Subject" ,"placeholder"=>"Enter Subject Name" ,"size"=>3],
            
            ]' /> 

        </div>


    </div>

</section> 
@endsection

@push('footer-script')
    <script>
         
        function AddSubject()
            {
                $('#show_field').toggle();
            }

    </script>
@endpush