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
        <x-edit-form name="admin.question-bank.topic" :id="$topic->slug" btnsubmit="Save" :fields='[
            ["name"=>"title",  "size"=>6,"value"=>$topic->title],
            ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush