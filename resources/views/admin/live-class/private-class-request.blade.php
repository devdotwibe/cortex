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
                ["th"=>"Term","name"=>"status","data"=>"termhtml"],
                ["th"=>"Status","name"=>"status","data"=>"statushtml"],
            ]' tableinit="requesttableinit"  />
        </div>
    </div>
</section> 
@endsection
@push('modals')
     
<div class="modal fade" id="user-term-modal" tabindex="-1" role="dialog" aria-labelledby="user-termLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-termLablel">User Term</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form action="" method="post" id="user-term-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" id="user-term-table">
    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Save</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Save</button> 
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
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
    function usertermlist(url){
        $.get(url,function(res){
            $('#user-termLablel').text(res.name)
            $('#user-term-form').attr('action',res.updateUrl)
            $('#user-term-table').html(`           
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Term</th>
                            <th>Access</th>
                        </tr>
                    </thead>
                    <tbody id="user-term-table-body">

                    </tbody>
                </table>
            `)
            $('#user-term-modal').modal('show')
            $.each(res.termsList,function(k,v){   
                $(`#user-term-table-body`).append(`                
                    <tr>
                        <td>${k}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  role="switch"  ${v>0?"checked":""} />
                            </div>
                        </td>
                    </tr>
                `)
            })
        },'json')
    }
     
    </script>
@endpush