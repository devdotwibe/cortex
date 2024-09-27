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
                <select  id="cat-list" onchange="changeplan()" class="select2 form-control" data-placeholder="Select an Plan" data-allow-clear="true" >
                     @foreach ($plans as $item)
                     <option value="{{$item->slug}}">{{ucfirst($item->title)}}</option>                         
                     @endforeach 
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
                ["th"=>"Name","name"=>"username","data"=>"username"],
                ["th"=>"Email","name"=>"usermail","data"=>"usermail"], 
                ["th"=>"Plan","name"=>"plan","data"=>"plan"], 
                ["th"=>"Amount","name"=>"amount","data"=>"amount"], 
                ["th"=>"Expire","name"=>"expire_at","data"=>"expire"], 
                ["th"=>"Pay Id","name"=>"payment_id","data"=>"payment_id"], 
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
        function changeplan(){ 
            if (usertable != null) {
                usertable.ajax.reload()
            } 
        }
        function usertableajaxbefoire(data) {
            data.plan=$('#cat-list').val()
        }
    </script>
@endpush
