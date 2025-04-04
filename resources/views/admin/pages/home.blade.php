@extends('layouts.admin')

@section('title', 'Home')

@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Home</h2>
            </div>
        </div>
    </section>

    <section class="invite-wrap mt-2">
        <div class="container">



            <!-- Tabs Navigation -->
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
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section8') active @endif" id="section8-tab"
                        data-bs-toggle="tab" href="#section8" role="tab" aria-controls="section8"
                        aria-selected="@if (old('section') == 'section8') true @else false @endif">Section 4</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section7') active @endif" id="section7-tab"
                        data-bs-toggle="tab" href="#section7" role="tab" aria-controls="section7"
                        aria-selected="@if (old('section') == 'section7') true @else false @endif">Section 5</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section4') active @endif" id="section4-tab"
                        data-bs-toggle="tab" href="#section4" role="tab" aria-controls="section4"
                        aria-selected="@if (old('section') == 'section4') true @else false @endif">Section 6</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section6') active @endif" id="section6-tab"
                        data-bs-toggle="tab" href="#section6" role="tab" aria-controls="section6"
                        aria-selected="@if (old('section') == 'section6') true @else false @endif">Section 7</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (old('section') == 'section5') active @endif" id="section5-tab"
                        data-bs-toggle="tab" href="#section5" role="tab" aria-controls="section5"
                        aria-selected="@if (old('section') == 'section5') true @else false @endif">Section 8</a>
                </li>




            </ul>



            <!-- Tabs Content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade  @if (old('section', 'save') == 'save') show active @endif" id="section1"
                    role="tabpanel" aria-labelledby="section1-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="section1">
                                            <!-- First Section Fields -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="title">Title</label>
                                                            <input type="text" name="title1" id="title"
                                                                value="{{ old('title', optional($banner)->title) }}"
                                                                class="form-control" placeholder="Title">
                                                            @error('title')
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
                                                            <label for="subtitle">Subtitle*</label>
                                                            <input type="text" name="subtitle" id="subtitle"
                                                                value="{{ old('subtitle', optional($banner)->subtitle) }}"
                                                                class="form-control" placeholder="Subtitle">
                                                            @error('subtitle')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 video_section">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="buttonlabel">Button Label*</label>
                                                            <input type="text" name="buttonlabel" id="buttonlabel"
                                                                value="{{ old('buttonlabel', optional($banner)->buttonlabel) }}"
                                                                class="form-control" placeholder="Button Label">
                                                            @error('buttonlabel')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 video_section">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="buttonlink">Button Link*</label>
                                                            <input type="text" name="buttonlink" id="buttonlink"
                                                                value="{{ old('buttonlink', optional($banner)->buttonlink) }}"
                                                                class="form-control" placeholder="Button Link">
                                                            @error('buttonlink')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Save Button -->
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-dark banner" name="section"
                                                        value="save">Save</button>
                                                </div>
                                            </div>


                                        </div>
                                        <div class=sec1>
                                            <div class="col-md-12 note_section">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="content">Content*</label>
                                                            <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', optional($banner)->content) }}</textarea>
                                                            @error('content')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="pricesection1 numericalsectionclass">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-data">
                                                            <div class="forms-inputs mb-4">
                                                                <label for="image" class="file-upload">Upload Image
                                                                    <br>
                                                                    <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                        alt="Upload Icon">
                                                                </label>
                                                                <input type="file" name="image" id="image"
                                                                    class="form-control" style="display: none;"
                                                                    onchange="previewImage(event, 'imagePreview')">
                                                                @error('image')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group" id="imgid1"
                                                    style="{{ isset($banner) && $banner->image ? '' : 'display: none;' }}">
                                                    <label for="imagePreview">Image Preview</label>
                                                    <div id="imagePreviewContainer" class="numericalclass"
                                                        style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px; position: relative;">
                                                        <img id="imagePreview"
                                                            src="{{ isset($banner) && $banner->image ? url('d0/' . $banner->image) : '' }}"
                                                            alt="Image Preview"
                                                            style="width: 100%; height: auto; display: {{ isset($banner) && $banner->image ? 'block' : 'none' }};">

                                                        <!-- Delete button for preview (before saving) -->
                                                        <button type="button" class="btn btn-danger" id="deleteicon"
                                                            style="position: absolute; top: 5px; right: 5px; display: none;"
                                                            onclick="removeImagePreview()">X</button>


                                                        <!-- Delete button for saved image -->
                                                        <button type="button" class="btn btn-danger" id="icondelete"
                                                            style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->image ? 'display: block;' : 'display: none;' }}"
                                                            onclick="removeImage()">X</button>

                                                    </div>
                                                </div>
                                            </div>










                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (old('section') == 'section2') show active @endif" id="section2"
                    role="tabpanel" aria-labelledby="section2-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section2') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div clas="first">
                                            <!-- Second Section Fields -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="guaranteetitle">Guarantee Title*</label>
                                                            <input type="text" name="guaranteetitle"
                                                                id="guaranteetitle"
                                                                value="{{ old('guaranteetitle', optional($banner)->guaranteetitle) }}"
                                                                class="form-control" placeholder="Guarantee Title">
                                                            @error('guaranteetitle')
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
                                                            <label for="learntitle">Learn Title*</label>
                                                            <input type="text" name="learntitle" id="learntitle"
                                                                value="{{ old('learntitle', optional($banner)->learntitle) }}"
                                                                class="form-control" placeholder="Learn Title">
                                                            @error('learntitle')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sec numericalsectionclass">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="learnimage" class="file-upload">Learn Image <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon">
                                                            </label>
                                                            <input type="file" name="learnimage" id="learnimage"
                                                                value="{{ old('learnimage', optional($banner)->learnimage) }}"
                                                                class="form-control" style="display: none;"
                                                                onchange="previewImage(event, 'learnImagePreview',this)"
                                                                data-id="imgid2">
                                                            @error('learnimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Preview Learn Image Container -->
                                            <div class="form-group imgid2" id="imgid2"
                                                style="{{ isset($banner) && $banner->learnimage ? '' : 'display: none;' }}">
                                                <label for="learnImagePreview">Learn Image Preview</label>
                                                <div id="learnImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">

                                                    <!-- Image Preview -->
                                                    <img id="learnImagePreview"
                                                        src="{{ isset($banner) && $banner->learnimage ? url('d0/' . $banner->learnimage) : '' }}"
                                                        alt="Learn Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->learnimage ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid2" id="deleteicon2"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeLearnImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete2"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->learnimage ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeLearnImage()">X</button>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="learncontent">Learn Content*</label>
                                                        <textarea name="learncontent" id="learncontent" class="form-control" rows="5">{{ old('learncontent', optional($banner)->learncontent) }}</textarea>
                                                        @error('learncontent')
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
                                                        <label for="practisetitle">Practice Title*</label>
                                                        <input type="text" name="practisetitle" id="practisetitle"
                                                            value="{{ old('practisetitle', optional($banner)->practisetitle) }}"
                                                            class="form-control" placeholder="Practice Title">
                                                        @error('practisetitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricesection1 numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="practiseimage" class="file-upload">Practice Image
                                                                <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon">
                                                            </label>
                                                            <input type="file" name="practiseimage" id="practiseimage"
                                                                value="{{ old('practiseimage', optional($banner)->practiseimage) }}"
                                                                class="form-control" style="display: none;"
                                                                onchange="previewImage(event, 'practiseImagePreview', this)"
                                                                data-id="imgid3">
                                                            @error('practiseimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview Practice Image Container -->
                                            <div class="form-group imgid3" id="imgid3"
                                                style="{{ isset($banner) && $banner->practiseimage ? '' : 'display: none;' }}">
                                                <label for="practiseImagePreview">Practice Image Preview</label>
                                                <div id="imagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="practiseImagePreview"
                                                        src="{{ isset($banner) && $banner->practiseimage ? url('d0/' . $banner->practiseimage) : '' }}"
                                                        alt="Practice Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->practiseimage ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid3" id="deleteicon3"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removePractiseImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete3"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->practiseimage ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removePractiseImage()">X</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="practisecontent">Practice Content*</label>
                                                        <textarea name="practisecontent" id="practisecontent" class="form-control" rows="5">{{ old('practisecontent', optional($banner)->practisecontent) }}</textarea>
                                                        @error('practisecontent')
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
                                                        <label for="preparetitle">Prepare Title*</label>
                                                        <input type="text" name="preparetitle" id="preparetitle"
                                                            value="{{ old('preparetitle', optional($banner)->preparetitle) }}"
                                                            class="form-control" placeholder="Prepare Title">
                                                        @error('preparetitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sec numericalsectionclass">


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="prepareimage" class="file-upload">Prepare Image
                                                                <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon">
                                                            </label>
                                                            <input type="file" name="prepareimage" id="prepareimage"
                                                                value="{{ old('prepareimage', optional($banner)->prepareimage) }}"
                                                                class="form-control" style="display: none;"
                                                                onchange="previewImage(event, 'prepareImagePreview', this)"data-id="imgid4">
                                                            @error('prepareimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview Prepare Image Container -->
                                            <div class="form-group imgid4" id="imgid4"
                                                style="{{ isset($banner) && $banner->prepareimage ? '' : 'display: none;' }}">
                                                <label for="prepareImagePreview">Prepare Image Preview</label>
                                                <div id="prepareImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="prepareImagePreview"
                                                        src="{{ isset($banner) && $banner->prepareimage ? url('d0/' . $banner->prepareimage) : '' }}"
                                                        alt="Prepare Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->prepareimage ? 'block' : 'none' }};">
                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid4" id="deleteicon4"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removePrepareImagePreview()">X</button>
                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete4"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->prepareimage ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removePrepareImage()">X</button>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="preparecontent">Prepare Content*</label>
                                                        <textarea name="preparecontent" id="preparecontent" class="form-control" rows="5">{{ old('preparecontent', optional($banner)->preparecontent) }}</textarea>
                                                        @error('preparecontent')
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
                                                        <label for="reviewtitle">Review Title*</label>
                                                        <input type="text" name="reviewtitle" id="reviewtitle"
                                                            value="{{ old('reviewtitle', optional($banner)->reviewtitle) }}"
                                                            class="form-control" placeholder="Review Title">
                                                        @error('reviewtitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sec numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="reviewimage" class="file-upload">Review Image <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon">
                                                            </label>
                                                            <input type="file" name="reviewimage" id="reviewimage"
                                                                value="{{ old('reviewimage', optional($banner)->reviewimage) }}"
                                                                class="form-control" style="display: none;"
                                                                onchange="previewReviewImage(event, 'reviewImagePreview', this)"
                                                                data-id="imgid5">
                                                            @error('reviewimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview Review Image Container -->
                                            <div class="form-group imgid5" id="imgid5"
                                                style="{{ isset($banner) && $banner->reviewimage ? '' : 'display: none;' }}">
                                                <label for="reviewImagePreview">Review Image Preview</label>
                                                <div id="reviewImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="reviewImagePreview"
                                                        src="{{ isset($banner) && $banner->reviewimage ? url('d0/' . $banner->reviewimage) : '' }}"
                                                        alt="Review Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->reviewimage ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid5" id="deleteicon5"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeReviewImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete5"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->reviewimage ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeReviewImage()">X</button>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="reviewcontent">Review Content*</label>
                                                        <textarea name="reviewcontent" id="reviewcontent" class="form-control" rows="5">{{ old('reviewcontent', optional($banner)->reviewcontent) }}</textarea>
                                                        @error('reviewcontent')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>






                                        <!-- Submit Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary review" name="section"
                                                value="section2">Save</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="tab-pane fade @if (old('section') == 'section3') show active @endif" id="section3"
                    role="tabpanel" aria-labelledby="section3-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section3') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">

                                                        <label for="ourfeaturestitle">Feature Title*</label>
                                                        <input type="text" name="ourfeaturestitle"
                                                            class="form-control"
                                                            value="{{ old('ourfeaturestitle', optional($banner)->ourfeaturestitle) }}"
                                                            placeholder="Feature Title">
                                                        @error('ourfeaturestitle')
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
                                                        <label for="FeatureHeading">Feature Top Heading*</label>
                                                        <input type="text" name="FeatureHeading" class="form-control"
                                                            value="{{ old('FeatureHeading', optional($banner)->FeatureHeading) }}"
                                                            placeholder="Feature Top Heading">
                                                        @error('FeatureHeading')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @php

                                            $feature = [];

                                            if (count(old('featuresubtitleupdate', [])) > 0) {
                                                $feature = old('featuresubtitleupdate', []);
                                            }

                                            if (count(old('featurecontentupdate', [])) > 0) {
                                                $feature = old('featurecontentupdate', []);
                                            }

                                            if (count(old('featureimageupdate', [])) > 0) {
                                                $feature = old('featureimageupdate', []);
                                            }

                                        @endphp

                                        @if (count($feature) > 0 && isset($feature))

                                            @foreach ($feature as $k => $item)
                                                <div class="outer-feature" id="close-{{ $k }}">



                                                    <!-- Feature Subtitle -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="featuresubtitle">Feature Heading*</label>
                                                                    <input type="text" name="featuresubtitleupdate[]"
                                                                        class="form-control" placeholder="Feature Heading"
                                                                        value="{{ old('featuresubtitleupdate.' . $k) }}">
                                                                    @error('featuresubtitleupdate.' . $k)
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
                                                                    <label for="featurecontent">Feature Description*</label>
                                                                    <textarea name="featurecontentupdate[]" class="form-control" rows="5" placeholder="Feature Description">{{ old('featurecontentupdate.' . $k) }}</textarea>
                                                                    @error('featurecontentupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>






                                                    <!-- Feature Image -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="featureimage" class="file-upload">Feature
                                                                        Image <br>
                                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                            alt="Upload Icon"> </label>
                                                                    <input type="hidden" name="featureids[]"
                                                                        value="{{ old('featureids.' . $k, $item->id ?? '') }}">
                                                                    <input type="file" name="featureimageupdate[]"
                                                                        class="form-control" style="display: none;"
                                                                        onchange="previewFeatureImage(event)">

                                                                    @if (!empty($item->image))
                                                                        <img src="{{ asset('path/to/images/' . $item->image) }}"
                                                                            alt="Feature Image"
                                                                            style="max-width: 100px; margin-top: 10px;"
                                                                            id="imagePreview_{{ $k }}">
                                                                    @else
                                                                        <img src="#" alt="Feature Image"
                                                                            style="max-width: 100px; margin-top: 10px; display: none;"
                                                                            id="imagePreview_{{ $k }}">
                                                                    @endif

                                                                    @error('featureimageupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeDiv(this, 'close-{{ $k }}')"
                                                        data-feature-id="{{ $k }}">X</button>

                                                </div>
                                            @endforeach
                                        @elseif(!empty($features) && count($features) > 0)
                                            @foreach ($features as $k => $item)
                                                <div class="outer-feature" id="close-{{ $item->id }}{{ $k == 0 ? '-dele' : '' }}">

                                                    <!-- Feature Subtitle -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="featuresubtitle">Feature Heading*</label>
                                                                    <input type="text" name="featuresubtitleupdate[]"
                                                                        class="form-control" placeholder="Feature Heading"
                                                                        value="{{ $item->featuresubtitle }}">
                                                                    @error('featuresubtitle')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Feature Content -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="featurecontent">Feature
                                                                        Description*</label>
                                                                    <textarea name="featurecontentupdate[]" class="form-control" rows="5" placeholder="Feature Description">{{ $item->featurecontent }}</textarea>
                                                                    @error('featurecontent')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Feature Image -->
                                                    {{-- <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-data">
                                                            <div class="forms-inputs mb-4">
                                                                <label for="featureimage-{{ $item->id }}"
                                                                    class="file-upload">Feature Image <br>
                                                                    <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                        alt="Upload Icon">
                                                                </label>
                                                                <input type="hidden" name="featureids[]"
                                                                    value="{{ $item->id }}">
                                                                <input type="file"
                                                                    id="featureimage-{{ $item->id }}"
                                                                    name="featureimageupdate[]" class="form-control"
                                                                    style="display: none;"
                                                                    onchange="previewFeatureImage(event)">
                                                                @if (!empty($item->image))
                                                                    <img src="{{ url('d0/' . $item->image) }}"
                                                                        alt="Feature Image"
                                                                        style="max-width: 100px; margin-top: 10px;">
                                                                @endif
                                                                @error('featureimage')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}


                                                    <div class="col-md-12 numericalsectionclass">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="featureimage-{{ $item->id }}"
                                                                        class="file-upload">
                                                                        Feature Image <br>
                                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                            alt="Upload Icon">
                                                                    </label>
                                                                    <input type="hidden" name="featureids[]"
                                                                        value="{{ $item->id }}">
                                                                    <input type="file"
                                                                        id="featureimage-{{ $item->id }}"
                                                                        name="featureimageupdate[]" class="form-control"
                                                                        style="display: none;"
                                                                        onchange="previewFeatureImagefea(event, '{{ $item->id }}')">

                                                                    <!-- Display Image Preview Here -->
                                                                    <div id="preview-container-{{ $item->id }}" 
                                                                        style="margin-top: 10px;" class="numericalclass imgid{{ $item->id }}" >
                                                                        <img id="preview-image-{{ $item->id }}"
                                                                            src="" alt="Image Preview"
                                                                            style="max-width: 100px; display: none;">
                                                                    </div>


                                                                         <!-- Delete button for preview (before saving) -->
                                                                    <button type="button" class="btn btn-danger imgid{{ $item->id }}"
                                                                        id="deleteicon-{{ $item->id }}"
                                                                        style="display: none;"
                                                                        onclick="removerepimg(this)">Delete image</button>

                                                                       



                                                                    <!-- Display existing saved image if available -->
                                                                    @if (!empty($item->image))
                                                                        <button type="button" class="btn btn-danger"
                                                                            id="deleteiconfeature-{{ $item->id }}"
                                                                            onclick="removeFeatureImage(this, '{{ $item->id }}')"
                                                                            data-id="feature_cls-{{ $item->id }}"
                                                                            data-image-path="{{ $item->image }}">Delete</button>

                                                                        <img src="{{ url('d0/' . $item->image) }}"
                                                                            alt="Feature Image" id="tohideimg-{{ $item->id }}"
                                                                            class="feature_cls-{{ $item->id }}"
                                                                            style="max-width: 100px; margin-top: 10px;">
                                                                    @endif

                                                                    @error('featureimage')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeDiv(this, 'close-{{ $item->id }}')"
                                                        data-feature-id="{{ $item->id }}">X</button>

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="featuresubtitle">Feature Heading*</label>
                                                            <input type="text" name="featuresubtitle[]"
                                                                class="form-control" placeholder="Feature Heading">
                                                            @error('featuresubtitle')
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
                                                            <label for="featurecontent">Feature Description*</label>
                                                            <textarea name="featurecontent[]" class="form-control" rows="5" placeholder="Feature Description"></textarea>
                                                            @error('featurecontent')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="featureimage" class="file-upload">Feature Image22
                                                                <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon"> </label>
                                                            <input type="file" name="featureimage[]"
                                                                class="form-control" style="display: none;"
                                                                id="featureimage" onchange="previewFeatureImage(event)">
                                                            @error('featureimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="featureimagefirst" class="file-upload">Feature Image
                                                                <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                            </label>
                                                            <input type="file" name="featureimage[]" class="form-control" style="display: none;" id="featureimagefirst" onchange="previewFirst(event)">
                                                            
                                                            <!-- Display Image Preview Here -->
                                                            <div id="preview-containerfirst" style="margin-top: 10px; display: none;">
                                                                <img id="preview-imagefirst" src="" alt="Image Preview" style="max-width: 100px; display: none;">
                                                                <!-- Delete button for preview (before saving) -->
                                                                <button type="button" class="btn btn-danger" id="deleteiconfirst"  onclick="removerepimgfirst()">Delete image</button>
                                                            </div>
                                            
                                                            @error('featureimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            


                                            

                                        @endif

                                        <!-- Add Feature Button -->


                                        <!-- Feature Repeater -->
                                        <div class="col-md-12" id="featuresContainer"></div>

                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-dark" id="addFeature">Add</button>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary feature" name="section"
                                                value="section3">Save</button>
                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>











                <div class="tab-pane fade @if (old('section') == 'section7') show active @endif" id="section7"
                    role="tabpanel" aria-labelledby="section7-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section7') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="featurestitle">Feature Title*</label>
                                                <input type="text" name="featurestitle" id="featurestitle"
                                                    value="{{ old('featurestitle', optional($banner)->featurestitle) }}"
                                                    class="form-control" placeholder="Feature Title">
                                                @error('featurestitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <!-- Analytics Section -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="analyticstitle">Analytics Title*</label>
                                                <input type="text" name="analyticstitle" id="analyticstitle"
                                                    value="{{ old('analyticstitle', optional($banner)->analytics_title) }}"
                                                    class="form-control" placeholder="Analytics Title">
                                                @error('analyticstitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="sec numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="analyticsimage" class="file-upload">Analytics Image <br>
                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon">
                                                    </label>
                                                    <input type="file" name="analyticsimage" id="analyticsimage"
                                                        class="form-control" style="display: none;"
                                                        onchange="previewImage(event, 'analyticsImagePreview', this)"
                                                        data-id="imgid7">
                                                    @error('analyticsimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Preview Analytics Image Container -->
                                            <div class="form-group imgid7" id="imgid7"
                                                style="{{ isset($banner) && $banner->analytics_image ? '' : 'display: none;' }}">
                                                <label for="analyticsImagePreview">Analytics Image Preview</label>
                                                <div id="analyticsImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="analyticsImagePreview"
                                                        src="{{ isset($banner) && $banner->analytics_image ? url('d0/' . $banner->analytics_image) : '' }}"
                                                        alt="Analytics Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->analytics_image ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid7" id="deleteicon7"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeAnalyticsImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete7"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->analytics_image ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeAnalyticsImage()">X</button>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="analyticscontent">Analytics Content*</label>
                                                <textarea name="analyticscontent" id="analyticscontent" class="form-control" rows="5">{{ old('analyticscontent', optional($banner)->analytics_content) }}</textarea>
                                                @error('analyticscontent')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Anytime Section -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="anytimetitle">Anytime Title*</label>
                                                <input type="text" name="anytimetitle" id="anytimetitle"
                                                    value="{{ old('anytimetitle', optional($banner)->anytime_title) }}"
                                                    class="form-control" placeholder="Anytime Title">
                                                @error('anytimetitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="sec numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="anytimeimage" class="file-upload">Anytime Image <br>
                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon">
                                                    </label>
                                                    <input type="file" name="anytimeimage" id="anytimeimage"
                                                        class="form-control" style="display: none;"
                                                        onchange="previewAnytimeImage(event, 'anytimeImagePreview',this)"
                                                        data-id="imgid8">
                                                    @error('anytimeimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Preview Anytime Image Container -->
                                            <div class="form-group imgid8" id="imgid8"
                                                style="{{ isset($banner) && $banner->anytime_image ? '' : 'display: none;' }}">
                                                <label for="anytimeImagePreview">Anytime Image Preview</label>
                                                <div id="anytimeImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="anytimeImagePreview"
                                                        src="{{ isset($banner) && $banner->anytime_image ? url('d0/' . $banner->anytime_image) : '' }}"
                                                        alt="Anytime Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->anytime_image ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid8" id="deleteicon8"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeAnytimeImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete8"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->anytime_image ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeAnytimeImage()">X</button>
                                                </div>
                                            </div>
                                        </div>











                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="anytimedescription">Anytime Description*</label>
                                                <textarea name="anytimedescription" id="anytimedescription" class="form-control" rows="5">{{ old('anytimedescription', optional($banner)->anytime_description) }}</textarea>
                                                @error('anytimedescription')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Unlimited Section -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="unlimitedtitle">Unlimited Title*</label>
                                                <input type="text" name="unlimitedtitle" id="unlimitedtitle"
                                                    value="{{ old('unlimitedtitle', optional($banner)->unlimited_title) }}"
                                                    class="form-control" placeholder="Unlimited Title">
                                                @error('unlimitedtitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="sec numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="unlimitedimage" class="file-upload">Unlimited Image <br>
                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon">
                                                    </label>
                                                    <input type="file" name="unlimitedimage" id="unlimitedimage"
                                                        class="form-control" style="display: none;"
                                                        onchange="previewImage(event, 'unlimitedImagePreview',this)"
                                                        data-id="imgid9">
                                                    @error('unlimitedimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Preview Unlimited Image Container -->
                                            <div class="form-group imgid9" id="imgid9"
                                                style="{{ isset($banner) && $banner->unlimited_image ? '' : 'display: none;' }}">
                                                <label for="unlimitedImagePreview">Unlimited Image Preview</label>
                                                <div id="unlimitedImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="unlimitedImagePreview"
                                                        src="{{ isset($banner) && $banner->unlimited_image ? url('d0/' . $banner->unlimited_image) : '' }}"
                                                        alt="Unlimited Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->unlimited_image ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid9" id="deleteicon9"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeUnlimitedImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete9"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->unlimited_image ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeUnlimitedImage()">X</button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="unlimitedcontent">Unlimited Content*</label>
                                                <textarea name="unlimitedcontent" id="unlimitedcontent" class="form-control" rows="5">{{ old('unlimitedcontent', optional($banner)->unlimited_content) }}</textarea>
                                                @error('unlimitedcontent')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Live Section -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="livetitle">Live Title*</label>
                                                <input type="text" name="livetitle" id="livetitle"
                                                    value="{{ old('livetitle', optional($banner)->live_title) }}"
                                                    class="form-control" placeholder="Live Title">
                                                @error('livetitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="sec numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="liveimage" class="file-upload">Live Image <br>
                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon">
                                                    </label>
                                                    <input type="file" name="liveimage" id="liveimage"
                                                        class="form-control" style="display: none;"
                                                        onchange="previewLiveImage(event, 'liveImagePreview',this)"
                                                        data-id="imgid10">
                                                    @error('liveimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Live Image Preview Section -->
                                            <div class="form-group imgid10" id="imgid10"
                                                style="{{ isset($banner) && $banner->live_image ? '' : 'display: none;' }}">
                                                <label for="liveImagePreview">Live Image Preview</label>
                                                <div id="liveImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="liveImagePreview"
                                                        src="{{ isset($banner) && $banner->live_image ? url('d0/' . $banner->live_image) : '' }}"
                                                        alt="Live Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->live_image ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid10"
                                                        id="deleteicon10"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeLiveImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete10"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->live_image ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeLiveImage()">X</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="livecontent">Live Content*</label>
                                                <textarea name="livecontent" id="livecontent" class="form-control" rows="5">{{ old('livecontent', optional($banner)->live_content) }}</textarea>
                                                @error('livecontent')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary content" name="section"
                                                value="section7">Save</button>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>























                <!-- Section 4 Content -->
                <div class="tab-pane fade @if (old('section') == 'section4') show active @endif" id="section4"
                    role="tabpanel" aria-labelledby="section4-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section4') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">




                                        <!-- Fourth Section Fields -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="exceltitle">Excel Title*</label>

                                                        <textarea class="form-control texteditor" name="exceltitle" id="exceltitle">{{ old('exceltitle', optional($banner)->exceltitle) }}</textarea>
                                                        @error('exceltitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <!-- Excel Button Label -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="excelbuttonlabel">Excel Button Label*</label>
                                                        <input type="text" name="excelbuttonlabel"
                                                            id="excelbuttonlabel"
                                                            value="{{ old('excelbuttonlabel', optional($banner)->excelbuttonlabel) }}"
                                                            class="form-control" placeholder="Excel Button Label">
                                                        @error('excelbuttonlabel')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Excel Button Link -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="excelbuttonlink">Excel Button Link*</label>
                                                        <input type="text" name="excelbuttonlink" id="excelbuttonlink"
                                                            value="{{ old('excelbuttonlink', optional($banner)->excelbuttonlink) }}"
                                                            class="form-control" placeholder="Excel Button Link">
                                                        @error('excelbuttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Excel Image -->
                                        <div class="sec numericalsectionclass">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="excelimage" class="file-upload">Excel Image <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon">
                                                            </label>
                                                            <input type="file" name="excelimage" id="excelimage"
                                                                class="form-control" style="display: none;"
                                                                onchange="previewExcelImage(event, 'excelImagePreview', this)"
                                                                data-id="imgid6">
                                                            @error('excelimage')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview Excel Image Container -->
                                            <div class="form-group imgid6" id="imgid6"
                                                style="{{ isset($banner) && $banner->excelimage ? '' : 'display: none;' }}">
                                                <label for="excelImagePreview">Excel Image Preview</label>
                                                <div id="excelImagePreviewContainer" class="numericalclass"
                                                    style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px; position: relative;">
                                                    <!-- Image Preview -->
                                                    <img id="excelImagePreview"
                                                        src="{{ isset($banner) && $banner->excelimage ? url('d0/' . $banner->excelimage) : '' }}"
                                                        alt="Excel Image Preview"
                                                        style="width: 100%; height: auto; display: {{ isset($banner) && $banner->excelimage ? 'block' : 'none' }};">

                                                    <!-- Delete button for preview (before saving) -->
                                                    <button type="button" class="btn btn-danger imgid6" id="deleteicon6"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeExcelImagePreview()">X</button>

                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondelete6"
                                                        style="position: absolute; top: 5px; right: 5px; {{ isset($banner) && $banner->excelimage ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeExcelImage()">X</button>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Submit Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary excel" name="section"
                                                value="section4">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4 Content -->
                <div class="tab-pane fade @if (old('section') == 'section5') show active @endif" id="section5"
                    role="tabpanel" aria-labelledby="section5-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section5') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="ourcoursetitle">Our Course Title*</label>
                                                        <input type="text" name="ourcoursetitle"
                                                            id="ourcoursetitle"
                                                            value="{{ old('ourcoursetitle', optional($courses)->ourcoursetitle) }}"
                                                            class="form-control" placeholder="Our Course Title">
                                                        @error('ourcoursetitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fourth Section Fields -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="coursetitle">Course Title*</label>
                                                        <input type="text" name="coursetitle" id="coursetitle"
                                                            value="{{ old('coursetitle', optional($courses)->coursetitle) }}"
                                                            class="form-control" placeholder="Course Title">
                                                        @error('coursetitle')
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
                                                        <label for="coursesubtitle">Course Subtitle*</label>
                                                        <input type="text" name="coursesubtitle"
                                                            id="coursesubtitle"
                                                            value="{{ old('coursesubtitle', optional($courses)->coursesubtitle) }}"
                                                            class="form-control" placeholder="Course Subtitle">
                                                        @error('coursesubtitle')
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
                                                        <label for="courseheading1">Course Heading 1*</label>
                                                        <input type="text" name="courseheading1"
                                                            id="courseheading1"
                                                            value="{{ old('courseheading1', optional($courses)->courseheading1) }}"
                                                            class="form-control" placeholder="Course Heading 1">
                                                        @error('courseheading1')
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
                                                        <label for="coursecontent1">Course Content 1*</label>
                                                        <textarea name="coursecontent1" id="coursecontent1" class="form-control" placeholder="Course Content 1">{{ old('coursecontent1', optional($courses)->coursecontent1) }}</textarea>
                                                        @error('coursecontent1')
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
                                                        <label for="courseheading2">Course Heading 2*</label>
                                                        <input type="text" name="courseheading2"
                                                            id="courseheading2"
                                                            value="{{ old('courseheading2', optional($courses)->courseheading2) }}"
                                                            class="form-control" placeholder="Course Heading 2">
                                                        @error('courseheading2')
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
                                                        <label for="coursecontent2">Course Content 2*</label>
                                                        <textarea name="coursecontent2" id="coursecontent2" class="form-control" placeholder="Course Content 2">{{ old('coursecontent2', optional($courses)->coursecontent2) }}</textarea>
                                                        @error('coursecontent2')
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
                                                        <label for="courseheading3">Course Heading 3*</label>
                                                        <input type="text" name="courseheading3"
                                                            id="courseheading3"
                                                            value="{{ old('courseheading3', optional($courses)->courseheading3) }}"
                                                            class="form-control" placeholder="Course Heading 3">
                                                        @error('courseheading3')
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
                                                        <label for="coursecontent3">Course Content 3*</label>
                                                        <textarea name="coursecontent3" id="coursecontent3" class="form-control" placeholder="Course Content 3">{{ old('coursecontent3', optional($courses)->coursecontent3) }}</textarea>
                                                        @error('coursecontent3')
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
                                                        <label for="courseheading4">Course Heading 4*</label>
                                                        <input type="text" name="courseheading4"
                                                            id="courseheading4"
                                                            value="{{ old('courseheading4', optional($courses)->courseheading4) }}"
                                                            class="form-control" placeholder="Course Heading 4">
                                                        @error('courseheading4')
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
                                                        <label for="coursecontent4">Course Content 4*</label>
                                                        <textarea name="coursecontent4" id="coursecontent4" class="form-control" placeholder="Course Content 4">{{ old('coursecontent4', optional($courses)->coursecontent4) }}</textarea>
                                                        @error('coursecontent4')
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
                                                        <label for="coursebuttonlabel">Course Button Label*</label>
                                                        <input type="text" name="coursebuttonlabel"
                                                            id="coursebuttonlabel"
                                                            value="{{ old('coursebuttonlabel', optional($courses)->coursebuttonlabel) }}"
                                                            class="form-control" placeholder="Course Button Label">
                                                        @error('coursebuttonlabel')
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
                                                        <label for="coursebuttonlink">Course Button Link*</label>
                                                        <input type="text" name="coursebuttonlink"
                                                            id="coursebuttonlink"
                                                            value="{{ old('coursebuttonlink', optional($courses)->coursebuttonlink) }}"
                                                            class="form-control" placeholder="Course Button Link">
                                                        @error('coursebuttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary course" name="section"
                                                value="section5">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 6 Content -->
                <div class="tab-pane fade @if (old('section') == 'section6') show active @endif" id="section6"
                    role="tabpanel" aria-labelledby="section6-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section6') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="studentsfeedback">Student Feedback</label>
                                                <input type="text" name="studentsfeedback" id="studentsfeedback"
                                                    value="{{ old('studentsfeedback', optional($courses)->studentsfeedback) }}"
                                                    class="form-control" placeholder="Students Feedback">
                                                @error('studentsfeedback')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Student Title Field -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="studenttitle">Student Title</label>
                                                <input type="text" name="studenttitle" id="studenttitle"
                                                    value="{{ old('studenttitle', optional($courses)->studenttitle) }}"
                                                    class="form-control" placeholder="Student Title">
                                                @error('studenttitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Student Subtitle Field -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="studentsubtitle">Student Subtitle</label>
                                                <input type="text" name="studentsubtitle" id="studentsubtitle"
                                                    value="{{ old('studentsubtitle', optional($courses)->studentsubtitle) }}"
                                                    class="form-control" placeholder="Student Subtitle">
                                                @error('studentsubtitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="percentage">Percentage</label>
                                                <input type="text" name="percentage" id="percentage"
                                                    value="{{ old('percentage', optional($courses)->percentage) }}"
                                                    class="form-control" placeholder="Percentage">
                                                @error('percentage')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="studentssubtitle">Students Subtitle</label>
                                                <input type="text" name="studentssubtitle" id="studentssubtitle"
                                                    value="{{ old('studentssubtitle', optional($courses)->studentssubtitle) }}"
                                                    class="form-control" placeholder="Students Subtitle">
                                                @error('studentssubtitle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                        @php

                                            $stud = [];

                                            if (count(old('nameupdate', [])) > 0) {
                                                $stud = old('nameupdate', []);
                                            }

                                            if (count(old('starratingupdate', [])) > 0) {
                                                $stud = old('starratingupdate', []);
                                            }

                                            if (count(old('reviewupdate', [])) > 0) {
                                                $stud = old('reviewupdate', []);
                                            }
                                            if (count(old('imageupdate', [])) > 0) {
                                                $stud = old('imageupdate', []);
                                            }
                                        @endphp


                                        @if (count($stud) > 0 && isset($stud))

                                            @foreach ($stud as $k => $item)
                                                <div class="outer-feature" id="close-{{ $k }}">






                                                    <!-- Name -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="name">Name*</label>
                                                                    <input type="text" name="nameupdate[]"
                                                                        class="form-control" placeholder="Name"
                                                                        value="{{ old('nameupdate.' . $k, $item->name ?? '') }}">
                                                                    @error('nameupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <div class="form-data">
                                                            <div class="forms-inputs mb-4">
                                                                <label for="starrating">Star Rating</label>
                                                                <select name="starratingupdate[]" class="form-control">
                                                                    <option value="1"
                                                                        {{ old('starratingupdate.' . $k, $item->starrating ?? '') == 1 ? 'selected' : '' }}>
                                                                        1</option>
                                                                    <option value="2"
                                                                        {{ old('starratingupdate.' . $k, $item->starrating ?? '') == 2 ? 'selected' : '' }}>
                                                                        2</option>
                                                                    <option value="3"
                                                                        {{ old('starratingupdate.' . $k, $item->starrating ?? '') == 3 ? 'selected' : '' }}>
                                                                        3</option>
                                                                    <option value="4"
                                                                        {{ old('starratingupdate.' . $k, $item->starrating ?? '') == 4 ? 'selected' : '' }}>
                                                                        4</option>
                                                                    <option value="5"
                                                                        {{ old('starratingupdate.' . $k, $item->starrating ?? '') == 5 ? 'selected' : '' }}>
                                                                        5</option>
                                                                </select>
                                                                @error('starratingupdate.' . $k)
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>






                                                    <!-- Review -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="review">Review*</label>
                                                                    <textarea name="reviewupdate[]" class="form-control" rows="5" placeholder="Review">{{ old('reviewupdate.' . $k, $item->review ?? '') }}</textarea>
                                                                    @error('reviewupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Image -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="image" class="file-upload">Image1 <br>
                                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                            alt="Upload Icon"> </label>

                                                                    <input type="file" name="imageupdate[]"
                                                                        class="form-control" style="display: none;"
                                                                        onchange="previewFeatureImage(event)">

                                                                    @error('imageupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>









                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeDiv(this, 'close-{{ $k }}')"
                                                        data-feature-id="{{ $k }}">X</button>

                                                </div>
                                            @endforeach
                                        @elseif(!empty($feed) && count($feed) > 0)
                                            @foreach ($feed as $k => $item)
                                                <div class="outer-feature" id="closefeed-{{ $item->id }}{{ $k == 0 ? '-delet' : '' }}">
                                                    <!-- Name -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="name">Name*</label>
                                                            <input type="text" name="nameupdate[]"
                                                                class="form-control" placeholder="Name"
                                                                value="{{ $item->name }}">
                                                            @error('name')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>




                                                    <div class="form-group">
                                                        <label for="starrating">Star Rating*</label>
                                                        <select name="starratingupdate[]" class="form-control">
                                                            <option value="1"
                                                                {{ $item->starrating == 1 ? 'selected' : '' }}>1</option>
                                                            <option value="2"
                                                                {{ $item->starrating == 2 ? 'selected' : '' }}>2</option>
                                                            <option value="3"
                                                                {{ $item->starrating == 3 ? 'selected' : '' }}>3</option>
                                                            <option value="4"
                                                                {{ $item->starrating == 4 ? 'selected' : '' }}>4</option>
                                                            <option value="5"
                                                                {{ $item->starrating == 5 ? 'selected' : '' }}>5</option>
                                                        </select>
                                                        @error('starrating')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>





                                                    <!-- Review -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="review">Review*</label>
                                                            <textarea name="reviewupdate[]" class="form-control" rows="5" placeholder="Review">{{ $item->review }}</textarea>
                                                            @error('review')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Image -->
                                                    <div class="col-md-12  numericalsectionclass ">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <!-- Label for file upload -->
                                                                    <label for="feedimage-{{ $item->id }}" class="file-upload">
                                                                        Image2 <br>
                                                                        <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                                    </label>
                                                    
                                                                    <!-- Hidden input for item ID -->
                                                                    <input type="hidden" name="feedids[]" value="{{ $item->id }}">
                                                    
                                                                    <!-- File input -->
                                                                    <input type="file" id="feedimage-{{ $item->id }}" name="imageupdate[]" class="form-control"
                                                                        style="display: none;" onchange="previewimgImage(event, '{{ $item->id }}')">
                                                    
                                                                    <!-- Preview container for new image -->
                                                                    <div id="preview-container2-{{ $item->id }}" style="margin-top: 10px;"  class="numericalclass imgidrev{{ $item->id }}">
                                                                        <img id="preview-image2-{{ $item->id }}" src="" alt="Image Preview"
                                                                            style="max-width: 100px; display: none;">
                                                                    </div>
                                                    
                                                                    <!-- Delete button for preview (before saving) -->
                                                                    <button type="button" class="btn btn-danger  imgidrev{{ $item->id }}" id="deleteicon131-{{ $item->id }}"
                                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                                        onclick="reviewimgdelete(this)">Delete</button>
                                                    
                                                                    <!-- Display existing saved image if available -->
                                                                    @if (!empty($item->image))
                                                                        <button type="button" class="btn btn-danger" id="deleteiconfeature-{{ $item->id }}"
                                                                            onclick="removeimgImage(this, '{{ $item->id }}')"
                                                                            data-id="feed_cls-{{ $item->id }}"
                                                                            data-image-path="{{ $item->image }}">Delete</button>
                                                    
                                                                        <img src="{{ url('d0/' . $item->image) }}" alt="Image"
                                                                            class="feed_cls-{{ $item->id }}"
                                                                            style="max-width: 100px; margin-top: 10px;">
                                                                    @endif
                                                    
                                                                    <!-- Error handling -->
                                                                    @error('image')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    


                                                    {{--                                                     
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="privateimage"  class="file-upload">Private Image <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                    alt="Upload Icon"> </label>
                                                            <input type="file" class="form-control" style="display: none;" name="privateimage" id="privateimage">
                                                        </div>
                                                    </div> --}}



                                                    <!-- Remove Button -->
                                                    <div class="col-md-12 mb-3">
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="removeDiv(this, 'closefeed-{{ $item->id }}')"
                                                            data-feed-id="{{ $item->id }}">X</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default Name Field -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Name*</label>
                                                    <input type="text" name="name[]" class="form-control"
                                                        placeholder="Name">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>






                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="starrating">Star Rating*</label>
                                                    <input type="text" name="starrating[]" class="form-control"
                                                        placeholder="Star Rating">
                                                    @error('starrating')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="review">Review*</label>
                                                    <textarea name="review[]" class="form-control" rows="5" placeholder="Review"></textarea>
                                                    @error('review')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>




                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="revimagefirst" class="file-upload">
                                                                Image3 <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                            </label>
                                            
                                                            <input type="file" name="image[]" class="form-control" style="display: none;" id="revimagefirst" onchange="previewrevImage(event)">
                                            
                                                            <!-- Image Preview Container -->
                                                            <div id="preview-containerrevfirst" style="margin-top: 10px; display: none;">
                                                                <img id="preview-imagerevfirst" src="" alt="Image Preview" style="max-width: 100px; display: none;">
                                                                <!-- Delete button for preview (before saving) -->
                                                                <button type="button" class="btn btn-danger" id="delete-iconrevfirst" style="" onclick="removePreviewImage()">Delete image</button>
                                                            </div>
                                            
                                                            @error('image')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                          

                                            {{-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="image" class="file-upload">Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                </label>
                                                <input type="hidden" name="feedids[]" value="">
                                                <input type="file" id="image" name="image[]" class="form-control" style="display: block;" onchange="previewFeatureImage(event)">
                                        
                                                @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}















                                        @endif

                                        <!-- Dynamic Feed Container -->
                                        <div class="col-md-12" id="feedContainer"></div>

                                        <!-- Add Feature Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-dark" id="addFeed">Add</button>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary feed" name="section"
                                                value="section6">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

























                <div class="tab-pane fade @if (old('section') == 'section8') show active @endif" id="section8"
                    role="tabpanel" aria-labelledby="section8-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.page.section8') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">

                                                        <label for="ourprocesstitle">Our Process Title*</label>
                                                        <input type="text" name="ourprocesstitle"
                                                            class="form-control"
                                                            value="{{ old('ourprocesstitle', optional($banner)->ourprocesstitle) }}"
                                                            placeholder="Our Process Title">
                                                        @error('ourprocesstitle')
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

                                                        <label for="ourprocesssubtitle">Our Process SubTitle*</label>
                                                        <input type="text" name="ourprocesssubtitle"
                                                            class="form-control"
                                                            value="{{ old('ourprocesssubtitle', optional($banner)->ourprocesssubtitle) }}"
                                                            placeholder="Our Process SubTitle">
                                                        @error('ourprocesssubtitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @php

                                            $processold = [];

                                            if (count(old('ourprocessheadingupdate', [])) > 0) {
                                                $processold = old('ourprocessheadingupdate', []);
                                            }

                                            if (count(old('ourprocessimageupdate', [])) > 0) {
                                                $processold = old('ourprocessimageupdate', []);
                                            }

                                        @endphp

                                        @if (count($processold) > 0 && isset($processold))

                                            @foreach ($processold as $k => $item)
                                                <div class="outer-feature" id="close-{{ $k }}">









                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="ourprocessheading">Our Process Heading
                                                                        1*</label>
                                                                    <textarea name="ourprocessheadingupdate[]" class="form-control texteditor" rows="5"
                                                                        placeholder="Process Heading">{{ old('ourprocessheadingupdate.' . $k) }}</textarea>
                                                                    @error('ourprocessheadingupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>






                                                    <!-- Feature Image -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="ourprocessimage">Process Icon*</label>
                                                                    <input type="hidden" name="processids[]"
                                                                        value="{{ old('processids.' . $k, $item->id ?? '') }}">
                                                                    <input type="file" name="ourprocessimageupdate[]"
                                                                        class="form-control"
                                                                        onchange="previewFeatureImage(event)">

                                                                    @if (!empty($item->image))
                                                                        <img src="{{ asset('path/to/images/' . $item->image) }}"
                                                                            alt="Feature Image"
                                                                            style="max-width: 100px; margin-top: 10px;"
                                                                            id="imagePreview_{{ $k }}">
                                                                    @else
                                                                        <img src="#" alt="Feature Image"
                                                                            style="max-width: 100px; margin-top: 10px; display: none;"
                                                                            id="imagePreview_{{ $k }}">
                                                                    @endif

                                                                    @error('ourprocessimageupdate.' . $k)
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>









                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeDiv(this, 'close-{{ $k }}')"
                                                        data-feature-id="{{ $k }}">X</button>

                                                </div>
                                            @endforeach
                                        @elseif(!empty($ourprocess) && count($ourprocess) > 0)
                                            @foreach ($ourprocess as $k => $item)

                                                <div class="outer-feature" id="close-{{ $item->id }}{{ $k == 0 ? '-del' : '' }}">








                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="ourprocessheading">Our Process Heading
                                                                        2*</label>

                                                                    <!-- Textarea for Process Heading -->
                                                                    <textarea name="ourprocessheadingupdate[]" class="form-control texteditor" rows="5"
                                                                        placeholder="Process Heading">{{ old('ourprocessheadingupdate[]', $item->ourprocessheading) }}</textarea>

                                                                    @error('ourprocessheading')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>











                                                    <!-- Feature Image -->
                                                    <div class="col-md-12 numericalsectionclass">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="ourprocessimage-{{ $item->id }}" class="file-upload">
                                                                        Process Icon* <br>
                                                                        <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                                    </label>
                                                                    <input type="hidden" name="processids[]" value="{{ $item->id }}">
                                                                    <input type="file" id="ourprocessimage-{{ $item->id }}" name="ourprocessimageupdate[]"
                                                                        class="form-control" style="display: none;" onchange="previewprocessImage(event, '{{ $item->id }}')">
                                                    
                                                                    <!-- Display Image Preview Here -->
                                                                    <div id="preview-container1-{{ $item->id }}" style="margin-top: 10px;" class="numericalclass imgidpro{{ $item->id }}">
                                                                        <img id="preview-image1-{{ $item->id }}" src="" alt="Image Preview" 
                                                                            style="max-width: 100px; display: none;">
                                                                    </div>
                                                    
                                                                    <!-- Delete button for preview (before saving) -->
                                                                    <button type="button" class="btn btn-danger imgidpro{{ $item->id }}" id="deleteicon121-{{ $item->id }}" 
                                                                        style="position: absolute; top: 5px; right: 5px; display: none;" onclick="removeImagedeletepro(this)">
                                                                        Delete
                                                                    </button>
                                                    
                                                                    <!-- Display existing saved image if available -->
                                                                    @if (!empty($item->ourprocessimage))
                                                                        <button type="button" class="btn btn-danger" id="deleteiconfeature-{{ $item->id }}"
                                                                            onclick="removeProcessImage(this, '{{ $item->id }}')" data-id="process_cls-{{ $item->id }}"
                                                                            data-image-path="{{ $item->ourprocessimage }}">Delete</button>
                                                    
                                                                        <img src="{{ url('d0/' . $item->ourprocessimage) }}" alt="Process Image"
                                                                            class="process_cls-{{ $item->id }}" style="max-width: 100px; margin-top: 10px;">
                                                                    @endif
                                                    
                                                                    @error('ourprocessimageupdate')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    






                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeDiv(this, 'close-{{ $item->id }}')"
                                                        data-feature-id="{{ $item->id }}">X</button>

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-data">
                                                        <div class="forms-inputs mb-4">
                                                            <label for="ourprocessheading">Our Process Heading 3*</label>

                                                            <!-- Textarea for Process Heading -->
                                                            <textarea name="ourprocessheadingupdate[]" class="form-control texteditor" rows="5"
                                                                placeholder="Process Heading">{{ old('ourprocessheadingupdate', optional($banner)->ourprocessheadings) }}</textarea>

                                                            @error('ourprocessheading')
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
                                                            <!-- File Upload Label -->
                                                            <label for="ourprocessimagefirst" class="file-upload">
                                                                Process Icon22*
                                                                <br>
                                                                <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                            </label>
                                            
                                                            <!-- Hidden File Input -->
                                                            <input type="file" name="ourprocessimageupdate[]" class="form-control" id="ourprocessimagefirst" style="display: none;" onchange="previewProcessImagefirst(event)">
                                            
                                                            <!-- Image Preview Section -->
                                                            <div id="preview-container-processfirst" style="margin-top: 10px; display: none;">
                                                                <img id="preview-image-processfirst" src="" alt="Image Preview" style="max-width: 100px; display: none;">
                                                                <!-- Delete Button -->
                                                                <button type="button" class="btn btn-danger btn-sm" id="delete-icon-processfirst"  onclick="removeProcessImagefirst()">Delete Image</button>
                                                            </div>
                                            
                                                            <!-- Validation Error Display -->
                                                            @error('ourprocessimageupdate')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        @endif







                                        <!-- Add Feature Button -->


                                        <!-- Feature Repeater -->
                                        <div class="col-md-12" id="processContainer"></div>

                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-dark" id="addprocess">Add</button>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary process" name="section"
                                                value="section8">Save</button>
                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>




            @endsection



            @push('footer-script')
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    function previewImage(event, previewId, element) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            var id = $(element).data('id');

                            $('.' + id).show();

                            // Show the image preview container and the preview delete button (deleteicon)
                            document.getElementById('imgid1').style.display = 'block';
                            document.getElementById('deleteicon').style.display = 'block';
                            document.getElementById('icondelete').style.display = 'none'; // Hide saved delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the image preview when the preview delete button (deleteicon) is clicked
                    function removeImagePreview() {
                        // Clear the image preview source and hide preview container and delete button
                        const output = document.getElementById('imagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid1').style.display = 'none';
                        document.getElementById('deleteicon').style.display = 'none';
                    }
                </script>

                <script>
                    // Function to preview the learnimage when a file is selected
                    function previewLearnImage(event, previewId) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the learn image preview container and the preview delete button (learnicondelete)
                            document.getElementById('imgid2').style.display = 'block';
                            document.getElementById('icondelete2').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon2').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the learnimage preview when the preview delete button (learndeleteicon) is clicked
                    function removeLearnImagePreview() {
                        // Clear the learn image preview source and hide preview container and delete button
                        const output = document.getElementById('learnImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid2').style.display = 'none';
                        document.getElementById('deleteicon2').style.display = 'none'; // Hide preview delete button
                    }
                </script>


                <script>
                    // Function to preview the practiseimage when a file is selected
                    function previewPractiseImage(event, previewId) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the practise image preview container and the preview delete button (icondelete3)
                            document.getElementById('imgid3').style.display = 'block';
                            document.getElementById('icondelete3').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon3').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the practiseimage preview when the preview delete button (deleteicon3) is clicked
                    function removePractiseImagePreview() {
                        // Clear the practise image preview source and hide preview container and delete button
                        const output = document.getElementById('practiseImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid3').style.display = 'none';
                        document.getElementById('deleteicon3').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the saved practiseimage when the saved delete button (icondelete3) is clicked
                    function removePractiseImage() {
                        // Clear the practise image preview source and hide saved preview container and delete button
                        const output = document.getElementById('practiseImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('icondelete3').style.display = 'none'; // Hide saved delete button
                        document.getElementById('practiseimage').value = ''; // Clear the file input

                        // Optionally, you can also make an AJAX call to delete the image from the server
                    }
                </script>




                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let featureIndex = 0;

                        document.getElementById('addFeature').addEventListener('click', function() {
                            featureIndex++;


                            let featureHTML = `
                <div class="feature-item mb-3" id="featureItem_${featureIndex}">
                    <h4>Feature ${featureIndex}</h4>

                    <div class="form-group">
                        <label for="featuresubtitle${featureIndex}">Feature Heading</label>
                        <input type="text" name="featuresubtitleupdate[]" id="featuresubtitle${featureIndex}" class="form-control" placeholder="Feature Heading">
                    </div>
                    <div class="form-group">
                        <label for="featurecontent${featureIndex}">Feature Description</label>
                        <textarea name="featurecontentupdate[]" id="featurecontent${featureIndex}" class="form-control" rows="5" placeholder="Feature Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="featureimage_text${featureIndex}" class="file-upload">Feature Image <br>   <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon"> </label>
                        <input type="file" name="featureimageupdate[]" onchange="previewFeatureImagefea(event, 'text${featureIndex}')" id="featureimage_text${featureIndex}" class="form-control"  style="display: none;">
                         <div id="preview-container-text${featureIndex}" style="margin-top: 10px;">
                        <img id="preview-image-text${featureIndex}" src="" alt="Image Preview" style="max-width: 100px; display: none;">

                       
                    <button type="button" id="deleteicon-text${featureIndex}" class="btn btn-danger" style="display: none; margin-top: 10px;" onclick="removerepimg('text${featureIndex}')">Delete image</button>
                    


                         </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removeFeatureItem('featureItem_${featureIndex}')">X</button>
                </div>
            `;


                            document.getElementById('featuresContainer').insertAdjacentHTML('beforeend', featureHTML);
                        });

                        function previewFeatureImage(event) {
                            let reader = new FileReader();
                            reader.onload = function() {
                                let output = document.getElementById('imagePreview');
                                output.src = reader.result;
                                output.style.display = 'block';
                                let output1 = document.getElementById('imagePreview1');
                                output1.src = reader.result;
                                output1.style.display = 'block';
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    });
                </script>




                <script>
                    function removeDiv(button, id) {
                        // Remove the element from the DOM
                        var element = document.getElementById(id);
                        element.remove();

                    }
                </script>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let feedIndex = 0;

                        document.getElementById('addFeed').addEventListener('click', function() {
                            feedIndex++;


                            let feedHTML = `
            <div class="feed-item mb-3" id="feedItem_${feedIndex}">
                <h4>Review ${feedIndex}</h4>

                <!-- Name Field -->
                <div class="form-group">
                    <label for="name${feedIndex}">Name</label>
                    <input type="text" name="name[]" id="name${feedIndex}" class="form-control" placeholder="Name">
                </div>



                <!-- Star Rating Field -->
<div class="form-group">
    <label for="starrating${feedIndex}">Star Rating</label>
    <select name="starrating[]" id="starrating${feedIndex}" class="form-control">
        <option value="1" selected>1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>


                <!-- Review Field -->
                <div class="form-group">
                    <label for="review${feedIndex}">Review</label>
                    <textarea name="review[]" id="review${feedIndex}" class="form-control" rows="5" placeholder="Review"></textarea>
                </div>

            



                <!-- Image Field -->
<div class="form-group">
    <label for="image_${feedIndex}" class="file-upload">
        Image <br>
        <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
    </label>


    <input type="file" name="image[]" id="image_${feedIndex}" class="form-control" style="display: none;" onchange="previewimgImage(event, '${feedIndex}')">
    
    <!-- Preview Container -->
    <div id="preview-container-${feedIndex}" style="margin-top: 10px;">
        <img id="preview-image-${feedIndex}" src="" alt="Image Preview" style="max-width: 100px; display: none;">

           <button type="button" id="deleteicon-text${feedIndex}" class="btn btn-danger" style="display: none; margin-top: 10px;" onclick="reviewimgdelete('text${feedIndex}')">Delete image</button>

    </div>
</div>


   <!-- Close Button -->
                <button type="button" class="btn btn-danger" onclick="removeFeedItem('feedItem_${feedIndex}')">X</button>
              
            </div>
        `;

                            document.getElementById('feedContainer').insertAdjacentHTML('beforeend', feedHTML);
                        });

                        window.removeDiv = function(button, id) {
                            const element = document.getElementById(id);
                            if (element) {
                                element.remove();
                            }
                        };



                        function previewFeedImage(event) {
                            let reader = new FileReader();
                            reader.onload = function() {
                                let output = document.getElementById('imagePreview');
                                output.src = reader.result;
                                output.style.display = 'block';
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    });
                </script>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    function previewLearnImage(event) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById('learnImagePreview');
                            output.src = reader.result;
                            output.style.display = 'block';
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                </script>

                <script>
                    function previewanalyticsImage(event) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById('analyticsImagePreview');
                            output.src = reader.result;
                            output.style.display = 'block';
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                </script>


                <script>
                    function previewanytimeImage(event) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById('anytimeImagePreview');
                            output.src = reader.result;
                            output.style.display = 'block';
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                </script>




                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let processIndex = 0;

                        document.getElementById('addprocess').addEventListener('click', function() {
                            processIndex++;

                            let processHTML = `
<div class="process-item mb-3" id="processItem_${processIndex}">
    <h4>Process ${processIndex}</h4>

    <div class="form-group">
        <label for="ourprocessheading${processIndex}">Process Heading</label>
        <textarea name="ourprocessheadingupdate[]" id="ourprocessheading${processIndex}" class="form-control texteditor" placeholder="Process Heading"></textarea>
    </div>

    <div class="form-group">
        <label for="ourprocessimage-text${processIndex}" class="file-upload">Our Process Icon <br> 
            <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
        </label>
        <input type="file" name="ourprocessimageupdate[]" id="ourprocessimage-text${processIndex}" class="form-control" style="display: none;" onchange="previewprocessImage(event, 'text${processIndex}')">
     

        <!-- Image Preview Section -->

        <div id="preview-container-text${processIndex}" style="margin-top: 10px;">
            <img id="preview-image-text${processIndex}" src="" alt="Image Preview" style="max-width: 100px; display: none;">

              <button type="button" id="deleteicon-text${processIndex}" class="btn btn-danger" style="display: none; margin-top: 10px;" onclick="removeImagedeletepro('text${processIndex}')">Delete image</button>


        </div>
    </div>
    
   <!-- Close Button -->
                <button type="button" class="btn btn-danger" onclick="removeprocessItem('processItem_${processIndex}')">X</button>
</div>
`;




                            let container = document.getElementById('processContainer');
                            container.insertAdjacentHTML('beforeend', processHTML);

                            // Initialize CKEditor for the newly added textarea
                            CKEDITOR.replace(`ourprocessheading${processIndex}`);
                        });

                        function previewFeatureImage(event) {
                            let reader = new FileReader();
                            reader.onload = function() {
                                let output = document.getElementById('imagePreview');
                                output.src = reader.result;
                                output.style.display = 'block';
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    });


                    function removeDiv(button, id) {
                        // Destroy CKEditor instance
                        if (CKEDITOR.instances[id]) {
                            CKEDITOR.instances[id].destroy();
                        }

                        // Remove the feature item
                        document.getElementById(id).remove();
                    }
                </script>
                <script>
                    CKEDITOR.replaceAll('texteditor');


                    // Function to remove the image
                    function removeImage() {
                        const imagePath = "{{ optional($banner)->image }}"; // Set the correct image path



                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteImage') }}', // Make sure this matches the correct route
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid1').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('imagePreview').style.display = 'none';
                                    document.querySelector('button.btn-danger').style.display = 'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },

                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }


                    function removeLearnImage() {
                        const imagePath = "{{ optional($banner)->learnimage }}";
                        // Set the correct image path for the learnimage

                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteLearnImage') }}', // Ensure this route matches the backend route for deleting learnimage
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid2').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('learnImagePreview').style.display = 'none';
                                    document.querySelector('#learnImagePreviewContainer button.btn-danger').style.display =
                                        'none';

                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }


                    function removePractiseImage() {
                        const imagePath = "{{ optional($banner)->practiseimage }}";
                        // Set the correct image path for the practiseimage

                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deletePractiseImage') }}', // Ensure this route matches the backend route for deleting practiseimage
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid3').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('practiseImagePreview').style.display = 'none';
                                    document.querySelector('#imagePreviewContainer button.btn-danger').style.display =
                                        'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }



                    // Function to preview the prepare image when a file is selected
                    function removePrepareImagePreview(event, previewId) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the prepare image preview container and the preview delete button (prepareicondelete)
                            document.getElementById('imgid4').style.display = 'block';
                            document.getElementById('icondelete4').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon4').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the prepare image preview when the preview delete button (preparedeleteicon) is clicked
                    function removePrepareImagePreview() {
                        // Clear the prepare image preview source and hide preview container and delete button
                        const output = document.getElementById('prepareImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid4').style.display = 'none';
                        document.getElementById('deleteicon4').style.display = 'none'; // Hide preview delete button
                    }
                </script>


                <script>
                    function removePrepareImage() {
                        const imagePath = "{{ optional($banner)->prepareimage }}";
                        // Set the correct image path for the prepareimage

                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deletePrepareImage') }}', // Ensure this route matches the backend route for deleting prepareimage
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid4').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('prepareImagePreview').style.display = 'none';
                                    document.querySelector('#imagePreviewContainer button.btn-danger').style.display =
                                        'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }




                    // Function to preview the review image when a file is selected
                    // Function to preview the review image when a file is selected
                    function previewReviewImage(event, previewId) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the review image preview container and the preview delete button (reviewicondelete)
                            document.getElementById('imgid5').style.display = 'block';
                            document.getElementById('icondelete5').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon5').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the review image preview when the preview delete button (reviewdeleteicon) is clicked
                    function removeReviewImagePreview() {
                        // Clear the review image preview source and hide preview container and delete button
                        const output = document.getElementById('reviewImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid5').style.display = 'none';
                        document.getElementById('deleteicon5').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the review image preview when the preview delete button (reviewdeleteicon) is clicked
                    function removeReviewImage() {
                        const imagePath = "{{ optional($banner)->reviewimage }}";
                        // Set the correct image path for the review image

                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteReviewImage') }}', // Ensure this route matches the backend route for deleting review image
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid5').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('reviewImagePreview').style.display = 'none';
                                    document.querySelector('#imagePreviewContainer button.btn-danger').style.display =
                                        'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }

                    // Function to preview the Excel image when a file is selected
                    function previewExcelImage(event, previewId, input) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the Excel image preview container and the preview delete button
                            document.getElementById('imgid6').style.display = 'block';
                            document.getElementById('icondelete6').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon6').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the Excel image preview when the preview delete button (exceldeleteicon) is clicked
                    function removeExcelImagePreview() {
                        // Clear the Excel image preview source and hide preview container and delete button
                        const output = document.getElementById('excelImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid6').style.display = 'none';
                        document.getElementById('deleteicon6').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the Excel image from the server when the delete button (excelimage delete) is clicked
                    function removeExcelImage() {
                        const imagePath = "{{ optional($banner)->excelimage }}";
                        // Set the correct image path for the Excel image

                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteExcelImage') }}', // Ensure this route matches the backend route for deleting Excel image
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid6').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('excelImagePreview').style.display = 'none';
                                    document.querySelector('#excelImagePreviewContainer button.btn-danger').style.display =
                                        'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }


                    // Function to preview the Analytics image when a file is selected
                    function previewAnalyticsImage(event, previewId, input) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the Analytics image preview container and the preview delete button
                            document.getElementById('imgid7').style.display = 'block';
                            document.getElementById('icondelete7').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon7').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the Analytics image preview when the preview delete button (deleteicon7) is clicked
                    function removeAnalyticsImagePreview() {
                        // Clear the Analytics image preview source and hide preview container and delete button
                        const output = document.getElementById('analyticsImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid7').style.display = 'none';
                        document.getElementById('deleteicon7').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the Analytics image from the server when the delete button (icondelete7) is clicked
                    function removeAnalyticsImage() {
                        const imagePath = "{{ optional($banner)->analytics_image }}";
                        // Set the correct image path for the Analytics image

                        // Send an AJAX request to delete the image
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteAnalyticsImage') }}', // Ensure this route matches the backend route for deleting Analytics image
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath // Send the image path as part of the data
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid7').hide();
                                    // Hide the image preview and the delete button
                                    document.getElementById('analyticsImagePreview').style.display = 'none';
                                    document.querySelector('#analyticsImagePreviewContainer button.btn-danger').style
                                        .display = 'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }



                    // Function to preview the Anytime image when a file is selected
                    function previewAnytimeImage(event, previewId) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the Anytime image preview container and the preview delete button
                            document.getElementById('imgid8').style.display = 'block';
                            document.getElementById('icondelete8').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon8').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the Anytime image preview when the preview delete button is clicked
                    function removeAnytimeImagePreview() {
                        const output = document.getElementById('anytimeImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid8').style.display = 'none';
                        document.getElementById('deleteicon8').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the Anytime image from the server when the delete button is clicked
                    function removeAnytimeImage() {
                        const imagePath = "{{ optional($banner)->anytime_image }}";
                        // Set the correct image path for the Anytime image

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteAnytimeImage') }}', // Ensure this route matches the backend route for deleting Anytime image
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid8').hide();
                                    document.getElementById('anytimeImagePreview').style.display = 'none';
                                    document.querySelector('#anytimeImagePreviewContainer button.btn-danger').style
                                        .display = 'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }




                    // Function to remove the Unlimited image preview when the preview delete button is clicked
                    function removeUnlimitedImagePreview() {
                        const output = document.getElementById('unlimitedImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid9').style.display = 'none';
                        document.getElementById('deleteicon9').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the Unlimited image from the server when the delete button is clicked
                    function removeUnlimitedImage() {
                        const imagePath = "{{ optional($banner)->unlimited_image }}";
                        // Set the correct image path for the Unlimited image

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteUnlimitedImage') }}', // Ensure this route matches the backend route for deleting Unlimited image
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid9').hide();
                                    document.getElementById('unlimitedImagePreview').style.display = 'none';
                                    document.querySelector('#unlimitedImagePreviewContainer button.btn-danger').style
                                        .display = 'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }


                    // Function to preview the Live Image when a file is selected
                    function previewLiveImage(event, previewId) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';

                            // Show the Live image preview container and the preview delete button
                            document.getElementById('imgid10').style.display = 'block';
                            document.getElementById('icondelete10').style.display = 'none'; // Hide saved delete button
                            document.getElementById('deleteicon10').style.display = 'block'; // Show preview delete button
                        };

                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }

                    // Function to remove the Live image preview when the preview delete button is clicked
                    function removeLiveImagePreview() {
                        const output = document.getElementById('liveImagePreview');
                        output.src = '';
                        output.style.display = 'none';

                        document.getElementById('imgid10').style.display = 'none';
                        document.getElementById('deleteicon10').style.display = 'none'; // Hide preview delete button
                    }

                    // Function to remove the Live image from the server when the delete button is clicked
                    function removeLiveImage() {
                        const imagePath = "{{ optional($banner)->live_image }}";
                        // Set the correct image path for the Live image

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteLiveImage') }}', // Ensure this route matches the backend route for deleting Live image
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_path: imagePath
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#imgid10').hide();
                                    document.getElementById('liveImagePreview').style.display = 'none';
                                    document.querySelector('#liveImagePreviewContainer button.btn-danger').style.display =
                                        'none';
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }
                </script>

                <script>
                    function removeFeatureImage(element, itemId) {
                        const imagePath = $(element).data('image-path'); // Get image path from data attribute
                        var className = $(element).data('id'); // Get class from data attribute

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.page.deleteFeatureImage') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: itemId,
                                image_path: imagePath
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Hide image and button on success
                                    $('.' + className).hide();
                                    $(element).hide();
                                } else {
                                    alert('Image could not be deleted. Please try again.');
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    }



                    function previewFeatureImagefea(event, itemId) {
    var reader = new FileReader();

    // Handle the file reading process
    reader.onload = function(e) {
        var previewImage = document.getElementById('preview-image-' + itemId);
        var previewContainer = document.getElementById('preview-container-' + itemId);
        var deleteButton = document.getElementById('deleteicon-' + itemId);

        var deleteimg2 = document.getElementById('tohideimg-' + itemId);

        // Set the image source to the selected file
        previewImage.src = e.target.result;

        // Show the preview image container
        previewContainer.style.display = 'block';

        deleteimg2.style.display = 'none';
        previewImage.style.display = 'block'; // Ensure the image is visible
        
        // Show the delete button
        deleteButton.style.display = 'inline-block'; // Display the delete button
    };

    // Read the file as a data URL
    reader.readAsDataURL(event.target.files[0]);
}





function previewFirst(event) {
        var reader = new FileReader();

        // Handle the file reading process
        reader.onload = function(e) {
            var previewImage = document.getElementById("preview-imagefirst");
            var previewContainer = document.getElementById("preview-containerfirst");
            var deleteButton = document.getElementById("deleteiconfirst");

            // Set the image source to the selected file
            previewImage.src = e.target.result;

            // Show the preview image container and the delete button
            previewContainer.style.display = 'block';
            previewImage.style.display = 'block'; // Ensure the image is visible
            deleteButton.style.display = 'inline-block'; // Display the delete button
        };

        // Read the file as a data URL
        reader.readAsDataURL(event.target.files[0]);
    }




function removeImagedelete(itemId) {
    // Clear the learn image preview source and hide preview container and delete button
    const output = document.getElementById('preview-container-' + itemId);
    if (output) {
        output.src = '';
        output.style.display = 'none';
    }

    const imgId = document.getElementById('imgid121');
    if (imgId) {
        imgId.style.display = 'none';
    }

    const deleteIcon = document.getElementById('deleteicon-' + itemId);
    if (deleteIcon) {
        deleteIcon.style.display = 'none'; // Hide preview delete button
    }
}


                    
                    function previewprocessImage(event, itemId) {
    var reader = new FileReader();

    // Handle the file reading process
    reader.onload = function(e) {
        var previewImage = document.getElementById('preview-image-' + itemId);
        var previewContainer = document.getElementById('preview-container-' + itemId);
        var deleteButton = document.getElementById('deleteicon-' + itemId);

        // Set the image source to the selected file
        previewImage.src = e.target.result;

        // Show the preview image container and image
        previewContainer.style.display = 'block';
        previewImage.style.display = 'block';

        // Show the delete button for image preview
        deleteButton.style.display = 'inline-block';
    };

    // Read the file as a data URL
    reader.readAsDataURL(event.target.files[0]);
}

function removeImagedelete(itemId) {
    var previewImage = document.getElementById('preview-image-' + itemId);
    var previewContainer = document.getElementById('preview-container-' + itemId);
    var deleteButton = document.getElementById('deleteicon121-' + itemId);

    // Reset the preview
    previewImage.src = '';
    previewImage.style.display = 'none';
    previewContainer.style.display = 'none';
    deleteButton.style.display = 'none';

    // Reset the file input
    document.getElementById('ourprocessimage-' + itemId).value = '';
}



    function removeProcessImage(element, processId) {
        const imagePath = $(element).data('image-path'); // Get image path from data attribute
        var className = $(element).data('id'); // Get class from data attribute

        $.ajax({
            type: 'POST',
            url: '{{ route('admin.page.deleteProcessImage') }}', // Define the route for deleting the process image
            data: {
                _token: '{{ csrf_token() }}',
                id: processId,
                image_path: imagePath
            },
            success: function(response) {
                if (response.success) {
                    // Hide image and button on success
                    $('.' + className).hide();
                    $(element).hide();
                } else {
                    alert('Process image could not be deleted. Please try again.');
                }
            },
            error: function(xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    }




    function previewimgImage(event, itemId) {
    var reader = new FileReader();

    // Handle the file reading process
    reader.onload = function(e) {
        // Select the elements dynamically based on the itemId
        var previewImage = document.getElementById('preview-image-' + itemId);
        var previewContainer = document.getElementById('preview-container-' + itemId);
        var deleteIcon = document.getElementById('deleteicon-text' + itemId);

        // Set the image source to the selected file
        previewImage.src = e.target.result;

        // Show the preview image and the delete icon
        previewContainer.style.display = 'block';
        previewImage.style.display = 'block'; // Ensure the image is visible
        deleteIcon.style.display = 'block';  // Display the delete button
    };

    // Read the file as a data URL
    reader.readAsDataURL(event.target.files[0]);
}



function removeimgImage(element, itemId) {
    const imagePath = $(element).data('image-path'); // Get image path from data attribute
    const className = $(element).data('id'); // Get class from data attribute

    // AJAX request to delete the image
    $.ajax({
        type: 'POST',
        url: '{{ route('admin.page.deleteImagesection7') }}', // Replace with your actual route
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            id: itemId, // ID of the item
            image_path: imagePath // Path of the image to be deleted
        },
        success: function(response) {
            if (response.success) {
                // On success, hide the image and delete button
                $('.' + className).hide(); // Hide the image container
                $(element).hide(); // Hide the delete button
            } else {
                alert(response.message || 'Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}



// Function to remove image preview and reset the file input
function removerepimg(featureIndex) {
    console.log('y');
    // Hide the preview container
    document.getElementById(`preview-container-${featureIndex}`).style.display = "none";
    
    // Reset the file input value
    document.getElementById(`featureimage-${featureIndex}`).value = "";
    
    // Hide the delete button
    document.getElementById(`deleteicon-${featureIndex}`).style.display = "none";
    
    // Optionally, reset the image preview to a blank state (or other fallback image)
    document.getElementById(`preview-image-${featureIndex}`).src = "";
}

// Function to remove image preview and reset the file input
function removerepimgfirst(featureIndex) {
    // Hide the preview container
    document.getElementById('preview-containerfirst').style.display = "none";
    
    // Reset the file input value
    document.getElementById('featureimagefirst').value = "";
    
    // Hide the delete button
    document.getElementById('deleteiconfirst').style.display = "none";
    
    // Optionally, reset the image preview to a blank state (or other fallback image)
    document.getElementById('preview-imagefirst').src = "";
}




function previewProcessImagefirst(event) {
    var reader = new FileReader();

    // Handle the file reading process
    reader.onload = function(e) {
        var previewImage = document.getElementById("preview-image-processfirst");
        var previewContainer = document.getElementById("preview-container-processfirst");
        var deleteButton = document.getElementById("delete-icon-processfirst");

        // Set the image source to the selected file
        previewImage.src = e.target.result;

        // Show the preview image container and the delete button
        previewContainer.style.display = 'block';
        previewImage.style.display = 'block'; // Ensure the image is visible
        deleteButton.style.display = 'inline-block'; // Display the delete button
    };

    reader.readAsDataURL(event.target.files[0]);
}




function removeProcessImagefirst() {
    // Hide the preview container
    document.getElementById('preview-container-processfirst').style.display = "none";

    // Reset the file input value
    document.getElementById('ourprocessimagefirst').value = "";

    // Hide the delete button
    document.getElementById('delete-icon-processfirst').style.display = "none";

    // Reset the image preview to a blank state
    document.getElementById('preview-image-processfirst').src = "";
}



function removeImagedeletepro(processIndex) {
    // Hide the preview container
    document.getElementById(`preview-container-${processIndex}`).style.display = "none";
    
    // Reset the file input value
    document.getElementById(`ourprocessimage_${processIndex}`).value = "";
    
    // Hide the delete button
    document.getElementById(`deleteicon121-${processIndex}`).style.display = "none";
    
    // Optionally, reset the image preview to a blank state (or other fallback image)
    document.getElementById(`preview-image-${processIndex}`).src = "";
}






function previewrevImage(event) {
    var reader = new FileReader();

    // Handle the file reading process
    reader.onload = function(e) {
        var previewImage = document.getElementById("preview-imagerevfirst");
        var previewContainer = document.getElementById("preview-containerrevfirst");
        var deleteButton = document.getElementById("delete-iconrevfirst");

        // Set the image source to the selected file
        previewImage.src = e.target.result;

        // Show the preview image container and the delete button
        previewContainer.style.display = 'block';
        previewImage.style.display = 'block'; // Ensure the image is visible
        deleteButton.style.display = 'inline-block'; // Display the delete button
    };

    // Read the file as a data URL
    reader.readAsDataURL(event.target.files[0]);
}






// Function to remove image preview and reset the file input
function removePreviewImage() {
    // Hide the preview container
    document.getElementById('preview-containerrevfirst').style.display = "none";
    
    // Reset the file input value
    document.getElementById('revimagefirst').value = "";
    
    // Hide the delete button
    document.getElementById('delete-iconrevfirst').style.display = "none";
    
    // Optionally, reset the image preview to a blank state (or other fallback image)
    document.getElementById('preview-imagerevfirst').src = "";
}





                    function reviewimgdelete(feedIndex) {
                        // Hide the preview container
                        document.getElementById(`preview-container-${feedIndex}`).style.display = "none";

                        // Reset the file input value
                        document.getElementById(`feedimage-${feedIndex}`).value = "";

                        // Hide the delete button
                        document.getElementById(`deleteicon131-${feedIndex}`).style.display = "none";

                        // Optionally, reset the image preview to a blank state (or other fallback image)
                        document.getElementById(`preview-image-${feedIndex}`).src = "";
                    }





                    function removeFeedItem(feedItemId) {
    // Get the element by its ID
    var feedItem = document.getElementById(feedItemId);
    if (feedItem) {
        // Hide the element by setting its display property to 'none'
        feedItem.style.display = 'none';
    } else {
        console.error(`Element with ID "${feedItemId}" not found.`);
    }
}



function removeFeatureItem(featureItemId) {
    // Get the element by its ID
    var feeatureItem = document.getElementById(featureItemId);
    if (feeatureItem) {
        // Hide the element by setting its display property to 'none'
        feeatureItem.style.display = 'none';
    } else {
        console.error(`Element with ID "${featureItemId}" not found.`);
    }
}




function removeprocessItem(processItemId) {
    // Get the element by its ID
    var processItem = document.getElementById(processItemId);
    if (processItem) {
        // Hide the element by setting its display property to 'none'
        processItem.style.display = 'none';
    } else {
        console.error(`Element with ID "${processItemId}" not found.`);
    }
}


</script>



                
            @endpush
