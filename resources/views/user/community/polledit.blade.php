@extends('layouts.user')
@section('title', 'Edit Post')
@section('content')



<form method="POST" action="{{ route('community.poll.update', $poll->id) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <div class="form-group">
        <label>Question</label>
        <input type="text" name="question" class="form-control" value="{{ $poll->question }}" required>
    </div>

    @foreach($poll->options as $index => $option)
        <div class="form-group">
            <label>Option {{ $index + 1 }}</label>
            <input type="text" name="options[]" class="form-control" value="{{ $option->option }}" required>
            <input type="hidden" name="option_ids[]" value="{{ $option->id }}">
        </div>
    @endforeach

    <div id="new-options-container"></div>
    <button type="button" class="btn btn-secondary" onclick="addOption()">Add Option</button>
    <button type="submit" class="btn btn-primary">Update Poll</button>
</form>


<script>
    function addOption() {
    const container = document.getElementById('new-options-container');
    const optionIndex = container.children.length + {{ $poll->options->count() }};
    const newOption = document.createElement('div');
    newOption.className = 'form-group';
    newOption.innerHTML = `
        <label>Option ${optionIndex + 1}</label>
        <input type="text" name="options[]" class="form-control" required>
    `;
    container.appendChild(newOption);
}

</script>

@endsection

@push('footer-script')
    
@endpush