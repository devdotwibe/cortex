@extends('layouts.admin')
@section('title', $post->title)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="back-btn" >
            <a href="{{route('admin.community.index')}}"><img src="{{asset('assets/images/leftarrowblack.svg')}}" alt=""></a>
        </div>
        <div class="header_title">
            <h2>{{$post->title}}</h2>
        </div> 
        <div class="header_right">
            <ul class="nav_bar"> 
                 
                @if($postUser->post_status=="active")
                <li class="nav_item"><a href="{{route('admin.community.report.banuser',$postUser->slug)}}" class=" btn btn-danger">Ban User</a></li> 
                @endif
                <li class="nav_item"><a href="{{route('admin.community.post.edit',$post->slug)}}" class="nav_link btn">Edit Post</a></li>       
                @if($post->visible_status=="show")
                <li class="nav_item"><a href="{{route('admin.community.report.hidepost',$post->slug)}}"   class="btn btn-outline-danger">Block Post</a></li>
                @else
                @endif      
            </ul>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3>Report</h3>
                </div>
                <div class="card-body">
                    <div class="post-header">
                        <div class="avathar">
                            <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                        </div>
                        <div class="title">
                            <h3>{{$user->name}}</h3>
                            <span>@if($reportPost->created_at->diffInMinutes(now())>1) {{$reportPost->created_at->diffForHumans(now(), true)}} ago @else Just Now @endif</span>
                        </div>
                    </div>
                    <div class="post-description" >
                        <div class="report-title">
                            <h3>{{$reportPost->type}}</h3>
                            <p>{{$reportPost->reason}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3>Post</h3>
                </div>
                <div class="card-body">
                    <div class="post-header">
                        <div class="avathar">
                            <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                        </div>
                        <div class="title">
                            <h3>{{optional($post->user)->name}}</h3>
                            <span>@if($post->created_at->diffInMinutes(now())>1) {{$post->created_at->diffForHumans(now(), true)}} ago @else Just Now @endif</span>
                        </div>
                    </div>
                    @if($post->type=="post")
                    <div class="post-image">
                        @if(!empty($post->image))
                        <img src="{{ $post->image }}" alt="">
                        @endif 
                    </div>
                    <div class="post-description" id="post-description"></div>
                    <script> 
                        const component = document.getElementById('post-description');
                        const shadowRoot = component.attachShadow({ mode: 'open' });
                        shadowRoot.innerHTML = `
                            <link rel="stylesheet" href="{{asset('ckeditor/contents.css')}}">
                            {!! $post->description !!}
                        `;
                    </script>
                    @elseif($post->type=="poll")
                    @php
                        $tvotes=$post->pollOption->sum('votes');
                    @endphp
                    <div class="poll-options">                            
                        @foreach($post->pollOption as $opt) 
                            <div class="form-check">
                                <span class="form-check-label" for="poll-{{$post->slug}}-option-{{$opt->slug}}">
                                    {{$opt->option}}
                                    <span id="poll-{{$post->slug}}-option-{{$opt->slug}}-percentage">({{$tvotes>0?round(($opt->votes*100)/$tvotes,2):0}}%)</span>
                                    <div class="poll-graph-bar-wrapper">
                                        <div class="poll-graph-bar" id="poll-{{$post->slug}}-option-{{$opt->slug}}-bar" style="width: {{$tvotes>0?round(($opt->votes*100)/$tvotes,2):0}}%;"></div>
                                    </div>
                                </span>
                            </div> 
                        @endforeach 
                    </div>
                    @endif

                    <div class="post-actions">
                        <a class="post-action-btn like-btn m-2 btn" ><img src="{{asset('assets/images/like.svg')}}" slt="comment"> <span>{{$post->likes()->count()}}</span></a>
                        <a class="post-action-btn comment-btn m-2 btn" ><img src="{{asset('assets/images/comment1.svg')}}" slt="comment"> <span>{{$post->comments()->whereNull('post_comment_id')->count()}}</span></a>
                    </div>  
                </div> 
            </div>
        </div>
    </div>
</section> 
@endsection 
@push('modals') 
    
    <div class="modal fade" id="delete-post" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.community.post.destroy',$post->slug)}}"  id="delete-post-form" method="post">
                        @csrf
                        @method("DELETE")
                        <p>Are you sure you want to delete the record </p>
                        <button type="button" data-bs-dismiss="modal"   class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>  
@endpush

@push('footer-script')
    <script> 
    </script>
@endpush