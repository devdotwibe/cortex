@extends('layouts.user')
@section('title', $post->title)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="back-btn" >
            <a href="{{route('community.index')}}"><img src="{{asset('assets/images/leftarrowblack.svg')}}" alt=""></a>
        </div>
        <div class="header_title">
            <h2>{{$post->title}}</h2>
        </div> 
        <div class="header_right">
            <ul class="nav_bar">
                @if ($post->user_id==$user->id)
                <li class="nav_item"><a href="{{route('community.post.edit',$post->slug)}}" class="nav_link btn">Edit Post</a></li>
                <li class="nav_item"><a data-bs-toggle="modal" data-target="#delete-post" data-bs-target="#delete-post" class="btn btn-outline-danger">Delete</a></li>                    
                @endif
            </ul>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
                @if($post->type=="post")
                <div class="card-body">
                    <div class="post-description">
                    {!! $post->description !!}
                    </div>
                    <div class="post-actions">
                        <a class="post-action-btn comment-btn m-2" ><img src="{{asset('assets/images/comment1.svg')}}" slt="comment"> <span>{{$post->comments()->count()}}</span></a>
                        <a class="post-action-btn like-btn m-2"  href="{{route('community.post.like',$post->slug)}}"><img @if($post->likes()->where('user_id',auth()->id())->count()>0) src="{{asset('assets/images/liked.svg')}}" @else src="{{asset('assets/images/like.svg')}}" @endif slt="comment"> <span>{{$post->likes()->count()}}</span></a>
                    </div>
                    <div class="post-comment">
                        <div class="form">
                            <form action="{{route('community.post.comment',$post->slug)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea name="comment" id="comment" class="form-control @error('comment')  is-invalid  @enderror" rows="10"></textarea>
                                    @error('comment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-dark ">Add Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="post-comment" id="post-comment-list">

                    </div>
                    <div class="post-comment-action">
                        <button id="load-more-btn" class="btn btn-outline-dark" style="display: none"> Load More </button>
                    </div>
                </div>
                @elseif($post->type=="poll")
                @php
                    $tvotes=$post->pollOption->sum('votes');
                @endphp
                <div class="card-body">                    
                    <div class="poll-options"> 
                        @if (!empty($vote))
                            @foreach($post->pollOption as $opt)
                            <a href="{{route('community.poll.vote',$opt->slug)}}">
                                <div class="form-check @if(optional($vote->pollOption)->slug==$opt->slug) voted @else vote @endif "> 
                                    <span class="form-check-label" for="poll-{{$post->slug}}-option-{{$opt->slug}}">
                                        {{$opt->option}}
                                        <span id="poll-{{$post->slug}}-option-{{$opt->slug}}-percentage">({{$tvotes>0?round(($opt->votes*100)/$tvotes,2):0}}%)</span>
                                        <div class="poll-graph-bar-wrapper">
                                            <div class="poll-graph-bar" id="poll-{{$post->slug}}-option-{{$opt->slug}}-bar" style="width: {{$tvotes>0?round(($opt->votes*100)/$tvotes,2):0}}%;"></div>
                                        </div>
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        @else                            
                            @foreach($post->pollOption as $opt)
                            <a href="{{route('community.poll.vote',$opt->slug)}}">
                                <div class="form-check">
                                    <span class="form-check-label" for="poll-{{$post->slug}}-option-{{$opt->slug}}">
                                        {{$opt->option}}
                                        <span id="poll-{{$post->slug}}-option-{{$opt->slug}}-percentage">({{$tvotes>0?round(($opt->votes*100)/$tvotes,2):0}}%)</span>
                                        <div class="poll-graph-bar-wrapper">
                                            <div class="poll-graph-bar" id="poll-{{$post->slug}}-option-{{$opt->slug}}-bar" style="width: {{$tvotes>0?round(($opt->votes*100)/$tvotes,2):0}}%;"></div>
                                        </div>
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        @endif
                    </div>
                    <div class="post-actions">
                        <a class="post-action-btn comment-btn m-2" ><img src="{{asset('assets/images/comment1.svg')}}" slt="comment"> <span>{{$post->comments()->count()}}</span></a>
                        <a class="post-action-btn like-btn m-2"  href="{{route('community.post.like',$post->slug)}}"><img @if($post->likes()->where('user_id',auth()->id())->count()>0) src="{{asset('assets/images/liked.svg')}}" @else src="{{asset('assets/images/like.svg')}}" @endif slt="comment"> <span>{{$post->likes()->count()}}</span></a>
                    </div>
                    <div class="post-comment">
                        <div class="form">
                            <form action="{{route('community.post.comment',$post->slug)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea name="comment" id="comment" class="form-control @error('comment')  is-invalid  @enderror" rows="10"></textarea>
                                    @error('comment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-dark ">Add Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="post-comment" id="post-comment-list">

                    </div>
                    <div class="post-comment-action">
                        <button id="load-more-btn" class="btn btn-outline-dark" style="display: none"> Load More </button>
                    </div>
                </div>
                @else
                <div class="card-body">
                </div>
                @endif 
            </div>
        </div>
    </div>
</section> 
@endsection

@push('modals') 
    @if ($post->user_id==$user->id)
        <div class="modal fade" id="delete-post" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="Lablel">Delete Confirmation Required</h5>
                        <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('community.post.destroy',$post->slug)}}"  id="delete-post-form" method="post">
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
    @endif
@endpush

@push('footer-script')
    <script>
        function loadcomment(url){
            $.get(url,function(res){
                if(res.next){
                    $('#load-more-btn').show().data('url',res.next)
                }else{
                    $('#load-more-btn').hide().data('url',null);
                }
                $.each(res.data,function(k,v){
                    $('#post-comment-list').append(`
                        <div class="post-comment-item" id="post-comment-${v.slug}"> 
                            <div class="post-comment-text">${v.comment}</div>
                            <div class="post-comment-replys" id="post-comment-${v.slug}-replys">
                            </div>
                        </div>
                    `)
                })
            },'json')
        }
        $(function(){
            loadcomment("{{url()->current()}}");
            $('#load-more-btn').click(function(){
                loadcomment($('#load-more-btn').data('url'))
            })
        })
    </script>
@endpush