@extends('layouts.user')
@section('title', 'Learn')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn</h2>
        </div>
    </div>
</section>
<section class="content_section learn-section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k => $item)
            <div class="col-md-6">
                @if ($user->is_free_access||(optional($user->subscription())->status??"")=="subscribed"||$k == 0)
                <a href="{{ route('learn.show', $item->slug) }}">
                @else
                <a href="{{route('pricing.index')}}">
                @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{$exam->examIcon($item->id,asset("assets/images/User-red.png"))}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{ $item->id }}">
                                            {{ $exam->subtitle($item->id, "Module " . ($item->getIdx() + 1)) }}
                                        </span></h5>
                                    <h3>{{ $item->name }}</h3>
                                </div>
                                <div class="progress-area">
                                    <progress max="100"
                                        value="{{ $item->progress }}">
                                        {{ round($item->progress, 2) }}%
                                    </progress>
                                    <span>{{ round($item->progress, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('modals')  
@endpush

@push('footer-script') 
 
@endpush
