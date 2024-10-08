@extends('layouts.user')
@section('title', 'Live Class - ' . ($live_class->class_title_1 ?? ' Private Class Room '))
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                    <a href="{{ route('live-class.privateclass',$user->slug) }}">
                      
                        <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                    </a>
                </div>
                <h2>Live Class - {{ $live_class->class_title_1 ?? ' Private Class Room ' }}</h2>
            </div>
        </div>
    </section>
    <section class="content_section">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{ route('live-class.privateclass.details', $user->slug) }}">
                                <div class="category">
                                    <div class="category-image">
                                        <img src="{{ asset('assets/images/class.svg') }}">
                                    </div>
                                    <div class="category-content">
                                        <h3>Class Details</h3> 
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{ route('live-class.privateclass.lesson', $user->slug) }}">
                                <div class="category">
                                    <div class="category-image">
                                        <img src="{{ asset('assets/images/lessonmaterial.svg') }}">
                                    </div>
                                    <div class="category-content">
                                        <h3>Lesson Material</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{route('home-work.index')}}">
                                <div class="category">

                                    <div class="category-image">

                                        <img src="{{ asset('assets/images/homework.svg') }}">

                                    </div>

                                    <div class="category-content">

                                        <h3>Homework Submission</h3>

                                        <p>   </p>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{route('lesson-record.index')}}">
                                <div class="category">

                                    <div class="category-image">

                                        <img src="{{ asset('assets/images/recording.svg') }}">

                                    </div>

                                    <div class="category-content">

                                        <h3>Lesson Recording</h3>

                                        <p>   </p>

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
