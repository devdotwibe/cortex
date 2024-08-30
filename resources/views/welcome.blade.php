@extends('layouts.app')

@section('content')


<section class="banner-wrapp">
    <div class="container">
        <div class="banner-row">
            <div class="banner-col1">
            @if(!empty($banner->title))

                <h3 class="highlight">{{$banner->title}}</h3>

            @endif

                {{-- Render subtitle as HTML --}}
                @if(!empty($banner->subtitle))
                    {!! $banner->subtitle !!}
                @endif


                @if(!empty($banner->content))
                <p>{{$banner->content}}</p>
                @endif



                @if(!empty($banner->buttonlink) && !empty($banner->buttonlabel))
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
         @if(!empty($banner->guaranteetitle))
         {!! $banner->guaranteetitle !!}
     @endif

        <div class="guarantee-row">
            <div class="guarantee-col1">
                <div class="guarantee-img">
                    {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Learn Icon"> --}}

                    @if (!empty($banner->learnimage))
                    <img src="{{ url('d0/' . $banner->learnimage) }}" alt="Learn Icon">
                    @endif
                </div>
                @if(!empty($banner->learntitle))
                <h3>{{$banner->learntitle}}</h3>
                @endif
                @if(!empty($banner->learncontent))
                <p>{{$banner->learncontent}}</p>
                @endif
            </div>
            <div class="guarantee-col1">
                <div class="guarantee-img">

                    @if (!empty($banner->practiseimage))
                    <img src="{{ url('d0/' . $banner->practiseimage) }}" alt="Learn Icon">
                    @endif
                    {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Practice Icon"> --}}
                </div>
                @if(!empty($banner->practisetitle))
                <h3>{{$banner->practisetitle}}</h3>
                @endif
                @if(!empty($banner->practisecontent))
                <p>{{$banner->practisecontent}}</p>
                @endif
            </div>
            <div class="guarantee-col1">
                <div class="guarantee-img">

                    @if (!empty($banner->prepareimage))
                    <img src="{{ url('d0/' . $banner->prepareimage) }}" alt="Learn Icon">
                    @endif
                    {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Prepare Icon"> --}}
                </div>
                @if(!empty($banner->preparetitle))
                <h3>{{$banner->preparetitle}}</h3>
                @endif
                @if(!empty($banner->preparecontent))
                <p>{{$banner->preparecontent}}</p>
                @endif
            </div>
            <div class="guarantee-col1">
                <div class="guarantee-img">

                    @if (!empty($banner->reviewimage))
                    <img src="{{ url('d0/' . $banner->reviewimage) }}" alt="Learn Icon">
                    @endif
                    {{-- <img src="{{ asset('app/images/learnicon.svg') }}" alt="Review Icon"> --}}
                </div>
                @if(!empty($banner->reviewtitle))
                <h3>{{$banner->reviewtitle}}</h3>
                @endif
                @if(!empty($banner->reviewcontent))
                <p>{{$banner->reviewcontent}}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="features-wrapp">
    <div class="container">
        <div class="features-row">
            <div class="features-col1">
                <h3 class="highlight">OUR FEATURES</h3>



                <h2> @if(!empty($banner->FeatureHeading))
                    {!! $banner->FeatureHeading !!}
                @endif</h2>

                <div class="accordion">
                    @if(!empty($feature) && count($feature) > 0)
                        @foreach ($feature as $k => $item)
                            <div class="accordion-item @if($k == 0)active @endif" data-img="img{{ $k + 1 }}">
                                <h3 class="accordion-item-header" data-target="img{{ $k + 1 }}">{{ $item->featuresubtitle }}</h3>
                                <div class="accordion-content">
                                    <p>{{ $item->featurecontent }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="features-col2">
                @if(!empty($feature) && count($feature) > 0)
                    @foreach ($feature as $k => $item)
                        <div class="feature-img @if($k == 0) active @endif" id="img{{ $k + 1 }}">
                            @if(!empty($item->image))
                                <img src="{{ url('d0/' . $item->image) }}" alt="Feature Image">
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

<section class="process-wrapp">
    <div class="container">
        <div class="process-row">
            <div class="process-col1">
                <h3 class="highlight">OUR PROCESS</h3>
                <h2>Unique <span>Preparation</span> Process</h2>
            </div>
            <div class="process-col2">
                <div class="sticky-cards">
                    <div class="process-box card-1 card-3">
                        <div class="process-icon">
                            <img src="{{ asset('app/images/preparation.svg') }}" alt="Preparation Icon">
                        </div>
                        <span class="count">01</span>
                        <h3>Exam Preparation</h3>
                        <p>Join Cortex’s industry-leading exam platform, purchase a test pack and begin your exam preparation journey.</p>
                    </div>
                    <div class="process-box card-2 card-3 _2">
                        <div class="process-icon">
                            <img src="{{ asset('app/images/preparation.svg') }}" alt="Preparation Icon">
                        </div>
                        <span class="count">02</span>
                        <h3>Exam Preparation</h3>
                        <p>Join Cortex’s industry-leading exam platform, purchase a test pack and begin your exam preparation journey.</p>
                    </div>
                    <div class="process-box card-3 card-3 _3">
                        <div class="process-icon">
                            <img src="{{ asset('app/images/preparation.svg') }}" alt="Preparation Icon">
                        </div>
                        <span class="count">03</span>
                        <h3>Exam Preparation</h3>
                        <p>Join Cortex’s industry-leading exam platform, purchase a test pack and begin your exam preparation journey.</p>
                    </div>
                    <div class="process-box card-4 card-3 _4">
                        <div class="process-icon">
                            <img src="{{ asset('app/images/preparation.svg') }}" alt="Preparation Icon">
                        </div>
                        <span class="count">04</span>
                        <h3>Exam Preparation</h3>
                        <p>Join Cortex’s industry-leading exam platform, purchase a test pack and begin your exam preparation journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="features-wrapp1">
    <div class="container">
        <h2>Our <span>Features</span></h2>
        <div class="features-row">
            <div class="features-box">
                <div class="features-icon">
                    <img src="{{ asset('app/images/feature1.svg') }}" alt="Feature 1">
                </div>
                <h3>Analytics</h3>
                <p>Detailed analytics reports include topic-wise analysis, time taken per question, and more to educate your child.</p>
            </div>
            <div class="features-box">
                <div class="features-icon">
                    <img src="{{ asset('app/images/feature2.svg') }}" alt="Feature 2">
                </div>
                <h3>Anytime, Anywhere</h3>
                <p>We are an online learning provider. That means our servers run 24/7, ready for any time that your child wants to learn.</p>
            </div>
            <div class="features-box">
                <div class="features-icon">
                    <img src="{{ asset('app/images/feature3.svg') }}" alt="Feature 3">
                </div>
                <h3>Unlimited Test Attempts</h3>
                <p>We want your child to succeed. Do the test once or as many times as you want, we believe practice makes perfect.</p>
            </div>
            <div class="features-box">
                <div class="features-icon">
                    <img src="{{ asset('app/images/feature4.svg') }}" alt="Feature 4">
                </div>
                <h3>Live Chat Support</h3>
                <p>We are here to help explain any questions or concepts over live chat. Message our friendly team anytime!</p>
            </div>
        </div>
    </div>
</section>

<section class="faq-wrapp">
    <div class="container">
        <h3 class="highlight">FAQ</h3>
        <h2>Most Frequent Questions and Answers</h2>
        <div class="faq-row">

            @if(!empty($faq) && count($faq) > 0)
            @foreach ($faq as $k => $item)

            <h4><span>@if($k < 9){{'0'}}@endif{{$k+1}} </span> {{$item->name}}</h4>

            @if(!empty($item->faqs) && count($item->faqs) > 0)

                @foreach ($item->faqs as $k => $subitem)
                <div class="accordion">

                    <div class="accordion-row">
                    <h5>{{$subitem->question}}</h5>
                    <div class="accordion-content1">
                        <p>{{$subitem->answer}}</p>
                    </div>
                    </div>
                
                
                @endforeach
            </div>
            @endif
              
         {{-- </div> --}}
            @endforeach
            @endif
        </div>
    </div>
</section>
<section class="learning-wrapp">
    <div class="container">
        <div class="learning-row">
            <div class="learning-col1">
                <h3 class="highlight">Learn, Perfect & Excel</h3>
                <h2>@if(!empty($banner->exceltitle))
                       {!! $banner->exceltitle !!}
                    @endif</h2>
                <p> @if(!empty($banner->excelsubtitle))
                    <p>{{$banner->excelsubtitle}}</p>
                    @endif</p>
                <ul>
                    <li>@if(!empty($banner->subtitle1))
                        <p>{{$banner->subtitle1}}</p>
                        @endif</li>
                    <li>@if(!empty($banner->subtitle2))
                        <p>{{$banner->subtitle2}}</p>
                        @endif</li>
                    <li>@if(!empty($banner->subtitle3))
                        <p>{{$banner->subtitle3}}</p>
                        @endif</li>
                </ul>

                @if(!empty($banner->excelbuttonlink) && !empty($banner->excelbuttonlabel))
                <a href="{{ $banner->excelbuttonlink }}" class="learning-btn">{{ $banner->excelbuttonlabel }}</a>
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
                <h3 class="highlight">Students feedback</h3>
                <h2>@if(!empty($courses->studenttitle))
                    {{ $courses->studenttitle}}
                 @endif</h2>
                @if(!empty($courses->studentsubtitle))
                    <p>{{$courses->studentsubtitle}}</p>
                    @endif
                <div class="review-col3">
                    <div class="review-col4">
                        <h1>99%</h1>
                    </div>
                    <div class="review-col5">
                        <h3>Students Completed
                            <span>Course Successfully.</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="review-col2">
                <div class="review-slider">
                    <div class="review-box">
                        <div class="review-img">
                            <img src="{{ asset('app/images/review-img.jpg') }}" alt="">
                        </div>
                        <div class="review-content">
                            <h3>Anna</h3>
                            <span class="rating"><img src="{{ asset('app/images/rating.svg') }}" alt=""></span>
                            <p>I am writing to share my selective results. I couldn't make it without your help. I received the North Sydney Boys' offer and reserve for James Ruse.</p>
                        </div>
                    </div>
                    <div class="review-box">
                        <div class="review-img">
                            <img src="{{ asset('app/images/review-img.jpg') }}" alt="">
                        </div>
                        <div class="review-content">
                            <h3>Anna</h3>
                            <span class="rating"><img src="{{ asset('app/images/rating.svg') }}" alt=""></span>
                            <p>I am writing to share my selective results. I couldn't make it without your help. I received the North Sydney Boys' offer and reserve for James Ruse.</p>
                        </div>
                    </div>
                    <div class="review-box">
                        <div class="review-img">
                            <img src="{{ asset('app/images/review-img.jpg') }}" alt="">
                        </div>
                        <div class="review-content">
                            <h3>Anna</h3>
                            <span class="rating"><img src="{{ asset('app/images/rating.svg') }}" alt=""></span>
                            <p>I am writing to share my selective results. I couldn't make it without your help. I received the North Sydney Boys' offer and reserve for James Ruse.</p>
                        </div>
                    </div>
                    <div class="review-box">
                        <div class="review-img">
                            <img src="{{ asset('app/images/review-img.jpg') }}" alt="">
                        </div>
                        <div class="review-content">
                            <h3>Anna</h3>
                            <span class="rating"><img src="{{ asset('app/images/rating.svg') }}" alt=""></span>
                            <p>I am writing to share my selective results. I couldn't make it without your help. I received the North Sydney Boys' offer and reserve for James Ruse.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="course-wrapp">
    <div class="container">
        <h3 class="highlight">Our Courses</h3>
        @if(!empty($courses->coursetitle))
            <h2>{{$courses->coursetitle}}</h2>
            @endif
            @if(!empty($courses->coursesubtitle))
            <p>{{$courses->coursesubtitle}}</p>
            @endif
        <div class="course-row">
            <div class="course-box">
                @if(!empty($courses->courseheading1))
                <h4>{{$courses->courseheading1}}</h4>
                @endif
                @if(!empty($courses->coursecontent1))
                <p>{{$courses->coursecontent1}}</p>
                @endif
            </div>
            <div class="course-box">
                @if(!empty($courses->courseheading2))
            <h4>{{$courses->courseheading2}}</h4>
            @endif
            @if(!empty($courses->coursecontent2))
            <p>{{$courses->coursecontent2}}</p>
            @endif
            </div>
            <div class="course-box">
                @if(!empty($courses->courseheading3))
            <h4>{{$courses->courseheading3}}</h4>
            @endif
            @if(!empty($courses->coursecontent3))
            <p>{{$courses->coursecontent3}}</p>
            @endif
            </div>
            <div class="course-box">
                @if(!empty($courses->courseheading4))
                <h4>{{$courses->courseheading4}}</h4>
                @endif
                @if(!empty($courses->coursecontent4))
                <p>{{$courses->coursecontent4}}</p>
                @endif
            </div>
        </div>
        {{-- <a href="" class="learn-more">Learn More</a> --}}



        @if(!empty($courses->coursebuttonlink) && !empty($courses->coursebuttonlabel))
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
                document.querySelectorAll('.accordion-item').forEach(item => item.classList.remove('active'));
                document.querySelectorAll('.feature-img').forEach(img => img.classList.remove('active'));

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
