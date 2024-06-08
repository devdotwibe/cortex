@extends('layouts.admin')
@section('title', 'Section')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Section</h2>
        </div> 
    </div>

</section>
<section class="content_section">
    <div class="container">
        <div class="row">

            <x-show-fields :fields='[
                ["name"=>"title",  "size"=>6,"value"=>$section->title],
            ]' /> 
        
        
        </div>
    </div>
</section>

@endsection