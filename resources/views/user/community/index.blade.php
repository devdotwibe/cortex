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

    <section class="post-section">
    <div class="post-container">
        @foreach($data as $poll)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $poll->question }}</h5>
                    <div class="poll-options">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="poll-{{ $poll->id }}" id="poll-{{ $poll->id }}-option1" value="option1" onclick="vote({{ $poll->id }}, 'option1')">
                            <label class="form-check-label" for="poll-{{ $poll->id }}-option1">
                                {{ $poll->option1 }} <span id="poll-{{ $poll->id }}-option1-percentage">({{ $poll->option1_votes }} votes)</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="poll-{{ $poll->id }}" id="poll-{{ $poll->id }}-option2" value="option2" onclick="vote({{ $poll->id }}, 'option2')">
                            <label class="form-check-label" for="poll-{{ $poll->id }}-option2">
                                {{ $poll->option2 }} <span id="poll-{{ $poll->id }}-option2-percentage">({{ $poll->option2_votes }} votes)</span>
                            </label>
                        </div>
                    </div>
                    <p class="card-text">
                        <small class="text-muted">Created at: {{ $poll->created_at->diffForHumans() }}</small><br>
                        <small class="text-muted">By: {{ optional($poll->user)->name }}</small>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>

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
    

<script>
    function vote(pollId, option) {
        fetch('{{ route("community.poll.vote") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ poll_id: pollId, option: option })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById(`poll-${pollId}-option1-percentage`).innerText = `(${data.option1_percentage.toFixed(2)}%)`;
                document.getElementById(`poll-${pollId}-option2-percentage`).innerText = `(${data.option2_percentage.toFixed(2)}%)`;
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

<script>
function vote(pollId, option) {
    fetch('{{ route("community.poll.vote") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ poll_id: pollId, option: option })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.error) {
            document.getElementById(`poll-${pollId}-option1-percentage`).innerText = `(${data.option1_percentage.toFixed(2)}%)`;
            document.getElementById(`poll-${pollId}-option2-percentage`).innerText = `(${data.option2_percentage.toFixed(2)}%)`;
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush