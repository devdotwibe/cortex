@extends('layouts.user')
@section('title', 'Learn')
@section('content')

<style>
    .card.grey {
        background:#c4c4c4;
    }

</style>

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn</h2>
        </div>
    </div>
</section>
<section class="content_section learn-section">
    <div class="container">
        <div class="row {{ $user->free_access_terms }}">
            @foreach ($categorys as $k => $item)
            <div class="col-md-6">
                @php
                    $user_access =false;
                @endphp

                @if (($user->is_free_access && in_array($item->id, explode(',', $user->free_access_terms)))||(optional($user->subscription())->status??"")=="subscribed" || $k==0)
                <a href="{{ route('learn.show', $item->slug) }}">

                    @php
                        $user_access = true;

                    @endphp
                @else
                    @php
                        $user_access = false;

                    @endphp
                    {{-- <a href="{{ route('pricing.index') }}#our-plans"> --}}
                        <a href="javascript:void(0);" onclick="showLockedModal('{{ $item->name }}')">
                @endif
                    <div class="card {{ !$user_access ? 'grey' : '' }}">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{$exam->examIcon($item->id,asset("assets/images/learnuser-red.png"))}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{ $item->id }}">
                                            {{ $exam->subtitle($item->id, "Module " . ($item->getIdx() + 1)) }}
                                        </span></h5>
                                    <h3>{{ $item->name }}</h3>
                                </div>
                                <div class="progress-area">
                                    <progress max="100"
                                        value="{{ $item->progress }}">
                                        {{ round($item->progress, 2) }}%
                                    </progress>
                                    <span>{{ round($item->progress, 2) }}%</span>
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
                <p>The content is locked and a subscription is required. </p>

                <p id="content_graph">  If you are enrolled in our classes, this will be unlocked in <span id="term_content">Term 1 Week 7</span> </p>

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
function showLockedModal(slug) {

    console.log(slug);

    $('#content_graph').show();

    var content = "";

    if(slug =='Critical Reasoning')
    {
        var content = "Term 1 Week 7";
    }
    else if(slug =='Logical Reasoning')
    {
        content="Term 1 Week 10";
    }
    else if(slug =='Abstract Reasoning')
    {
        content="Term 2 Week 5";
    }
    else if(slug =='Numerical Reasoning')
    {
        content="Term 2 Week 10";
    }
    else if(slug =='Exam Performance')
    {
        content="If you are enrolled in our classes, this will be unlocked in Term 3 Week 7";
    }

    if(content =="")
    {
        $('#content_graph').hide();
    }

    $('#term_content').text(content);

    document.getElementById('lockedModal').style.display = 'block';
}

function closeLockedModal() {
    document.getElementById('lockedModal').style.display = 'none';

    $('#lockedModal').modal('hide');
    $('body').removeClass('modal-open');
}
</script>

@endpush
