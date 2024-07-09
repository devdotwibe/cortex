@extends('layouts.user')
@section('title', 'Class Details')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Term {{$classDetail->getIdx()+1}} : Class Details </h2>
        </div>
    </div>
</section>
@endsection