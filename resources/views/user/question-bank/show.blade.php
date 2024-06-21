@extends('layouts.user')
@section('title', $exam->subtitle($category->id,"Topic ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="container">
    <div class="container-wrap">
        <div class="lesson">
            <div class="lesson-title">
                <h3><span>{{$exam->subtitle($category->id,"Topic ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
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
                                <span>{{ $item->name }}</span>
                            </div>
                            <div class="lesson-row-sets"> 
                                @foreach ($item->setname as $set)
                                    <div class="sets-item">
                                        <a @if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$item->id.'-set-'.$set->id.'-complete-review',"no")=="yes") @elseif($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$item->id.'-set-'.$set->id.'-complete-date',"")=="") href="{{route('question-bank.set.show',["category"=>$category->slug,"sub_category"=>$item->slug,'setname'=>$set->slug])}}" @else onclick="loadlessonsetreviews('{{route("question-bank.set.history",["category"=>$category->slug,"sub_category"=>$item->slug,'setname'=>$set->slug])}}')" @endif ><span class="sets-title">{{$set->name}}</span></a>
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
                <h5 class="modal-title">Lesson <span  id="review-history-label" ></span></h5>
                <button type="button" class="close" data-bs-dismiss="modal"    aria-label="Close"><span  aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-outer">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Progress</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="attemt-list">
                                    
                                </tbody>
                            </table>
                        </div>                        
                    </div>
                </div>
                <a type="button" href="" id="restart-btn"  class="btn btn-dark">Re-Start Lesson</a> 
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

    function loadlessonreviews(url,i){
        $('#attemt-list').html('')
        $.get(url,function(res){
            $.each(res.data,function(k,v){ 
                $('#attemt-list').append(`
                    <tr>
                        <td>${v.date}</td>
                        <td>${v.progress}%</td>
                        <td><a type="button" href="${v.url}" class="btn btn-warning btn-sm">Preview</a> </td>
                    </tr>
                `)
            })
            $('#restart-btn').attr('href',res.url);
            $('#review-history-label').html(` ${i} : ${res.name} `)
            $('#review-history-modal').modal('show')
        },'json')
    }
    </script>
@endpush