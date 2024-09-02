@extends('layouts.admin')
@section('title', 'Tips n Advice')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Tips</h2>
        </div>

        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.tip.storetip', $tip->id)}}" class="nav_link btn">Add +</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container">
        <div class="row">
            <div class="table-outer table-categoryquestiontable-outer">
                <table class="table" id="table-categoryquestiontable" style="width: 100%">
                    <thead>
                        <tr>
                            <th data-th="Sl.No">Sl.No</th>
                            <th data-th="Tip">Tip</th>
                            <th data-th="Advice">Advice</th>
                            <th data-th="Action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tips as $key => $tip)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $tip->tip }}</td>
                                <td>{{ $tip->advice }}</td>
                                <td>
                                    <!-- Action buttons (e.g., edit, delete) -->
                                    <a href="{{ route('admin.tip.edit', $tip->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('admin.tip.delete', $tip->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No tips available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
