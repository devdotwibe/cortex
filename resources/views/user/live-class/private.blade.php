@extends('layouts.user')
@section('title', 'Live Class - '.($live_class->class_title_1??' Private Class Room '))
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('live-class.index') }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
            <h2>Live Class - {{($live_class->class_title_1??' Private Class Room ')}}</h2>
        </div>
    </div>
</section>
<section class="content_section"> 
    <div class="workshop-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="workshop-content">
                    {!! $live_class->private_class??""!!}
                </div>



                <div class="timetable-wrapp">
                    <p><strong>Timetable</strong></p>
                    @foreach ($timetables as $timetable)
                    <div class="timetable-row">
                        <p>
                            {{ $timetable->day }} 
                            <span>({{ $timetable->starttime }} {{ $timetable->starttime_am_pm }} - {{ $timetable->endtime }} {{ $timetable->endtime_am_pm }})</span>
                        </p>
                        <div class="user-icons">
                            @for ($i = 0; $i < $timetable['count']; $i++)
                                <span class="user-icon"><img src="{{ asset('assets/images/fa6-solid_user.svg') }}" alt=""></span>
                            @endfor
                            @for ($i = $timetable['count']; $i < 10; $i++)  <!-- Assuming a maximum of 10 users -->
                                <span class="user-icon"><img src="{{ asset('assets/images/fa6-regular_user.svg') }}" alt=""></span>
                            @endfor
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="workshop-action"> 
                    @if (empty($user->privateClass))
                  {{-- @guest('admin')  
                  
                  <a class="btn btn-outline-warning m-2" href="{{route('live-class.privateclass.form',$user->slug)}}">Register</a>
                  
                  @endguest --}}
                  @guest('admin')  
                  @if((auth('web')->user()->is_free_access)&& (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed")  
                  {{-- <a @if(auth('admin')->check() &&!(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed") data-bs-toggle="modal" data-bs-target="#adminsubModal"  @else href="{{ route('analytics.index') }}" @endif >   --}}

                  <a class="btn btn-warning m-2" href="{{route('live-class.privateclass.room',$user->slug)}}">Enter</a>

                  @else 
                  

                  <a class="btn btn-outline-warning m-2" href="#" onclick="showLockedModal()">Register</a>

                  @endif
              @endguest
                    @elseif($user->privateClass->status!="approved")
                    @if($user->privateClass->status=="pending") <p class="text-warning"> You are under verification, Please wait.</p> @elseif($user->privateClass->status=="rejected") <p class="text-danger" >Your are rejected by admin, Please <a @if(!empty(optional($setting)->emailaddress)) href="mailto:{{optional($setting)->emailaddress}}" @endif >contact Admin {{ optional($setting)->emailaddress }}</a> for further details.</p> @else <span class="btn btn-outline-warning"> {{ucfirst($user->privateClass->status)}} </span> @endif
                    @else
                    <a class="btn btn-warning m-2" href="{{route('live-class.privateclass.room',$user->slug)}}">Enter</a>
                    @endif 
                </div>
            </div>
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



 