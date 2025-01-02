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
<section class="content_section admin_section" id="category-content-section">
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

    </div>
</section>

<section class="content_section admin_section" id="subcategory-content-section" style="display: none">
    <div class="container">
        <div class="row" id="subcategory-list">

        </div>
    </div>
</section>
@endsection
