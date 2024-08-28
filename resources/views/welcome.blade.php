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
                <h2>Using Exam Online is easy and <span>straightforward. Here's how it works:</span></h2>
                <div class="accordion">
                    <div class="accordion-item active">
                        <h3 data-target="img1" class="accordion-item-header">Learning, Finally organised</h3>
                        <div class="accordion-content">
                            <p>Hours of interactive video tutorials walking students through our specially designed syllabus. </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 data-target="img2" class="accordion-item-header">Easy to learn system</h3>
                        <div class="accordion-content">
                            <p>Hours of interactive video tutorials walking students through our specially designed syllabus. </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 data-target="img3" class="accordion-item-header">Detailed analytics</h3>
                        <div class="accordion-content">
                            <p>Hours of interactive video tutorials walking students through our specially designed syllabus. </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 data-target="img4" class="accordion-item-header">Prepare smart</h3>
                        <div class="accordion-content">
                            <p>Hours of interactive video tutorials walking students through our specially designed syllabus. </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="features-col2">
                <div class="feature-img active" id="img1">
                    <img src="{{ asset('app/images/feature-img.png') }}" alt="Feature Image">
                    <span class="feature-shape">
                        <img src="{{ asset('app/images/ourfeaturebgcircle.png') }}" alt="Feature Background Circle">
                    </span>
                </div>
                <div class="feature-img" id="img2">
                    <img src="{{ asset('app/images/feature-img.png') }}" alt="Feature Image">
                    <span class="feature-shape">
                        <img src="{{ asset('app/images/ourfeaturebgcircle.png') }}" alt="Feature Background Circle">
                    </span>
                </div>
                <div class="feature-img" id="img3">
                    <img src="{{ asset('app/images/feature-img.png') }}" alt="Feature Image">
                    <span class="feature-shape">
                        <img src="{{ asset('app/images/ourfeaturebgcircle.png') }}" alt="Feature Background Circle">
                    </span>
                </div>
                <div class="feature-img" id="img4">
                    <img src="{{ asset('app/images/feature-img.png') }}" alt="Feature Image">
                    <span class="feature-shape">
                        <img src="{{ asset('app/images/ourfeaturebgcircle.png') }}" alt="Feature Background Circle">
                    </span>
                </div>
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
            <h4><span>01</span> Common Questions</h4>
            <div class="accordion">
                <div class="accordion-row">
                    <h5>What is the Selective Test?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>What is the Selective Test?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>What is the Selective Test?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>What is the Selective Test?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
            </div>

            <h4><span>02</span> Why go to Selective High School?</h4>
            <div class="accordion">
                <div class="accordion-row">
                    <h5>What are the benefits of sending my child to a selective high school?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>What is the Selective Placement Test Structure?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
            </div>

            <h4><span>03</span> About Test & Structure</h4>
            <div class="accordion">
                <div class="accordion-row">
                    <h5>What is the Selective Placement Test Structure?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>How difficult is the Selective Placement Test?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>Are Cortex practice tests similar to the Selective Test?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>What is the purpose of Cortex Online Tests?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>How do Cortex test results help parents?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>Will Cortex practice tests improve my child's test scores?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
                <div class="accordion-row">
                    <h5>How does Cortex support students to make them exam ready?</h5>
                    <div class="accordion-content1">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis eius nobis aut illum veritatis eligendi dicta tenetur voluptatem, ex ipsa repellat odio. Provident odit ex accusantium, doloribus mollitia rerum consequuntur!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="learning-wrapp">
    <div class="container">
        <div class="learning-row">
            <div class="learning-col1">
                <h3 class="highlight">Learn, Perfect & Excel</h3>
                <h2>Get access to free Selective Style <span>Tests for Year 5 & 6 students to see</span> if your child is exam-ready.</h2>
                <p>Check if your child is exam-ready with a free Selective Style test. Prepare smarter, not harder.</p>
                <ul>
                    <li>Latest exam-style questions</li>
                    <li>Detailed solutions & comprehensive reports provided</li>
                    <li>No payment details required</li>
                </ul>
                <a href="" class="learning-btn">Claim your Free test today</a>
            </div>
            <div class="learning-col2">
                <img src="{{ asset('app/images/learn-img.jpg') }}" alt="">
            </div>
        </div>
    </div>
</section>

<section class="review-wrapp">
    <div class="container">
        <div class="review-row">
            <div class="review-col1">
                <h3 class="highlight">Students feedback</h3>
                <h2>Our 5-Star Reviews</h2>
                <p>Find any educational institution with higher rated and more reviews than Cortex, and we will offer our Premium Package absolutely free</p>
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
        <h2>Explore our MasterClasses</h2>
        <p>Learn the proper fundamental theory of conclusions, assumptions, arguments and reasoning. Follow the proven techniques and strategies from a professional Thinking Skills exam writer and teacher.</p>
        <div class="course-row">
            <div class="course-box">
                <h4>Logical Reasoning</h4>
                <p>A free full-length Thinking Skills exam that allows your child to test their current abilities. Take a sneak-peek into Cortex Online's style of teaching and questions.</p>
            </div>
            <div class="course-box">
                <h4>Critical Reasoning</h4>
                <p>Learn the proper fundamental theory of conclusions, assumptions, arguments and reasoning. Follow the proven techniques and strategies from a professional Thinking Skills exam writer and teacher.</p>
            </div>
            <div class="course-box">
                <h4>Abstract Reasoning</h4>
                <p>Give your child a competitive edge in the Selective Test. Learn the most efficient techniques and strategies for each question type from a Thinking Skills expert.</p>
            </div>
            <div class="course-box">
                <h4>Numerical Reasoning</h4>
                <p>Give your child a competitive edge in the Selective Test. Learn the most efficient techniques and strategies for each question type from a Thinking Skills expert.</p>
            </div>
        </div>
        <a href="" class="learn-more">Learn More</a>
    </div>
</section>


@endsection
