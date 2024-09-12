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
                    <a class="nav-link @if ((old('section') == 'section1' || old('section') == '') && session('tab_1') != true) active @endif" id="section1-tab"
                        data-bs-toggle="tab" href="#section1" role="tab" aria-controls="section1"
                        aria-selected="@if (old('section') == 'section1' || old('section') == '') true @else false @endif">Section 1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section2') active @endif @if (session('tab_1') == true) show active @else @endif "
                        id="section2-tab" data-bs-toggle="tab" href="#section2" role="tab" aria-controls="section2"
                        aria-selected="@if (old('section') == 'section2') true @else false @endif">Section 2</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section3') active @endif" id="section3-tab"
                        data-bs-toggle="tab" href="#section3" role="tab" aria-controls="section3"
                        aria-selected="@if (old('section') == 'section3') true @else false @endif">Section 3</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section5') active @endif" id="section5-tab"
                        data-bs-toggle="tab" href="#section5" role="tab" aria-controls="section5"
                        aria-selected="@if (old('section') == 'section5') true @else false @endif">Section 4</a>
                </li>


            </ul>


            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade  @if (old('section', 'save') == 'save') show active @endif" id="section1"
                    role="tabpanel" aria-labelledby="section1-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course.section1') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">




                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="heading">Course Banner Title</label>
                                                        <textarea class="form-control texteditor" name="heading" id="heading">{{ old('heading', optional($course)->heading) }}</textarea>
                                                        @error('heading')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="learn_btn_label">Learn Button Label</label>
                                                        <input type="text" class="form-control" name="buttonlabel"
                                                            value="{{ old('buttonlabel', optional($course)->buttonlabel) }}">
                                                        @error('buttonlabel')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="learn_btn_link">Learn Button Link</label>
                                                        <input type="text" class="form-control" name="buttonlink"
                                                            value="{{ old('buttonlink', optional($course)->buttonlink) }}">
                                                        @error('buttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="image">Image</label>
                                                        <input type="file" class="form-control" name="image"
                                                            id="imageInput" onchange="previewImage()">
                                                        @error('image')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer"
                                                style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                                @if (isset($course) && $course->image)
                                                    <img id="imagePreview-save" src="{{ url('d0/' . $course->image) }}"
                                                        alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" onclick="removeImage(this)"
                                                        value="{{ $course->id }}" class="btn btn-danger"
                                                        style="float: right;">X</button>
                                                @endif
                                                    <img id="imagePreview" src="#" alt="Image Preview"
                                                        style="display: none; width: 100%; height: auto;">

                                            </div>
                                        </div>




                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-dark" name="section"
                                                    value="save">Save</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (old('section') == 'section2') show active @endif @if (session('tab_1') == true) show active @else @endif "
                    id="section2" role="tabpanel" aria-labelledby="section2-tab">





                    <form action="{{ route('admin.course.section5') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="coursetitle">Course Title</label>
                                <textarea class="form-control texteditor" name="coursetitle" id="coursetitle">{{ old('coursetitle', optional($course)->coursetitle) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="section"
                                    value="save">Save</button>
                            </div>
                        </div>
                    </form>





                    {{-- <ul class="nav nav-tabs" id="section2Tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab1' || old('sub_section') == '') active @endif @if (session('tab_1') == true) active @else @endif "
                                id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                                aria-selected="@if (old('sub_section') == 'tab1' || old('sub_section') == '') true @else false @endif">Tab 1</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab2') active @endif" id="tab2-tab"
                                data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2"
                                aria-selected="@if (old('sub_section') == 'tab2') true @else false @endif">Tab 2</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab3') active @endif" id="tab3-tab"
                                data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3"
                                aria-selected="@if (old('sub_section') == 'tab3') true @else false @endif">Tab 3</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab4') active @endif" id="tab4-tab"
                                data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4"
                                aria-selected="@if (old('sub_section') == 'tab4') true @else false @endif">Tab 4</a>
                        </li>
                    </ul> --}}

                    @php

                        $tabs = [
                                ['id' => 'tab1', 'name' => 'Tab 1'],
                                ['id' => 'tab2', 'name' => 'Tab 2'],
                                ['id' => 'tab3', 'name' => 'Tab 3'],
                                ['id' => 'tab4', 'name' => 'Tab 4']
                            ];

                    @endphp

                    <ul class="nav nav-tabs" id="section2Tabs" role="tablist">
                        @foreach($tabs as $tab)
                            <li class="nav-item" role="presentation" data-tab-id="{{ $tab['id'] }}">
                                <a class="nav-link @if (old('sub_section') == $tab['id']) active @endif" 
                                   id="{{ $tab['id'] }}-tab" 
                                   data-bs-toggle="tab" 
                                   href="#{{ $tab['id'] }}" 
                                   role="tab" 
                                   aria-controls="{{ $tab['id'] }}" 
                                   aria-selected="@if (old('sub_section') == $tab['id']) true @else false @endif">
                                    {{ $tab['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    

                    <div class="tab-content mt-2" id="section2TabContent">
                        <!-- Tab 1 -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab1' || old('sub_section') == '') show active @endif @if (session('tab_1') == true) show active @else @endif "
                            id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                            <form action="{{ route('admin.course.tab1.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf





                                <div class="row">



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="logicaltitle1">Logical Title 1</label>
                                            <input type="text" class="form-control" name="logicaltitle1"
                                                value="{{ old('logicaltitle1', optional($course)->logicaltitle1) }}">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="logicalcontent">Logical Content</label>
                                            <textarea class="form-control texteditor" name="logicalcontent" id="logicalcontent">{{ old('logicalcontent', optional($course)->logicalcontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="logicalimage">Logical Image</label>
                                            <input type="file" class="form-control" name="logicalimage">
                                        </div>
                                    </div>









                                    <!-- Preview Image Container -->
                                    <div class="form-group">
                                        <label for="logicalImagePreview">Image Preview</label>
                                        <div id="logicalImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->logicalimage)
                                                <img id="logicalImagePreview-save"
                                                    src="{{ url('d0/' . $course->logicalimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" onclick="removeLogicalImage(this)"
                                                    value="{{ $course->id }}" class="btn btn-danger"
                                                    style="float: right;">X</button>
                                                    @endif
                                                <img id="logicalImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">

                                        </div>
                                    </div>



                                </div>
                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab1_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 2 -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab2') show active @endif" id="tab2"
                            role="tabpanel" aria-labelledby="tab2-tab">
                            <form action="{{ route('admin.course.tab2.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="criticaltitle1">Critical Title 1</label>
                                            <input type="text" class="form-control" name="criticaltitle1"
                                                value="{{ old('criticaltitle1', optional($course)->criticaltitle1) }}">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="criticalcontent">Critical Content</label>
                                            <textarea class="form-control texteditor" name="criticalcontent" id="criticalcontent">{{ old('criticalcontent', optional($course)->criticalcontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="criticalimage">Critical Image</label>
                                            <input type="file" class="form-control" name="criticalimage">
                                        </div>
                                    </div>

                                    <!-- Preview Image Container -->
                                    {{-- <div class="form-group">
                                        <label for="criticalImagePreview">Image Preview</label>
                                        <div id="criticalImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->criticalimage)
                                                <img id="criticalImagePreview"
                                                    src="{{ url('d0/' . $course->criticalimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                            @else
                                                <img id="criticalImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
                                        </div>
                                    </div> --}}

                                    <!-- Preview Image Container -->
                                    <div class="form-group">
                                        <label for="criticalImagePreview">Image Preview</label>
                                        <div id="criticalImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->criticalimage)
                                                <img id="criticalImagePreview"
                                                    src="{{ url('d0/' . $course->criticalimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" onclick="removeCriticalImage(this)"
                                                    value="{{ $course->id }}" class="btn btn-danger"
                                                    style="float: right;">X</button>
                                            @else
                                                <img id="criticalImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
                                        </div>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab2_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 3 -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab3') show active @endif" id="tab3"
                            role="tabpanel" aria-labelledby="tab3-tab">
                            <form action="{{ route('admin.course.tab3.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="abstracttitle1">Abstract Title 1</label>
                                            <input type="text" class="form-control" name="abstracttitle1"
                                                value="{{ old('abstracttitle1', optional($course)->abstracttitle1) }}">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="abstractcontent">Abstract Content</label>
                                            <textarea class="form-control texteditor" name="abstractcontent" id="abstractcontent">{{ old('abstractcontent', optional($course)->abstractcontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="abstractimage">Abstract Image</label>
                                            <input type="file" class="form-control" name="abstractimage">
                                        </div>
                                    </div>

                                    <!-- Preview Image Container -->
                                    <div class="form-group">
                                        <label for="abstractImagePreview">Image Preview</label>
                                        <div id="abstractImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->abstractimage)
                                                <img id="abstractImagePreview"
                                                    src="{{ url('d0/' . $course->abstractimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" onclick="removeAbstractImage(this)"
                                                    value="{{ $course->id }}" class="btn btn-danger"
                                                    style="float: right;">X</button>
                                            @else
                                                <img id="abstractImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
                                        </div>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab3_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 4 -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab4') show active @endif" id="tab4"
                            role="tabpanel" aria-labelledby="tab4-tab">
                            <form action="{{ route('admin.course.tab4.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="numericaltitle1">Numerical Title 1</label>
                                            <input type="text" class="form-control" name="numericaltitle1"
                                                value="{{ old('numericaltitle1', optional($course)->numericaltitle1) }}">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="numericalcontent">Numerical Content</label>
                                            <textarea class="form-control texteditor" name="numericalcontent" id="numericalcontent">{{ old('numericalcontent', optional($course)->numericalcontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="numericalimage">Numerical Image</label>
                                            <input type="file" class="form-control" name="numericalimage">
                                        </div>
                                    </div>

                                    <!-- Preview Image Container -->
                                    <!-- Preview Image Container -->
                                    <div class="form-group">
                                        <label for="numericalImagePreview">Image Preview</label>
                                        <div id="numericalImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->numericalimage)
                                                <img id="numericalImagePreview"
                                                    src="{{ url('d0/' . $course->numericalimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" onclick="removeNumericalImage(this)"
                                                    value="{{ $course->id }}" class="btn btn-danger"
                                                    style="float: right;">X</button>
                                            @else
                                                <img id="numericalImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
                                        </div>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab4_save">Save</button>
                            </form>
                        </div>

                    </div>
                </div>






                <div class="tab-pane fade @if (old('section') == 'section3') show active @endif" id="section3"
                    role="tabpanel" aria-labelledby="section3-tab">
                    <ul class="nav nav-tabs" id="section3Tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab1' || old('sub_section') == '') active @endif" id="tab1-tabb"
                                data-bs-toggle="tab" href="#tab11" role="tab" aria-controls="tab1"
                                aria-selected="@if (old('sub_section') == 'tab1' || old('sub_section') == '') true @else false @endif">Tab 1</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab2') active @endif" id="tab2-tabb"
                                data-bs-toggle="tab" href="#tab22" role="tab" aria-controls="tab2"
                                aria-selected="@if (old('sub_section') == 'tab2') true @else false @endif">Tab 2</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab3') active @endif" id="tab3-tabb"
                                data-bs-toggle="tab" href="#tab33" role="tab" aria-controls="tab3"
                                aria-selected="@if (old('sub_section') == 'tab3') true @else false @endif">Tab 3</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab4') active @endif" id="tab4-tabb"
                                data-bs-toggle="tab" href="#tab44" role="tab" aria-controls="tab4"
                                aria-selected="@if (old('sub_section') == 'tab4') true @else false @endif">Tab 4</a>
                        </li>

                    </ul>

                    <div class="tab-content mt-2" id="section3TabContent">
                        <!-- Tab 1: Learn Content & Learn Image -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab1' || old('sub_section') == '') show active @endif" id="tab11"
                            role="tabpanel" aria-labelledby="tab1-tabb">
                            <form action="{{ route('admin.course.section3.tab1.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="learncontent">Learn Content</label>
                                            <textarea class="form-control texteditor" name="learncontent" id="learncontent">{{ old('learncontent', optional($course)->learncontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="learnimage">Learn Image</label>
                                            <input type="file" class="form-control" name="learnimage">
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Image Container -->
                                <!-- Preview Image Container -->
                                <div class="form-group">
                                    <label for="learnImagePreview">Image Preview</label>
                                    <div id="learnImagePreviewContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->learnimage)
                                            <img id="learnImagePreview" src="{{ url('d0/' . $course->learnimage) }}"
                                                alt="Image Preview" style="width: 100%; height: auto;">
                                            <button type="button" onclick="removeLearnImage(this)"
                                                value="{{ $course->id }}" class="btn btn-danger"
                                                style="float: right;">X</button>
                                        @else
                                            <img id="learnImagePreview" src="#" alt="Image Preview"
                                                style="display: none; width: 100%; height: auto;">
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab1_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 2: Question Bank Content & Image -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab2') show active @endif" id="tab22"
                            role="tabpanel" aria-labelledby="tab2-tabb">
                            <form action="{{ route('admin.course.section3.tab2.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="questionbankcontent">Question Bank Content</label>
                                            <textarea class="form-control texteditor" name="questionbankcontent" id="questionbankcontent">{{ old('questionbankcontent', optional($course)->questionbankcontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="questionbankimage">Question Bank Image</label>
                                            <input type="file" class="form-control" name="questionbankimage">
                                        </div>
                                    </div>
                                </div>
                                <!-- Preview Image Container -->
                                <!-- Preview Image Container -->
                                <div class="form-group">
                                    <label for="questionbankimage">Image Preview</label>
                                    <div id="questionbankContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->questionbankimage)
                                            <img id="questionbankimage"
                                                src="{{ url('d0/' . $course->questionbankimage) }}" alt="Image Preview"
                                                style="width: 100%; height: auto;">
                                            <button type="button" onclick="removeQuestionBankImage(this)"
                                                value="{{ $course->id }}" class="btn btn-danger"
                                                style="float: right;">X</button>
                                        @else
                                            <img id="questionbankimage" src="#" alt="Image Preview"
                                                style="display: none; width: 100%; height: auto;">
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab2_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 3: Topic Content & Image -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab3') show active @endif" id="tab33"
                            role="tabpanel" aria-labelledby="tab3-tabb">
                            <form action="{{ route('admin.course.section3.tab3.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="topiccontent">Topic Content</label>
                                            <textarea class="form-control texteditor" name="topiccontent" id="topiccontent">{{ old('topiccontent', optional($course)->topiccontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="topicimage">Topic Image</label>
                                            <input type="file" class="form-control" name="topicimage">
                                        </div>
                                    </div>
                                </div>
                                <!-- Preview Image Container -->
                                <!-- Preview Image Container -->
                                <div class="form-group">
                                    <label for="topicImagePreview">Image Preview</label>
                                    <div id="topicImagePreviewContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->topicimage)
                                            <img id="topicImagePreview" src="{{ url('d0/' . $course->topicimage) }}"
                                                alt="Image Preview" style="width: 100%; height: auto;">
                                            <button type="button" onclick="removeTopicImage(this)"
                                                value="{{ $course->id }}" class="btn btn-danger"
                                                style="float: right;">X</button>
                                        @else
                                            <img id="topicImagePreview" src="#" alt="Image Preview"
                                                style="display: none; width: 100%; height: auto;">
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab3_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 4: Full Mock Content & Image -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab4') show active @endif" id="tab44"
                            role="tabpanel" aria-labelledby="tab4-tabb">
                            <form action="{{ route('admin.course.section3.tab4.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fullmockcontent">Full Mock Content</label>
                                            <textarea class="form-control texteditor" name="fullmockcontent" id="fullmockcontent">{{ old('fullmockcontent', optional($course)->fullmockcontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fullmockimage">Full Mock Image</label>
                                            <input type="file" class="form-control" name="fullmockimage">
                                        </div>
                                    </div>
                                </div>
                                <!-- Preview Image Container -->
                                <!-- Preview Image Container -->
                                <div class="form-group">
                                    <label for="fullmockImagePreview">Image Preview</label>
                                    <div id="fullmockPreviewContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->fullmockimage)
                                            <img id="fullmockImagePreview"
                                                src="{{ url('d0/' . $course->fullmockimage) }}" alt="Image Preview"
                                                style="width: 100%; height: auto;">
                                            <button type="button" onclick="removeFullmockImage(this)"
                                                value="{{ $course->id }}" class="btn btn-danger"
                                                style="float: right;">X</button>
                                        @else
                                            <img id="fullmockImagePreview" src="#" alt="Image Preview"
                                                style="display: none; width: 100%; height: auto;">
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab4_save">Save</button>
                            </form>
                        </div>



                        </form>
                    </div>
                </div>




                <div class="tab-pane fade  @if (old('section', 'save') == 'save1') show active @endif" id="section5"
                    role="tabpanel" aria-labelledby="section5-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course.section5') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">




                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="privatecontent">Private Content</label>
                                                        <textarea class="form-control texteditor" name="privatecontent" id="privatecontent">{{ old('privatecontent', optional($course)->privatecontent) }}</textarea>
                                                        @error('privatecontent')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="privateimage">Private Image</label>
                                                <input type="file" class="form-control" name="privateimage">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Preview Image Container -->
                                    <div class="form-group">
                                        <label for="privateImagePreview">Image Preview</label>
                                        <div id="privateImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->privateimage)
                                                <img id="privateImagePreview"
                                                    src="{{ url('d0/' . $course->privateimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                            @else
                                                <img id="privateImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
                                        </div>
                                    </div> --}}


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="privateimage">Private Image</label>
                                                <input type="file" class="form-control" name="privateimage">
                                            </div>
                                        </div>

                                        <!-- Preview Image Container -->
                                        <div class="form-group">
                                            <label for="privateImagePreview">Image Preview</label>
                                            <div id="privateImagePreviewContainer"
                                                style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                                @if (isset($course) && $course->privateimage)
                                                    <img id="privateImagePreview"
                                                        src="{{ url('d0/' . $course->privateimage) }}"
                                                        alt="Image Preview" style="width: 100%; height: auto;">
                                                    <!-- Delete button for Private Image -->
                                                    <button type="button" onclick="removePrivateImage(this)"
                                                        value="{{ $course->id }}" class="btn btn-danger"
                                                        style="float: right;">X</button>
                                                @else
                                                    <img id="privateImagePreview" src="#" alt="Image Preview"
                                                        style="display: none; width: 100%; height: auto;">
                                                @endif
                                            </div>
                                        </div>





                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-dark" name="section5"
                                                    value="save">Save</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
    </section>






@endsection

@push('footer-script')


    <script>
        CKEDITOR.replaceAll('texteditor');




        function removeImage(button) {

            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteImage') }}'; // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('imagePreview-save').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>




    <script>
        function removePrivateImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deletePrivateImage', ':id') }}'.replace(':id',
                courseId); // Construct the URL

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('privateImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Private image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Private image could not be deleted. Please try again.');
                }
            });
        }
    </script>


    <script>
        function removeLogicalImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteLogicalImage') }}'; // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('logicalImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>


    <script>
        function removeCriticalImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteCriticalImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('criticalImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>


    <script>
        function removeAbstractImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteAbstractImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('abstractImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>



    <script>
        function removeNumericalImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteNumericalImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('numericalImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>

    <script>
        function removeLearnImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteLearnImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('learnImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>


    <script>
        function removeQuestionBankImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteQuestionBankImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('questionbankimage').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>

    <script>
        function removeTopicImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteTopicImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('topicImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>


    <script>
        function removeFullmockImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteFullmockImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the image and button after successful deletion
                        document.getElementById('fullmockImagePreview').style.display = 'none';
                        button.style.display = 'none';
                    } else {
                        alert('Image could not be deleted. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Image could not be deleted. Please try again.');
                }
            });
        }
    </script>


<script>
    function previewImage() {


        const file = document.getElementById('imageInput').files[0];
        const imagePreview = document.getElementById('imagePreview');

        const savedimage = document.getElementById('imagePreview-save');

        const reader = new FileReader();

        reader.onloadend = function() {
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
            savedimage.style.display = 'none';
        }

        if (file) {
            reader.readAsDataURL(file); // Converts image to base64 string
        } else {

            imagePreview.src = "#";
            imagePreview.style.display = 'none';
            savedimage.style.display = 'block';
        }
    }

    </script>




<script>
    function previewImage1() {


        const file = document.getElementById('imageInput').files[0];
        const imagePreview = document.getElementById('logicalImagePreview');

        const savedimage = document.getElementById('logicalImagePreview-save');

        const reader = new FileReader();

        reader.onloadend = function() {
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
            savedimage.style.display = 'none';
        }

        if (file) {
            reader.readAsDataURL(file); // Converts image to base64 string
        } else {

            imagePreview.src = "#";
            imagePreview.style.display = 'none';
            savedimage.style.display = 'block';
        }
    }

    </script>


@endpush
