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
                            @if ($user->is_free_access||(optional($user->subscription())->status??"")=="subscribed"||$k == 0)
                                <a @if ($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id.'-complete-review',"no") == "yes") 
                                    
                                    @elseif ($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id.'-complete-date',"") == "")
                                    @guest('admin')   href="{{ route('learn.lesson.show', ["category" => $category->slug, "sub_category" => $item->slug]) }}" @endguest
                                @else
                                    href="#" onclick="loadlessonreviews('{{ route('learn.lesson.history', ['category' => $category->slug, 'sub_category' => $item->slug]) }}', {{$k+1}}); return false;"
                                @endif> 
                            @else
                            <a href="{{route('pricing.index')}}">
                            @endif
                            <div class="lesson-row">
                                <div class="lesson-row-title">
                                    <span class="lesson-line">Lesson {{$k+1}}</span>
                                    <h3>: {{ $item->name }} </h3>
                                    <h4>{{ round($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id,0), 2) }}%</h4>
                                </div>
                                {{-- <div class="lesson-row-subtitle"> --}}
                                
                                {{-- </div> --}}
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
                @guest('admin') <a type="button" href="" id="restart-btn" class="btn btn-dark">Re-Start Lesson</a> @endguest
            </div>
        </div>
    </div>
</div>
 
@endpush

@push('footer-script') 
<script>
 
    function loadlessonreviews(url, i) {
        $('#attemt-list').html('');
        $.get(url, function(res) {
            $.each(res.data, function(k, v) {
                $('#attemt-list').append(`
                    <tr>
                        <td>${v.date}</td>
                        <td>${v.progress}%</td>
                        <td><a type="button" href="${v.url}" class="btn btn-warning btn-sm">Review</a></td>
                    </tr>
                `);
            });
            $('#restart-btn').attr('href', res.url);
            $('#review-history-label').html(` ${i} : ${res.name} `);
            $('#review-history-modal').modal('show');
        }, 'json');
    }
      
</script>
@endpush
