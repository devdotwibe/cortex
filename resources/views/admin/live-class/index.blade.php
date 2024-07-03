@extends('layouts.admin')
@section('title', 'Live Teaching')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Live Teaching</h2>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">

                <div class="col-md-6 pt-4">

                        <div class="card">

                            <div class="card-body">

                                <div class="category">

                                    <div class="card-box" id="card_box_1">

                                        <a onclick="CardBoxOpen(this)" class="btn-live-class"> <h5><img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5></a>

                                        <div class="category-image">

                                            @if(!empty($live_class->class_image_1))

                                                <img src="{{ url('d0/' . $live_class->class_image_1) }}">
                                            @else

                                                <img src="{{asset("assets/images/User-red.png")}}">

                                            @endif
                                        
                                        </div>

                                        <div class="category-content">

                                            <h3> @if(!empty($live_class->class_title_1)) {{ $live_class->class_title_1 }} @else Private Class Room @endif</h3>

                                            <p>
                                                @if(!empty($live_class->class_description_1))

                                                {{ $live_class->class_description_1 }}

                                                @else
                                                Receive a personalised learning experience with regular feedback by entrolling with our tutors Desinged for Year 5 students
                                                
                                                @endif
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                </div>

                <div class="col-md-6 pt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="category">

                                <div class="card-box" id="card_box_1">

                                    <a onclick="CardBoxOpenTwo(this)" class="btn-live-class"> <h5><img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5></a>

                                    <div class="category-image">

                                        @if(!empty($live_class->class_image_2))

                                            <img src="{{ url('d0/' . $live_class->class_image_2) }}">
                                        @else

                                            <img src="{{asset("assets/images/User-red.png")}}">

                                        @endif
                                    
                                    </div>

                                    <div class="category-content">

                                        <h3> @if(!empty($live_class->class_title_2)) {{ $live_class->class_title_2 }} @else Intensive Workshop  @endif</h3>
                                           
                                        <p>
                                            @if(!empty($live_class->class_description_2))

                                            {{ $live_class->class_description_2 }}

                                            @else
                                            These open group sessions condense the entire Thinking Skills curriculum into ten intensive lessions Designed for Year 6 students 
                                            
                                            @endif
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

            </div>
           
        </div>

        <div class="row" id="card_box_form_1" style="display:none">

            <div class="card-box-form">

                <form method="post" action="{{ route('admin.live-class.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="category-image">

                        <button type="button" onclick="EditImage1()" id="edit_btn_1" >X</button>

                        <label>Image</label>

                        <span id="card_image_1">

                            @if(!empty($live_class->class_image_1))

                                <img src="{{ url('d0/' . $live_class->class_image_1) }}">
                            @else

                                <img src="{{asset("assets/images/User-red.png")}}">

                            @endif

                        </span>

                        <span id="card_image_upload_1" style="display:none">

                            <input type="file" name="class_image_1" id="class_image_1" class="form-control">

                            <div class="preview-box" id="preview-box" style="width:300px; height:200px; display:none">

                                <img id="preview-image" class="image-preview">

                            </div>
                        
                        </span>
                    
                    </div>

                    <div class="form-group">

                        <div class="form-data">

                            <div class="forms-inputs mb-4">

                                <label>Title</label>

                                <input type="text" name="class_title_1" id="class_title_1" class="form-control" value="@if(!empty($live_class->class_title_1)) {{ $live_class->class_title_1 }} @else Private Class Room @endif">

                            </div>

                            <div class="forms-inputs mb-4">
                                
                                <label>Description</label>

                                <textarea class="form-control" name="class_description_1" id="class_description_1" rows="3">@if(!empty($live_class->class_description_1)){{ $live_class->class_description_1 }}@else Receive a personalised learning experience with regular feedback by enrolling with our tutors. Designed for Year 5 students.@endif</textarea>
                                
                            </div>

                        </div>

                    </div>

                    <div class="forms-inputs mb-4">

                        <button type="submit" class="btn btn-primary">Save</button>

                        <button type="button"  onclick="CardBoxClose(this)"  class="btn btn-secondary">Cancel</button>

                    </div>
                    

                </form>

            </div>

        </div>


        <div class="row" id="card_box_form_2" style="display:none">

            <div class="card-box-form">

                <form method="post" action="{{ route('admin.live-class.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="category-image">

                        <button type="button" onclick="EditImage2()" id="edit_btn_2" >X</button>

                        <label>Image</label>

                        <span id="card_image_2">

                            @if(!empty($live_class->class_image_2))

                                <img src="{{ url('d0/' . $live_class->class_image_2) }}">
                            @else

                                <img src="{{asset("assets/images/User-red.png")}}">

                            @endif

                        </span>

                        <span id="card_image_upload_2" style="display:none">

                            <input type="file" name="class_image_2" id="class_image_2" class="form-control">

                            <div class="preview-box" id="preview-box_2" style="width:300px; height:200px; display:none">

                                <img id="preview-image_2" class="image-preview">

                            </div>
                        
                        </span>
                    
                    </div>

                    <div class="form-group">

                        <div class="form-data">

                            <div class="forms-inputs mb-4">

                                <label>Title</label>

                                <input type="text" name="class_title_2" id="class_title_2" class="form-control" value="@if(!empty($live_class->class_title_2)) {{ $live_class->class_title_2 }} @else Intensive Workshop @endif">

                            </div>

                            <div class="forms-inputs mb-4">
                                
                                <label>Description</label>

                                <textarea class="form-control" name="class_description_2" id="class_description_2" rows="3">@if(!empty($live_class->class_description_2)){{ $live_class->class_description_2 }}@else These open group sessions condense the entire Thinking Skills curriculum into ten intensive lessions Designed for Year 6 students @endif</textarea>
                                
                            </div>

                        </div>

                    </div>

                    <div class="forms-inputs mb-4">

                        <button type="submit" class="btn btn-primary">Save</button>

                        <button type="button"  onclick="CardBoxCloseTwo(this)"  class="btn btn-secondary">Cancel</button>

                    </div>
                    

                </form>

            </div>

        </div>



    </div>
</section>
@endsection



@push('footer-script')
   
<script>

        function CardBoxOpen(id)
        {
            $('#card_box_form_1').fadeToggle();

            $('#card_box_form_2').hide();
        }

        function CardBoxOpenTwo(id)
        {
            $('#card_box_form_2').fadeToggle();

            $('#card_box_form_1').hide();

        }

        function CardBoxClose(id)
        {
            $('#card_box_form_1').hide();
           
            $('#card_image_upload_1').hide();

            $('#card_image_1').show();

            $('#edit_btn_1').show();
            
        }

        function CardBoxCloseTwo(id)
        {
            $('#card_box_form_2').hide();
           
            $('#card_image_upload_2').hide();

            $('#card_image_2').show();

            $('#edit_btn_2').show();
            
        }

        function EditImage1()
        {
            $('#card_image_1').hide();

            $('#edit_btn_1').hide();

            $('#card_image_upload_1').show();
        }

        function EditImage2()
        {
            $('#card_image_2').hide();

            $('#edit_btn_2').hide();

            $('#card_image_upload_2').show();
        }

</script>

<script>

    $(document).ready(function() {

        $('#class_image_1').change(function(event) {

            var input = event.target;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {

                    $('#preview-box').show();

                    $('#preview-image').attr('src', e.target.result).show();
                };

                reader.readAsDataURL(input.files[0]);
            }
        });


        $('#class_image_2').change(function(event) {

            var input = event.target;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {

                        $('#preview-box_2').show();

                        $('#preview-image_2').attr('src', e.target.result).show();
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            });

    });

</script>

@endpush
