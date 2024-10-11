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
    <section class="content_section admin_section private_section">
        <div class="container">
            <div class="row">

                <div class="col-md-6 pt-4 privateclass workshopclass">

                    <div class="card">
                        <div class="card-body">
                            <div class="row" id="card_box_1">
                                <a href="{{ route('admin.live-class.private_class_create') }}">

                                    <div class="category">

                                        <div class="card-box"  >

                                            <button onclick="CardBoxOneToggle(event)" class="btn-live-class">
                                                <h5><img src="{{ asset('assets/images/pen.png') }}" width="15"
                                                        alt=""></h5>
                                            </button>

                                            <button onclick="AddCardDetail(event)" class="btn btn-dark">
                                                <h5>Add +</h5>
                                            </button>

                                            <div class="category-image">

                                                @if (!empty($live_class->class_image_1))
                                                    <img src="{{ url('d0/' . $live_class->class_image_1) }}">
                                                @else
                                                    <img src="{{ asset('assets/images/User-red.png') }}">
                                                @endif

                                            </div>

                                            <div class="category-content">

                                                <h3>
                                                    @if (!empty($live_class->class_title_1))
                                                        {{ $live_class->class_title_1 }}
                                                    @else
                                                        Private Class Room
                                                    @endif
                                                </h3>
                                                <p>
                                                    @if (!empty($live_class->class_description_1))
                                                        {{ $live_class->class_description_1 }}
                                                    @else
                                                        Receive a personalised learning experience with regular feedback by
                                                        entrolling with our tutors Desinged for Year 5 students
                                                    @endif
                                                </p>

                                            </div>

                                        </div>

                                    </div>
                                </a>
                            </div>

                            <div class="row" id="card_box_form_1" style="display:none">

                                <div class="card-box-form">

                                    <form method="post" action="{{ route('admin.live-class.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="category-image">

                                            <button type="button" onclick="EditImage1()" id="edit_btn_1">X</button>

                                            <label>Image</label>

                                            <span id="card_image_1">

                                                @if (!empty($live_class->class_image_1))
                                                    <img src="{{ url('d0/' . $live_class->class_image_1) }}">
                                                @else
                                                    <img src="{{ asset('assets/images/User-red.png') }}">
                                                @endif

                                            </span>

                                            <span id="card_image_upload_1" style="display:none">

                                                <input type="file" name="class_image_1" id="class_image_1"
                                                    class="form-control">

                                                <div class="preview-box" id="preview-box"
                                                    style="width:300px; height:200px; display:none">

                                                    <img id="preview-image" class="image-preview">

                                                </div>

                                            </span>

                                        </div>

                                        <div class="form-group">

                                            <div class="form-data">

                                                <div class="forms-inputs mb-4">

                                                    <label>Title</label>

                                                    <input type="text" name="class_title_1" id="class_title_1"
                                                        class="form-control"
                                                        value="@if (!empty($live_class->class_title_1)) {{ $live_class->class_title_1 }} @else Private Class Room @endif">

                                                </div>

                                                <div class="forms-inputs mb-4">

                                                    <label>Description</label>

                                                    <textarea class="form-control" name="class_description_1" id="class_description_1" rows="3">
                                                    @if (!empty($live_class->class_description_1))
                                                    {{ $live_class->class_description_1 }}
                                                    @else
                                                    Receive a personalised learning experience with regular feedback by enrolling with our tutors. Designed for Year 5 students.
                                                    @endif
                                                    </textarea>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="forms-inputs mb-4">

                                            <button type="submit" class="btn btn-primary">Save</button>

                                            <button type="button" onclick="CardBoxOneToggle(event)"
                                                class="btn btn-secondary">Cancel</button>

                                        </div>


                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-6 pt-4 privateclass intensivework">

                    <div class="card">

                        <div class="card-body">
                            <div class="row" id="card_box_2" >
                                <div class="category">

                                    <div class="card-box" >
    
                                        <button onclick="CardBoxTwoToggle(event)" class="btn-live-class">
                                            <h5><img src="{{ asset('assets/images/pen.png') }}" width="15" alt="">
                                            </h5>
                                        </button>
    
                                        <button onclick="AddCardDetail2(event)" class="btn btn-dark">
                                            <h5>Add +</h5>
                                        </button>
    
                                        <div class="category-image">
    
                                            @if (!empty($live_class->class_image_2))
                                                <img src="{{ url('d0/' . $live_class->class_image_2) }}">
                                            @else
                                                <img src="{{ asset('assets/images/User-red.png') }}">
                                            @endif
    
                                        </div>
    
                                        <div class="category-content">
    
                                            <h3>
                                                @if (!empty($live_class->class_title_2))
                                                    {{ $live_class->class_title_2 }}
                                                @else
                                                    Intensive Workshop
                                                @endif
                                            </h3>
    
                                            <p>
                                                @if (!empty($live_class->class_description_2))
                                                    {{ $live_class->class_description_2 }}
                                                @else
                                                    These open group sessions condense the entire Thinking Skills curriculum
                                                    into ten intensive lessions Designed for Year 6 students
                                                @endif
                                            </p>
    
                                        </div>
    
                                    </div>
    
                                </div>
                            </div>
                            <div class="row" id="card_box_form_2" style="display:none">

                                <div class="card-box-form">
                
                                    <form method="post" action="{{ route('admin.live-class.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="category-image">
                
                                            <button type="button" onclick="EditImage2()" id="edit_btn_2">X</button>
                
                                            <label>Image</label>
                
                                            <span id="card_image_2">
                
                                                @if (!empty($live_class->class_image_2))
                                                    <img src="{{ url('d0/' . $live_class->class_image_2) }}">
                                                @else
                                                    <img src="{{ asset('assets/images/User-red.png') }}">
                                                @endif
                
                                            </span>
                
                                            <span id="card_image_upload_2" style="display:none">
                
                                                <input type="file" name="class_image_2" id="class_image_2" class="form-control">
                
                                                <div class="preview-box" id="preview-box_2"
                                                    style="width:300px; height:200px; display:none">
                
                                                    <img id="preview-image_2" class="image-preview">
                
                                                </div>
                
                                            </span>
                
                                        </div>
                
                                        <div class="form-group">
                
                                            <div class="form-data">
                
                                                <div class="forms-inputs mb-4">
                
                                                    <label>Title</label>
                
                                                    <input type="text" name="class_title_2" id="class_title_2" class="form-control"
                                                        value="@if (!empty($live_class->class_title_2)) {{ $live_class->class_title_2 }} @else Intensive Workshop @endif">
                
                                                </div>
                
                                                <div class="forms-inputs mb-4">
                
                                                    <label>Description</label>
                
                                                    <textarea class="form-control" name="class_description_2" id="class_description_2" rows="3">
                                                @if (!empty($live_class->class_description_2))
                                                {{ $live_class->class_description_2 }}
                                                @else
                                                These open group sessions condense the entire Thinking Skills curriculum into ten intensive lessions Designed for Year 6 students
                                                @endif
                                                </textarea>
                
                                                </div>
                
                                            </div>
                
                                        </div>
                
                                        <div class="forms-inputs mb-4">
                
                                            <button type="submit" class="btn btn-primary">Save</button>
                
                                            <button type="button" onclick="CardBoxTwoToggle(event)"
                                                class="btn btn-secondary">Cancel</button>
                
                                        </div>
                
                
                                    </form>
                
                                </div>
                
                            </div>
                            

                        </div>

                    </div>

                </div>

            </div>

 

        </div>
    </section>
