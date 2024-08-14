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
                <li class="nav_item"><a href="{{route('admin.community.post.edit',$post->slug)}}" class="nav_link btn">Edit Post</a></li>
                <li class="nav_item"><a data-bs-toggle="modal" data-target="#delete-post" data-bs-target="#delete-post" class="btn btn-outline-danger">Delete</a></li>                    
            </ul>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
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
                    {{-- <div class="post-comment">
                        <div class="form">
                            <form action="{{route('admin.community.post.comment',$post->slug)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea name="comment" id="comment" class="form-control @error('comment')  is-invalid  @enderror" rows="5"></textarea>
                                    @error('comment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-dark ">Add Comment</button>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="post-comment" id="post-comment-list">

                    </div>
                    <div class="post-comment-action">
                        <button id="load-more-btn" class="btn btn-outline-dark" style="display: none"> Load More </button>
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
    <div class="modal fade" id="delete-post-comment" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="#"  id="delete-post-comment-form" method="post">
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
                            <div class="post-comment-text">
                                <div class="comment-avathar">
                                    <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                                </div>
                                <div class="comment-title">
                                    <h3>${v.user}</h3>
                                    <span>${v.createdAt}</span>
                                </div>
                                <p class="comment-text">${v.comment}</p>
                                <div class="comment-action">
                                    <a class="reply-btn m-2 btn"  >Reply <span>${v.replys}</span></a>
                                    <a class="like-btn m-2 btn"  ><img src="{{asset('assets/images/like.svg')}}"  slt="comment"> <span>${v.likes}</span></a>
                                    <a class="delete-btn m-2 btn float-end" onclick="deletecomment('${v.deleteUrl}')"><img src="{{asset('assets/images/delete.svg')}}"  slt="comment"></a>
                                </div>
                            </div>
                            <div class="post-comment-replys" > 
                                <div class="replay-list" id="post-comment-${v.slug}-replys"></div>
                            </div>
                        </div>
                    `)
                    loadcommentreplay(v.replyUrl,`#post-comment-${v.slug}-replys`)
                })
            },'json')
        } 
        function loadcommentreplay(url,comment){
            $.get(url,function(res){
                // if(res.next){
                //     $('#load-more-btn').show().data('url',res.next)
                // }else{
                //     $('#load-more-btn').hide().data('url',null);
                // }
                $.each(res.data,function(k,v){

                    $(comment).append(`
                        <div class="replay-list-item" id="replay-list-${v.slug}"> 
                            <div class="replay-list-text">
                                <div class="replay-avathar">
                                    <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                                </div>
                                <div class="replay-title">
                                    <h3>${v.user}</h3>
                                    <span>${v.createdAt}</span>
                                </div>
                                <p class="replay-text">${v.comment}</p>
                                <div class="replay-action">
                                    <a class="delete-btn m-2 btn float-end" onclick="deletecomment('${v.deleteUrl}')"><img src="{{asset('assets/images/delete.svg')}}"  slt="comment"></a>
                                </div>
                            </div> 
                        </div>
                    `)
                })
            })
        }
        function deletecomment(url){
            $('#delete-post-comment-form').attr('action',url);
            $('#delete-post-comment').modal('show');
        }
        $(function(){
            loadcomment("{{url()->current()}}");
            $('#load-more-btn').click(function(){
                loadcomment($('#load-more-btn').data('url'))
            })
            $('#delete-post-comment-form').submit(function(e){
                e.preventDefault();
                $.post($(this).attr('action'),$(this).serialize(),function(res){
                    $('#post-comment-list').html(``)
                    loadcomment("{{url()->current()}}");
                });
                $('#delete-post-comment').modal('hide')
            });
        })
    </script>
@endpush