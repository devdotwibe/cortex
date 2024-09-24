@extends('layouts.admin')
@section('title', 'Tips n Advice')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Tips and Advice</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tip.store') }}" class="form" id="frmvk3a41725017844" method="post" onsubmit="return validateLines()">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tip">Tip</label>
                                    <textarea name="tip" id="tip" class="form-control texteditor" rows="5" oninput="limitLines(this, 3)">{{ old('tip') }}</textarea>
                                    @error('tip')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="advice">Advice</label>
                                    <textarea name="advice" id="advice" class="form-control texteditor" rows="5" oninput="limitLines(this, 3)">{{ old('advice') }}</textarea>
                                    @error('advice')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('admin.tip.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-dark">Save</button>
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

    function limitLines(textarea, maxLines) {
        const lines = textarea.value.split('\n');
        if (lines.length > maxLines) {
            textarea.value = lines.slice(0, maxLines).join('\n');
        }
    }

    function validateLines() {
        const tipTextarea = document.getElementById('tip');
        const adviceTextarea = document.getElementById('advice');
        
        const tipLines = tipTextarea.value.split('\n').length;
        const adviceLines = adviceTextarea.value.split('\n').length;

        if (tipLines > 3) {
            alert("Tip can only have up to 3 lines.");
            return false;
        }
        
        if (adviceLines > 3) {
            alert("Advice can only have up to 3 lines.");
            return false;
        }
        
        return true;
    }
</script>
@endpush
