@extends('layouts.user')
@section('title', $post->title)
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="back-btn" >
            <a href="{{route('community.index')}}"><img src="{{asset('assets/images/leftarrowblack.svg')}}" alt=""></a>
        </div>
        <div class="header_title">
            <h2>{{$post->title}}</h2>
        </div> 
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('community.post.edit',$post->slug)}}" class="nav_link btn">Edit Post</a></li>
                @if ($post->user_id==$user->id)
                <li class="nav_item"><a data-bs-toggle="modal" data-target="#delete-post" data-bs-target="#delete-post" class="btn btn-outline-danger">Delete</a></li>                    
                @endif
            </ul>
        </div>
    </div>
</section>

<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
                <div class="card-body">
                    {!! $post->description !!}
                </div>
            </div>
        </div>
    </div>
</section> 
@endsection

@push('modals') 
    @if ($post->user_id==$user->id)
        <div class="modal fade" id="delete-post" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="Lablel">Delete Confirmation Required</h5>
                        <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('community.post.destroy',$post->slug)}}"  id="delete-post-form" method="post">
                            @csrf
                            @method("DELETE")
                            <p>Are you sure you want to delete the record </p>
                            <button type="button" data-bs-dismiss="modal"   class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endpush

@push('footer-script')
    
@endpush