@extends('layouts.user')
@section('title', 'Live Class - ' . ($live_class->class_title_1 ?? ' Private Class Room '))
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                    <a href="{{ route('live-class.privateclass',$user->slug) }}">
                      
                        <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                    </a>
                </div>
                <h2>Live Class - {{ $live_class->class_title_1 ?? ' Private Class Room ' }}</h2>
            </div>
        </div>
    </section>
    <section class="content_section private">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a>
                                <div class="category">
                                    <div class="category-image">
                                        <img src="{{ asset('assets/images/class.svg') }}">
                                    </div>
                                    <div class="category-content">
                                        <h3>Class Details</h3> 
                                    </div>
                                </div>
                                <div class="category cat-1" id="category-content-class-detail">

                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a>
                                <div class="category">
                                    <div class="category-image">
                                        <img src="{{ asset('assets/images/lessonmaterial.svg') }}">
                                    </div>
                                    <div class="category-content">
                                        <h3>Lesson Material</h3>
                                    </div>
                                </div>
                                <div class="category cat-1" id="category-content-lesson-material">

                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a>
                                <div class="category">

                                    <div class="category-image">

                                        <img src="{{ asset('assets/images/homework.svg') }}">

                                    </div>

                                    <div class="category-content">

                                        <h3>Homework Submission</h3>

                                        <p>   </p>

                                    </div>
                                </div>
                                <div class="category cat-1" id="category-content-home-work">

                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{route('lesson-record.index')}}">
                                <div class="category">

                                    <div class="category-image">

                                        <img src="{{ asset('assets/images/recording.svg') }}">

                                    </div>

                                    <div class="category-content">

                                        <h3>Lesson Recording</h3>

                                        <p>   </p>

                                    </div>
                                </div>
                                <div class="category cat-1" id="category-content-lesson-recording">

                                </div>
                            </a>
                        </div>
                    </div>
                </div>
 

            </div>
        </div>
    </section>
@endsection

@push('footer-script')



<script>

    function loadclassdetail(url){
            $.get(url,function(res){
                $.each(res,function(k,v){

                    var str="";

                    $.each(res,function(k,v){
                        str+=`
                            <div class="category-title">
                            <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                            </div>
                        `;
                    })
                    $('#category-content-class-detail').html(str);

                })
                // pagetoggle()
            },'json')
        }
        
        function loadlessonmaterial(url){
            $.get(url,function(res){
                $.each(res,function(k,v){

                    var str="";

                    $.each(res,function(k,v){
                        str+=`
                            <div class="category-title">
                            <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                            </div>
                        `;
                    })
                    $('#category-content-lesson-material').html(str);

                })
                // pagetoggle()
            },'json')
        }

        function loadhomework(url){
            $.get(url,function(res){
                $.each(res,function(k,v){

                    var str="";

                    $.each(res,function(k,v){
                        str+=`
                            <div class="category-title">
                            <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                            </div>
                        `;
                    })
                    $('#category-content-home-work').html(str);

                })
                // pagetoggle()
            },'json')
        }

        function loadlessonrecord(url){
            $.get(url,function(res){
                $.each(res,function(k,v){

                    var str="";

                    $.each(res,function(k,v){
                        str+=`
                            <div class="category-title">
                            <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                            </div>
                        `;
                    })
                    $('#category-content-lesson-recording').html(str);

                })
                // pagetoggle()
            },'json')
        }

    // function pagetoggle(){
    //     $('#category-content-section,#subcategory-content-section').slideToggle()
    //     $('#back-btn').fadeToggle()
    // }
    $(document).ready(function() {

        loadclassdetail('{{route('term.class_detail')}}');

        loadlessonmaterial('{{route('term.lesson_material')}}');

        loadhomework('{{route('term.home_work')}}');

        loadlessonrecord('{{route('term.lesson_recording')}}');

    });


</script>

@endpush
