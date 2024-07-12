@extends('layouts.user')
@section('title', 'Home Work - '.$homeWork->term_name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Home Work - {{$homeWork->term_name}}</h2>
        </div>
    </div>
</section>


<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($booklets as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <a  onclick="confimbooklet('{{route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$item->slug])}}','{{$item->title}}')">
                            <div class="category">
                                <div class="category-content"> 
                                    <h4>{{$item->title}}</h4> 
                                </div>
                                <div class="category-image">
                                    <img src="{{ asset('assets/images/file-text.svg') }}">
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
        async function confimbooklet(url, title) {
            if (await showConfirm({
                    title: "Start the " + title
                })) {
                localStorage.removeItem("home-work-booklet")
                window.location.href = url;
            }
        }
    </script>
@endpush