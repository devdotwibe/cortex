@extends('layouts.admin')
@section('title', $homeWork->term_name)
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                    <a href="{{ route('admin.live-class.private_class_create') }}">
                        <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                    </a>
                </div>
                <h2>Booklets</h2>
            </div>
        </div>
    </section>
    <section class="content_section admin_section private_section">
        <div class="container">
            <div class="row">
                @if(count($booklets)>0)
                @foreach ($booklets as $book)
                <a href="{{ route('admin.home-work.show',['home_work'=>$homeWork->slug,'home_work_book'=>$book->slug]) }}">
                    <div class="col-md-6 pt-4 privateclass intensivework">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="card_box_2">
                                    <div class="category">
                                        <div class="card-box">
                                            <div class="category-content">
                                                <h3>
                                                    {{ $book->title }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @else
                No booklets
                @endif
            </div>
        </div>
    </section>
@endsection

