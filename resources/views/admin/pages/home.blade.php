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
        <a class="nav-link @if(old('section') == 'section1' || old('section') == '') active @endif" id="section1-tab" data-bs-toggle="tab" href="#section1" role="tab" aria-controls="section1" aria-selected="@if(old('section') == 'section1' || old('section') == '') true @else false @endif">Section 1</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link @if(old('section') == 'section2') active @endif" id="section2-tab" data-bs-toggle="tab" href="#section2" role="tab" aria-controls="section2" aria-selected="@if(old('section') == 'section2') true @else false @endif">Section 2</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link @if(old('section') == 'section3') active @endif" id="section3-tab" data-bs-toggle="tab" href="#section3" role="tab" aria-controls="section3" aria-selected="@if(old('section') == 'section3') true @else false @endif">Section 3</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link @if(old('section') == 'section4') active @endif" id="section4-tab" data-bs-toggle="tab" href="#section4" role="tab" aria-controls="section4" aria-selected="@if(old('section') == 'section4') true @else false @endif">Section 4</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link @if(old('section') == 'section5') active @endif" id="section5-tab" data-bs-toggle="tab" href="#section5" role="tab" aria-controls="section5" aria-selected="@if(old('section') == 'section5') true @else false @endif">Section 5</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link @if(old('section') == 'section6') active @endif" id="section6-tab" data-bs-toggle="tab" href="#section6" role="tab" aria-controls="section6" aria-selected="@if(old('section') == 'section6') true @else false @endif">Section 6</a>
    </li>
</ul>



        <!-- Tabs Content -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade  @if(old('section','save')=='save') show active @endif" id="section1" role="tabpanel" aria-labelledby="section1-tab">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <!-- First Section Fields -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" value="{{ old('title', optional($banner)->title) }}" class="form-control" placeholder="Title">
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
                                                    <label for="subtitle">Subtitle</label>
                                                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', optional($banner)->subtitle) }}" class="form-control" placeholder="Subtitle">
                                                    @error('subtitle')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 note_section">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="content">Content</label>
                                                    <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', optional($banner)->content) }}</textarea>
                                                    @error('content')
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
                                                    <label for="buttonlabel">Button Label</label>
                                                    <input type="text" name="buttonlabel" id="buttonlabel" value="{{ old('buttonlabel', optional($banner)->buttonlabel) }}" class="form-control" placeholder="Button Label">
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
                                                    <label for="buttonlink">Button Link</label>
                                                    <input type="text" name="buttonlink" id="buttonlink" value="{{ old('buttonlink', optional($banner)->buttonlink) }}" class="form-control" placeholder="Button Link">
                                                    @error('buttonlink')
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
                                                    <label for="image">Upload Image</label>
                                                    <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
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
                                            <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                                 @if(isset($banner) && $banner->image)
                                                <img id="imagePreview" src="{{ url('d0/'.$banner->image) }}" alt="Image Preview" style="width: 100%; height: auto;">

                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                 @endif
                                                 </div>
                                                    </div>
                                    <!-- Save Button -->
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
                            <form action="{{ route('admin.page.section2') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <!-- Second Section Fields -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="guaranteetitle">Guarantee Title</label>
                                                    <input type="text" name="guaranteetitle" id="guaranteetitle" value="{{ old('guaranteetitle', optional($banner)->guaranteetitle) }}" class="form-control" placeholder="Guarantee Title">
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
                                                    <label for="learntitle">Learn Title</label>
                                                    <input type="text" name="learntitle" id="learntitle" value="{{ old('learntitle', optional($banner)->learntitle) }}" class="form-control" placeholder="Learn Title">
                                                    @error('learntitle')
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
                                                    <label for="learnimage">Learn Image</label>
                                                    <input type="file" name="learnimage" id="learnimage" value="{{ old('learnimage', optional($banner)->learnimage) }}" class="form-control" onchange="previewImage(event)">
                                                    @error('learnimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px;">
                                                 @if(isset($banner) && $banner->learnimage)
                                                <img id="imagePreview" src="{{ url('d0/'.$banner->learnimage) }}" alt="Image Preview" style="width: 100%; height: auto;">

                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                 @endif
                                                 </div>
                                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="learncontent">Learn Content</label>
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
                                                    <label for="practisetitle">Practice Title</label>
                                                    <input type="text" name="practisetitle" id="practisetitle" value="{{ old('practisetitle', optional($banner)->practisetitle) }}" class="form-control" placeholder="Practice Title">
                                                    @error('practisetitle')
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
                                                    <label for="practiseimage">Practice Image</label>
                                                    <input type="file" name="practiseimage" id="practiseimage" value="{{ old('practiseimage', optional($banner)->practiseimage) }}" class="form-control" onchange="previewImage(event)">
                                                    @error('practiseimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px;">
                                                 @if(isset($banner) && $banner->practiseimage)
                                                <img id="imagePreview" src="{{ url('d0/'.$banner->practiseimage) }}" alt="Image Preview" style="width: 100%; height: auto;">

                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                 @endif
                                                 </div>
                                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="practisecontent">Practice Content</label>
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
                                                    <label for="preparetitle">Prepare Title</label>
                                                    <input type="text" name="preparetitle" id="preparetitle" value="{{ old('preparetitle', optional($banner)->preparetitle) }}" class="form-control" placeholder="Prepare Title">
                                                    @error('preparetitle')
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
                                                    <label for="prepareimage">Prepare Image</label>
                                                    <input type="file" name="prepareimage" id="prepareimage" value="{{ old('prepareimage', optional($banner)->prepareimage) }}" class="form-control" onchange="previewImage(event)">
                                                    @error('prepareimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px;">
                                                 @if(isset($banner) && $banner->prepareimage)
                                                <img id="imagePreview" src="{{ url('d0/'.$banner->prepareimage) }}" alt="Image Preview" style="width: 100%; height: auto;">

                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                 @endif
                                                 </div>
                                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="preparecontent">Prepare Content</label>
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
                                                    <label for="reviewtitle">Review Title</label>
                                                    <input type="text" name="reviewtitle" id="reviewtitle" value="{{ old('reviewtitle', optional($banner)->reviewtitle) }}" class="form-control" placeholder="Review Title">
                                                    @error('reviewtitle')
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
                                                    <label for="reviewimage">Review Image</label>
                                                    <input type="file" name="reviewimage" id="reviewimage" value="{{ old('reviewimage', optional($banner)->reviewimage) }}" class="form-control" onchange="previewImage(event)">
                                                    @error('reviewimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px;">
                                                 @if(isset($banner) && $banner->reviewimage)
                                                <img id="imagePreview" src="{{ url('d0/'.$banner->reviewimage) }}" alt="Image Preview" style="width: 100%; height: auto;">

                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                 @endif
                                                 </div>
                                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="reviewcontent">Review Content</label>
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
                                        <button type="submit" class="btn btn-primary" name="section" value="section2">Save</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>





            <div class="tab-pane fade @if(old('section') == 'section3') show active @endif" id="section3" role="tabpanel" aria-labelledby="section3-tab">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.page.section3') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="FeatureHeading">Feature Top Heading</label>
                                        <input type="text" name="FeatureHeading" class="form-control" value="{{ old('FeatureHeading', optional($banner)->FeatureHeading) }}" placeholder="Feature Top Heading">
                                        @error('FeatureHeading')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                            @if(!empty($feature) && count($feature) > 0)
                                @foreach ($feature as $k => $item)

                                    <div class="outer-feature" id="close-{{$item->id}}">

                                        <!-- Feature Subtitle -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="featuresubtitle">Feature Heading</label>
                                                        <input type="text" name="featuresubtitleupdate[]" class="form-control" placeholder="Feature Heading" value="{{ $item->featuresubtitle }}">
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
                                                        <label for="featurecontent">Feature Description</label>
                                                        <textarea name="featurecontentupdate[]" class="form-control" rows="5" placeholder="Feature Description">{{ $item->featurecontent }}</textarea>
                                                        @error('featurecontent')
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
                                                        <label for="featureimage">Feature Image</label>
                                                        <input type="hidden" name="featureids[]" value="{{$item->id}}">
                                                        <input type="file" name="featureimageupdate[]" class="form-control" onchange="previewFeatureImage(event)">
                                                        @if(!empty($item->image))
                                                            <img src="{{ url('d0/' . $item->image) }}" alt="Feature Image" style="max-width: 100px; margin-top: 10px;">
                                                        @endif
                                                        @error('featureimage')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-danger" onclick="removeDiv(this, 'close-{{$item->id}}')" data-feature-id="{{$item->id}}">X</button>

                                    </div>

                                @endforeach

                                        @else

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="featuresubtitle">Feature Heading</label>
                                                    <input type="text" name="featuresubtitle[]" class="form-control" placeholder="Feature Heading">
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
                                                    <label for="featurecontent">Feature Description</label>
                                                    <textarea name="featurecontent[]" class="form-control" rows="5" placeholder="Feature Description"></textarea>
                                                    @error('featurecontent')
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
                                                    <label for="featureimage">Feature Image</label>
                                                    <input type="file" name="featureimage[]" class="form-control" onchange="previewFeatureImage(event)">
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
                                        <button type="submit" class="btn btn-primary" name="section" value="section3">Save</button>
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>






          <!-- Section 4 Content -->
          <div class="tab-pane fade @if(old('section') == 'section4') show active @endif" id="section4" role="tabpanel" aria-labelledby="section4-tab">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.page.section4') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                 <!-- Fourth Section Fields -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-data">
                                            <div class="forms-inputs mb-4">
                                                <label for="exceltitle">Excel Title</label>
                                                <input type="text" name="exceltitle" id="exceltitle" value="{{ old('exceltitle', optional($banner)->exceltitle) }}" class="form-control" placeholder="Excel Title">
                                                @error('exceltitle')
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
                                                <label for="excelsubtitle">Excel Subtitle</label>
                                                <input type="text" name="excelsubtitle" id="excelsubtitle" value="{{ old('excelsubtitle', optional($banner)->excelsubtitle) }}" class="form-control" placeholder="Excel Subtitle">
                                                @error('excelsubtitle')
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
                                                <label for="subtitle1">Subtitle 1</label>
                                                <input type="text" name="subtitle1" id="subtitle1" value="{{ old('subtitle1', optional($banner)->subtitle1) }}" class="form-control" placeholder="Subtitle 1">
                                                @error('subtitle1')
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
                                                <label for="subtitle2">Subtitle 2</label>
                                                <input type="text" name="subtitle2" id="subtitle2" value="{{ old('subtitle2', optional($banner)->subtitle2) }}" class="form-control" placeholder="Subtitle 2">
                                                @error('subtitle2')
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
                                                <label for="subtitle3">Subtitle 3</label>
                                                <input type="text" name="subtitle3" id="subtitle3" value="{{ old('subtitle3', optional($banner)->subtitle3) }}" class="form-control" placeholder="Subtitle 3">
                                                @error('subtitle3')
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
                                        <label for="excelbuttonlabel">Excel Button Label</label>
                                        <input type="text" name="excelbuttonlabel" id="excelbuttonlabel" value="{{ old('excelbuttonlabel', optional($banner)->excelbuttonlabel) }}" class="form-control" placeholder="Excel Button Label">
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
                                        <label for="excelbuttonlink">Excel Button Link</label>
                                        <input type="text" name="excelbuttonlink" id="excelbuttonlink" value="{{ old('excelbuttonlink', optional($banner)->excelbuttonlink) }}" class="form-control" placeholder="Excel Button Link">
                                        @error('excelbuttonlink')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Excel Image -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="excelimage">Excel Image</label>
                                        <input type="file" name="excelimage" id="excelimage" class="form-control" onchange="previewExcelImage(event)">
                                        @error('excelimage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div class="form-group">
                            <label for="imagePreview">Image Preview</label>
                            <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px;">
                                @if(isset($banner) && $banner->excelimage)
                                    <img id="imagePreview" src="{{ url('d0/'.$banner->excelimage) }}" alt="Image Preview" style="width: 100%; height: auto;">

                                    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                @endif
                            </div>
                        </div>




                                     <!-- Submit Button -->
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary" name="section" value="section4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- Section 4 Content -->
<div class="tab-pane fade @if(old('section') == 'section5') show active @endif" id="section5" role="tabpanel" aria-labelledby="section5-tab">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.page.section5') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Fourth Section Fields -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="coursetitle">Course Title</label>
                                        <input type="text" name="coursetitle" id="coursetitle" value="{{ old('coursetitle', optional($courses)->coursetitle) }}" class="form-control" placeholder="Course Title">
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
                                        <label for="coursesubtitle">Course Subtitle</label>
                                        <input type="text" name="coursesubtitle" id="coursesubtitle" value="{{ old('coursesubtitle', optional($courses)->coursesubtitle) }}" class="form-control" placeholder="Course Subtitle">
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
                                        <label for="courseheading1">Course Heading 1</label>
                                        <input type="text" name="courseheading1" id="courseheading1" value="{{ old('courseheading1', optional($courses)->courseheading1) }}" class="form-control" placeholder="Course Heading 1">
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
                                        <label for="coursecontent1">Course Content 1</label>
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
                                        <label for="courseheading2">Course Heading 2</label>
                                        <input type="text" name="courseheading2" id="courseheading2" value="{{ old('courseheading2', optional($courses)->courseheading2) }}" class="form-control" placeholder="Course Heading 2">
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
                                        <label for="coursecontent2">Course Content 2</label>
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
                                        <label for="courseheading3">Course Heading 3</label>
                                        <input type="text" name="courseheading3" id="courseheading3" value="{{ old('courseheading3', optional($courses)->courseheading3) }}" class="form-control" placeholder="Course Heading 3">
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
                                        <label for="coursecontent3">Course Content 3</label>
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
                                        <label for="courseheading4">Course Heading 4</label>
                                        <input type="text" name="courseheading4" id="courseheading4" value="{{ old('courseheading4', optional($courses)->courseheading4) }}" class="form-control" placeholder="Course Heading 4">
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
                                        <label for="coursecontent4">Course Content 4</label>
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
                                        <label for="coursebuttonlabel">Course Button Label</label>
                                        <input type="text" name="coursebuttonlabel" id="coursebuttonlabel" value="{{ old('coursebuttonlabel', optional($courses)->coursebuttonlabel) }}" class="form-control" placeholder="Course Button Label">
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
                                        <label for="coursebuttonlink">Course Button Link</label>
                                        <input type="text" name="coursebuttonlink" id="coursebuttonlink" value="{{ old('coursebuttonlink', optional($courses)->coursebuttonlink) }}" class="form-control" placeholder="Course Button Link">
                                        @error('coursebuttonlink')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary" name="section" value="section5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Section 6 Content -->
<div class="tab-pane fade @if(old('section') == 'section6') show active @endif" id="section6" role="tabpanel" aria-labelledby="section6-tab">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.page.section6') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Student Title Field -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="studenttitle">Student Title</label>
                                <input type="text" name="studenttitle" id="studenttitle" value="{{ old('studenttitle', optional($courses)->studenttitle) }}" class="form-control" placeholder="Student Title">
                                @error('studenttitle')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Student Subtitle Field -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="studentsubtitle">Student Subtitle</label>
                                <input type="text" name="studentsubtitle" id="studentsubtitle" value="{{ old('studentsubtitle', optional($courses)->studentsubtitle) }}" class="form-control" placeholder="Student Subtitle">
                                @error('studentsubtitle')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if(!empty($feed) && count($feed) > 0)
                            @foreach ($feed as $k => $item)
                                <div class="outer-feature" id="closefeed-{{$item->id}}">
                                    <!-- Name -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="nameupdate[]" class="form-control" placeholder="Name" value="{{ $item->name }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


{{--
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="starrating">Star Rating</label>
                                            <select name="starratingupdate[]" class="form-control">
                                                <option value="1" {{ $item->starrating == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->starrating == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->starrating == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $item->starrating == 4 ? 'selected' : '' }}>4</option>
                                                <option value="5" {{ $item->starrating == 5 ? 'selected' : '' }}>5</option>
                                            </select>
                                            @error('starrating')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}



                                    <div class="form-group">
                                        <label for="starrating">Star Rating</label>
                                        <select name="starratingupdate[]" class="form-control">
                                            <option value="1" {{ $item->starrating == 1 ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ $item->starrating == 2 ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ $item->starrating == 3 ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ $item->starrating == 4 ? 'selected' : '' }}>4</option>
                                            <option value="5" {{ $item->starrating == 5 ? 'selected' : '' }}>5</option>
                                        </select>
                                        @error('starrating')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>





                                    <!-- Review -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="review">Review</label>
                                            <textarea name="reviewupdate[]" class="form-control" rows="5" placeholder="Review">{{ $item->review }}</textarea>
                                            @error('review')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="hidden" name="feedids[]" value="{{$item->id}}">
                                            <input type="file" name="imageupdate[]" class="form-control" onchange="previewFeatureImage(event)">
                                            @if(!empty($item->image))
                                                <img src="{{ url('d0/' . $item->image) }}" alt="Image" style="max-width: 100px; margin-top: 10px;">
                                            @endif
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-md-12 mb-3">
                                        <button type="button" class="btn btn-danger" onclick="removeDiv(this, 'closefeed-{{$item->id}}')" data-feed-id="{{$item->id}}">X</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Default Name Field -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name[]" class="form-control" placeholder="Name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="starrating">Star Rating</label>
                                    <input type="text" name="starrating[]" class="form-control" placeholder="Star Rating">
                                    @error('starrating')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>






               <!-- Default Review Field -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="review">Review</label>
                                    <textarea name="review[]" class="form-control" rows="5" placeholder="Review"></textarea>
                                    @error('review')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Default Image Field -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image[]" class="form-control" onchange="previewFeatureImage(event)">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Dynamic Feed Container -->
                        <div class="col-md-12" id="feedContainer"></div>

                        <!-- Add Feature Button -->
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-dark" id="addFeed">Add</button>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary" name="section" value="section6">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Include Bootstrap JS (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>


<script>



        document.addEventListener('DOMContentLoaded', function () {
        let featureIndex = 0;

        document.getElementById('addFeature').addEventListener('click', function () {
            featureIndex++;

            let featureHTML = `
                <div class="feature-item mb-3">
                    <h4>Feature ${featureIndex}</h4>

                    <div class="form-group">
                        <label for="featuresubtitle${featureIndex}">Feature Heading</label>
                        <input type="text" name="featuresubtitle[]" id="featuresubtitle${featureIndex}" class="form-control" placeholder="Feature Heading">
                    </div>
                    <div class="form-group">
                        <label for="featurecontent${featureIndex}">Feature Description</label>
                        <textarea name="featurecontent[]" id="featurecontent${featureIndex}" class="form-control" rows="5" placeholder="Feature Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="featureimage_${featureIndex}">Feature Image</label>
                        <input type="file" name="featureimage[]" id="featureimage_${featureIndex}" class="form-control" onchange="previewFeatureImage(event)">
                    </div>
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

document.addEventListener('DOMContentLoaded', function () {
    let feedIndex = 0;

    document.getElementById('addFeed').addEventListener('click', function () {
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
                    <input type="text" name="starrating[]" id="starrating${feedIndex}" class="form-control" placeholder="Star Rating">
                </div>

                <!-- Review Field -->
                <div class="form-group">
                    <label for="review${feedIndex}">Review</label>
                    <textarea name="review[]" id="review${feedIndex}" class="form-control" rows="5" placeholder="Review"></textarea>
                </div>

                <!-- Image Field -->
                <div class="form-group">
                    <label for="image_${feedIndex}">Image</label>
                    <input type="file" name="image[]" id="image_${feedIndex}" class="form-control" onchange="previewFeedImage(event)">
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






@endsection

