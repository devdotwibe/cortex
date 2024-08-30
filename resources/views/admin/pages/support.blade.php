@extends('layouts.admin')
@section('title', 'Support')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Support</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <!-- Create a form for saving support data -->
        <form action="{{ route('admin.support.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Description (CKEditor) -->
            <div class="form-group">
                <label for="texteditor">Description</label>
                <textarea name="description" id="texteditor" rows="10" cols="80">
                    {{ old('description', optional($support)->description) }}
                </textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Save Button -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('footer-script')
    <!-- Include CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>

    <script>
        // Initialize CKEditor
        CKEDITOR.replace('texteditor');
    </script>
@endpush
