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
{{--  
    <div class="post-container">
        @foreach($data as $poll) 
            <div class="card mb-3" id="poll-{{ $poll->id }}">
                <div class="card-body"> 
                    <h5 class="card-title">{{ $poll->question }}</h5>
                    <div class="poll-options">
                        @foreach ($poll->options as $index => $option)
                        <input type="hidden" name="option_ids[]" value="{{ $option->id }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="poll-{{ $poll->id }}" id="poll-{{ $poll->id }}-option{{ $index + 1 }}" value="{{ $option->id }}" onclick="vote({{ $poll->id }}, '{{ $option->id }}')">
                                <label class="form-check-label" for="poll-{{ $poll->id }}-option{{ $index + 1 }}">
                                    {{ $option->option }} 
                                    <span id="poll-{{ $poll->id }}-option{{ $index + 1 }}-percentage">({{ number_format($option->percentage, 2) }}%)</span>
                                    <div class="poll-graph-bar-wrapper">
                                        <div class="poll-graph-bar" id="poll-{{ $poll->id }}-option{{ $index + 1 }}-bar" style="width: {{ $option->percentage }}%;"></div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="card-text">
                        <small class="text-muted">Created at: {{ $poll->created_at->diffForHumans() }}</small><br>
                        <small class="text-muted">By: {{ optional($poll->user)->name }}</small>
                    </p>
                    
                    
                     
                        <a href="{{ route('community.poll.edit', $poll->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('community.poll.destroy', $poll->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    
                </div>
            </div>
        @endforeach
    </div> --}}
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
                        <div class="form-check ${v.vote.slug==pv.slug?"voted":"vote"}">
                            <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" onclick="vote('${v.voteUrl}')" disabled>
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
                            <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" onclick="vote('${v.voteUrl}')">
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

                $('#post-item-list').append(`
                    <div class="post-item" id="post-item-${v.slug}">  
                        <div class="post-header">
                            <div class="avathar">
                                <img src="{{asset("assets/images/User-blk.png")}}" alt="img">
                            </div>
                            <div class="title">
                                <h3>${v.user.name||""}</h3>
                                <span>${v.createdAt}</span>
                            </div>
                        </div>
                        <div class="post-title">
                            ${v.title||""}
                        </div>
                        <div class="post-content">
                            ${v.description||""}
                        </div>
                        <div class="poll-options">
                            ${polloption}
                        </div>
                        <div class="post-actions">
                            <a class="post-action-btn comment-btn" href="${v.showUrl}""><img src="{{asset('assets/images/comment.svg')}}" slt="comment"> <span>1</span></a>
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
    function vote(url) {
        $.get(url,function(){
            
        })
    }
</script>
    

{{-- <script>
   function vote(pollId, optionId) {
    fetch('{{ route("community.poll.vote") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ poll_id: pollId, option_id: optionId })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.error) {
            data.options.forEach((opt, index) => {
                document.getElementById(`poll-${pollId}-option${index + 1}-percentage`).innerText = `(${opt.percentage.toFixed(2)}%)`;
                document.getElementById(`poll-${pollId}-option${index + 1}-bar`).style.width = `${opt.percentage}%`;
            });

            // Disable voting options
            document.querySelectorAll(`input[name="poll-${pollId}"]`).forEach(input => {
                input.disabled = true;
            });

            // Disable poll section
            document.getElementById(`poll-${pollId}`).classList.add('poll-disabled');
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

</script> --}}


@endpush