@extends('layouts.exam')
@section('title', ucfirst($subLessonMaterial->pdf_name))
@section('content')
    <style>
        canvas {
            border: 1px solid black;
        }
    </style>
    <section class="exam-container">
        <div class="container-wrap" id="question-answer-page">
            <div class="lesson">
                <a class="lesson-exit float-start"
                    href="{{ route('live-class.privateclass.lessonshow', ['live' => $user->slug, 'lesson_material' => $lessonMaterial->slug]) }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="exiticon">
                </a>
                <div class="lesson-title">
                    <h3><span>{{ ucfirst($subLessonMaterial->pdf_name) }}</h3>
                </div>
                <div class="lesson-body">
                    <div id="lesson-pdf-body" class="lesson-pdf-body">
                        <canvas id="image-render" width="570" height="800"></canvas>
                    </div>
                </div>
                <div class="lesson-footer" id="lesson-footer-pagination">
                </div>
            </div>
        </div>
    </section>

@endsection

@push('footer-script')
    <script>
        function renderimage() {

            // Get the canvas element and its context
            var canvas = document.getElementById('image-render');
            var ctx = canvas.getContext('2d');

            // Assuming the width of each image is known and stored in `imageWidth`
            var imageWidth = 570; // Set this to the width of each image
            var height = 800; // Set this to the height of each image
            var totalImages = 4;
            var currentImage = 0;
            var x = 0;
            canvas.height = height * 4
            // Create image data for each image
            var imageDataArray = [];
            for (var i = 0; i < totalImages; i++) {
                imageDataArray.push(ctx.createImageData(1, height));
            }


        }

        // Function to draw a column of pixels for the current image
        function drawColumn(receivedColumnOfPixels) {
            // Ensure the received data length matches the expected column length
            if (receivedColumnOfPixels.length !== height * 4) {
                console.error("Incorrect data length");
                return;
            }

            // Get the current image data
            var imageData = imageDataArray[currentImage];

            // Copy the received column of pixels into the image data
            for (var ii = 0; ii < receivedColumnOfPixels.length; ++ii) {
                imageData.data[ii] = receivedColumnOfPixels[ii];
            }

            // Put the image data on the canvas
            ctx.putImageData(imageData, x + currentImage * imageWidth, 0);
            ++x;

            // If the current image is complete, move to the next image
            if (x >= imageWidth) {
                x = 0;
                ++currentImage;
                // If all images are done, reset to the first image
                if (currentImage >= totalImages) {
                    currentImage = 0;
                }
            }
        } 
    </script>
@endpush
