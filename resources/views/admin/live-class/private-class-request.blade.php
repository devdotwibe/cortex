@extends('layouts.admin')
@section('title', 'Users Request')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Users Request</h2>
        </div> 
        <div class="header_right">
            <ul class="nav_bar"> 
                <li class="nav_item"  >
                     <button class="btn btn-dark">Export</button>
                </li>  
            </ul>
        </div>
    </div>
</section> 
<section class="content_section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Full Name","name"=>"full_name","data"=>"full_name"],
                ["th"=>"Email","name"=>"email","data"=>"email"],
            ]' />
        </div>
    </div>
</section> 
@endsection
@push('modals')
     
@endpush
@push('footer-script')
    <script> 
    </script>
@endpush