
@extends('layouts.app')

@section('content')

    <section class="banner-wrapp banner-wrapp2">
        <div class="container">
            <div class="banner-row">
                <div class="banner-col1">
                    @if (!empty($course->heading))
                    {!! $course->heading !!}
                @endif
                @if (!empty($course->buttonlink) && !empty($course->buttonlabel))
                <a href="{{ $course->buttonlink }}" class="banner-btn1">{{ $course->buttonlabel }}</a>
            @endif
                </div>
                <div class="banner-col2">
                    <div class="banner-img">
                        @if (!empty($course->image))
                            <img src="{{ url('d0/' . $course->image) }}" alt="">
                        @endif
                        {{-- <img src="./assets/images/home2-banner1.png" alt=""> --}}
                        <span class="banner-shape"><img src="./assets/images/bgcircleheader.png" alt=""></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="courses-wrapp">
        <div class="container">
            @if (!empty($course->coursetitle))
            {!! $course->coursetitle !!}
        @endif

            @if(!empty($course->coursesubtitle))
                <p>{{$course->coursesubtitle}}</p>
                @endif
            <div class="courses-row">


                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" data-target="#first">{{ $course->logicaltitle1 }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-target="#second">{{ $course->criticaltitle1 }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-target="#third">{{ $course->abstracttitle1 }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-target="#four">{{ $course->numericaltitle1 }}</button>
                    </li>
                  </ul>
                  <div class="tab-content tab-slider" >
                    <div class="tab-pane fade show active" id="first">
                        <div class="courses-col1">
                            <div class="courses-col2">
                                @if (!empty($course->logicaltitle2))
                                <h3>{{ $course->logicaltitle2 }}</h3>
                            @endif
                            @if (!empty($course->logicalcontent))
                            {!! $course->logicalcontent !!}
                            @endif
                                </div>
                            <div class="courses-col3">
                                <img src="./assets/images/courses.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="second">
                        <div class="courses-col1">
                            <div class="courses-col2">
                                @if (!empty($course->criticaltitle2))
                                <h3>{{ $course->criticaltitle2 }}</h3>
                            @endif

                            @if (!empty($course->criticalcontent))
                            {!! $course->criticalcontent !!}
                            @endif
                            </div>
                            <div class="courses-col3">
                                <img src="./assets/images/courses.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="third">
                        <div class="courses-col1">
                            <div class="courses-col2">
                                @if (!empty($course->abstracttitle2))
                                <h3>{{ $course->abstracttitle2 }}</h3>
                            @endif
                            @if (!empty($course->abstractcontent))
                            {!! $course->abstractcontent !!}
                            @endif
                            </div>
                            <div class="courses-col3">
                                <img src="./assets/images/courses.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="four">
                        <div class="courses-col1">
                            <div class="courses-col2">
                                @if (!empty($course->numericaltitle2))
                                <h3>{{ $course->numericaltitle2 }}</h3>
                            @endif
                            @if (!empty($course->numericalcontent))
                            {!! $course->numericalcontent !!}
                            @endif
                            </div>
                            <div class="courses-col3">
                                <img src="./assets/images/courses.png" alt="">
                            </div>
                        </div>
                    </div>
                  </div>

            </div>
        </div>
    </section>

    <section class="detail-wrapp">
        <div class="container">
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->numericaltitle2))
                    <h3>{{ $course->numericaltitle2 }}</h3>
                @endif
                    <p>Hours of video tutorials walking students through each topic of Thinking Skills. Follow us as we guide your learning journey from the fundamental principles all the way up to advanced techniques.</p>
                    <ul>
                        <li>Stay engaged with interactive videos and practice questions</li>
                        <li>Retain up to 80% more information</li>
                    </ul>
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        <img src="./assets/images/detail1.png" alt="">
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->numericaltitle2))
                    {{ $course->numericaltitle2 }}
                @endif
                    <p>Hours of video tutorials walking students through each topic of Thinking Skills. Follow us as we guide your learning journey from the fundamental principles all the way up to advanced techniques.</p>
                    <ul>
                        <li>Stay engaged with interactive videos and practice questions</li>
                        <li>Retain up to 80% more information</li>
                    </ul>
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        <img src="./assets/images/detail2.png" alt="">
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->numericaltitle2))
                                <h3>{{ $course->numericaltitle2 }}</h3>
                            @endif
                    <p>Hours of video tutorials walking students through each topic of Thinking Skills. Follow us as we guide your learning journey from the fundamental principles all the way up to advanced techniques.</p>
                    <ul>
                        <li>Stay engaged with interactive videos and practice questions</li>
                        <li>Retain up to 80% more information</li>
                    </ul>
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        <img src="./assets/images/detail3.png" alt="">
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->numericaltitle2))
                                <h3>{{ $course->numericaltitle2 }}</h3>
                            @endif
                    <p>Hours of video tutorials walking students through each topic of Thinking Skills. Follow us as we guide your learning journey from the fundamental principles all the way up to advanced techniques.</p>
                    <ul>
                        <li>Stay engaged with interactive videos and practice questions</li>
                        <li>Retain up to 80% more information</li>
                    </ul>
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        <img src="./assets/images/detail4.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="analysis-wrapp">
        <div class="container">
            <div class="analysis-row">
                <div class="analysis-col1">
                    <h2>Analyse Your Progress</h2>
                    <p>Measure how you perform in every exam, with mock insights that compare your answer to each question with other students</p>
                    <ul>
                        <li>Every response to our questions & quizzes is recorded on our database to determine the percentage of students that selected each option</li>
                        <li>Time data also shows how long you spent on each question compared to the average student</li>
                    </ul>
                </div>
                <div class="analysis-col2">
                    <img src="./assets/images/analysis-img.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="contact-wrapp">
        <div class="container">
            <div class="contact-row">
                <h3 class="highlight">Our Courses</h3>
                <h2>Need help? Have a question?</h2>
                <form action="">
                    <div class="text-fields">
                        <div class="text-field">
                            <input type="text" name="" id="" placeholder="First Name">
                        </div>
                        <div class="text-field">
                            <input type="text" name="" id="" placeholder="Last Name">
                        </div>
                        <div class="text-field">
                            <input type="text" name="" id="" placeholder="Phone Number">
                        </div>
                        <div class="text-field">
                            <input type="text" name="" id="" placeholder="Email">
                        </div>
                        <div class="text-field">
                            <textarea name="" id="" placeholder="Your Message"></textarea>
                        </div>
                    </div>
                    <div class="form-btn">
                        <button class="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @endsection

