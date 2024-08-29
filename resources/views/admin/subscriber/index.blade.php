@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Paid Subscribers</h2>
        </div> 
    </div>
</section> 
<section class="table-section">
    <div class="container">
        <div class="row">
            <x-ajax-table :action='false' :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Name","name"=>"name","data"=>"name"],
                ["th"=>"Email","name"=>"email","data"=>"email"], 
                ["th"=>"Plan","name"=>"plan","data"=>"plan"], 
                ["th"=>"Pay Id","name"=>"payid","data"=>"payid"], 
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
