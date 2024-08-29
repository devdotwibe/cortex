@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Subscribers</h2>
        </div> 
    </div>
</section> 
<section class="table-section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"], 
                ["th"=>"Pay ID","name"=>"slug","data"=>"slug"], 
                ["th"=>"Name","name"=>"subscriber","data"=>"subscriber"],
                ["th"=>"Amount","name"=>"amount","data"=>"amount"],
                ["th"=>"Status","name"=>"status","data"=>"status"],
                ["th"=>"Content","name"=>"content","data"=>"content"],

            ]' tableinit="usertableinit" />
        </div>
    </div>
</section>
@endsection


@push('footer-script')
    <script>
        var usertable = null;
        function usertableinit(table) {
            usertable = table
        }
        function changeactivestatus(url){
            $.get(url,function(res){
                if (usertable != null) {
                    usertable.ajax.reload()
                }
            })
        }
    </script>
@endpush
