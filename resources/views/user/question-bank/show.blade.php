@extends('layouts.user')
@section('title', $exam->subtitle($category->id,"Topic ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="container set-container">
    <div class="container-wrap">
        <div class="lesson">                  
            <a class="lesson-exit float-start" href="{{route('question-bank.index')}}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip">
                <img src="{{asset("assets/images/exiticon.svg")}}" alt="exiticon">
            </a> 
            <div class="lesson-title">
                <h5><span>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h5>
            </div> 
            <div class="lesson-option">
                <div class="option-toggle">
                    <div class="option-item">
                        <label for="option-timed" class="option-item-label">TIMED</label>
                        <input type="radio" name="timed" id="option-timed" value="timed" checked onchange="changemode(this.value)" >
                    </div>
                    <div class="option-item">
                        <label for="option-untimed" class="option-item-label">UNTIMED</label>
                        <input type="radio" name="timed" id="option-untimed" value="untimed" onchange="changemode(this.value)">
                    </div>
                </div>
            </div>
            <div class="lesson-body">
                <div class="row" id="lesson-list">
                    @forelse ($lessons as $k=> $item)
                    <div class="col-md-6">                        
                        <div class="lesson-row">
                            <div class="lesson-row-title"> 
                                <h2>{{ $item->name }}</h2>
                            </div>
                            <div class="lesson-row-sets"> 
                                @foreach ($item->setname()->has('questions')->get() as $sk=> $set)
                                    <div class="sets-item">
                                        @if ($user->is_free_access||(optional($user->subscription())->status??"")=="subscribed"||($k == 0&&$sk==0)) 
                                        <a @if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$item->id.'-set-'.$set->id.'-complete-review',"no")=="yes") @elseif($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$item->id.'-set-'.$set->id.'-complete-date',"")=="")  @guest('admin') onclick="confimexam('{{route('question-bank.set.show',['category'=>$category->slug,'sub_category'=>$item->slug,'setname'=>$set->slug])}}')" @endguest @else onclick="loadlessonsetreviews('{{route('question-bank.set.history',['category'=>$category->slug,'sub_category'=>$item->slug,'setname'=>$set->slug])}}')" @endif >
                                        @else
                                        <a href="{{route('pricing.index')}}">
                                        @endif
                                            <span class="sets-title">{{$set->name}}</span>
                                        </a>
                                    </div>                                    
                                @endforeach
                            </div> 
                        </div> 
                    </div>                     
                    @empty
                    <div class="col-md-12">
                        <div class="empty-row">
                            <span class="text-muted">Empty item</span>
                        </div>
                    </div>
                    @endforelse
                </div>  
            </div> 
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
                @guest('admin')  <a type="button" href="" id="restart-btn"  class="btn btn-dark">Re-Start Set</a> @endguest
            </div>
        </div>
    </div>
</div>
@endpush
@push('footer-script') 
    <script> 
    localStorage.setItem("question-bank", "timed");
    function changemode(v){
        localStorage.setItem("question-bank", v);
    }
    async function confimexam(url){
        if(await showConfirm({ title:"Start the question set" })){
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
                        <th>Timed</th>
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
                        data: 'timed',
                        name: 'timed',
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