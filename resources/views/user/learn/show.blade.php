@extends('layouts.user')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title"> 
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('learn.index') }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="">
                </a>
            </div>
            <h2><span>{{$exam->subtitle($category->id,"Module ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h2>
        </div>
    </div>
</section>
<section class="content_section learn-inner-section">
    <div class="container">
        <div class="container-wrap">
            <div class="lesson">
                <div class="lesson-body">
                    <div class="row" id="lesson-list">
                        @forelse ($lessons as $k => $item)
                        <div class="col-md-6"> 
                            @if (($user->is_free_access && in_array($item->id, explode(',', $user->free_access_terms)))||(optional($user->subscription())->status??"")=="subscribed"||$k == 0)
                                <a @if ($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id.'-complete-review',"no") == "yes") 
                                    
                                    @elseif ($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id.'-complete-date',"") == "")
                                    @guest('admin')   
                                    @if($item->progress==0)
                                        href="{{ route('learn.lesson.show', ["category" => $category->slug, "sub_category" => $item->slug]) }}" 
                                    @else
                                        href="javascript:void(0);" onclick="showLearnModal('{{ route('learn.lesson.show', ['category' => $category->slug, 'sub_category' => $item->slug]) }}')"
                                    @endif
                                    @endguest
                                @else
                                    href="#" onclick="loadlessonreviews('{{ route('learn.lesson.history', ['category' => $category->slug, 'sub_category' => $item->slug]) }}', {{$k+1}}); return false;"
                                @endif> 
                            @else
                            {{-- <a href="{{route('pricing.index')}}"> --}}
                                <a href="javascript:void(0);" onclick="showLockedModal()">
                            @endif
                            <div class="lesson-row">
                                <div class="lesson-row-title">
                                    <span class="lesson-line">Lesson {{$k+1}}</span>
                                    <h3> {{ $item->name }} </h3>
                                    <h4>{{  round($item->progress,2) }}%</h4>
                                </div>
                            </div>
                            </a>
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
    </div>
</div>
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


<div class="modal fade" id="review-history-modal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lesson <span id="review-history-label"></span></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                                    <!-- Content dynamically loaded via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- @guest('admin') <a type="button" href="" id="restart-btn" class="btn btn-dark">Re-Start Lesson</a> @endguest --}}
                @guest('admin')
                <a type="button" href="" id="restart-btn" class="btn btn-dark">
                    Restart Lesson
                </a>
                <a type="button" href="" id="continue-btn" class="btn btn-dark d-none">
                    Continue Lesson
                </a>
                @endguest


            </div>
        </div>
    </div>
</div>
 
<div id="learnModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeLearnModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you want continue your lessons or start over ?.</p>
            </div>
            <div class="modal-footer">
                <a id="startOverLink" onclick="updateprogress()" class="btn btn-primary">Start Over</a>
                <a id="continueLink" class="btn btn-secondary" data-dismiss="modal" >Continue</a>
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
 
 
 
<script>
    // Get the lesson ID from the server-side to the client-side
    const lessonId = "{{ $item->id }}"; // Ensure this variable is passed from the controller
    const activeLessonId = localStorage.getItem('activeLesson');

    // Check if the user has an active lesson in localStorage
    if (activeLessonId === lessonId) {
        // If the active lesson matches the current lesson, change the button text
        document.getElementById('restart-btn').innerText = "Continue Lesson";
    }

    // Function to set active lesson when the lesson starts
    function setActiveLesson() {
        localStorage.setItem('activeLesson', lessonId);
    }

    // Call this function when the lesson starts
    // You might call it when the user clicks a button to start the lesson
    // Example: setActiveLesson();

    // Optional: Clear the active lesson when the lesson is completed
    function clearActiveLesson() {
        localStorage.removeItem('activeLesson');
    }
</script>
<script>
 
    function loadlessonreviews(url, i) {
        $('#attemt-list').html('');
        $.get(url, function(res) {
            $.each(res.data, function(k, v) {
                if(v.questions>0){
                    $('#attemt-list').append(`
                        <tr>
                            <td>${v.date}</td>
                            <td>${v.progress}%</td>
                            <td><a type="button" href="${v.url}" class="btn btn-warning btn-sm">Review</a></td>
                        </tr>
                    `);
                }else{
                    $('#attemt-list').append(`
                        <tr>
                            <td>${v.date}</td>
                            <td>${v.progress}%</td>
                            <td></td>
                        </tr>
                    `);
                }
                
            });
            if(res.starturl){
                $('#restart-btn').attr('href', res.starturl);
                $('#continue-btn').attr('href', res.url);
                $("#continue-btn").removeClass("d-none");
            }else{
                $('#restart-btn').attr('href', res.url);
                $("#continue-btn").addClass("d-none");
            }
            $('#review-history-label').html(` ${i} : ${res.name} `);
            $('#review-history-modal').modal('show');
        }, 'json');
    }
    function showLearnModal(url) {
        document.getElementById('learnModal').style.display = 'block';
        document.getElementById('startOverLink').href = url+'?start=true';
        document.getElementById('continueLink').href = url;
    }
    function closeLearnModal() {
        document.getElementById('learnModal').style.display = 'none';
        $('#learnModal').modal('hide');
        $('body').removeClass('modal-open');
    }

    
</script>
@endpush
