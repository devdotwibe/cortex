@extends('layouts.admin')
@section('title', 'Edit Tip')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.tip.index') }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>
            <h2>Edit Tip</h2>
        </div>
    </div>
</section>

<section class="content_section admin_section">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tip.update', $tip->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tip">Tip</label>
                            <textarea name="tip" id="tip" class="form-control texteditor" rows="5">{{ old('tip', $tip->tip) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="advice">Advice</label>
                            <textarea name="advice" id="advice" class="form-control texteditor" rows="5">{{ old('advice', $tip->advice) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('admin.tip.index') }}" class="btn btn-secondary">Cancel</a>
                           
                            <button type="submit" class="btn btn-dark">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('footer-script')
<script>
    CKEDITOR.replace('tip');
    CKEDITOR.replace('advice');
</script>


@endpush
