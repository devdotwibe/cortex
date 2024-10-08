

@extends('layouts.admin')
@section('title', 'Privacy')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Privacy Policy</h2>
        </div>
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-general-form
            :url="route('admin.privacy.store')"
            btnsubmit="Save"
            :fields='[
                [
                    "name" => "description",
                    "label" => "Description",
                    "placeholder" => "Description",
                    "size" => 12,
                    "type" => "editor",
                    "value" => old("description", optional($privacy)->description)
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
