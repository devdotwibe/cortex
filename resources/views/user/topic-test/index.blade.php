@extends('layouts.user')
@section('title', 'Topic Test')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Topic Test</h2>
        </div> 
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k=> $item)
            <div class="col-md-6">
 
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{$item->id}}"> {{$exam->subtitle($item->id,"Topic ".($item->getIdx()+1))}} </span></h5>
                                    <h3>{{$item->name}}</h3> 
                                </div>
                            </div>
                            <div class="action-button">
                                @if ($user->progress('cortext-subscription-payment','')=="paid"||$k == 0) 
                                    @if($user->progress('exam-'.$exam->id.'-topic-'.$item->id.'-complete-review',"no")=="yes") 
                                    
                                    @elseif($user->progress('exam-'.$exam->id.'-topic-'.$item->id.'-complete-date',"")=="") 
                                    @guest('admin')    <a   class="btn btn-warning" onclick="confimexam('{{route('topic-test.show',$item->slug)}}')">ATTEMPT</a> @endguest
                                    @else 
                                        <a   class="btn btn-primary" onclick="loadlessonsetreviews('{{route('topic-test.topic.history',$item->slug)}}')">REVIEW</a>
                                    @endif
                                @else
                                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cortext-subscription-payment-modal">ATTEMPT</a>
                                @endif 
                            </div>
                        </div>
                    </div>    
            </div>
            @endforeach  
        </div>
    </div>
</section> 
@endsection

@push('modals')
 
<div class="modal fade" id="review-history-modal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span  id="review-history-label" ></span></h5>
                <button type="button" class="close" data-bs-dismiss="modal"    aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-outer" id="attemt-list">
                             
                        </div> 
                    </div>
                </div>
                @guest('admin') <a type="button" href="" id="restart-btn"  class="btn btn-dark">Re-Start Topic</a> @endguest
            </div>
        </div>
    </div>
</div>
@endpush

@push('footer-script') 
    <script>  
    async function confimexam(url){
        if(await showConfirm({ title:"Start the Topic" })){
            window.location.href=url;
        }
    }

    function loadlessonsetreviews(url){
        $('#attemt-list').html(`
            <table id="attemt-list-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Date</th>
                        <th>Progress</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        `)
        $('#review-history-modal').modal('show')
        $('#attemt-list-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            bFilter: false,                
            ajax: {
                url:url
            },
            order: [
                [0, 'DESC']
            ],
            initComplete: function() {
                var info = this.api().page.info(); 
                var json = this.api().ajax.json();
                $('#restart-btn').attr('href', json.url);
                $('#review-history-label').html(` ${json.name} `)
                if (info.pages > 1) {
                    $("#attemt-list-table_wrapper .pagination").show();
                } else {
                    $("#attemt-list-table_wrapper .pagination").hide();
                }
                if (info.recordsTotal > 0) {
                    $("#attemt-list-table_wrapper #attemt-list-table_info").show();
                } else {
                    $("#attemt-list-table_wrapper #attemt-list-table_info").hide();
                } 
            },
            drawCallback: function() {
                var info = this.api().page.info();
                var json = this.api().ajax.json();
                $('#restart-btn').attr('href', json.url);
                $('#review-history-label').html(` ${json.name} `)
                if (info.pages > 1) {
                    $("#attemt-list-table_wrapper .pagination").show();
                } else {
                    $("#attemt-list-table_wrapper .pagination").hide();
                }
                if (info.recordsTotal > 0) {
                    $("#attemt-list-table_wrapper #attemt-list-table_info").show();
                } else {
                    $("#attemt-list-table_wrapper #attemt-list-table_info").hide();
                } 
            },
            columns: [ 

                {
                    data: 'DT_RowIndex',
                    name: 'id',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'date',
                    name: 'created_at',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'progress',
                    name: 'progress',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'action', 
                    orderable: false,
                    searchable: false, 
                },
            ],
        })
        // $.get(url,function(res){
        //     $.each(res.data,function(k,v){ 
        //         $('#attemt-list').append(`
        //             <tr>
        //                 <td>${v.date}</td>
        //                 <td>${v.progress}%</td>
        //                 <td><a type="button" href="${v.url}" class="btn btn-warning btn-sm">Review</a> </td>
        //             </tr>
        //         `)
        //     })
        //     $('#restart-btn').attr('href',res.url);
        //     $('#review-history-label').html(` ${res.name} `)
        //     $('#review-history-modal').modal('show')
        // },'json')
    }
    </script>
@endpush