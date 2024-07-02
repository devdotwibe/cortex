@extends('layouts.admin')
@section('title', 'Exam Simulator Option')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Exam Simulator Option</h2>
        </div> 
    </div>
</section> 
<section class="invite-wrap mt-2">
    <div class="container">
        <x-general-form :url="route('admin.exam.options')"   btnsubmit="Save" :fields='[ 
            ["name"=>"description","label"=>"Description","placeholder"=>"Description","size"=>12,"type"=>"editor" ,"value"=>get_option("exam_simulator_description") ],
        ]' />
    </div>
</section>
@endsection
@push('footer-script')
    <script>
         
    </script>
@endpush