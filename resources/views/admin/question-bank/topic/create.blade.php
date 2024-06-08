@extends('layouts.admin')
@section('title', 'Topic')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Topic</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form name="admin.question-bank.topic" btnsubmit="Save" :fields='[
            ["name"=>"title","size"=>8], 
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush