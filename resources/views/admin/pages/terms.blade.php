

@extends('layouts.admin')
@section('title', 'Terms')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Terms & Conditions</h2>
        </div>
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-general-form
            :url="route('admin.terms.store')"
            btnsubmit="Save"
            :fields='[
                [
                    "name" => "description",
                    "label" => "Description",
                    "placeholder" => "Description",
                    "size" => 12,
                    "type" => "editor",
                    "value" => old("description", optional($TermsAndConditions)->description)
                ]
            ]'
        />
    </div>
</section>
@endsection

@push('footer-script')
    <script>

    </script>
@endpush
