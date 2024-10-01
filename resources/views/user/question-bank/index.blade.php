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
                <a href="javascript:void(0);" 
                    @if ($user->is_free_access || (optional($user->subscription())->status ?? "") == "subscribed" || $k == 0)
                        onclick="window.location.href='{{ route('question-bank.show', $item->slug) }}'"
                    @else
                        onclick="showSubscriptionNotification()"
                    @endif>
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

<!-- Notification Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscriptionModalLabel">Subscription Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Candidate Not Subscriber Plan
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endpush
@push('footer-script')
<script>
    function showSubscriptionNotification() {
        $('#subscriptionModal').modal('show'); // Show the modal using Bootstrap
    }
</script>

    
@endpush