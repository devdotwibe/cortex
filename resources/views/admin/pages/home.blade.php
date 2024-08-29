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

                                {{-- <button type="button" class="btn-btn-danger" onclick="removeDiv(this,close-{{$item->id}})">X</button> --}}

                                {{-- <button type="button" class="btn btn-danger" onclick="removeDiv(this, 'close-{{$item->id}}')">X</button> --}}

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


</section>

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



    // function removeDiv(element,id)
    // {
    //     $('#'+id).remove();
    // }



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



@endsection

