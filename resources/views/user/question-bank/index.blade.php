@extends('layouts.user')
@section('title', 'Question Bank')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Question Bank</h2>
        </div> 
    </div>
</section>
<section class="content_section learn-section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k=> $item)
            <div class="col-md-6">
                @if ($user->is_free_access||(optional($user->subscription())->status??"")=="subscribed"||$k == 0) 
                <a href="{{route('question-bank.show',$item->slug)}}">
                @else
                {{-- <a href="{{ route('pricing.index') }}#our-plans"> --}}
                    <a href="javascript:void(0);" onclick="showLockedModal()">
                @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{$exam->examIcon($item->id,asset("assets/images/User-red.png"))}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{$item->id}}"> {{$exam->subtitle($item->id,"Topic ".($item->getIdx()+1))}} </span></h5>
                                    <h3>{{$item->name}}</h3>
                                </div>
                                <div class="progress-area">
                                    <progress max="100" value="{{$user->progress('exam-'.$exam->id.'-topic-'.$item->id,0)}}">{{round($user->progress('exam-'.$exam->id.'-topic-'.$item->id,0),2)}}%</progress>
                                    <span>{{round($user->progress('exam-'.$exam->id.'-topic-'.$item->id,0),2)}}%</span>
                                </div>
                            </div>
                        </div>
                    </div>        
                </a>
                
            </div>
            @endforeach  
        </div>
    </div>
</section> 
@endsection

@push('modals')  

<!-- Locked Content Modal -->
<div id="lockedModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Content Locked</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeLockedModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>The content is locked and a subscription is required.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('pricing.index') }}#our-plans" class="btn btn-primary">View Pricing Plans</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeLockedModal()">Close</button>
            </div>
        </div>
    </div>
</div>

@endpush


@push('footer-script')
<script>
    function showLockedModal() {
        document.getElementById('lockedModal').style.display = 'block';
    }
    
    function closeLockedModal() {
        document.getElementById('lockedModal').style.display = 'none';
    }
    </script>
     
@endpush