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
<section class="content_section">
    <div class="container">
        <div class="row">

            <x-show-fields :fields='[
                ["name"=>"title",  "size"=>6,"value"=>$topic->title],
            ]' /> 
        
        
        </div>
    </div>
</section>

@endsection