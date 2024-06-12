@extends('layouts.admin')
@section('title', 'Users Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Update User</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container"> 
        <x-edit-form name="admin.exam"  :id="$exam->slug" btnsubmit="Save" :fields='[
            ["name"=>"title","size"=>12,"value"=>$exam->title],  
        ]' />
        {{-- <x-edit-form name="admin.exam"  :id="$exam->slug" btnsubmit="Save" :fields='[
            ["name"=>"title","size"=>8], 
            ["name"=>"price","size"=>3],
            ["name"=>"discount","size"=>3],
            ["name"=>"duration","label"=>"Expire at","size"=>3],
            ["name"=>"time_of_exam","label"=>"Time Of Exam (Hrs)","size"=>3,"type"=>"select","options"=> array_map(function($k){ return (object)["value"=>$k,"text"=>"$k Hr"]; },range(1, 24))],
            ["name"=>"overview","size"=>4,"type"=>"textarea"],
            ["name"=>"requirements","size"=>4,"type"=>"textarea"], 
            ["name"=>"description","size"=>4,"type"=>"textarea"],
        ]' /> --}}
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush