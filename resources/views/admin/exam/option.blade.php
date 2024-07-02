@extends('layouts.admin')
@section('title', 'Full Mock Exam Option')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Full Mock Exam Option</h2>
        </div> 
    </div>
</section> 
<section class="invite-wrap mt-2">
    <div class="container">
        <x-general-form :url="route('admin.exam.options')"   btnsubmit="Save" :fields='[ 
            ["name"=>"description","label"=>"Description","placeholder"=>"Description","size"=>12,"type"=>"editor"],
        ]' />
    </div>
</section>
@endsection
@push('footer-script')
    <script>
         
    </script>
@endpush