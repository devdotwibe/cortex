@extends('layouts.admin')
@section('title', 'Pricing')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Pricing</h2>
        </div>
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container">
        
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade   show active " id="section1" role="tabpanel" aria-labelledby="section1-tab">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="http://localhost:8000/admin/page" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="KQyqLkVJSBUfegcLqDhFcp7qMxxxpb5rsPKiqymF" autocomplete="off">                                <div class="row">

                                    <!-- First Section Fields -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="subtitle">Subtitle</label>
                                                    <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Subtitle">
                                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 note_section">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="content">Content</label>
                                                    <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 video_section">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="buttonlabel">Button Label</label>
                                                    <input type="text" name="buttonlabel" id="buttonlabel" class="form-control" placeholder="Button Label">
                                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 video_section">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="buttonlink">Button Link</label>
                                                    <input type="text" name="buttonlink" id="buttonlink" class="form-control" placeholder="Button Link">
                                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="image">Upload Image</label>
                                                    <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event, 'imagePreview')">
                                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    {{-- <div class="form-group">
                                        <label for="imagePreview">Image Preview</label>
                                        <div id="imagePreviewContainer" style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                                                                            <img id="imagePreview" src="http://localhost:8000/d0/banner/qabdNs9Do5psRcEtkDgYOD10w2CgDgXXapxSgDTC.jpg" alt="Image Preview" style="width: 100%; height: auto;">
                                                                                    </div>
                                    </div> --}}
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
    </div>
</section>
@endsection