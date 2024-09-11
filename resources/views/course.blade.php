
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


            <div class="courses-row">


                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" data-bs-target="#first" role="tab" data-bs-toggle="tab"> @if(!empty($course->logicaltitle1)){{$course->logicaltitle1}}@endif</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-target="#second" role="tab" data-bs-toggle="tab"> @if(!empty($course->criticaltitle1)){{$course->criticaltitle1}}@endif</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-target="#third" role="tab" data-bs-toggle="tab">@if(!empty($course->abstracttitle1)){{$course->abstracttitle1}}@endif</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-target="#four" role="tab" data-bs-toggle="tab">@if(!empty($course->numericaltitle1)){{$course->numericaltitle1}}@endif</button>
                    </li>
                  </ul>
                  <div class="tab-content tab-slider" >

                    <div class="tab-pane fade show active" id="first">
                        <div class="courses-col1">
                            <div class="courses-col2">


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
                <form id="contact_form" action="" method="post">
                    @csrf <!-- Include the CSRF token -->
                    <div class="text-fields">
                        <div class="text-field">
                            <input type="text" name="first_name" id="first_name" placeholder="First Name">
                            <div class="error text-danger" id="first_name_error"></div>
                        </div>
                        <div class="text-field">
                            <input type="text" name="last_name" id="last_name" placeholder="Last Name">
                            <div class="error text-danger" id="last_name_error"></div>
                        </div>
                        <div class="text-field">
                            <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number">
                            <div class="error text-danger" id="phone_number_error"></div>
                        </div>
                        <div class="text-field">
                            <input type="email" name="email" id="email" placeholder="Email">
                            <div class="error text-danger" id="email_error"></div>
                        </div>
                        <div class="text-field">
                            <textarea name="message" id="message" placeholder="Your Message"></textarea>
                            <div class="error text-danger" id="message_error"></div>
                        </div>
                    </div>
                    <div class="form-btn">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                    <div id="form-messages"></div>
                </form>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')

    <script>
        $(document).ready(function() {

            $('#contact_form').on('submit', function(event) {
                event.preventDefault();

                // Clear previous error messages
                $('.error').html(''); // Clear all error fields
                $('#form-messages').html(''); // Clear form messages

                const formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("contact.submit") }}',
                    data: formData,
                    success: function(response) {
                        $('#form-messages').html('<p>Thank you for your message. We will get back to you soon.</p>');
                        $('#contact_form').trigger('reset'); // Reset the form fields
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;


                            $('#first_name_error').text(errors.first_name);
                            $('#last_name_error').text(errors.last_name);
                            $('#phone_number_error').text(errors.phone_number);
                            $('#email_error').text(errors.email);
                            $('#message_error').text(errors.message);
                    }
                });
            });
        });
    </script>

    @endpush
