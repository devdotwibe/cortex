@extends('layouts.admin')
@section('title', 'Exam')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Exam</h2>
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        <x-create-form name="admin.exam"   btnsubmit="Save" :fields='[
            ["name"=>"title","size"=>9],  
            ["name"=>"time_of_exam","label"=>"Time Of Exam ","placeholder"=>"Time Of Exam ( HH : MM )","size"=>3,"type"=>"maskinput","options"=>["placeholder"=>"HH : MM","mask"=>"^(0[0-9]|1[0-9]|2[0-4]) : [0-5][0-9]$"]],
        ]' />
        {{-- <x-create-form name="admin.exam" btnsubmit="Save" :fields='[
            ["name"=>"title","size"=>8], 
            ["name"=>"price","size"=>3],
            ["name"=>"discount","size"=>3],
            ["name"=>"duration","label"=>"Expire at","size"=>3],
            ["name"=>"time_of_exam","label"=>"Time Of Exam (Hrs)","size"=>3,"type"=>"select","options"=> array_map(function($k){ return (object)["value"=>$k,"text"=>"$k Hr"]; },range(1, 24))],
            ["name"=>"overview","size"=>4,"type"=>"textarea"],
            ["name"=>"requirements","size"=>4,"type"=>"textarea"], 
            ["name"=>"description","size"=>4,"type"=>"textarea"],
        ]' />  --}}
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush