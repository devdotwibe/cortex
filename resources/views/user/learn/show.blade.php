@extends('layouts.user')
@section('title', $exam->subtitle($category->id,"Module ".($category->getIdx()+1)).':'.$category->name)
@section('content')
<section class="container">
    <div class="container-wrap">
        <div class="lesson">
            <div class="lesson-title">
                <h3><span>{{$exam->subtitle($category->id,"Module ".($category->getIdx()+1))}}</span><span> : </span><span>{{$category->name}}</span></h3>
            </div>
            <div class="lesson-body">
                <div class="row" id="lesson-list">
                    @forelse ($lessons as $k=> $item)
                    <div class="col-md-6">
                        <a href="{{route('learn.lesson.show',["category"=>$category->slug,"sub_category"=>$item->slug])}}">
                            <div class="lesson-row">
                                <div class="lesson-row-title">
                                    <span>Lesson {{$k+1}}</span>
                                    <span> : </span>
                                    <span>{{ $item->name }}</span>
                                </div>
                                <div class="lesson-row-subtitle"> 
                                    <span>{{session('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$item->id,0)}}%</span>
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
</section>
@endsection

@push('footer-script') 
    <script> 
    </script>
@endpush