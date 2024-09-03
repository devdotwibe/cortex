@extends('layouts.user')
@section('title', 'Tips and Advice')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Tips for Category: {{ $category->name }}</h2>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container">
        <div class="row">
            @forelse ($tips as $tip)
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h3>{{ $tip->tip }}</h3>
                        {{-- <p>{{ $tip->advice }}</p> --}}
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <p>No tips available for this category.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