@endsection


@push('modals')
    <div class="modal fade live-modal" id="live-private-modal" tabindex="-1" role="dialog"
        aria-labelledby="live-class-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="modal-row">
                        <div class="modal-col1">
                            <x-general-form :url="route('admin.live-class.private_class')" btnsubmit="Save" :fields="[
                                [
                                    'name' => 'private_class',
                                    'label' => 'Description',
                                    'placeholder' => 'Description',
                                    'size' => 12,
                                    'type' => 'editor',
                                    'value' => $live_class->private_class ?? '',
                                ],
                            ]" />
                        </div>


                        <div class="modal-col1">
                            <form action="{{ route('admin.timetable.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <!-- Day Picker -->
                                    <div class="text-field">
                                        <label for="day">Select Day:</label>
                                        <select name="day" id="day" class="form-control">
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                            <option value="Saturday">Saturday</option>
                                            <option value="Sunday">Sunday</option>
                                        </select>
                                    </div>
                        
                                    <div class="text-field">
                                        <label for="starttime">Start Time:</label>
                                        <input type="text" name="starttime" id="starttime" class="form-control" placeholder="HH : MM" required>
                                        <select name="starttime_am_pm" id="starttime_am_pm" class="form-control" required>
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                        
                                    <div class="text-field">
                                        <label for="endtime">End Time:</label>
                                        <input type="text" name="endtime" id="endtime" class="form-control" placeholder="HH : MM" required>
                                        <select name="endtime_am_pm" id="endtime_am_pm" class="form-control" required>
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                        
                                    <div class="text-field">
                                        <label for="count">Number of Users:</label>
                                        <input type="number" name="count" id="count" class="form-control" min="1" required>
                                    </div>
                        
                                    <button class="add-btn" type="submit">+ Add</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="text-field-preview">
                            @foreach ($timetables as $timetable)
                            <p>{{ $timetable->day }} 
                                <span>({{ $timetable->starttime }} {{ $timetable->starttime_am_pm }} - {{ $timetable->endtime }} {{ $timetable->endtime_am_pm }})</span>
                            </p>
                            
                            <div class="user-icons">
                                @for ($i = 1; $i <= $timetable->count; $i++)
                                    <span class="user-icon" data-index="{{ $i }}" data-timetable-id="{{ $timetable->id }}">
                                        <img src="{{ asset('assets/images/fa6-regular_user.svg') }}" alt="user-icon-{{ $i }}" class="regular-user">
                                        <span class="active-icon">
                                            <img src="{{ asset('assets/images/fa6-solid_user.svg') }}" alt="active-icon-{{ $i }}" class="solid-user d-none">
                                        </span>
                                    </span>
                                @endfor
                            </div>

                               <!-- Save Button -->
    <button class="save-btn" data-timetable-id="{{ $timetable->id }}" type="button">Save</button>
    @endforeach
