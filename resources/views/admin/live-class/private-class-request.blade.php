@extends('layouts.admin')
@section('title', 'Users Request')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Users Request</h2>
        </div> 
        <div class="header_right">
            <ul class="nav_bar"> 
                <li class="nav_item"  >
                    <button  class="btn btn-dark m-1"  onclick="exportrequestdata('Export Csv')">Export Csv</button> 
                </li>  
                <li class="nav_item"  >
                    <button  class="btn btn-dark m-1"  onclick="exportrequestdata('Export Excel')">Export Excel</button> 
                </li> 
            </ul>
        </div>
    </div>
</section> 
<section class="content_section">
    <div class="container">
        <div class="row">
            <x-ajax-table :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Email","name"=>"email","data"=>"email"],
                ["th"=>"Full Name","name"=>"full_name","data"=>"full_name"],
                ["th"=>"Parent Name","name"=>"parent_name","data"=>"parent_name"],
                ["th"=>"Phone","name"=>"phone","data"=>"phone"],
                ["th"=>"Timeslot","name"=>"timeslot","data"=>"timeslottext"],
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
    function changeactivestatus(url){
        $.get(url,function(res){
            if (requesttable != null) {
                requesttable.ajax.reload()
            }
        })
    }

    function s2ab(s) { 
        var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
        var view = new Uint8Array(buf);  //create uint8array as viewer
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
        return buf;    
    }
    async function exportrequestdata(exportType="Export Csv"){
        const responce =await fetch("{{route('admin.live-class.private_class_request_export')}}",{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json', 
                'X-Requested-With': 'XMLHttpRequest'
            },
        }) 
        const data = await responce.json();
        var wb = XLSX.utils.book_new();
        wb.Props = {
            Title: "private-class-form-request",
            Subject: "Users Request",
            Author: "{{config('app.name')}}",
            CreatedDate: new Date()
        };
        wb.SheetNames.push("Users Request");
        ws = XLSX.utils.json_to_sheet(data);
        wb.Sheets["Users Request"] = ws;
        if(exportType=="Export Excel")
        {
            var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
            var file = new File([s2ab(wbout)], "private-class-form-request.xlsx", {type: "application/octet-stream"});
        }else{
            var wbout = XLSX.write(wb, {bookType:'csv',  type: 'binary'});
            var file = new File([s2ab(wbout)], "private-class-form-request.csv", {type: "application/vnd.ms-excel"});
        }
        const link = document.createElement('a')
        const url = URL.createObjectURL(file)
        link.href = url
        link.download = file.name
        document.body.appendChild(link)
        link.click()

        document.body.removeChild(link)
        window.URL.revokeObjectURL(url)
    }
     
    </script>
@endpush