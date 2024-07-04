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

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'class_detail')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>

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

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'lesson_material')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
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

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'home_work')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
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

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'lesson_recording')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
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

<div class="modal fade bd-example-modal-lg" id="private-class-modal" tabindex="-1" role="dialog" aria-labelledby="private-classLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="sub-category-set-createLabel">Add Term</h5>
                <button type="button" class="close" data-bs-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form  class="form" id="term_form" data-save="create" data-action="{{ route('admin.term.store') }}" data-createurl="" >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="term_label">Term Name</label>

                                        <input type="text" name="term_name" id="term_label" class="form-control " >

                                        <input type="hidden" name="term_type" id="term_type_form" class="form-control " >

                                        <div class="invalid-feedback" id="term-errror"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4 pt-4">
                            <button type="submit" class="btn btn-dark" id="table-subcategoryset-form-submit"> Add + </button>
                            <button type="button" class="btn btn-secondary" style="display: none" id="table-subcategoryset-form-clear" >Cancel</button>
                        </div>
                    </div>

                </form>

                <div id="class_detail" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        :url="route('admin.term.show_table')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

                <div id="lesson_material" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        :url="route('admin.term.show_table_lesson_material')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

                <div id="home_work" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        :url="route('admin.term.show_table_home_work')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

                <div id="lesson_recording" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        :url="route('admin.term.show_table_lesson_recording')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

            </div>
        </div>
    </div>
</div>


@endpush

@push('footer-script')
    <script>

        function AddTerm(event,term)
        {
            event.preventDefault();
            event.stopPropagation();

            $('#term_type_form').val(term);

            $('#private-class-modal').modal('show');

            $('.table-term-ajax').hide();

            $('#'+term).show();

        }

        
        $(document).ready(function() {

            $('#term_form').on('submit', function(event) {

                event.preventDefault(); 
                
                var form = $(this);
                var url = form.data('action');
                var formData = new FormData(this);

                $.ajax({
                    url: url,

                    type: 'POST',

                    data: formData,

                    processData: false,
                    contentType: false,
                  
                    success: function(response) {
                      
                        form.trigger('reset');
                    },
                    error: function(response) {
                       
                        var errors = response.responseJSON.errors;
                        if (errors.term_name) {
                            $('#term-errror').text(errors.term_name[0]).show();
                        }
                    }
                });
            });

            $('#term_label').on('focus', function() {
                $('#term-errror').hide().text('');
            });
        });
        
    </script>
@endpush
