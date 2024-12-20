@extends('layouts.user')
@section('title', 'Tips and Advice')
@section('content')

<div class="critical-reasoning">
    <div class="backtitleclass">
    <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
        <a href="{{ route('tipsandadvise.index') }}">
            <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
        </a>
    </div>
    <h2>Tips And Advice</h2>
</div>
    <div class="critical-reasoning-row">
        <!-- Left Column: List of Tips -->
        <div class="critical-reasoning-col1">
            @forelse ($tips as $index => $tip)
                <div class="critical-reasoning-row1">
                    <h3 data-target="tab{{ $index + 1 }}">{!!$tip->tip!!}</h3>
                </div>
            @empty
                <p>No tips available.</p>
            @endforelse
        </div>

        <!-- Right Column: Advice Content -->
        <div class="critical-reasoning-col2">
            @forelse ($tips as $index => $tip)
                <div class="critical-reasoning-conten" id="tab{{ $index + 1 }}">
                    <p>{!! $tip->content !!}</p>
                    <p>{!! $tip->advice !!}</p>
                </div>
            @empty
                <p>No content available.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
