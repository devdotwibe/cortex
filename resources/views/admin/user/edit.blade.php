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
            ["name"=>"name","size"=>6,"value"=>$user->name],
            ["name"=>"email","size"=>6,"value"=>$user->email,"readonly"=>true], 
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush