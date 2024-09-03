@extends('layouts.admin')
@section('title', 'Tips n Advice')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: none">
                <a onclick="pagetoggle()"><img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt=""></a>
            </div>
            <h2>Tips and Advice</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tip.store', $tip->id) }}" class="form" id="frmvk3a41725017844" method="post">
                        @csrf

                        <div class="row">
                            <input type="hidden" name="exam_id" id="exam_id" value="2">
                            <input type="hidden" name="exam_type" id="exam_type" value="question-bank">
                            <input type="hidden" name="category_id" id="category_id" value="3">
                            <input type="hidden" name="sub_category_id" id="sub_category_id" value="2">
                            <input type="hidden" name="sub_category_set" id="sub_category_set" value="2">
                            <input type="hidden" name="redirect" id="redirect-frmvk3a41725017844" value="http://localhost:8000/admin/question-bank/5a88aba7547d089097697baa9badf614">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4">
                                            <label for="tip">Tip</label>
                                            <textarea name="tip" id="tip" class="form-control texteditor" rows="5">{{ old('tip', $tip->tip) }}</textarea>
                                            @error('tip')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4">
                                            <label for="advice">Advice</label>
                                            <textarea name="advice" id="advice" class="form-control texteditor" rows="5">{{ old('advice', $tip->advice) }}</textarea>
                                            @error('advice')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mb-3">
                            <a href="{{ route('admin.tip.create', $tip->id) }}"  class="btn btn-secondary">Cancel</a>
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
    CKEDITOR.replaceAll('texteditor');
</script>
@endpush
