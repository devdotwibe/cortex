@extends('layouts.exam')
@section('headerclass', 'top-barhide')
@section('bodyclass', 'bartop-hide')
@section('title', $exam->title)
@section('content')
<section class="exam-container" id="exam-container">
    <div class="container-wrap learnlessonclass">
        <div class="lesson">

            <a class="lesson-exit float-start" href="{{route('full-mock-exam.complete',$userExamReview->slug)}}" title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip" >
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a>
          
            <div class="lesson-title">
                <h5><span>{{$exam->title}}</span></h5>
            </div>

            <div class="lesson-body">

                <div class="row" id="vimeo_video_show">

                   
                </div>

            </div>
           
        </div>
    </div>
</section>

@endsection


@push('footer-script')
<script>

</script>

    <script src="{{asset("assets/js/player.js")}}"></script>
    <script>
      
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

        $(function(){

            LoadVideo('{{$exam->explanation_video}}');
        });

        function LoadVideo(vimeoid)
        {
            if (vimeoid.includes('vimeo.com')) {
                vimeoid =getVimeoId(vimeoid);
            }

            $('#vimeo_video_show').html(`
                <div class="col-md-12">
                    <div class="video-row video-box" >
                        <div class="video-title">
                            <span>{{$exam->title}}</span>
                        </div>
                        <div class="video-container">
                            <div class="videoframe" id="vimo-videoframe">
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            `).fadeIn();

            let vimeoplay = false;
            let pauseAtTime = 0;

            examPlayers =new Vimeo.Player(`vimo-videoframe`,{
                id: vimeoid,
                width: "100%",
                controls: true,
                autoplay: false,
                muted: false,
                ref: '0' ,
                dnt: true,
                // loop: true
            
            });
            examPlayers.getDuration().then(function(duration) { 
                vimeotime=duration; 
                console.log('Video Duration:', duration);
                
                pauseAtTime = duration;

                examPlayers.on('timeupdate', function(data) {
                    const currentTime = data.seconds; 
                    console.log('Current Time:', currentTime);


                    if (currentTime >= pauseAtTime && vimeoplay) {
                        examPlayers.pause().then(function() {
                            console.log('Video paused at ' + pauseAtTime + ' seconds');
                        }).catch(function(error) {
                            console.error('Error pausing video:', error);
                        });
                    }
                });
            }); 
            examPlayers.on('play', function() { 

                console.log('Video is playing');

                vimeoplay=true;
                examPlayers.on('timeupdate', function(data) {
                    const currentTime = data.seconds; 

                    console.log('Current Time:', currentTime);

                    if (currentTime >= pauseAtTime && vimeoplay) {
                        examPlayers.pause().then(function() {
                            console.log('Video paused at ' + pauseAtTime + ' seconds');
                        }).catch(function(error) {
                            console.error('Error pausing video:', error);
                        });
                    }
                });

            });
            examPlayers.on('pause', function() { 
                console.log('Video is paused');
                vimeoplay=false;
                $('#video-suggestions').hide();
                $('.vp-outro-content').hide();
            });
            examPlayer.on('ended', function() {

                vimeoplay=false;
                console.log('Video has ended');

            });

            console.log(examPlayers);

        }
    
    </script>

@endpush
