@extends('layouts.admin')
@section('title', 'Learn Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn Detail</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
       
        <x-general-form :url="route('admin.lessson_create',$learn->slug)" :id="$learn->slug" btnsubmit="Save" :fields='[
            ["name"=>"lessons", "label"=>"Lessons" ,"size"=>6], 
           
        ]' /> 
            
    </div>

</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush