@extends('layouts.user')
@section('title', 'Home Work - '.$homeWork->term_name)
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Home Work - {{$homeWork->term_name}}</h2>
        </div>
    </div>
</section>


<section class="content_section">
    <div class="container">
        <div class="row">
            @foreach ($booklets as  $k=>$item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        @if ($user->progress("home-work-{$homeWork->id}-booklet-{$item->id}-complete-review", 'no') == 'yes')

                        @elseif($user->progress("home-work-{$homeWork->id}-booklet-{$item->id}-complete-date", '') == '')
                        <a  onclick="confimbooklet('{{route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$item->slug])}}','{{$item->title}}')">
                        @else
                        <a  onclick="loadbooklethistory('{{route('home-work.history',['home_work'=>$homeWork->slug,'home_work_book'=>$item->slug])}}','{{$item->title}}')">
                        @endif
                            <div class="category">
                                <div class="category-content"> 
                                    <h4>{{$item->title}}</h4> 
                                </div>
                                <div class="category-image">
                                    <img src="{{ asset('assets/images/file-text.svg') }}">
                                </div> 
                            </div>
                        </a>
                    </div>
                </div>
            </div>                
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('modals')
    <div class="modal fade" id="review-history-modal" tabindex="-1" role="dialog" aria-labelledby="Label"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="review-history-label"></span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-outer" id="attemt-list">
                                
                            </div>
                        </div>
                    </div>
                    <a type="button" href="" id="restart-btn" class="btn btn-dark">Re-Start Booklet</a>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('footer-script')
    <script>
        async function confimbooklet(url, title) {
            localStorage.removeItem("home-work-booklet")
            if (await showConfirm({
                    title: "Start the " + title
                })) { 
                window.location.href = url;
            }
        }


        function loadbooklethistory(url) {
            localStorage.removeItem("home-work-booklet")
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
        }
    </script>
@endpush