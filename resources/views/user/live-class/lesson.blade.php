@extends('layouts.user')
@section('title', 'Class Details')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('live-class.privateclass.lesson',$user->slug) }}">
                  
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
            <h2>Term {{$lessonMaterial->getIdx()+1}} :Lesson Details </h2>
        </div>
    </div>
</section>


<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($lessons as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <a href="{{ route('live-class.privateclass.lessonpdf', ["live" =>$user->slug,"sub_lesson_material"=>$item->slug ]) }}">
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