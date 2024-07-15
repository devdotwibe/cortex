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
            ]' />
        </div>
    </div>
</section> 
@endsection
@push('modals')
     
@endpush
@push('footer-script')
    <script> 
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
            Title: $('title').text(),
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
            var file = new File([s2ab(wbout)], $('title').text()+".xlsx", {type: "application/octet-stream"});
        }else{
            var wbout = XLSX.write(wb, {bookType:'csv',  type: 'binary'});
            var file = new File([s2ab(wbout)], $('title').text()+".csv", {type: "application/vnd.ms-excel"});
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