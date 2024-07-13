@extends('layouts.user')
@section('title', 'Create Post')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Create Post</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <x-general-form :cancel="route('community.index')" :url="route('community.post.store')"   btnsubmit="Publish" :fields='[
            ["name"=>"title","size"=>12],
            ["name"=>"description","size"=>12,"type"=>"editor"],
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    
@endpush