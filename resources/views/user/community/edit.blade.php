@extends('layouts.user')
@section('title', 'Edit Post')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Edit Post</h2>
        </div> 
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <x-edit-form name="community.post" :id="$post->slug" :cancel="route('community.post.show',$post->slug)"   btnsubmit="Publish" :fields='[
            ["name"=>"title","size"=>12,"value"=> $post->title],
            ["name"=>"description","size"=>12,"type"=>"editor","value"=> $post->description],
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    
@endpush