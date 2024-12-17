@extends('layouts.user')
@section('title', 'Class Details')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('live-class.privateclass.room',$user->slug) }}">
                  
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
            <h2>Term {{$lessonMaterial->getIdx()+1}} :Lesson Details </h2>
        </div>
    </div>
</section>


<div id="status-container">

    <img id="refreshing-gif" src="{{asset('assets/images/loader.svg')}}" style="display:none;" alt="Processing...">

</div>

<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($lessons as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <a  onclick="checkStatus('{{ route('live-class.privateclass.lessonpdf', ['live' => $user->slug, 'sub_lesson_material' => $item->slug]) }}')">
                            <div class="category">
                                <div class="category-content"> 
                                    <h4>{{$item->pdf_name}}</h4> 
                                </div>
                                <div class="category-image">
                                    <img src="{{ asset('assets/images/pdf.png') }}">
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
@endsection

@push('footer-script')

<script>

// function checkStatus(route) {

//     $('#refreshing-gif').show();

//     var interval = setInterval(function() {
//         $.ajax({
//             url: route,
//             type: 'GET',
//             success: function(response) {
//                 if (response.status === 'processing') {
        
//                     $('#refreshing-gif').show();
//                 }
//                 else if (response.status === 'completed') {
//                     window.location.reload(); 
//                     clearInterval(interval);  
//                 } else if (response.status === 'failed') {
                  
//                     $('#refreshing-gif').hide();
//                     alert('There was an error processing the file.');
//                     clearInterval(interval);
//                 }
//             },
//             error: function() {

//                 $('#refreshing-gif').hide();
//                 alert('An error occurred while checking the status.');
//                 clearInterval(interval);
//             }
//         });
//     }, 10000);
// }


function checkStatus(route) {
    // Show the refreshing GIF while processing
    $('#refreshing-gif').show();

    // Send the first AJAX request
    $.ajax({
        url: route,
        type: 'GET',
        success: function(response) {
            if (response.status === 'processing') {

                setInterval(() => {
                    checkStatus(route);
                }, 20000);

            } else if (response.status === 'completed') {
              
                window.location.href = route; 

            } else if (response.status === 'failed') {
                
                $('#refreshing-gif').hide();
            }
        },
        error: function() {
           
            $('#refreshing-gif').hide();
            alert('An error occurred while checking the status.');
        }
    });
}



</script>

@endpush