@extends('layouts.admin')
@section('title', $live_class->class_title_1?? "Private Class")
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            @if(!empty($live_class->class_title_1))

            <h2>{{ $live_class->class_title_1 }}</h2>
            @else
            <h2>Private Class</h2>

            @endif
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
           
            <div class="col-md-6 pt-4">

                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Class Details</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 pt-4">

                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Lesson Material</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            <div class="col-md-6 pt-4">

                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Home work submission</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            <div class="col-md-6 pt-4">

                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Lesson Recording</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                
            </div>

            </div>
          
        </div>
    </div>
</section>
@endsection

@push('modals')

<div class="modal fade" id="question-bank-subtitle" tabindex="-1" role="dialog" aria-labelledby="question-bank-subtitleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.question-bank.subtitle')}}"  id="question-bank-subtitle-form" method="post">
                    @csrf
                    <input type="hidden" name="category_id" id="question-bank-category-id" value="">
                    <input type="hidden" name="exam_id" value="">
                     <div class="form-group">
                        <div class="form-data">
                            <div class="forms-inputs mb-4">
                                <label for="question-bank-category-title">Sub Title</label>
                                <input type="text" name="title" id="question-bank-category-title" value="" class="form-control " placeholder="Sub Title" aria-placeholder="Sub Title" >
                                <div class="invalid-feedback">The field is required</div>
                            </div>
                        </div>
                     </div>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary mr-1">Cancel</button>
                    <button type="submit" class="btn btn-dark ml-1">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endpush

@push('footer-script')
    <script>
        
    </script>
@endpush
