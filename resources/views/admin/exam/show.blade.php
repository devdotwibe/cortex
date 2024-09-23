@extends('layouts.admin')
@section('title', $exam->title.' - Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>{{$exam->title}} - Questions</h2>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.exam-simulator.create',$exam->slug)}}" class="nav_link btn">New Questions</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section admin_section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Question","name"=>"description","data"=>"description"], 
            ]' />
        </div>
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush