@extends('layouts.admin')
@section('title', 'Users Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Update User</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-edit-form name="admin.user" :id="$user->slug" btnsubmit="Save" :fields='[
            ["name"=>"first_name", "label"=>"First Name" ,"size"=>6,"value"=>$user->first_name?? $user->name],
            ["name"=>"last_name","label"=>"Last Name" ,"size"=>6,"value"=>$user->last_name], 
            ["name"=>"email","label"=>"email", "size"=>6,"value"=>$user->email,"readonly"=>true],
            ["name"=>"phone", "label"=>"Phone No", "size"=>6,"value"=>$user->phone], 
            ["name"=>"schooling_year", "label"=>"Current year of schooling", "size"=>6,"value"=>$user->schooling_year], 
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush