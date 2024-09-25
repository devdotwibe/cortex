@extends('layouts.admin')
@section('title', 'Users Request')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Users Request</h2>
        </div> 
        <div class="header_content">
            <div class="form-group">
               <select  id="timeslot-list" class="select2 form-control" data-allow-clear="true" ></select>
            </div>
       </div>    
       <div class="header_content">
        <div class="form-group">

            <select id="term-list" class="select2 form-control" data-allow-clear="true">

                <option value="">Select Term</option> 
                @foreach($terms  as $term)
                    <option value="{{ $term }}">{{ $term }}</option>
                @endforeach


            </select>
        </div>
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
<section class="content_section admin_section">
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
            ]' tableinit="requesttableinit" :bulkaction="true" beforeajax="hideaction" :bulkactionlink="route('admin.live-class.request.bulkaction')"  />
        </div>
        <div class="multi-user-action" style="display:none">
            <button class="btn btn-outline-secondary" id="multi-user-action" >+ User Access</button>
        </div>
    </div>
</section> 
@endsection
@push('modals')
<div class="modal fade" id="multi-user-term-modal" tabindex="-1" role="dialog" aria-labelledby="multi-user-termLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="multi-user-termLablel">User Term</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form action="{{route('admin.user-access.multi-user.update')}}" method="post" id="multi-user-term-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" id="multi-user-term-table">
    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Close</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Save</button> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div  class="list-group" id="multi-user-list">
    
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
     
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
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Close</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Save</button> 
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>

<div class="modal fade" id="user-acceptreq-modal" tabindex="-1" role="dialog" aria-labelledby="user-acceptreqLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-acceptreqLablel">Confirm Student Time Slot</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form action="" method="post" id="user-acceptreq-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" id="user-acceptreq-table">
    
                        </div>
                    </div>
                    <div class="row">
                        <p>Are you sure you want to proceed with this action?</p>
                        <div class="col-md-12">
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Close</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Accept</button> 
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
<div class="modal fade" id="user-rejectreq-modal" tabindex="-1" role="dialog" aria-labelledby="user-rejectreqLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-rejectreqLablel">Reject Student Time Slot</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form action="" method="post" id="user-rejectreq-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" id="user-rejectreq-table">
    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Are you sure you want to proceed with this action?</p>
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Close</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Reject</button> 
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>

<div class="modal fade" id="user-updatetreq-modal" tabindex="-1" role="dialog" aria-labelledby="user-updatetreqLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-updatetreqLablel">Confirm Student Time Slot</h5>
                <button type="button" class="close" data-bs-dismiss="modal"  aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form action="" method="post" id="user-updatetreq-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" id="user-updatetreq-table">
    
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <button type="button"  class="btn btn-outline-dark m-1" data-bs-dismiss="modal"  aria-label="Close" >Close</button> 
                            <button type="submit"  class="btn btn-dark m-1" >Update</button> 
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
    var timeslotlist=[ 
            {
                text:"Saturday 9:30 - 11:30 a.m (Online)",
                id:"Saturday 9:30 - 11:30 a.m (Online)"
            },
            {
                text:"Saturday 12 - 2 p.m",
                id:"Saturday 12 - 2 p.m"
            },
            {
                text:"Sunday 9:30 - 11:30 a.m",
                id:"Sunday 9:30 - 11:30 a.m"
            },
            {
                text:"Sunday 12 - 2 p.m",
                id:"Sunday 12 - 2 p.m"
            },
    ]
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
    function rejectrequest(url){
        $.get(url,function(res){
            $('#user-rejectreq-form').attr('action',res.rejectUrl)
            // var str='';
            // $.each(timeslotlist,function(k,v){
            //     str=`
            //     <div class="form-check">
            //         <input type="checkbox" name="timeslot[]" class="form-check-input"  id="user-rejectreq-${k}" value="${v.id}" ${(res.timeslot||[]).includes()}  disabled >
            //         <label for="user-rejectreq-${k}">${v.text}</label>
            //     </div>
            //     `
            // })
            // $('#user-rejectreq-table').html(`
            //     <div class="form-group">
            //         <div class="form-data">
            //             <div class="forms-inputs mb-4"> 
            //                 <div class="check-group form-control">
            //                     ${str}
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            // `)
            $('#user-rejectreq-modal').modal('show')
        },'json')

    }

    function updaterequest(url){
        $.get(url,function(res){
            $('#user-updatetreq-form').attr('action',res.updateUrl)
            var str='';
            $.each(timeslotlist,function(k,v){
                str+=`
                <div class="form-check">
                    <input type="checkbox" name="timeslot[]" class="form-check-input"  id="user-updatetreq-${k}" value="${v.id}" ${(res.timeslot||[]).includes(v.id)?"checked":""} >
                    <label for="user-updatetreq-${k}">${v.text}</label>
                </div>
                `
            })
            $('#user-updatetreq-table').html(`
                <div class="form-group">
                    <div class="form-data">
                        <div class="forms-inputs mb-4"> 
                            <div class="check-group form-control" id="user-updatetreq-form-timeslot">
                                ${str}
                            </div>
                            <div id="user-updatetreq-form-timeslot-error" class="invalid-feedback"></div> 
                        </div>
                    </div>
                </div>
            `)
            $('#user-updatetreq-modal').modal('show')
        },'json')

    }
    
    function acceptrequest(url){
        $.get(url,function(res){
            $('#user-acceptreq-form').attr('action',res.acceptUrl)
            var str='';
            $.each(timeslotlist,function(k,v){
                str+=`
                <div class="form-check">
                    <input type="checkbox" name="timeslot[]" class="form-check-input"  id="user-acceptreq-${k}" value="${v.id}" ${(res.timeslot||[]).includes(v.id)?"checked":""} >
                    <label for="user-acceptreq-${k}">${v.text}</label>
                </div>
                `
            })
            $('#user-acceptreq-table').html(`
                <div class="form-group">
                    <div class="form-data">
                        <div class="forms-inputs mb-4"> 
                            <div class="check-group form-control" id="user-acceptreq-form-timeslot">
                                ${str}
                            </div>
                            <div id="user-acceptreq-form-timeslot-error" class="invalid-feedback"></div> 
                        </div>
                    </div>
                </div>
            `)
            $('#user-acceptreq-modal').modal('show')
        },'json')
    }
    function hideaction(d){
        $('.multi-user-action').hide();
        d.timeslot=$('#timeslot-list').val()
        return d;
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
                                <input class="form-check-input" name="term[]" value="${k}" type="checkbox"  role="switch"  ${v>0?"checked":""} />
                            </div>
                        </td>
                    </tr>
                `)
            })
        },'json')
    }
    function refreshaction(){
        if($('[name="select_all"]').is(":checked")){
                $('.multi-user-action').show()
        }else{
            if($('.selectbox:checked').length>1){
                $('.multi-user-action').show()
            }else{
                $('.multi-user-action').hide()
            }
        }
    }
    $(function(){
        $(document).on('change','.selectbox,[name="select_all"]',function(e){
            setTimeout(() => {
                refreshaction()
            }, 500);
        })
        $('#multi-user-action').click(function(){
            var selectedbox=[];
            $('.selectbox:checked').each(function(k,v){
                selectedbox.push(this.value)
            })
            $.post("{{route('admin.live-class.request.bulkupdate')}}",{
                select_all:$('[name="select_all"]').is(":checked")?"yes":"no",
                selectbox:selectedbox
            },function(res){
                $('#multi-user-term-table').html(`           
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Access</th>
                            </tr>
                        </thead>
                        <tbody id="multi-user-term-table-body">

                        </tbody>
                    </table>
                `)
                $('#multi-user-list').html('')
                $('#multi-user-term-modal').modal('show')
                $.each(res.termsList,function(k,v){   
                    $(`#multi-user-term-table-body`).append(`                
                        <tr>
                            <td>${k}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="term[]" value="${k}" type="checkbox"  role="switch"  />
                                </div>
                            </td>
                        </tr>
                    `)
                }) 
                $.each(res.userList,function(k,v){  
                    $('#multi-user-list').append(`
                        <div class="list-group-item">
                            <span>${v.name}</span>
                            <input type="hidden" name="user[]" value="${v.id}">
                        </div>
                    `)
                })

            })
        })
        $('#timeslot-list').val("").select2({
            placeholder:"Select an Timeslot",
            allowClear: true,
            data:timeslotlist,
        }).change(function(){
            if (requesttable != null) {
                requesttable.ajax.reload()
            }
        }).val("").change()
        $('#user-acceptreq-form').submit(function(e){
            e.preventDefault()
            $('.form-control').removeClass('is-invalid')
            $('.invalid-feedback').text('')
            $.post($(this).attr('action'),$(this).serialize(),function(res){
                if(res.success){
                    showToast(res.success||"Time slot Accepted",'success'); 
                }

                if (requesttable != null) {
                    requesttable.ajax.reload()
                }
                $('#user-acceptreq-modal').modal('hide')
            },'json').fail(function(xhr){
                try {
                    let res = JSON.parse(xhr.responseText); 
                    $.each(res.errors,function(k,v){
                        $(`#user-acceptreq-form-${k}`).addClass('is-invalid')
                        $(`#user-acceptreq-form-${k}-error`).text(v[0])
                    })
                } catch (error) {
                    
                }
            })
            return false;
        })

        $('#user-rejectreq-form').submit(function(e){
            e.preventDefault()
            $.post($(this).attr('action'),$(this).serialize(),function(res){
                if(res.success){
                    showToast(res.success||"Time slot Rejected",'success'); 
                    $('#user-rejectreq-modal').modal('hide')
                }
                if (requesttable != null) {
                    requesttable.ajax.reload()
                }
            },'json')
            return false;
        })

        $('#user-updatetreq-form').submit(function(e){
            e.preventDefault()
            $('.form-control').removeClass('is-invalid')
            $('.invalid-feedback').text('')
            $.post($(this).attr('action'),$(this).serialize(),function(res){
                if(res.success){
                    showToast(res.success||"Time slot Accepted",'success'); 
                }

                if (requesttable != null) {
                    requesttable.ajax.reload()
                }
                $('#user-updatetreq-modal').modal('hide')
            },'json').fail(function(xhr){
                try {
                    let res = JSON.parse(xhr.responseText);  
                    $.each(res.errors,function(k,v){ 
                        $(`#user-updatetreq-form-${k}`).addClass('is-invalid')
                        $(`#user-updatetreq-form-${k}-error`).text(v[0])
                    })
                } catch (error) { 
                    
                }
            })
            return false;
        })
    })
     
    </script>
    

   
@endpush