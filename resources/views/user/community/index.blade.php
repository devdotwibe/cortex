@extends('layouts.user')
@section('title', 'Community')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Community</h2>
        </div>

        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('community.post.create')}}" class="nav_link btn">Create Post</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="post-section" >
    <div class="post-container" id="post-item-list">
        
    </div>
    <div class="load-more" >
        <button class="btn btn-sm btn-outline-dark" id="load-more-btn" style="display: none" >Load more...</button>
    </div>
</section>
<section class="post-section"  id="post-detail-section">
</section>

@endsection


@push('footer-script')

<script>
    function loadpost(url){
        $.get(url,function(res){
            if(res.next){
                $('#load-more-btn').show().data('url',res.next)
            }else{
                $('#load-more-btn').hide().data('url',null);
            }
            $.each(res.data,function(k,v){
                $('#post-item-list').append(`
                    <div class="post-item">  
                        <div class="post-header">
                            <div class="avathar">
                                <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                            </div>
                            <div class="title">
                                <h3>${v.user.name||""}</h3>
                                <span>${v.createdAt}</span>
                            </div>
                        </div>
                        <div class="post-content">
                            ${v.description}
                        </div>
                        <div class="post-actions">
                            <a class="post-action-btn comment-btn"><img src="{{asset('assets/images/comment.svg')}}" slt="comment"> <span>1</span></a>
                        </div>
                    </div>
                `)
            })
        },'json');
    }
    $(function(){
        loadpost("{{url()->current()}}");
        $('#load-more-btn').click(function(){
            loadpost($('#load-more-btn').data('url'))
        })
    })
</script>
    
@endpush