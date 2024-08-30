@extends('layouts.admin')
@section('title', 'Tips n Advice')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn"  id="back-btn" style="display: none">
                <a onclick="pagetoggle()"><img src="{{asset('assets/images/leftarrowblack.svg')}}" alt=""></a>
            </div>
            <h2>Tips and Advice</h2>
        </div>
    </div>
</section>
<section class="content_section" id="category-content-section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k=> $item) 
            <div class="col-md-6">

                <a href="{{route('admin.tip.create',$item->id)}}">
                    <div class="card mt-4">
                        <div class="card-body">
                            
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset('assets/images/User-red.png')}}">
                                </div>
                                
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-3"> Topic {{$k+1}} </span> <i id="category-content-subtitle-edit-3" onclick="editsubtitle(event,this)" data-title="a" data-subtitle="Topic 1" data-category="3"><img src="http://localhost:8000/assets/images/pen.png" width="15" alt=""> </i></h5>
                                    <h3>{{$item->name}}</h3>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </a>

            </div>
            @endforeach
                        {{-- <div class="col-md-6">

                <a  onclick="loadsubcategory('http://localhost:8000/admin/question-bank/7cfcc084d95ab0ba9320b58159053983/subcategory')">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="http://localhost:8000/assets/images/User-red.png">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-4"> Topic 2 </span> <i id="category-content-subtitle-edit-4" onclick="editsubtitle(event,this)" data-title="bcd" data-subtitle="Topic 2" data-category="4"><img src="http://localhost:8000/assets/images/pen.png" width="15" alt=""> </i></h5>
                                    <h3>Tip2</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
                    </div> --}}
    </div>
</section>

<section class="content_section" id="subcategory-content-section" style="display: none">
    <div class="container">
        <div class="row" id="subcategory-list">

        </div>
    </div>
</section>
@endsection
