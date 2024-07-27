@extends('layouts.user')
@section('title', 'Community')
@section('content')

<section class="poll-section">
    <div class="container">
        <h1>Polls</h1>
        @foreach($polls as $poll)
            <div class="poll">
                <h3>{{ $poll->question }}</h3>
                @if($poll->isVotable())
                    <form method="POST" action="{{ route('community.poll.vote') }}" class="poll-form">
                        @csrf
                        <input type="hidden" name="poll_id" value="{{ $poll->id }}">
                        @foreach($poll->options as $index => $option)
                            <div class="poll-choice">
                                <label for="choice-{{ $option->id }}">
                                    <input type="radio" id="choice-{{ $option->id }}" name="option_id" value="{{ $option->id }}">
                                    {{ $option->option }}
                                    <span class="poll-percent">{{ $option->votes }} votes</span>
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Vote</button>
                    </form>
                @else
                    <div class="poll-vote-disabled">
                        <p>This poll has ended. You cannot vote anymore.</p>
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>

@endpush
