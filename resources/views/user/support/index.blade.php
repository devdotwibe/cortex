<!-- In resources/views/user/support/show.blade.php -->
@extends('layouts.user') <!-- Adjust this based on your layout -->

@section('title', 'Support')

@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Support</h2>
        </div>
    </div>
</section>

<section class="support-content mt-2">
    <div class="container">
        <!-- Display the support content -->

        @if(!empty($support->description))

        {!! $support->description !!}
        @endif

    </div>
</section>
@endsection


