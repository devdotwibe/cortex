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
            @foreach ($categorys as $k => $item)
            <div class="col-md-6">
                <a href="{{route('admin.tip.create', $item->id)}}">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <!-- Edit icon for the category image -->
                                    <img src="{{ asset('assets/images/User-red.png') }}" id="category-content-icon-{{$item->id}}">
                                    <i id="category-content-icon-edit-{{$item->id}}" onclick="editIcon(event, this)" data-category="{{$item->id}}">
                                        <img src="{{ asset('assets/images/pen.png') }}" width="15" alt="">
                                    </i>
                                </div>

                                <div class="category-content">
                                    <!-- Edit icon for the subtitle -->
                                    <h5>
                                        <span id="category-content-subtitle-{{$item->id}}"> Topic {{$k+1}} </span> 
                                        <i id="category-content-subtitle-edit-{{$item->id}}" onclick="editSubtitle(event, this)" 
                                            data-title="{{$item->name}}" 
                                            data-subtitle="Topic {{$k+1}}" 
                                            data-category="{{$item->id}}">
                                            <img src="{{ asset('assets/images/pen.png') }}" width="15" alt="">
                                        </i>
                                    </h5>
                                    <h3>{{$item->name}}</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="content_section admin_section" id="subcategory-content-section" style="display: none">
    <div class="container">
        <div class="row" id="subcategory-list">

        </div>
    </div>
</section>
@endsection
