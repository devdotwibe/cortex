<section class="review-wrapp">
        <div class="container">
            <div class="review-row">
                <div class="review-col1">
                    <h3 class="highlight">Students feedback</h3>
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


