@extends('layouts.user')
@section('title', 'Community')
@section('content') 
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Community</h2>
            @if($user->post_status!=="active")
            <p class="text-danger">You have been banned by admin</p>
            @endif
        </div>

        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('community.index')}}" class="nav_link btn">All Post</a></li>
                @if($user->post_status=="active")
                <li class="nav_item"><a href="{{route('community.post.create')}}" class="nav_link btn">Create Post</a></li>
                @endif
            </ul>
        </div>
    </div>
</section>
<section class="post-section" >

    <div class="container">
        <div class="row"> 
            <div class="col-md-3">
                <h4>SPACES</h4>
 
               <div class="mb-3">
                <label for="backtoall" class="form-label"></label>
                <a href="{{ route('community.post.index') }}" id="backtoall" class="form-control text-decoration-none" >
                    #Backtoall
                </a>
            </div>
 


    <div class="d-flex flex-wrap"> 
        <ul class="list-group"  > 
            @foreach ($hashtags as $hashtag)
                <li class="list-group-item d-inline-block"  >
                    <a
                        href="{{ route('community.post.index', ['hashtag' => $hashtag]) }}">{{ $hashtag }}</a>
                </li>
            @endforeach
        </ul>
    </div>




</div>
     
</div>
</div> 


    <div class="post-container" id="post-item-list">
        
    </div> 
    <div class="post-action">
        <button id="load-more-btn" class="btn btn-outline-dark" style="display: none"> Load More </button>
    </div>
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
                let polloption=``;
                if(v.vote){

                    $.each(v.poll||[],function(pk,pv){ 
                        polloption+=`
                        <div class="form-check ${v.vote.option==pv.slug?"voted":"vote"}">
                            <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" onchange="likevote('${pv.voteUrl}','#post-item-${v.slug}')" >
                            <label class="form-check-label" for="poll-${v.slug}-option-${pv.slug}">
                                ${pv.option}
                                <span id="poll-${v.slug}-option-${pv.slug}-percentage">(${pv.percentage}%)</span>
                                <div class="poll-graph-bar-wrapper">
                                    <div class="poll-graph-bar" id="poll-${v.slug}-option-${pv.slug}-bar" style="width: ${pv.percentage}%;"></div>
                                </div>
                            </label>
                        </div>
                        `;
                    })
                }else{

                    $.each(v.poll||[],function(pk,pv){
                        polloption+=`
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" onchange="likevote('${pv.voteUrl}','#post-item-${v.slug}')">
                            <label class="form-check-label" for="poll-${v.slug}-option-${pv.slug}">
                                ${pv.option}
                                <span id="poll-${v.slug}-option-${pv.slug}-percentage">(${pv.percentage}%)</span>
                                <div class="poll-graph-bar-wrapper">
                                    <div class="poll-graph-bar" id="poll-${v.slug}-option-${pv.slug}-bar" style="width: ${pv.percentage}%;"></div>
                                </div>
                            </label>
                        </div>
                        `;
                    })
                }
                
                let imagehtml='';
                if(v.image){
                    imagehtml=`
                        <img src="${v.image}" alt="">
                    `;
                }
                let hashtag = '';
                console.log(v.hashtags);

                $('#post-item-list').append(`
                    <div class="post-item" id="post-item-${v.slug}">  
                        <div class="post-header">
                            <div class="avathar">
                                <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                            </div>
                           <div class="title">
                      <h3>${capitalizeFirstLetter(v.user.name) || ""}</h3>
                    <span>${v.createdAt}</span>
                            </div>
                            <div class="action">
                                <a class="btn btn-outline-dark" href="${v.showUrl}">View</a>
                                <a class="btn btn-dark" href="${v.editUrl}">edit</a>
                            </div>
                        </div>
                        <div class="post-title">
                            ${v.title||""}
                        </div>
                        <div class="post-content">
                            ${v.description||""}
                        </div>
                         <div class="post-content">
                            ${v.hashtags||""}
                        </div>
                        <div class="poll-options">
                            ${polloption}
                        </div>
                        <div class="post-image">
                            ${imagehtml}
                        </div>
                        <div class="post-actions">
                            <a class="post-action-btn like-btn btn" onclick="likevote('${v.likeUrl}','#post-item-${v.slug}')"><img src="${v.liked?"{{asset('assets/images/liked.svg')}}":"{{asset('assets/images/like.svg')}}"}" slt="comment"> <span>${v.likes}</span></a>
                            <a class="post-action-btn comment-btn btn" href="${v.showUrl}"><img src="{{asset('assets/images/comment1.svg')}}" slt="comment"> <span>${v.comments}</span></a>
                        </div>
                    </div>
                `)
            })
        },'json');
    }
    $(function(){
        loadpost("{!! route('community.ajaxindex',['ref'=>'ajax','hashtag'=>request('hashtag')]) !!}");
        // loadpost("{{url()->full()}}");
        $('#load-more-btn').click(function(){
            loadpost($('#load-more-btn').data('url'))
        })
    })
    function likevote(url,id) {
        $.get(url,function(v){
            let polloption=``;
            if(v.vote){

                $.each(v.poll||[],function(pk,pv){ 
                    polloption+=`
                    <div class="form-check ${v.vote.option==pv.slug?"voted":"vote"}">
                        <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" onchange="likevote('${pv.voteUrl}','#post-item-${v.slug}')" >
                        <label class="form-check-label" for="poll-${v.slug}-option-${pv.slug}">
                            ${pv.option}
                            <span id="poll-${v.slug}-option-${pv.slug}-percentage">(${pv.percentage}%)</span>
                            <div class="poll-graph-bar-wrapper">
                                <div class="poll-graph-bar" id="poll-${v.slug}-option-${pv.slug}-bar" style="width: ${pv.percentage}%;"></div>
                            </div>
                        </label>
                    </div>
                    `;
                })
            }else{

                $.each(v.poll||[],function(pk,pv){
                    polloption+=`
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" onchange="likevote('${pv.voteUrl}','#post-item-${v.slug}')">
                        <label class="form-check-label" for="poll-${v.slug}-option-${pv.slug}">
                            ${pv.option}
                            <span id="poll-${v.slug}-option-${pv.slug}-percentage">(${pv.percentage}%)</span>
                            <div class="poll-graph-bar-wrapper">
                                <div class="poll-graph-bar" id="poll-${v.slug}-option-${pv.slug}-bar" style="width: ${pv.percentage}%;"></div>
                            </div>
                        </label>
                    </div>
                    `;
                })
            }

            let imagehtml='';
            if(v.image){
                imagehtml=`
                    <img src="${v.image}" alt="">
                `;
                let hashtag = '';
                console.log(v.hashtags);
            }
            $(id).html(`
            <div class="post-header">
                <div class="avathar">
                    <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                </div>
                <div class="title">
                    <h3>${v.user.name||""}</h3>
                    <span>${v.createdAt}</span>
                </div>
                <div class="action">
                    <a class="btn btn-outline-dark" href="${v.showUrl}">View</a>
                    <a class="btn btn-dark" href="${v.editUrl}">edit</a>
                </div>
            </div>
            <div class="post-title">
                ${v.title||""}
            </div>
            <div class="post-content">
                ${v.description||""}
            </div>
             <div class="post-content">
                ${v.hashtags||""}
            </div>
            <div class="poll-options">
                ${polloption}
            </div>
            <div class="post-image">
                ${imagehtml}
            </div>
            <div class="post-actions">
                <a class="post-action-btn like-btn btn" onclick="likevote('${v.likeUrl}','#post-item-${v.slug}')"><img src="${v.liked?"{{asset('assets/images/liked.svg')}}":"{{asset('assets/images/like.svg')}}"}" slt="comment"> <span>${v.likes}</span></a>
                <a class="post-action-btn comment-btn btn" href="${v.showUrl}"><img src="{{asset('assets/images/comment1.svg')}}" slt="comment"> <span>${v.comments}</span></a>
            </div>
            `)
        })
    }

    function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

</script>
     
@endpush