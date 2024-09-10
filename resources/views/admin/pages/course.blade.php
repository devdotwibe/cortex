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
                    <a class="nav-link @if (old('section') == 'section1' || old('section') == '') active @endif" id="section1-tab"
                        data-bs-toggle="tab" href="#section1" role="tab" aria-controls="section1"
                        aria-selected="@if (old('section') == 'section1' || old('section') == '') true @else false @endif">Section 1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section2') active @endif" id="section2-tab"
                        data-bs-toggle="tab" href="#section2" role="tab" aria-controls="section2"
                        aria-selected="@if (old('section') == 'section2') true @else false @endif">Section 2</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section3') active @endif" id="section3-tab"
                        data-bs-toggle="tab" href="#section3" role="tab" aria-controls="section3"
                        aria-selected="@if (old('section') == 'section3') true @else false @endif">Section 3</a>
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
                                                        <input type="file" class="form-control" name="image">
                                                        @error('image')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Preview Image Container -->
                                        <div class="form-group">
                                            <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer"
                                                style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                                @if (isset($course) && $course->image)
                                                    <img id="imagePreview" src="{{ url('d0/' . $course->image) }}"
                                                        alt="Image Preview" style="width: 100%; height: auto;">
                                                @else
                                                    <img id="imagePreview" src="#" alt="Image Preview"
                                                        style="display: none; width: 100%; height: auto;">
                                                @endif
                                            </div>
                                        </div>








                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-dark" name="section"
                                                    value="save">Save</button>
                                            </div>
                                            {{-- <div class="mb-3">
                                                <button type="button" class="btn btn-btn-secondary" name="section"
                                                    value="cancel">Cancel</button>
                                            </div> --}}
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (old('section') == 'section2') show active @endif" id="section2"
                    role="tabpanel" aria-labelledby="section2-tab">





                    <form action="{{ route('admin.course.section4') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="coursetitle">Course Title</label>
                                <textarea class="form-control texteditor" name="coursetitle" id="coursetitle">{{ old('coursetitle', optional($course)->coursetitle) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="section" value="save">Save</button>
                            </div>
                        </div>
                    </form>





                    <ul class="nav nav-tabs" id="section2Tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab1' || old('sub_section') == '') active @endif" id="tab1-tab"
                                data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
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
                    </ul>

                    <div class="tab-content mt-2" id="section2TabContent">
                        <!-- Tab 1 -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab1' || old('sub_section') == '') show active @endif" id="tab1"
                            role="tabpanel" aria-labelledby="tab1-tab">
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
                                            <label for="logicaltitle2">Logical Title 2</label>
                                            <input type="text" class="form-control" name="logicaltitle2"
                                                value="{{ old('logicaltitle2', optional($course)->logicaltitle2) }}">
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
                                                <img id="logicalImagePreview"
                                                    src="{{ url('d0/' . $course->logicalimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
                                            @else
                                                <img id="logicalImagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
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
                                            <label for="criticaltitle2">Critical Title 2</label>
                                            <input type="text" class="form-control" name="criticaltitle2"
                                                value="{{ old('criticaltitle2', optional($course)->criticaltitle2) }}">
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
                                    <div class="form-group">
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
                                            <label for="abstracttitle2">Abstract Title 2</label>
                                            <input type="text" class="form-control" name="abstracttitle2"
                                                value="{{ old('abstracttitle2', optional($course)->abstracttitle2) }}">
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
                                            <label for="numericaltitle2">Numerical Title 2</label>
                                            <input type="text" class="form-control" name="numericaltitle2"
                                                value="{{ old('numericaltitle2', optional($course)->numericaltitle2) }}">
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
                                    <div class="form-group">
                                        <label for="numericalImagePreview">Image Preview</label>
                                        <div id="numericalImagePreviewContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($course) && $course->numericalimage)
                                                <img id="numericalImagePreview"
                                                    src="{{ url('d0/' . $course->numericalimage) }}" alt="Image Preview"
                                                    style="width: 100%; height: auto;">
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
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if (old('sub_section') == 'tab5') active @endif" id="tab5-tabb"
                                data-bs-toggle="tab" href="#tab55" role="tab" aria-controls="tab5"
                                aria-selected="@if (old('sub_section') == 'tab5') true @else false @endif">Tab 5</a>
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
                                 <div class="form-group">
                                    <label for="learnImagePreview">Image Preview</label>
                                    <div id="learnImagePreviewContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->learnimage)
                                            <img id="learnImagePreview"
                                                src="{{ url('d0/' . $course->learnimage) }}" alt="Image Preview"
                                                style="width: 100%; height: auto;">
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
                                  <div class="form-group">
                                    <label for="questionbankimage">Image Preview</label>
                                    <div id="questionbankContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->questionbankimage)
                                            <img id="questionbankimage"
                                                src="{{ url('d0/' . $course->questionbankimage) }}" alt="Image Preview"
                                                style="width: 100%; height: auto;">
                                        @else
                                            <img id="questionbankImagePreview" src="#" alt="Image Preview"
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
                                  <div class="form-group">
                                    <label for="topicImagePreview">Image Preview</label>
                                    <div id="topicImagePreviewContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->topicimage)
                                            <img id="topicImagePreview"
                                                src="{{ url('d0/' . $course->topicimage) }}" alt="Image Preview"
                                                style="width: 100%; height: auto;">
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
                                  <div class="form-group">
                                    <label for="fullmockImagePreview">Image Preview</label>
                                    <div id="fullmockPreviewContainer"
                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                        @if (isset($course) && $course->fullmockimage)
                                            <img id="fullmockImagePreview"
                                                src="{{ url('d0/' . $course->fullmockimage) }}" alt="Image Preview"
                                                style="width: 100%; height: auto;">
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

                        <!-- Tab 5: Private Content & Image -->
                        <div class="tab-pane fade @if (old('sub_section') == 'tab5') show active @endif" id="tab55"
                            role="tabpanel" aria-labelledby="tab5-tabb">
                            <form action="{{ route('admin.course.section3.tab5.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="privatecontent">Private Content</label>
                                            <textarea class="form-control texteditor" name="privatecontent" id="privatecontent">{{ old('privatecontent', optional($course)->privatecontent) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
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
                                </div>
                                <button type="submit" class="btn btn-dark" name="sub_section"
                                    value="tab5_save">Save</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>



        @endsection

        @push('footer-script')
            <script>
                CKEDITOR.replaceAll('texteditor');
            </script>


            <script>
            @endpush
