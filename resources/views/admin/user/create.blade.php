@extends('layouts.admin')
@section('title', 'Users Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Invite User</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form name="admin.user" btnsubmit="Invite" :fields='[
            ["name"=>"name","size"=>4],
            ["name"=>"email","size"=>4],
            ["name"=>"password","size"=>4,"type"=>"password"],
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush