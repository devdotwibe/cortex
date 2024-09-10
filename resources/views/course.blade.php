
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



        <h2> @if (!empty($course->coursetitle))
            {!! $course->coursetitle !!}
        @endif</h2>

            @if(!empty($course->coursesubtitle))
                <p>{{$course->coursesubtitle}}</p>
                @endif
            <div class="courses-row">


                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" data-target="#first"> @if(!empty($course->logicaltitle1)){{$course->logicaltitle1}}@endif</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-target="#second"> @if(!empty($course->criticaltitle1)){{$course->criticaltitle1}}@endif</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-target="#third">@if(!empty($course->abstracttitle1)){{$course->abstracttitle1}}@endif</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-target="#four">@if(!empty($course->numericaltitle1)){{$course->numericaltitle1}}@endif</button>
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
                                @if (!empty($course->logicalimage))
                        <img src="{{ url('d0/' . $course->logicalimage) }}" alt="">
                    @endif
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
                                @if (!empty($course->criticalimage))
                        <img src="{{ url('d0/' . $course->criticalimage) }}" alt="">
                    @endif

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
                                @if (!empty($course->abstractimage))
                                <img src="{{ url('d0/' . $course->abstractimage) }}" alt="">
                            @endif
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
                                @if (!empty($course->numericalimage))
                                <img src="{{ url('d0/' . $course->numericalimage) }}" alt="">
                            @endif
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
                    @if (!empty($course->learncontent))
                    {!! $course->learncontent !!}
                @endif
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        {{-- <img src="./assets/images/detail1.png" alt=""> --}}
                        @if (!empty($course->learnimage))
                        <img src="{{ url('d0/' . $course->learnimage) }}" alt="">
                    @endif
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->questionbankcontent))
                    {!! $course->questionbankcontent !!}
                @endif

                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        {{-- <img src="./assets/images/detail2.png" alt=""> --}}
                        @if (!empty($course->questionbankimage))
                        <img src="{{ url('d0/' . $course->questionbankimage) }}" alt="">
                    @endif
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->topiccontent))
                    {!! $course->topiccontent !!}
                @endif
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        {{-- <img src="./assets/images/detail3.png" alt=""> --}}
                        @if (!empty($course->topicimage))
                        <img src="{{ url('d0/' . $course->topicimage) }}" alt="">
                    @endif
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-col1">
                    @if (!empty($course->fullmockcontent))
                    {!! $course->fullmockcontent !!}
                @endif
                </div>
                <div class="detail-col2">
                    <div class="detail-img">
                        {{-- <img src="./assets/images/detail4.png" alt=""> --}}
                        @if (!empty($course->fullmockimage))
                        <img src="{{ url('d0/' . $course->fullmockimage) }}" alt="">
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="analysis-wrapp">
        <div class="container">
            <div class="analysis-row">
                <div class="analysis-col1">
                    @if (!empty($course->privatecontent))
                    {!! $course->privatecontent !!}
                @endif
                </div>
                <div class="analysis-col2">
                    {{-- <img src="./assets/images/analysis-img.png" alt=""> --}}
                    @if (!empty($course->privateimage))
                        <img src="{{ url('d0/' . $course->privateimage) }}" alt="">
                    @endif

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

