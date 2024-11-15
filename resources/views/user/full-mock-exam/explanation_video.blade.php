@extends('layouts.exam')
@section('headerclass', 'top-barhide')
@section('bodyclass', 'bartop-hide')
@section('title', $exam->title)
@section('content')
<section class="exam-container" id="exam-container">
    <div class="container-wrap learnlessonclass">
        <div class="lesson">
          
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
            examPlayers =new Vimeo.Player(`vimo-videoframe`,{
                id: vimeoid,
                width: "100%",
                controls: true,
                autoplay: false,
                muted: false

            });
            examPlayers.getDuration().then(function(duration) { 
                vimeotime=duration; 
                console.log('Video Duration:', duration);
            }); 
            examPlayers.on('play', function() { 
                console.log('Video is playing');

                vimeoplay=true;
            });
            examPlayers.on('pause', function() { 
                console.log('Video is paused');
                vimeoplay=false;
                $('#video-suggestions').hide();
            });
            examPlayer.on('ended', function() {
                console.log('Video has ended');

                $('#video-suggestions').hide();
            });

            console.log(examPlayers);

        }
    
    </script>

@endpush
