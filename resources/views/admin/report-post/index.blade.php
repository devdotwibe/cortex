@extends('layouts.admin')
@section('title', 'Reported Post')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Reported Post</h2>
        </div>  
    </div>
</section> 
<section class="content_section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Post","name"=>"post_id","data"=>"post"],
                ["th"=>"Reason","name"=>"type","data"=>"type"],
                ["th"=>"Status","name"=>"status","data"=>"statushtml"],
            ]' tableinit="requesttableinit"  />
        </div>
    </div>
</section> 
@endsection
@push('modals')
     
@endpush
@push('footer-script')
    <script> 

    var requesttable = null;
    function requesttableinit(table) {
        requesttable = table
    }
    // function changeactivestatus(url){
    //     $.get(url,function(res){
    //         if (requesttable != null) {
    //             requesttable.ajax.reload()
    //         }
    //     })
    // }
    </script>
@endpush