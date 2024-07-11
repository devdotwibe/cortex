@extends('layouts.user')
@section('title', 'Home Work -> '.$homeWork->term_name .' -> '.$homeWorkBook->title)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Home Work -> {{$homeWork->term_name}} -> {{$homeWorkBook->title}}</h2>
        </div>
    </div>
</section>

@endsection