</div>


                        
                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="live-intensive-modal" tabindex="-1" role="dialog"
        aria-labelledby="live-class-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <x-general-form :url="route('admin.live-class.intensive_class')" btnsubmit="Save" :fields="[
                            [
                                'name' => 'intensive_class',
                                'label' => 'Description',
                                'placeholder' => 'Description',
                                'size' => 12,
                                'type' => 'editor',
                                'value' => $live_class->intensive_class ?? '',
                            ],
                        ]" />
                    </div>

                </div>

            </div>
        </div>
    </div>
@endpush

@push('footer-script')

<script>
    // JavaScript to handle click events on the icons and save functionality
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.user-icon').forEach(function(icon) {
            icon.addEventListener('click', function() {
                let clickedIndex = parseInt(this.getAttribute('data-index'));
                let timetableId = this.getAttribute('data-timetable-id');

                // Highlight the clicked and previous icons
                document.querySelectorAll(`[data-timetable-id="${timetableId}"] .user-icon`).forEach(function(item, index) {
                    if (index < clickedIndex) {
                        item.querySelector('.regular-user').classList.add('d-none');
                        item.querySelector('.solid-user').classList.remove('d-none');
                    } else {
                        item.querySelector('.regular-user').classList.remove('d-none');
                        item.querySelector('.solid-user').classList.add('d-none');
                    }
                });
            });
        });

        // Save the number of solid icons on click
        document.querySelectorAll('.save-btn').forEach(function(saveBtn) {
            saveBtn.addEventListener('click', function() {
                let timetableId = this.getAttribute('data-timetable-id');
                let solidCount = document.querySelectorAll(`[data-timetable-id="${timetableId}"] .solid-user:not(.d-none)`).length;

                // Send an AJAX request to save the count
                fetch("{{ route('admin.timetable.saveCount') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        timetable_id: timetableId,
                        count: solidCount
                    })
                }).then(response => response.json())
                .then(data => {
                    alert('Count saved successfully!');
                }).catch(error => {
                    console.error('Error saving count:', error);
                });
            });
        });
    });
</script>


    <script>
        $(document).ready(function() {

            @error('intensive_class')

                AddCardDetail2(event);
            @enderror

            @error('private_class')

                AddCardDetail(event);
            @enderror

        });
    </script>

    <script>
        function CardBoxOneToggle(event) {
            event.preventDefault();
            event.stopPropagation();
            $('#card_box_form_1,#card_box_1').slideToggle(); 
        }

        function CardBoxTwoToggle(event) {
            event.preventDefault();
            event.stopPropagation();
            $('#card_box_form_2,#card_box_2').slideToggle(); 
        }  

        function EditImage1() {
            $('#card_image_1').hide();

            $('#edit_btn_1').hide();

            $('#card_image_upload_1').show();
        }

        function EditImage2() {
            $('#card_image_2').hide();

            $('#edit_btn_2').hide();

            $('#card_image_upload_2').show();
        }

        function AddCardDetail(event) {
            event.preventDefault();
            event.stopPropagation();

            $('#live-private-modal').modal('show');
        }

        function AddCardDetail2(event) {
            event.preventDefault();
            event.stopPropagation();

            $('#live-intensive-modal').modal('show');
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

<script>
    $(document).ready(function(){
        $("#starttime").inputmask("99 : 99", { placeholder: "HH : MM" });
        $("#endtime").inputmask("99 : 99", { placeholder: "HH : MM" });
    });
    </script>
    
@endpush
