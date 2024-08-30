@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Paid Subscribers</h2>
        </div> 
        <div class="header_content">
             <div class="form-group">
                <select  id="cat-list" onchange="changeyear()" class="select2 form-control" data-placeholder="Select an Year" data-allow-clear="true" >
                     @for ($i = 2024; $i < (date('Y')+2); $i++)
                         <option value="{{$i}}-{{$i+1}}">June {{$i}} - May {{$i+1}}</option>
                     @endfor
                </select>
             </div>
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
                ["th"=>"Amount","name"=>"amount","data"=>"amount"], 
                ["th"=>"Pay Id","name"=>"payid","data"=>"payid"], 
            ]' tableinit="usertableinit" beforeajax="usertableajaxbefoire"/>
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
        function changeyear(){ 
            if (usertable != null) {
                usertable.ajax.reload()
            } 
        }
        function usertableajaxbefoire(data) {
            data.year=$('#cat-list').val()
        }
    </script>
@endpush
