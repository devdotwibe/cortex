@extends('layouts.admin')
@section('title', 'Polls')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>POLLS</h2>
        </div>
    </div>
</section>

<section class="table-section my-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Options</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $poll)
                            <tr>
                                <td>{{ $poll->created_at->format('Y-m-d') }}</td>
                                <td>{{ $poll->question }}</td>
                                <td>
                                    @foreach($poll->options as $option)
                                        <div>{{ $option->option }} ({{ $option->votes }} votes)</div>
                                    @endforeach
                                </td>
                                <td>
                                    
                                    <a href="{{ route('admin.community.poll.edit', $poll->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    
                                    <form action="{{ route('admin.community.poll.destroy', $poll->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



@endsection

@push('modals')
<!-- Include modals here if needed -->
@endpush

@push('footer-script')
<script>
    function votePoll(pollId) {
        // Handle the voting process here
        // You can use AJAX to submit the vote and update the poll options dynamically
    }
</script>
@endpush
