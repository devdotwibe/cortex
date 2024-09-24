@extends('layouts.user')
@section('title', 'Tips and Advice')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: none">
                <a onclick="pagetoggle()"><img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt=""></a>
            </div>
            <h2>Tips and Advices</h2>
        </div>
    </div>
</section>

<section class="content_section" id="category-content-section">
    <div class="container">
        <div class="row">
            @forelse ($categories as $k => $item)
                @if($item->tips->isNotEmpty()) <!-- Check if the category has tips -->
                <div class="col-md-6">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="category">
                                <a href="{{ route('tipsandadvise.tip_show', $item->id) }}">
                                    <div class="category-image">
                                        <img src="{{ asset('assets/images/User-red.png') }}">
                                    </div>
                                    <div class="category-content">
                                        <h5><span id="category-content-subtitle-{{ $k + 1 }}"> Topic {{ $k + 1 }} </span></h5>
                                        <h3>{{ $item->name }}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <p>No categories available.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="content_section" id="subcategory-content-section" style="display: none">
    <div class="container">
        <div class="row" id="subcategory-list">
        </div>
    </div>
</section>

@endsection
