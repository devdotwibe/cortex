@extends('layouts.user')
@section('title', 'Profile')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Profile</h2>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{ route('profile.edit') }}" class="nav_link btn">Edit</a></li>
            </ul>
        </div>
    </div>

</section>
<section class="content_section">
    <div class="container">
        <div class="row">

            <x-show-fields :fields='[
                ["name"=>"first_name", "label"=>"First Name" ,"size"=>6,"value"=>$user->name,"readonly"=>true],
                ["name"=>"last_name","label"=>"Last Name" ,"size"=>6,"value"=>$user->last_name,"readonly"=>true], 
                ["name"=>"email","label"=>"email", "size"=>6,"value"=>$user->email,"readonly"=>true],
                ["name"=>"phone", "label"=>"Phone No", "size"=>6,"value"=>$user->phone,"readonly"=>true], 
                ["name"=>"schooling_year", "label"=>"Current year of schooling", "size"=>6,"value"=>$user->schooling_year,"readonly"=>true], 
                
                
               
            ]' /> 
        
        
        </div>
    </div>
</section>

@endsection