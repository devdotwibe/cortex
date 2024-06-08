@extends('layouts.admin')
@section('title', 'Learn Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn Detail</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
       
        <x-edit-form name="admin.learn" :id="$learn->slug" btnsubmit="Save" :fields='[
            ["name"=>"first_name", "label"=>"First Name" ,"size"=>6,"value"=>$learn->subject],
           
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush