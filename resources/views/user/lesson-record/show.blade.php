@extends('layouts.user')
@section('title', 'Lesson Recording - '.$lessonRecording->term_name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Lesson Recording - {{$lessonRecording->term_name}}</h2>
        </div>
    </div>
</section>


<section class="content_section" id="main-content">
    <div class="container">
        <div class="row">
            @foreach ($recordVideos as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body"> 
                        <a  onclick="loadvideowrap('{{$item->source_video}}','{{$item->title}}')">

                            <div class="category">
                                <div class="category-content"> 
                                    <h4>{{$item->title}}</h4> 
                                </div>
                                <div class="category-image">
                                    <img src="{{ asset('assets/images/video-clip.png') }}">
                                </div> 
                            </div>
                        </a>
                    </div>
                </div>
            </div>                
            @endforeach
        </div>
    </div>
</section>


<section class="content_section" id="video-content" style="display:none">
    <div class="container">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">  
                        <button type="button" class="close float-end m-3" onclick="closevideo()" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
                        <div class="video-content-body" id="video-content-body">

                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</section>

@endsection
@push('footer-script')
    <script>
        function generateRandomId(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }
        function getVimeoId(url) {
            // Regular expression to match Vimeo URL format
            const regex = /vimeo\.com\/(?:video\/|)(\d+)/;
            // Extract video ID using match function
            const match = url.match(regex);

            if (match) {
                return match[1]; // Return the captured video ID
            } else {
                return url; // Return null if no match found
            }
        }
        function getYoutubeId(url) {
            // Regular expression to match Vimeo URL format
            const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
            // Extract video ID using match function
            const match = url.match(regex);

            if (match) {
                return match[1]; // Return the captured video ID
            } else {
                return url; // Return null if no match found
            }
        }
        function loadvideowrap(url,title){
            var videocontent = `${url}`;
            const lesseonId=generateRandomId(10);
            if (videocontent.includes('youtube.com')||videocontent.match(/^[a-zA-Z0-9_-]{11}$/)) {
                videocontent =getYoutubeId(videocontent);
                $('#video-content-body').html(`
                <div class="video-row video-box" >

                    <div class="video-title">
                        <span>${title}</span>
                    </div>
                    <div class="video-container">
                        <div class="videoframe" id="vimo-videoframe-${lesseonId}">
                            <iframe src="https://www.youtube.com/embed/${videocontent}?byline=0&keyboard=0&dnt=1&app_id=${lesseonId}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="${title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div> 
                    </div>
                </div>
                `)
            }else if (videocontent.includes('vimeo.com')||videocontent.match(/^\d{8,10}$/)) {
                videocontent =getVimeoId(videocontent);
                $('#video-content-body').html(`
                <div class="video-row video-box" >
                    <div class="video-title">
                        <span>${title}</span>
                    </div>
                    <div class="video-container">
                        <div class="videoframe" id="vimo-videoframe-${lesseonId}">
                            <iframe src="https://player.vimeo.com/video/${videocontent}?byline=0&keyboard=0&dnt=1&app_id=${lesseonId}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="${title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div> 
                    </div>
                </div>
                `)
            }else{
                
                $('#video-content-body').html(`
                <div class="video-row video-box" >
                    <div class="video-title">
                        <span>${title}</span>
                    </div>
                    <div class="video-container">
                        <div class="videoframe" id="vimo-videoframe-${lesseonId}">
                            <iframe src="${videocontent}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="${title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div> 
                    </div>
                </div>
                `)
            }
            $('#main-content,#video-content').slideToggle();
        }
        function closevideo(){
            $('#main-content,#video-content').slideToggle("slow","swing", function(){
                $('#video-content-body').html('')
            }); 
        } 
    </script>
@endpush