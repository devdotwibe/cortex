@extends('layouts.user')
@section('title', 'Tips and Advice')
@section('content')

<div class="critical-reasoning">
    <h2>Tips And Advice</h2>
    <div class="critical-reasoning-row">
        <!-- Left Column: List of Tips -->
        <div class="critical-reasoning-col1">
            @forelse ($tips as $index => $tip)
                <div class="critical-reasoning-row1">
                    <h3 data-target="tab{{ $index + 1 }}">{{ strip_tags($tip->tip) }}</h3>
                </div>
            @empty
                <p>No tips available.</p>
            @endforelse
        </div>

        <!-- Right Column: Advice Content -->
        <div class="critical-reasoning-col2">
            @forelse ($tips as $index => $tip)
                <div class="critical-reasoning-conten" id="tab{{ $index + 1 }}">
                    <p>{{ strip_tags($tip->content) }}</p>
                    <p>{{ strip_tags($tip->advice) }}</p>
                </div>
            @empty
                <p>No content available.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
