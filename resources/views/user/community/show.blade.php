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
                @else
                <li class="nav_item"><a data-bs-toggle="modal" data-target="#report-post" data-bs-target="#report-post" class="btn btn-outline-warning">Report</a></li>
                @endif
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
                    @endif

                    <div class="post-actions">
                        <a class="post-action-btn like-btn m-2 btn"  href="{{route('community.post.like',$post->slug)}}"><img @if($post->likes()->where('user_id',auth()->id())->count()>0) src="{{asset('assets/images/liked.svg')}}" @else src="{{asset('assets/images/like.svg')}}" @endif slt="comment"> <span>{{$post->likes()->count()}}</span></a>
                        <a class="post-action-btn comment-btn m-2 btn" ><img src="{{asset('assets/images/comment1.svg')}}" slt="comment"> <span>{{$post->comments()->whereNull('post_comment_id')->count()}}</span></a>
                    </div>
                    <div class="post-comment">
                        <div class="form">
                            <form action="{{route('community.post.comment',$post->slug)}}" method="post">
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
                    </div>
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
    @else   
    <div class="modal fade" id="report-post" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Lablel">Report</h5>
                    <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('community.post.report',$post->slug)}}"  id="report-post-form" method="post">
                        @csrf 
                        <div class="form-group">
                            <label for="report-type">Choose a Reason for Reporting</label>
                            <select class="form-control" name="type" id="report-type">
                                <option value="">--Choose a Reason--</option>
                                <option value="Spam">Spam</option>
                                <option value="Harassment or Bullying">Harassment or Bullying</option>
                                <option value="Hate Speech">Hate Speech</option>
                                <option value="Inappropriate Content">Inappropriate Content</option>
                                <option value="Misinformation">Misinformation</option>
                                <option value="Violence or Harmful Behavior">Violence or Harmful Behavior</option>
                                <option value="Privacy Violation">Privacy Violation</option>
                                <option value="Impersonation">Impersonation</option>
                                <option value="Copyright Infringement">Copyright Infringement</option>
                                <option value="Scam or Fraud">Scam or Fraud</option>
                                <option value="Off-topic">Off-topic</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="invalid-feedback" id="report-type-error"></div> 
                        </div>
                        <div class="form-group">
                            <label for="report-reason">Provide Additional Information</label>
                            <textarea name="reason" id="report-reason" class="form-control" rows="10"></textarea>
                            <div class="invalid-feedback" id="report-reason-error"></div> 
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" data-bs-dismiss="modal"   class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-danger">Submit the Report</button>
                        </div>
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
                                    <a class="reply-btn m-2 btn" onclick="showToggle('#post-comment-${v.slug}-reply-form')" >Reply <span>${v.replys}</span></a>
                                    <a class="like-btn m-2 btn" onclick="likevote('${v.likeUrl}','#post-comment-${v.slug}')" ><img src="{{asset('assets/images/like.svg')}}"  slt="comment"> <span>${v.likes}</span></a>
                                </div>
                            </div>
                            <div class="post-comment-replys" >
                                <div class="form" id="post-comment-${v.slug}-reply-form" style="display:none">
                                    <form  onSubmit="replaysubmit(event,this,'${v.slug}','${v.replyUrl}')" method="post">
                                        @csrf
                                        <input type="hidden" name="reply" value="${v.slug}" >
                                        <div class="form-group">
                                            <label for="post-comment-${v.slug}-reply-form-comment">Reply</label>
                                            <textarea name="comment" id="post-comment-${v.slug}-reply-form-comment" class="form-control"></textarea>
                                            <div class="invalid-feedback" id="post-comment-${v.slug}-reply-form-comment-error"></div> 
                                        </div>
                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-dark ">Add Reply</button>
                                            <button type="button"  onclick="showToggle('#post-comment-${v.slug}-reply-form')" class="btn btn-outline-dark ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="replay-list" id="post-comment-${v.slug}-replys"></div>
                            </div>
                        </div>
                    `)
                    loadcommentreplay(v.replyUrl,`#post-comment-${v.slug}-replys`)
                })
            },'json')
        }
        function showToggle(e){
            $(e).slideToggle();
        }
        function replaysubmit(e,form,slug,replyUrl){
            e.preventDefault();
            $(form).find('.form-control').removeClass('is-invalid')
            $.post("{{route('community.post.comment',$post->slug)}}",$(form).serialize(),function(res){
                form.reset();
                $(`#post-comment-${v.slug}-replys`).html('')
                loadcommentreplay(replyUrl,`#post-comment-${slug}-replys`)
            },'json').fail(function(xhr){
                try {
                    let res = JSON.parse(xht.responseText); 
                    $.each(res.errors,function(k,v){
                        $(`#post-comment-${slug}-reply-form-${k}`).addClass('is-invalid')
                        $(`#post-comment-${slug}-reply-form-${k}-error`).text(v[0])
                    })
                } catch (error) {
                    
                }
            })
        }
        function loadcommentreplay(url,comment){
            $.get(url,function(res){
            //     // if(res.next){
            //     //     $('#load-more-btn').show().data('url',res.next)
            //     // }else{
            //     //     $('#load-more-btn').hide().data('url',null);
            //     // }
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
                            </div> 
                        </div>
                    `)
                })
            })
        }
        function likevote(url,id) {
            $.get(url,function(v){ 
                $(id).html(`
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
                        <a class="reply-btn m-2 btn" onclick="showToggle('#post-comment-${v.slug}-reply-form')" >Reply <span>${v.replys}</span></a>
                        <a class="like-btn m-2 btn" onclick="likevote('${v.likeUrl}','#post-comment-${v.slug}')"  ><img src="{{asset('assets/images/like.svg')}}"  slt="comment"> <span>${v.likes}</span></a>
                    </div>
                </div>
                <div class="post-comment-replys" >
                    <div class="form" id="post-comment-${v.slug}-reply-form" style="display:none">
                        <form  onSubmit="replaysubmit(event,this,'${v.slug}','${v.replyUrl}')" method="post">
                            @csrf
                            <input type="hidden" name="reply" value="${v.slug}" >
                            <div class="form-group">
                                <label for="post-comment-${v.slug}-reply-form-comment">Reply</label>
                                <textarea name="comment" id="post-comment-${v.slug}-reply-form-comment" class="form-control"></textarea>
                                <div class="invalid-feedback" id="post-comment-${v.slug}-reply-form-comment-error"></div> 
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-dark ">Add Reply</button>
                                <button type="button"  onclick="showToggle('#post-comment-${v.slug}-reply-form')" class="btn btn-outline-dark ">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <div class="replay-list" id="post-comment-${v.slug}-replys"></div>
                </div>
                `)
                loadcommentreplay(v.replyUrl,`#post-comment-${v.slug}-replys`)
            })
        }
        $(function(){
            loadcomment("{{url()->current()}}");
            $('#load-more-btn').click(function(){
                loadcomment($('#load-more-btn').data('url'))
            })    
            $('#report-post').on('shown.bs.modal',function(){
                $('#report-type').val("")
                $('#report-reason').val("")
            })
            $('#report-post-form').submit(function(e){
                e.preventDefault()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
                $.post("{{route('community.post.report',$post->slug)}}",$(this).serialize(),function(response){
                    $('#report-post').modal('hide')
                    showToast(response.success||"Report Submited",'success');  
                },'json').fail(function(xhr){
                    try {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors,function(k,v){
                            $('#report-'+k+'-error').text(v[0])
                            $('#report-'+k).addClass("is-invalid")
                        })
                    } catch (error) {

                    }
                })
            })
        })
    </script>
@endpush