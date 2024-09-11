@extends('layouts.app')

@section('content')


    <section class="banner-wrapp">
        <div class="container">
            <div class="banner-row">
                <div class="banner-col1">
                    @if (!empty($banner->title))
                        <h3 class="highlight">{{ $banner->title }}</h3>
                    @endif


                    <h1> @if (!empty($banner->subtitle))
                        {!! $banner->subtitle !!}
                    @endif
                    </h1>




                    @if (!empty($banner->content))
                        <p>{{ $banner->content }}</p>
                    @endif



                    @if (!empty($banner->buttonlink) && !empty($banner->buttonlabel))
                        <a href="{{ $banner->buttonlink }}" class="banner-btn1">{{ $banner->buttonlabel }}</a>
                    @endif


                </div>
                <div class="banner-col2">
                    <div class="banner-img">
                        @if (!empty($banner->image))
                            <img src="{{ url('d0/' . $banner->image) }}" alt="Header Image">
                        @endif


                        <span class="banner-shape">
                            <img src="{{ asset('app/images/bgcircleheader.png') }}" alt="Background Circle">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="guarantee-wrapp">
        <div class="container">
            {{-- Render subtitle as HTML --}}

            <h2> @if (!empty($banner->guaranteetitle))
                {!! $banner->guaranteetitle !!}
            @endif</h2>


            <div class="guarantee-row">
                <div class="guarantee-col1">
                    <div class="guarantee-img">
                        {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Learn Icon"> --}}

                        @if (!empty($banner->learnimage))
                            <img src="{{ url('d0/' . $banner->learnimage) }}" alt="Learn Icon">
                        @endif
                    </div>
                    @if (!empty($banner->learntitle))
                        <h3>{{ $banner->learntitle }}</h3>
                    @endif
                    @if (!empty($banner->learncontent))
                        <p>{{ $banner->learncontent }}</p>
                    @endif
                </div>
                <div class="guarantee-col1">
                    <div class="guarantee-img">

                        @if (!empty($banner->practiseimage))
                            <img src="{{ url('d0/' . $banner->practiseimage) }}" alt="Learn Icon">
                        @endif
                        {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Practice Icon"> --}}
                    </div>
                    @if (!empty($banner->practisetitle))
                        <h3>{{ $banner->practisetitle }}</h3>
                    @endif
                    @if (!empty($banner->practisecontent))
                        <p>{{ $banner->practisecontent }}</p>
                    @endif
                </div>
                <div class="guarantee-col1">
                    <div class="guarantee-img">

                        @if (!empty($banner->prepareimage))
                            <img src="{{ url('d0/' . $banner->prepareimage) }}" alt="Learn Icon">
                        @endif
                        {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Prepare Icon"> --}}
                    </div>
                    @if (!empty($banner->preparetitle))
                        <h3>{{ $banner->preparetitle }}</h3>
                    @endif
                    @if (!empty($banner->preparecontent))
                        <p>{{ $banner->preparecontent }}</p>
                    @endif
                </div>
                <div class="guarantee-col1">
                    <div class="guarantee-img">

                        @if (!empty($banner->reviewimage))
                            <img src="{{ url('d0/' . $banner->reviewimage) }}" alt="Learn Icon">
                        @endif
                        {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Review Icon"> --}}
                    </div>
                    @if (!empty($banner->reviewtitle))
                        <h3>{{ $banner->reviewtitle }}</h3>
                    @endif
                    @if (!empty($banner->reviewcontent))
                        <p>{{ $banner->reviewcontent }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="features-wrapp">
        <div class="container">
            <div class="features-row">
                <div class="features-col1">
                    <h3 class="highlight">{{ $banner->ourfeaturestitle }}</h3>



                    <h2>
                        @if (!empty($banner->FeatureHeading))
                            {!! $banner->FeatureHeading !!}
                        @endif
                    </h2>
                    <div class="accordion">
                        @if (!empty($feature) && count($feature) > 0)
                            @foreach ($feature as $k => $item)
                                <div class="accordion-item @if ($k == 0) active @endif"
                                    data-img="img{{ $k + 1 }}">
                                    <h3 class="accordion-item-header" data-target="img{{ $k + 1 }}">
                                        {{ $item->featuresubtitle }}</h3>
                                    <div class="accordion-content">
                                        <p>{{ $item->featurecontent }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="features-col2">
                    @if (!empty($feature) && count($feature) > 0)
                        @foreach ($feature as $k => $item)
                            <div class="feature-img @if ($k == 0) active @endif"
                                id="img{{ $k + 1 }}">
                                @if (!empty($item->image))
                                    <img src="{{ url('d0/' . $item->image) }}" alt="Feature Image">
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>


 {{-- <section class="process-wrapp">
    <div class="container">
        <div class="process-row">
            <div class="process-col1">
                @if (!empty($banner->ourprocesstitle))
                    <h3 class="highlight">{{ $banner->ourprocesstitle }}</h3>
                @endif
                <h2>
                    @if (!empty($banner->ourprocesssubtitle))
                        {!! $banner->ourprocesssubtitle !!}
                    @endif
                </h2>
            </div>
            <div class="process-col2">
                <div class="sticky-cards">
                    @foreach ($ourprocess as $p)
                        <div class="process-box card-{{ $p->id }} card-3 _{{ $p->id }}">
                            <div class="process-icon">
                                <img src="{{ url('d0/' . $p->ourprocessimage) }}" alt="{{ $p->icon_alt }}">
                            </div>
                            <span class="count">{{ $p->step_number }}</span>
                            @if (!empty($p->ourprocessheading))
                                {!! $p->ourprocessheading !!}
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section> --}}



 <section class="process-wrapp">
        <div class="container">
            <div class="process-row">
                <div class="process-col1">
                    <h3 class="highlight">OUR PROCESS</h3>
                    <h2>Unique <span>Preparation</span> Process</h2>
                </div>

                <div class="process-col2">
                    <div class="sticky-cards">


                        <div class="card-3">
                            <div class="card-icon-container">
                                <div class="process-icon">
                                    <img src="./assets/images/preparation.svg" alt="">
                                </div>
                                <div class="card-number">01</div>
                            </div>
                            <div class="card-text-container-2">
                                <div class="card-title">Exam Preparation</div>
                                <p class="card-text">Join Cortex’s industry-leading exam platform, purchase a test pack and begin your exam preparation journey</p>
                            </div>
                        </div>
                        <div class="card-3 _2">
                            <div class="card-icon-container">
                                <div class="process-icon">
                                    <img src="./assets/images/acess.svg" alt="">
                                </div>
                                <div class="card-number">02</div>

                            </div>
                            <div class="card-text-container-2">
                                <div class="card-title">Gain Access Instantly</div>
                                <p class="card-text">After you have joined, your child can start taking tests straight
                                    away. You will have access to Premium / Platinum for 365 days.</p>
                            </div>
                        </div>
                        <div class="card-3 _3">
                            <div class="card-icon-container">
                                <div class="process-icon">
                                    <img src="./assets/images/first-test.svg" alt="">
                                </div>
                                <div class="card-number">03</div>

                            </div>
                            <div class="card-text-container-2">
                                <div class="card-title"> Take the First Test</div>
                                <p class="card-text">Start by taking one of NotesEdu's crafted exam-style tests. These
                                    tests are under exam conditions and are timed. Use the first attempt of the test to
                                    gauge your child's understanding level.</p>
                            </div>
                        </div>
                        <div class="card-3 _4">
                            <div class="card-icon-container">
                                <div class="process-icon">
                                    <img src="./assets/images/result.svg" alt="">
                                </div>
                                <div class="card-number">04</div>

                            </div>
                            <div class="card-text-container-2">
                                <div class="card-title">Evaluate Your Results</div>
                                <p class="card-text">This is one of the most important aspects of reviewing your success
                                    while preparing. Utilise NotesEdu’s detailed answer solutions combined with
                                    comprehensive result analysis to pin point your strengths and weaknesses. </p>
                            </div>
                        </div>
                        <div class="card-3 _5">
                            <div class="card-icon-container">
                                <div class="process-icon">
                                    <img src="./assets/images/preparation.svg" alt="">
                                </div>
                                <div class="card-number">05</div>
                            </div>
                            <div class="card-text-container-2">
                                <div class="card-title">Excel Extraordinarily!</div>
                                <p class="card-text">Repeat the test with unlimited test attempts to improve your
                                    understanding of key concepts. Repeat this process and you are on the path to
                                    success.</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="features-wrapp1">
        <div class="container">
            <h2>
                @if (!empty($banner->featurestitle))
                    {!! $banner->featurestitle !!}
                @endif
            </h2>

            <div class="features-row">
                <div class="features-box">
                    <div class="features-icon">

                        @if (!empty($banner->analytics_image))
                            <img src="{{ url('d0/' . $banner->analytics_image) }}" alt="Feature 1">
                        @endif
                    </div>
                    @if (!empty($banner->analytics_title))
                        <h3>{{ $banner->analytics_title }}</h3>
                    @endif


                    @if (!empty($banner->analytics_content))
                        <p>{{ $banner->analytics_content }}</p>
                    @endif
                </div>
                <div class="features-box">
                    <div class="features-icon">
                        @if (!empty($banner->anytime_image))
                            <img src="{{ url('d0/' . $banner->anytime_image) }}" alt="Feature 2">
                        @endif
                    </div>
                    @if (!empty($banner->anytime_title))
                        <h3>{{ $banner->anytime_title }}</h3>
                    @endif

                    @if (!empty($banner->anytime_description))
                        <p>{{ $banner->anytime_description }}</p>
                    @endif
                </div>
                <div class="features-box">
                    <div class="features-icon">
                        @if (!empty($banner->unlimited_image))
                            <img src="{{ url('d0/' . $banner->unlimited_image) }}" alt="Feature 3">
                        @endif
                    </div>
                    @if (!empty($banner->unlimited_title))
                        <h3>{{ $banner->unlimited_title }}</h3>
                    @endif

                    @if (!empty($banner->unlimited_content))
                        <p>{{ $banner->unlimited_content }}</p>
                    @endif
                </div>
                <div class="features-box">
                    <div class="features-icon">
                        @if (!empty($banner->live_image))
                            <img src="{{ url('d0/' . $banner->live_image) }}" alt="Feature 4">
                        @endif
                    </div>
                    @if (!empty($banner->live_title))
                        <h3>{{ $banner->live_title }}</h3>
                    @endif
                    @if (!empty($banner->live_content))
                        <p>{{ $banner->live_content }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="faq-wrapp">
        <div class="container">
            <h3 class="highlight">FAQ</h3>
            <h2>Most Frequent Questions and Answers</h2>
            <div class="faq-row">
                @php
                    $count = 0;
                @endphp

                @if (!empty($faq) && count($faq) > 0)
                    @foreach ($faq as $k => $item)
                        @if (!empty($item->faqs) && count($item->faqs) > 0)
                            @php
                                $count++;
                            @endphp
                            <h4><span>
                                    @if ($count < 10)
                                        {{ '0' }}
                                    @endif{{ $count }}
                                </span> {{ $item->name }}</h4>

                            <div class="accordion">
                                @foreach ($item->faqs as $subitem)
                                    <div class="accordion-row">
                                        <h5>{{ $subitem->question }}</h5>
                                        <div class="accordion-content1">
                                            <p>{{ $subitem->answer }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

    </section>
    <section class="learning-wrapp">
        <div class="container">
            <div class="learning-row">
                <div class="learning-col1">


                    @if (!empty($banner->exceltitle))
                        {!! $banner->exceltitle !!}
                    @endif


                    @if (!empty($banner->excelbuttonlink) && !empty($banner->excelbuttonlabel))
                        <a href="{{ $banner->excelbuttonlink }}"
                            class="learning-btn">{{ $banner->excelbuttonlabel }}</a>
                    @endif


                </div>
                <div class="learning-col2">

                    @if (!empty($banner->excelimage))
                        <img src="{{ url('d0/' . $banner->excelimage) }}" alt="Header Image">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="review-wrapp">
        <div class="container">
            <div class="review-row">
                <div class="review-col1">
                    <h3 class="highlight"> {{ $courses->studentsfeedback }}</h3>
                    <h2>
                        @if (!empty($courses->studenttitle))
                            {{ $courses->studenttitle }}
                        @endif
                    </h2>
                    @if (!empty($courses->studentsubtitle))
                        <p>{{ $courses->studentsubtitle }}</p>
                    @endif
                    <div class="review-col3">
                        <div class="review-col4">
                            @if (!empty($courses->percentage))
                        <h1>{{ $courses->percentage }}</h1>
                    @endif
                        </div>
                        <div class="review-col5">
                            <h3> @if (!empty($courses->studentssubtitle))
                                {!! $courses->studentssubtitle !!}
                            @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="review-col2">
                    <div class="review-slider">
                        @foreach ($feed as $review)
                            <!-- Ensure you're using the correct variable here -->

                            <div class="review-box">
                                <div class="review-img">
                                    <img src="{{ url('d0/' . $review->image) }}" alt="">
                                </div>
                                <div class="review-content">
                                    @if (!empty($review->name))
                                        <h3>{{ $review->name }}</h3>
                                    @endif
                                    <span class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->starrating)
                                                <img src="{{ asset('assets/images/Star-Yellow.svg') }}"
                                                    alt="Yellow Star">
                                            @else
                                                <img src="{{ asset('assets/images/Star-Grey.svg') }}" alt="Grey Star">
                                            @endif
                                        @endfor
                                    </span>
                                    @if (!empty($review->review))
                                        <p>{{ $review->review }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>





    <section class="course-wrapp">
        <div class="container">
            <h3 class="highlight">{{ $courses->ourcoursetitle }}</h3>
            @if (!empty($courses->coursetitle))
                <h2>{{ $courses->coursetitle }}</h2>
            @endif
            @if (!empty($courses->coursesubtitle))
                <p>{{ $courses->coursesubtitle }}</p>
            @endif
            <div class="course-row">
                <div class="course-box">
                    @if (!empty($courses->courseheading1))
                        <h4>{{ $courses->courseheading1 }}</h4>
                    @endif
                    @if (!empty($courses->coursecontent1))
                        <p>{{ $courses->coursecontent1 }}</p>
                    @endif
                </div>
                <div class="course-box">
                    @if (!empty($courses->courseheading2))
                        <h4>{{ $courses->courseheading2 }}</h4>
                    @endif
                    @if (!empty($courses->coursecontent2))
                        <p>{{ $courses->coursecontent2 }}</p>
                    @endif
                </div>
                <div class="course-box">
                    @if (!empty($courses->courseheading3))
                        <h4>{{ $courses->courseheading3 }}</h4>
                    @endif
                    @if (!empty($courses->coursecontent3))
                        <p>{{ $courses->coursecontent3 }}</p>
                    @endif
                </div>
                <div class="course-box">
                    @if (!empty($courses->courseheading4))
                        <h4>{{ $courses->courseheading4 }}</h4>
                    @endif
                    @if (!empty($courses->coursecontent4))
                        <p>{{ $courses->coursecontent4 }}</p>
                    @endif
                </div>
            </div>
            {{-- <a href="" class="learn-more">Learn More</a> --}}



            @if (!empty($courses->coursebuttonlink) && !empty($courses->coursebuttonlabel))
                <a href="{{ $courses->coursebuttonlink }}" class="learn-more">{{ $courses->coursebuttonlabel }}</a>
            @endif
        </div>
    </section>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headers = document.querySelectorAll('.accordion-item-header');
            const images = document.querySelectorAll('.feature-img');

            headers.forEach(header => {
                header.addEventListener('click', function() {
                    // Get target image ID
                    const targetImgId = this.getAttribute('data-target');

                    // Remove active class from all accordion items and images
                    document.querySelectorAll('.accordion-item').forEach(item => item.classList
                        .remove('active'));
                    document.querySelectorAll('.feature-img').forEach(img => img.classList.remove(
                        'active'));

                    // Add active class to the clicked accordion item and corresponding image
                    this.parentElement.classList.add('active');
                    document.getElementById(targetImgId).classList.add('active');
                });
            });
        });
    </script>

    <style>
        .accordion-item.active .accordion-content {
            display: block;
        }

        .feature-img {
            display: none;
        }

        .feature-img.active {
            display: block;
        }
    </style>


@endsection
