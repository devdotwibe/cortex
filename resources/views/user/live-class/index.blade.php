@extends('layouts.user')
@section('title', 'Live Class')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Live Class</h2>
            </div>
        </div>
    </section>
    <section class="content_section">
        <div class="container">
            <div class="row">

                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('live-class.privateclass', $user->slug) }}">
                                <div class="category">

                                    <div class="category-image">

                                        @if (!empty($live_class->class_image_1))
                                            <img src="{{ url('d0/' . $live_class->class_image_1) }}">
                                        @else
                                            <img src="{{ asset('assets/images/User-red.png') }}">
                                        @endif

                                    </div>

                                    <div class="category-content">

                                        <h3>
                                            @if (!empty($live_class->class_title_1))
                                                {{ $live_class->class_title_1 }}
                                            @else
                                                Private Class Room
                                            @endif
                                        </h3>

                                        <p>
                                            @if (!empty($live_class->class_description_1))
                                                {{ $live_class->class_description_1 }}
                                            @else
                                                Receive a personalised learning experience with regular feedback by
                                                entrolling with our tutors Desinged for Year 5 students
                                            @endif
                                        </p>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('live-class.workshop', $user->slug) }}">
                                <div class="category">
                                    <div class="category-image">

                                        @if (!empty($live_class->class_image_2))
                                            <img src="{{ url('d0/' . $live_class->class_image_2) }}">
                                        @else
                                            <img src="{{ asset('assets/images/User-red.png') }}">
                                        @endif

                                    </div>
                                    <div class="category-content">

                                        <h3>
                                            @if (!empty($live_class->class_title_2))
                                                {{ $live_class->class_title_2 }}
                                            @else
                                                Intensive Workshop
                                            @endif
                                        </h3>

                                        <p>
                                            @if (!empty($live_class->class_description_2))
                                                {{ $live_class->class_description_2 }}
                                            @else
                                                These open group sessions condense the entire Thinking Skills curriculum
                                                into ten intensive lessions Designed for Year 6 students
                                            @endif
                                        </p>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

@endsection
 


@push('footer-script')

@endpush
