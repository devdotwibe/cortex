@extends('layouts.admin')
@section('title', 'Live Teaching')
@section('content')

<style>
    .modal-content {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>
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

                                        <div class="card-box">

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
                                                        {!! $live_class->class_description_1 !!}
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




                                            <span id="card_image_upload_1" style="display: none;" >
                                             <label for="class_image_1" class="file-upload">Upload File <br>
                                                <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                              </label>
                                                <input type="file" name="class_image_1" id="class_image_1"
                                                    class="form-control"  style="display: none;">

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
                            <div class="row" id="card_box_2">
                                <div class="category">

                                    <div class="card-box">

                                        <button onclick="CardBoxTwoToggle(event)" class="btn-live-class">
                                            <h5><img src="{{ asset('assets/images/pen.png') }}" width="15"
                                                    alt="">
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
                                                    {!! $live_class->class_description_2 !!}
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

                                    <form method="post" action="{{ route('admin.live-class.store') }}"
                                        enctype="multipart/form-data">
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

                                            <span id="card_image_upload_2" style="display: none;">
                                                <label for="class_image_2" class="file-upload">Upload File <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                  </label>
                                                <input type="file" name="class_image_2" id="class_image_2"
                                                    class="form-control" style="display: none;">

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

                                                    <input type="text" name="class_title_2" id="class_title_2"
                                                        class="form-control"
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

                    @if (session()->has('create_timetable'))
                        <div class="alert alert-success">
                            {{ session()->get('create_timetable') }}
                        </div>
                    @endif

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
                            <form action="{{ route('admin.timetable.store') }}" method="POST" id="formedit">
                                @csrf
                                <div class="form-row">
                                    <!-- Day Picker -->
                                    <div class="startdayclass">
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



                                        <div class="text-field timestartclass">
                                            <label for="starttime">Start Time:</label>
                                            <div class="form-group">
                                                <input type="text" name="starttime" id="starttime"
                                                    class="form-control" placeholder="HH : MM"
                                                    data-mask="^(0[0-9]|1[0-9]|2[0-4]) : [0-5][0-9]$">
                                            </div>
                                        </div>

                                        <div class="text-field ampmclass">
                                            <label for="starttime_am_pm">Select AM/PM:</label>
                                            <div class="form-group">
                                                <select name="starttime_am_pm" id="starttime_am_pm" class="form-control"
                                                    required>
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="startdayclass">
                                        <!-- End Time Picker -->
                                        <div class="text-field timestartclass">
                                            <label for="endtime">End Time:</label>
                                            <div class="form-group">
                                                <input type="text" name="endtime" id="endtime" class="form-control"
                                                    placeholder="HH : MM"
                                                    data-mask="^(0[0-9]|1[0-9]|2[0-4]) : [0-5][0-9]$">
                                            </div>
                                        </div>

                                        <div class="text-field ampmclass">
                                            <label for="endtime_am_pm">Select AM/PM:</label>
                                            <div class="form-group">
                                                <select name="endtime_am_pm" id="endtime_am_pm" class="form-control"
                                                    required>
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="text-field">
                                            <label for="count">Number of Users:</label>
                                            <select name="count" id="count" class="form-control" required>
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="text-field">
                                            <label for="year">Select Year:</label>
                                            <select name="year" id="year" class="form-control">
                                                <option value=""> select </option>
                                                @for ($year = date('Y'); $year <= date('Y') + 10; $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="text-field">
                                            <label for="type">Type :</label>

                                            <select name="type" id="type" class="form-control">
                                                <option value=""> select </option>
                                                <option value="Online"> Online </option>
                                                <option value="F2F">F2F</option>
                                            </select>
                                        </div>


                                    </div>


                                    <button class="add-btn addbuttonclass" type="submit" id="updatebutton">+ Add
                                    </button>
                                    <a href="{{ route('admin.live-class.index') }}"
                                        class="add-btn cancel-button-class"  id="cancelid" style="display:none">Cancel</a>



                                        @foreach ($timetables as $k => $timetable)
                                        <div class="text-field-preview">

                                            <p>{{ $timetable->day }}
                                                <span>({{ $timetable->starttime }} {{ $timetable->starttime_am_pm }} -
                                                    {{ $timetable->endtime }} {{ $timetable->endtime_am_pm }}) ({{ $timetable->type }}) {{  $timetable->year }}</span>
                                            </p>

                                            <div class="user-icons">
                                                @for ($i = 1; $i <= $timetable->count; $i++)
                                                    <span class="user-icon">
                                                        <img src="{{ asset('assets/images/fa6-solid_user.svg') }}"
                                                            alt="">

                                                    </span>
                                                @endfor
                                            </div>


                                            {{-- <div class="action-buttons">

                                                <button data-url="{{ route('admin.timetable.fetcheditdata', $timetable->id) }}"
                                                    onclick="edittimetable(this)" class="btn btn-primary">Edit</button>


                                                    <button
                                                        onclick="deletefunction(this)"  data-url="{{ route('admin.timetable.destroy', $timetable->id) }}"  class="btn btn-primary">Delete</button>
                                            </div> --}}

                                            <div class="action-buttons">

                                                <div class="form-check order-change">

                                                    <select name="order_no" id="order_no" data-id={{ $timetable->id }} onchange="OrderChange(this)">
                                                            <option value="">Select Order</option>
                                                            @for ($i = 1; $i <= $time_count; $i++)

                                                                <option value="{{ $i }}" {{ $timetable->order_no == $i ? 'selected' : ''}}>{{ $i  }}</option>

                                                            @endfor
                                                    </select>

                                                </div>

                                                <div class="form-check form-switch">

                                                    <label for="hide_time_{{ $timetable->id }}">Hide</label>
                                                    <input name="hide_time"   {{ $timetable->hide_time == 'Y' ? 'checked' : '' }} data-id="{{ $timetable->id }}" value="Y"  id="hide_time_{{ $timetable->id }}" onchange="HideButton(this)"  type="checkbox" class="form-check-input" role="switch">

                                                </div>
                                                <button type="button"
                                                    data-url="{{ route('admin.timetable.fetcheditdata', $timetable->id) }}"
                                                    onclick="edittimetable(this)" class="btn btn-icons edit_btn">
                                                    <span class="adminside-icon">
                                                        <img src="{{ asset('assets/images/icons/iconamoon_edit.svg') }}"
                                                            alt="Edit">
                                                    </span>
                                                    <span class="adminactive-icon">
                                                        <img src="{{ asset('assets/images/iconshover/iconamoon_edit-yellow.svg') }}"
                                                            alt="Edit Active" title="Edit">
                                                    </span>
                                                </button>

                                                <button type="button" onclick="deletefunction(this)"
                                                    data-url="{{ route('admin.timetable.destroy', $timetable->id) }}"
                                                    class="btn btn-icons dlt_btn">
                                                    <span class="adminside-icon">
                                                        <img src="{{ asset('assets/images/icons/material-symbols_delete-outline.svg') }}"
                                                            alt="Delete">
                                                    </span>
                                                    <span class="adminactive-icon">
                                                        <img src="{{ asset('assets/images/iconshover/material-symbols_delete-yellow.svg') }}"
                                                            alt="Delete Active" title="Delete">
                                                    </span>
                                                </button>
                                            </div>


                                        </div>
                                    @endforeach
                                </div>
                            </form>


                        </div>





                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="delete-post" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Lablel">Delete Confirmation Required</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="delete-post-form" method="post">
                        @csrf
                        @method('DELETE')
                        <p>Are you sure you want to delete the record </p>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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
        function deletefunction(element) {

            var url = $(element).data('url');

            $('#delete-post-form').attr('action', url);


            $('#live-private-modal').modal('hide');

            $('#delete-post').modal('show');


        }

        function HideButton(element)
        {
            var value = $(element).is(':checked') ? 'Y' : 'N';

            var id = $(element).attr('data-id');

            console.log(value,'value');

            $.ajax({
                url: "{{route('admin.live-class.hide_button') }}",
                type: 'POST',
                data :
                {
                    id:id,
                    value:value,
                },
                success: function(response) {

                    const checkbox = $(`#hide_time_${response.id}`);

                    if (response.value === 'Y') {
                        checkbox.attr('checked', 'checked');
                    } else {
                        checkbox.removeAttr('checked');
                    }
                },
            });

        }

        function OrderChange(element)
        {
            var id = $(element).attr('data-id');

            var value = $(element).val();

            $.ajax({
                url: "{{route('admin.live-class.time_order') }}",
                type: 'POST',
                data :
                {
                    id:id,
                    value:value,
                },
                success: function(response) {
                    console.log(response);
                    window.location.reload();
                },
            });

        }

        function edittimetable(button) {
            // Get the URL from the button's data attribute
            var url = button.getAttribute('data-url');

            // Make an AJAX request to fetch the edit data
            $.ajax({
                url: url,
                type: 'GET', // Change to 'GET' since we are fetching data
                success: function(response) {
                    $('#day').val(response.day);
                    $('#starttime').val(response.starttime);
                    $('#starttime_am_pm').val(response.starttime_am_pm);
                    $('#endtime').val(response.endtime);
                    $('#endtime_am_pm').val(response.endtime_am_pm);
                    $('#count').val(response.count);

                    $('#year').val(response.year);
                    $('#type').val(response.type);

                    // Update the form action with the timetable ID
                    $('#formedit').attr('action', '{{ route('admin.timetable.update', '') }}/' + response.id);


                    $('#cancelid').show();
                    $('#editModal').modal('show');
                    $("#updatebutton").text('update');
                    $("#updatebutton").text('update');

                    $('#live-private-modal .modal-content').animate({ scrollTop: 0 }, 'slow');

                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error fetching data:', error);
                    alert('Error fetching data. Please try again.');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {

            @if (session()->has('create_timetable'))

                $('#live-private-modal').modal('show');
            @endif

            @if (session()->has('timeorder'))

                $('#live-private-modal').modal('show');
            @endif

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
    $(document).ready(function() {
        // Apply input mask for format only
        $("#starttime").inputmask("99 : 99", {
            placeholder: "HH : MM",
            oncomplete: function() {
                var startTime = $("#starttime").val();
                var timeParts = startTime.split(" : ");
                var hours = parseInt(timeParts[0], 10);
                var minutes = parseInt(timeParts[1], 10);

                // If hours > 23 or minutes > 59, reset the value
                if (hours > 23 || minutes > 59) {
                    $("#starttime").val(""); // Clear the field if invalid
                }
            }
        });

        $("#endtime").inputmask("99 : 99", {
            placeholder: "HH : MM",
            oncomplete: function() {
                var endTime = $("#endtime").val();
                var timeParts = endTime.split(" : ");
                var hours = parseInt(timeParts[0], 10);
                var minutes = parseInt(timeParts[1], 10);

                // If hours > 23 or minutes > 59, reset the value
                if (hours > 23 || minutes > 59) {
                    $("#endtime").val(""); // Clear the field if invalid
                }
            }
        });
    });
</script>


@endpush
