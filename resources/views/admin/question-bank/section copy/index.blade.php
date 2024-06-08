@extends('layouts.admin')
@section('title', 'Section')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Section</h2>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.question-bank.section.create')}}" class="nav_link btn">New</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>New  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
             
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Verifyed  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>


            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Trial  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
            <div class="dash_card">
                <div class="admin-icon">
                    <span class="wht-icon"><img
                            src="{{asset("assets/images/User-wht.png")}}"></span>
                    <span class="red-icon"><img
                            src="{{asset("assets/images/User-red.png")}}"></span>
                </div>
                <h3>Paid  Users</h3> 
                <span class="badge text-success">{{$newuser??0}}</span> 
            </div>
        </div>
    </div>
</section>
<section class="table-section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Title","name"=>"title","data"=>"title"], 
            ]' />
        </div>
    </div>
</section>
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush