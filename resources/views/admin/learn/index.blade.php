@extends('layouts.admin')
@section('title', 'Learn')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form name="admin.exam" btnsubmit="Add" :fields='[
            ["name"=>"Subject","label"=>"Subject" "placeholder"=>"Enter Subject Name" ,"size"=>3],
          
        ]' /> 
    </div>

</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush