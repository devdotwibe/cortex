@extends('layouts.user')
@section('title', 'Create Post')
@section('content')
<style>
    #selection {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 20px;
        display: block;
        width: 200px;
    }
    .header_nav {
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #0056b3;
    }
</style>

<br><br>
<div class="form-group">
    <select id="selection" onchange="toggleForm()" class="header_wrapp">
        <option value="poll">Poll</option>
        <option value="post">Post</option>
    </select>
</div>

<section class="header_nav" id="poll-form" style="display: none;">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Create Poll</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2" id="poll-section" style="display: none;">
    <div class="container">
        <form method="POST" action="{{ route('community.poll.store') }}">
            @csrf

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="form-group">
                <label>Question</label>
                <input type="text" name="question" class="form-control" required>
            </div>
            <div id="options-container">
                <div class="form-group">
                    <label>Option 1</label>
                    <input type="text" name="options[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Option 2</label>
                    <input type="text" name="options[]" class="form-control" required>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addOption()">Add Option</button>
            <button type="submit" class="btn btn-primary">Create Poll</button>
        </form>
    </div>
</section>

<section class="header_nav" id="post-form" style="display: none;">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Create Post</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2" id="post-section" style="display: none;">
    <div class="container">
        <x-general-form :cancel="route('community.index')" :url="route('community.post.store')" btnsubmit="Publish" :fields='[
            ["name"=>"title","size"=>12],
            ["name"=>"description","size"=>12,"type"=>"editor"],
        ]' />
    </div>
</section>
@endsection

@push('footer-script')
<script>
    function toggleForm() {
        const selection = document.getElementById('selection').value;
        document.getElementById('poll-form').style.display = selection === 'poll' ? 'block' : 'none';
        document.getElementById('poll-section').style.display = selection === 'poll' ? 'block' : 'none';
        document.getElementById('post-form').style.display = selection === 'post' ? 'block' : 'none';
        document.getElementById('post-section').style.display = selection === 'post' ? 'block' : 'none';
    }

    function addOption() {
        const optionsContainer = document.getElementById('options-container');
        const optionCount = optionsContainer.children.length + 1;
        const newOption = document.createElement('div');
        newOption.classList.add('form-group');
        newOption.innerHTML = `
            <label>Option ${optionCount}</label>
            <input type="text" name="options[]" class="form-control" required>
        `;
        optionsContainer.appendChild(newOption);
    }

    window.onload = function() {
        toggleForm(); // Show the default form based on the initial selection
    };
</script>
@endpush
