@extends('layouts.admin')
@section('title', 'Category')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Community</h2>
        </div>

        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{ route('admin.community.create') }}" class="nav_link btn">Create Post</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="post-section">
    <div class="post-container" id="post-item-list"></div>
    <div class="post-container1" id="post-item-list1"></div>

    <div class="post-container">
        @foreach($polls as $poll)
            <div class="card mb-3" id="poll-{{ $poll->id }}">
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
                        <small class="text-muted">Created at: {{ $poll->created_at->diffForHumans() }}</small>
                    </p>
                    <div class="poll-actions">
                        <a href="{{ route('admin.community.poll.view', $poll->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.community.poll.edit', $poll->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="deletePoll({{ $poll->id }})">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="load-more">
        <button class="btn btn-sm btn-outline-dark" id="load-more-btn" style="display: none">Load more...</button>
    </div>
</section>

<section class="post-section" id="post-detail-section"></section>

@endsection

@push('footer-script')
<script>
    function loadPost(url, containerId) {
        $.get(url, function(res) {
            if (res.next) {
                $('#load-more-btn').show().data('url', res.next);
            } else {
                $('#load-more-btn').hide().data('url', null);
            }
            $.each(res.data, function(k, v) {
                $(`#${containerId}`).append(`
                    <div class="post-item">
                        <div class="post-header">
                            <div class="avatar">
                                <img src="{{ asset('assets/images/User-blk.png') }}" alt="img">
                            </div>
                            <div class="title">
                                <h3>${v.user.name || ""}</h3>
                                <span>${v.createdAt}</span>
                            </div>
                        </div>
                        <div class="post-content">
                            ${v.description}
                        </div>
                        <div class="post-actions">
                            <a class="post-action-btn comment-btn"><img src="{{ asset('assets/images/comment.svg') }}" alt="comment"> <span>1</span></a>
                        </div>
                    </div>
                `);
            });
        }, 'json');
    }

    $(function() {
        loadPost("{{ url()->current() }}", "post-item-list");
        $('#load-more-btn').click(function() {
            loadPost($('#load-more-btn').data('url'), "post-item-list");
        });
    });

    function vote(pollId, option) {
        fetch('{{ route("admin.community.poll.vote") }}', {
            method: 'PUT',
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

    function deletePoll(pollId) {
        if (!confirm('Are you sure you want to delete this poll?')) return;
        
        fetch(`{{ url('/admin/community/poll/delete/') }}/${pollId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById(`poll-${pollId}`).remove();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
