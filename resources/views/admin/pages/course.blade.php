@extends('layouts.admin')

@section('title', 'Course')

@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Course</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2">
    <div class="container">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link @if(old('section') == 'section1' || old('section') == '') active @endif" id="section1-tab" data-bs-toggle="tab" href="#section1" role="tab" aria-controls="section1" aria-selected="@if(old('section') == 'section1' || old('section') == '') true @else false @endif">Section 1</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link @if(old('section') == 'section2') active @endif" id="section2-tab" data-bs-toggle="tab" href="#section2" role="tab" aria-controls="section2" aria-selected="@if(old('section') == 'section2') true @else false @endif">Section 2</a>
        </li>
    
    </ul>


        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade  @if(old('section','save')=='save') show active @endif" id="section1" role="tabpanel" aria-labelledby="section1-tab">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="title">Title</label>
                                                    <textarea class="form-control" name="couse_title" value="{{old('couse_title')}}"></textarea>
                                                    @error('title')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-dark" name="section" value="save">Save</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade @if(old('section')=='section2') show active @endif" id="section2" role="tabpanel" aria-labelledby="section2-tab">
                <div class="row">
                    <div class="card">

                        <div class="card-body">

                            <form></form>
                           
                        </div>
                    </div>
                </div>
            </div>


@endsection


@push('footer-script')

    <script>


         
    </script>


@endpush




