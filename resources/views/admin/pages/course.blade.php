@extends('layouts.admin')

@section('title', 'Course')

@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Course </h2>
                {{-- {{session('section_tab')}} {{session('section_tab1')}} {{session('section_tab11')}} --}}
            </div>
        </div>
    </section>

    <section class="invite-wrap mt-2">
        <div class="container">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('section_tab') == 'section1-tab' || session('section_tab') == "") active @endif" id="section1-tab"
                        data-bs-toggle="tab" href="#section1" role="tab" aria-controls="section1"
                        aria-selected="@if (old('section') == 'section1' || old('section') == '') true @else false @endif">Section 1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('section_tab') == 'section2-tab')  active @endif"
                        id="section2-tab" data-bs-toggle="tab" href="#section2" role="tab" aria-controls="section2"
                        aria-selected="@if (old('section') == 'section2') true @else false @endif">Section 2</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('section_tab') == 'section3-tab')  active @endif" id="section3-tab"
                        data-bs-toggle="tab" href="#section3" role="tab" aria-controls="section3"
                        aria-selected="@if (old('section') == 'section3') true @else false @endif">Section 3</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('section_tab') == 'section5-tab') active @endif" id="section5-tab"
                        data-bs-toggle="tab" href="#section5" role="tab" aria-controls="section5"
                        aria-selected="@if (old('section') == 'section5') true @else false @endif">Section 4</a>
                </li>


            </ul>


            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade @if (session('section_tab') == 'section1-tab' ||  session('section_tab') == "") show active @endif" id="section1"
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
                                                        <label for="heading" >Course Banner Title</label>
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
                                                        <label for="learn_btn_label">Learn Button Label*</label>
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
                                                        <label for="learn_btn_link">Learn Button Link*</label>
                                                        <input type="text" class="form-control" name="buttonlink"
                                                            value="{{ old('buttonlink', optional($course)->buttonlink) }}">
                                                        @error('buttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                      

                                   


                                    <div class="numericalsectionclass">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="image" class="file-upload">Section Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon"></label>
                                                <input type="file" class="form-control" style="display: none;" name="image" id="image" onchange="previewImage(event, 'imagePreview',this)" data-id="imgid1">
                                            </div>
                                        </div>
                                    
                                        <div class="form-group imgid1" id="imgid1" style="display: {{ isset($course) && $course->image ? 'block' : 'none' }};">
                                            <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->image)
                                                    <img id="imagePreview-save" src="{{ url('d0/' . $course->image) }}" alt="Image Preview"
                                                         style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondelete1" style="position: absolute; top: 5px; right: 5px;"
                                                            onclick="removeSectionImage()">X</button>
                                                @endif
                                        
                                                <!-- Dynamic image preview -->
                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteicon1" style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeImage()">X</button>


                                                         <!-- Delete button for saved image -->
                                                     <button type="button" class="btn btn-danger" id="icondelete1"
                                                     style="position: absolute; top: 5px; right: 5px; {{ isset($course) && $course->image ? 'display: block;' : 'display: none;' }}"
                                                     onclick="removeSectionImage()">X</button>


                                            </div>
                                        </div>
                                                                        
                                    </div>
                                    
                                   


                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-dark learn" name="section"
                                                    value="save">Save</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>







                <div class="tab-pane fade @if (session('section_tab') == 'section2-tab')  show active @endif"
                    id="section2" role="tabpanel" aria-labelledby="section2-tab">





                    <form action="{{ route('admin.course.section2') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="coursetitle">Course Title*</label>
                                <textarea class="form-control texteditor" name="coursetitle" id="coursetitle">{{ old('coursetitle', optional($course)->coursetitle) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary coursetitle" name="section"
                                    value="save">Save</button>
                            </div>
                        </div>
                    </form>






                    <ul class="nav nav-tabs" id="section2Tabs" role="tablist">
                        @foreach($tabs1 as $k => $tab)
                            <li class="nav-item" role="presentation" data-tab-id="{{ $tab['tab_id_1'] }}">
                                <a class="nav-link @if(session('section_tab1') == $tab['tab_id_1'] || ($k ==0) && session('section_tab1')=="") active @endif"
                                   id="{{ $tab['tab_id_1'] }}-tab"
                                   data-bs-toggle="tab"
                                   href="#{{ $tab['tab_id_1'] }}"
                                   role="tab"
                                   aria-controls="{{ $tab['tab_id_1'] }}"
                                   aria-selected="@if (old('sub_section') == $tab['tab_id_1']) true @else false @endif">
                                    {{ $tab['tab_name_1'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>


                    <div class="tab-content mt-2" id="section2TabContent">
                        <!-- Tab 1 -->








                        <div class="tab-pane fade @if (session('section_tab1') == 'tab1' || (session('section_tab1')=="" && $tabsctive1->tab_id_1=='tab1' )) show active @endif"
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
                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="logicalimage" class="file-upload">Logical Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                </label>
                                                <input type="file" class="form-control" style="display: none;" name="logicalimage" id="logicalimage" 
                                                       onchange="previewLogicalImage(event, 'logicalImagePreview', this)" data-id="logicalimgid1">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group logicalimgid1" id="logicalimgid1" 
                                             style="display: {{ isset($course) && $course->logicalimage ? 'block' : 'none' }};">
                                            <label for="logicalImagePreview">Image Preview</label>
                                            <div id="logicalImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->logicalimage)
                                                    <img id="logicalImagePreview-save" src="{{ url('d0/' . $course->logicalimage) }}"
                                                         alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondeletelogicalimg" 
                                                            style="position: absolute; top: 5px; right: 5px;" 
                                                            onclick="removeLogicalImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview -->
                                                <img id="logicalImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteiconlogicalimg" 
                                                        style="position: absolute; top: 5px; right: 5px; display: none;" 
                                                        onclick="removeImage2()">X</button>
                                    
                                                <!-- Delete button for saved image -->
                                                <button type="button" class="btn btn-danger" id="icondeletelogicalimg"
                                                        style="position: absolute; top: 5px; right: 5px; 
                                                               {{ isset($course) && $course->logicalimage ? 'display: block;' : 'display: none;' }};"
                                                        onclick="removeLogicalImage()">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                                <button type="submit" class="btn btn-dark logical" name="sub_section"
                                    value="tab1_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 2 -->




                        <div class="tab-pane fade @if (session('section_tab1') == 'tab2' || (session('section_tab1')=="" && $tabsctive1->tab_id_1=='tab2' ))  show active @endif" id="tab2"
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

                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="criticalimage" class="file-upload">Critical Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                </label>
                                                <input type="file" class="form-control" style="display: none;" name="criticalimage" id="criticalimage" 
                                                       onchange="previewCriticalImage(event, 'criticalImagePreview', this)" data-id="criticalimgid1">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group criticalimgid1" id="criticalimgid1" 
                                             style="display: {{ isset($course) && $course->criticalimage ? 'block' : 'none' }};">
                                            <label for="criticalImagePreview">Image Preview</label>
                                            <div id="criticalImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->criticalimage)
                                                    <img id="criticalImagePreview-save" src="{{ url('d0/' . $course->criticalimage) }}" 
                                                         alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondeletecriticalimg" 
                                                            style="position: absolute; top: 5px; right: 5px;" 
                                                            onclick="removeCriticalImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview -->
                                                <img id="criticalImagePreview" src="#" alt="Image Preview" 
                                                     style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteiconcriticalimg" 
                                                        style="position: absolute; top: 5px; right: 5px; display: none;" 
                                                        onclick="removeImagecritical()">X</button>
                                    
                                                <!-- Delete button for saved image -->
                                                <button type="button" class="btn btn-danger" id="icondeletecriticalimg"
                                                        style="position: absolute; top: 5px; right: 5px;
                                                               {{ isset($course) && $course->criticalimage ? 'display: block;' : 'display: none;' }};"
                                                        onclick="removeCriticalImage()">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                                <button type="submit" class="btn btn-dark critical" name="sub_section"
                                    value="tab2_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 3 -->





                        <div class="tab-pane fade @if (session('section_tab1') == 'tab3' || (session('section_tab1')=="" && $tabsctive1->tab_id_1=='tab3' ))  show active @endif" id="tab3"
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
                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="abstractimage" class="file-upload">Abstract Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                </label>
                                                <input type="file" class="form-control" style="display: none;" name="abstractimage" id="abstractimage" onchange="previewAbstractImage(event, 'abstractImagePreview', this)">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group" id="abstractimgid1" style="display: {{ isset($course) && $course->abstractimage ? 'block' : 'none' }};">
                                            <label for="abstractImagePreview">Image Preview</label>
                                            <div id="abstractImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->abstractimage)
                                                    <img id="abstractImagePreview-save" src="{{ url('d0/' . $course->abstractimage) }}"
                                                        alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondeleteabstractimg"
                                                            style="position: absolute; top: 5px; right: 5px;"
                                                            onclick="removeAbstractImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview -->
                                                <img id="abstractImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteiconabstractimg"
                                                        style="position: absolute; top: 5px; right: 5px; display: none;"
                                                        onclick="removeImageabstract()">X</button>
                                    
                                                <!-- Delete button for saved image -->
                                                <button type="button" class="btn btn-danger" id="icondeleteabstractimg"
                                                        style="position: absolute; top: 5px; right: 5px; 
                                                               {{ isset($course) && $course->abstractimage ? 'display: block;' : 'display: none;' }};"
                                                        onclick="removeAbstractImage()">X</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-dark abstract" name="sub_section"
                                    value="tab3_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 4 -->




                        <div class="tab-pane fade @if (session('section_tab1') == 'tab4' || (session('section_tab1')=="" && $tabsctive1->tab_id_1=='tab4' )) show active @endif" id="tab4"
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

                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="numericalimage" class="file-upload">Numerical Image  <br>
                                                <img src="{{ asset('assets/images/upfile.svg') }}"
                                                    alt="Upload Icon"></label>
                                            <input type="file" class="form-control" style="display: none;" name="numericalimage">
                                        </div>
                                    </div> --}}

                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="numericalimage" class="file-upload">Numerical Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                                </label>
                                                <input type="file" class="form-control" style="display: none;" name="numericalimage" id="numericalimage" 
                                                       onchange="previewNumericalImage(event, 'numericalImagePreview', this)">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group numericalimgid2" id="numericalimgid2" 
                                             style="display: {{ isset($course) && $course->numericalimage ? 'block' : 'none' }};">
                                            <label for="numericalImagePreview">Image Preview</label>
                                            <div id="numericalImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->numericalimage)
                                                    <img id="numericalImagePreview-save" src="{{ url('d0/' . $course->numericalimage) }}"
                                                         alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondeletenumericalimg" 
                                                            style="position: absolute; top: 5px; right: 5px;" 
                                                            onclick="removeNumericalImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview -->
                                                <img id="numericalImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteiconnumericalimg" 
                                                        style="position: absolute; top: 5px; right: 5px; display: none;" 
                                                        onclick="removeImagenumerical()">X</button>
                                    
                                                <!-- Delete button for saved image -->
                                                <button type="button" class="btn btn-danger" id="icondeletenumericalimg"
                                                        style="position: absolute; top: 5px; right: 5px; 
                                                               {{ isset($course) && $course->numericalimage ? 'display: block;' : 'display: none;' }};"
                                                        onclick="removeNumericalImage()">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                                <button type="submit" class="btn btn-dark numerical" name="sub_section"
                                    value="tab4_save">Save</button>
                            </form>
                        </div>

                    </div>
                </div>








                <div class="tab-pane fade @if (session('section_tab') == 'section3-tab')  show active @endif" id="section3"
                    role="tabpanel" aria-labelledby="section3-tab">




                    <ul class="nav nav-tabs" id="section3Tabs" role="tablist">
                        @foreach($tabs2 as $k => $tab)
                            <li class="nav-item" role="presentation" data-tab-id="{{ $tab['tab_id_2'] }}">
                                <a class="nav-link @if(session('section_tab11') == $tab['tab_id_2'] || ($k ==0) && session('section_tab11')=="") active @endif"
                                   id="{{ $tab['tab_id_2'] }}-tab"
                                   data-bs-toggle="tab"
                                   href="#{{ $tab['tab_id_2'] }}"
                                   role="tab"
                                   aria-controls="{{ $tab['tab_id_2'] }}"
                                   aria-selected="@if (old('sub_section') == $tab['tab_id_2']) true @else false @endif">
                                    {{ $tab['tab_name_2'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>





                    <div class="tab-content mt-2" id="section3TabContent">
                        <!-- Tab 1: Learn Content & Learn Image -->






                        <div class="tab-pane fade @if (session('section_tab11') == 'sec_tab1' || (session('section_tab11')=="" && $tabsctive2->tab_id_2=='sec_tab1')) show active @endif"  id="sec_tab1"
                            role="tabpanel" aria-labelledby="sec_tab1">
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

                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="learnimage" class="file-upload">Learn Image  <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon"> </label>
                                                <input type="file" class="form-control" style="display: none;" name="learnimage" id="learnimage" onchange="previewLearnImage(event, 'learnImagePreview', this)" data-id="learnimgid1">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group learnimgid1" id="learnimgid1" style="display: {{ isset($course) && $course->learnimage ? 'block' : 'none' }};">
                                            <label for="learnImagePreview">Image Preview</label>
                                            <div id="learnImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->learnimage)
                                                    <img id="learnImagePreview-save" src="{{ url('d0/' . $course->learnimage) }}"
                                                        alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondeletelearnimg" 
                                                            style="position: absolute; top: 5px; right: 5px;" 
                                                            onclick="removeLearnImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview -->
                                                <img id="learnImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteiconlearnimg" 
                                                        style="position: absolute; top: 5px; right: 5px; display: none;" 
                                                        onclick="removeImage1()">X</button>
                                    
                                                <!-- Delete button for saved image -->
                                                <button type="button" class="btn btn-danger" id="icondeletelearnimg"
                                                        style="position: absolute; top: 5px; right: 5px; 
                                                               {{ isset($course) && $course->learnimage ? 'display: block;' : 'display: none;' }}"
                                                        onclick="removeLearnImage()">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                            </div>

                                <button type="submit" class="btn btn-dark lrn" name="sub_section"
                                    value="tab1_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 2: Question Bank Content & Image -->




                        <div class="tab-pane fade @if (session('section_tab11') == 'sec_tab2' || (session('section_tab11')=="" && $tabsctive2->tab_id_2=='sec_tab2')) show active @endif" id="sec_tab2"
                            role="tabpanel" aria-labelledby="sec_tab2">
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
                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="questionbankimage" class="file-upload">
                                                    Question Bank Image  
                                                    <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon"> 
                                                </label>
                                                <input type="file" class="form-control" style="display: none;" name="questionbankimage" id="questionbankimage" onchange="previewQuestionBankImage(event, 'questionbankImagePreview', this)" data-id="imgid10">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group imgid10" id="imgid10" style="display: {{ isset($course) && $course->questionbankimage ? 'block' : 'none' }};">
                                            <label for="questionbankImagePreview">Image Preview</label>
                                            <div id="questionbankImagePreviewContainer" class="numericalclass">
                                            
                                                @if (isset($course) && $course->questionbankimage)
                                                    <!-- Display existing image if set -->
                                                    <img id="questionbankImagePreview-save" src="{{ url('d0/' . $course->questionbankimage) }}" alt="Image Preview" style="width: 100%; height: auto;">
                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="icondeletequestionbankimg" style="position: absolute; top: 5px; right: 5px;" onclick="removeQuestionBankImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview (hidden by default) -->
                                                <img id="questionbankImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                
                                                <button type="button" class="btn btn-danger" id="deleteiconquestionbankimg" style="position: absolute; top: 5px; right: 5px; display: none;" onclick="removeQuestionImage()">X</button>
                                    



                                                <!-- Delete button for saved image (if exists) -->
                                                <button type="button" class="btn btn-danger" id="icondeletequestionbankimg" style="position: absolute; top: 5px; right: 5px; 
                                                    {{ isset($course) && $course->questionbankimage ? 'display: block;' : 'display: none;' }}" onclick="removeQuestionBankImage()">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                            
                        </div>
                                <button type="submit" class="btn btn-dark qbank" name="sub_section"
                                    value="tab2_save">Save</button>
                            </form>
                        </div>

                        <!-- Tab 3: Topic Content & Image -->




                        <div class="tab-pane fade @if (session('section_tab11') == 'sec_tab3'|| (session('section_tab11')=="" && $tabsctive2->tab_id_2=='sec_tab3' )) show active @endif" id="sec_tab3"
                            role="tabpanel" aria-labelledby="sec_tab3">
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
                 

                            <div class="numericalsectionclass">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="topicimage" class="file-upload">
                                            Topic Image  
                                            <br>
                                            <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon">
                                        </label>
                                        <input type="file" class="form-control" style="display: none;" name="topicimage" id="topicimage" 
                                               onchange="previewTopicImage(event, 'topicImagePreview', this)" data-id="imgid20">
                                    </div>
                                </div>
                            
                                <!-- Preview Image Container -->
                                <div class="form-group imgid20" id="imgid20" 
                                     style="display: {{ isset($course) && $course->topicimage ? 'block' : 'none' }};">
                                    <label for="topicImagePreview">Image Preview</label>
                                    <div id="topicImagePreviewContainer" class="numericalclass">
                                        @if (isset($course) && $course->topicimage)
                                            <!-- Display existing image if set -->
                                            <img id="topicImagePreview-save" src="{{ url('d0/' . $course->topicimage) }}" 
                                                 alt="Image Preview" style="width: 100%; height: auto;">

                                                 <button type="button" class="btn btn-danger" id="iconDeleteTopicImage" style="position: absolute; top: 5px; right: 5px;" onclick="removeTopicImage()">X</button>

                                                 
                                            <!-- Delete button for saved image -->
                                            <button type="button" class="btn btn-danger" id="iconDeleteTopicImage" 
                                                    style="position: absolute; top: 5px; right: 5px;" 
                                                    onclick="removeTopicImage()" >X</button>
                                        @endif
                            
                                        <!-- Dynamic image preview (hidden by default) -->
                                        <img id="topicImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                        
                                        <!-- Delete button for dynamically uploaded image -->
                                        <button type="button" class="btn btn-danger" id="deleteIconTopicImage" 
                                                style="position: absolute; top: 5px; right: 5px; display: none;" 
                                                onclick="removeDynamicTopicImage()">X</button>
                                    </div>
                                </div>
                            </div>

                            

                        </div>

                                <button type="submit" class="btn btn-dark topic" name="sub_section"
                                    value="tab3_save">Save</button>
                            </form>
                        </div>





                        <!-- Tab 4: Full Mock Content & Image -->
                        <div class="tab-pane fade @if (session('section_tab11') == 'sec_tab4' || (session('section_tab11')=="" && $tabsctive2->tab_id_2=='sec_tab4' )) show active @endif" id="sec_tab4"
                            role="tabpanel" aria-labelledby="sec_tab4">
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
                                    <div class="numericalsectionclass">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fullmockimage" class="file-upload">Full Mock Image  
                                                    <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon"> 
                                                </label>
                                                <input type="file" class="form-control" style="display: none;" name="fullmockimage" id="fullmockimage" onchange="previewFullmockImage(event, 'fullmockImagePreview', this)"data-id="fullmockPreviewContainer">
                                            </div>
                                        </div>
                                    
                                        <!-- Preview Image Container -->
                                        <div class="form-group  fullmockPreviewContainer" id="fullmockPreviewContainer"  style="display: {{ isset($course) && $course->fullmockimage ? 'block' : 'none' }};">
                                            <label for="fullmockImagePreview">Image Preview</label>
                                            <div id="fullmockImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->fullmockimage)
                                                    <!-- Display existing image if set -->
                                                    <img id="fullmockImagePreview-save" src="{{ url('d0/' . $course->fullmockimage) }}" 
                                                         alt="Image Preview" style="width: 100%; height: auto;">

                                                         <button type="button" class="btn btn-danger" id="iconDeleteFullmockImage" style="position: absolute; top: 5px; right: 5px;" onclick="removeFullmockImage()">X</button>
                                    
                                                    <!-- Delete button for saved image -->
                                                    <button type="button" class="btn btn-danger" id="iconDeleteFullmockImage" 
                                                            style="position: absolute; top: 5px; right: 5px;" 
                                                            onclick="removeFullmockImage()">X</button>
                                                @endif
                                    
                                                <!-- Dynamic image preview (hidden by default) -->
                                                <img id="fullmockImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                

                                                
                                                <!-- Delete button for dynamically uploaded image -->
                                                <button type="button" class="btn btn-danger" id="deleteDynamicFullmockImage" 
                                                        style="position: absolute; top: 5px; right: 5px; display: none;" 
                                                        onclick="removeDynamicFullmockImage()">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                        </div>
                                <button type="submit" class="btn btn-dark fullmock" name="sub_section"
                                    value="tab4_save">Save</button>
                            </form>
                        </div>



                        </form>
                    </div>
                </div>







                <div class="tab-pane fade  @if (session('section_tab') == 'section5-tab') show active @endif" id="section5"
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
                                                        <label for="privatecontent">Private Content*</label>
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
                                    <div class="numericalsectionclass">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="privateimage" class="file-upload">Private Image <br>
                                                    <img src="{{ asset('assets/images/upfile.svg') }}" alt="Upload Icon"></label>
                                                <input type="file" class="form-control" style="display: none;" name="privateimage" id="privateimage" onchange="previewImageprivate(event, 'privateImagePreview', this)" data-id="privateimgid">
                                            </div>
                                        </div>
                                    
                                        <div class="form-group privateimgid" id="privateimgid" style="display: {{ isset($course) && $course->privateimage ? 'block' : 'none' }};">
                                            <label for="privateImagePreview">Image Preview</label>
                                            <div id="privateImagePreviewContainer" class="numericalclass">
                                                @if (isset($course) && $course->privateimage)
                                                    <!-- Saved Image Preview -->
                                                    <img id="privateImagePreview-save" src="{{ url('d0/' . $course->privateimage) }}" alt="Image Preview" style="width: 100%; height: auto;">
                                                    <button type="button" class="btn btn-danger" id="icondelete2" style="position: absolute; top: 5px; right: 5px;" onclick="removePrivateImage(this)">X</button>
                                                @endif
                                    
                                                <!-- Dynamic Image Preview -->
                                                <img id="privateImagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger" id="deleteicon2" style="position: absolute; top: 5px; right: 5px; display: none;" onclick="removeImageprivate()">X</button>
                                    
                                                <!-- Delete Button for Saved Image -->
                                                <button type="button" class="btn btn-danger" id="icondelete2" style="position: absolute; top: 5px; right: 5px; {{ isset($course) && $course->privateimage ? 'display: block;' : 'display: none;' }}" onclick="removePrivateImage(this)">X</button>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    



                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-dark privat" name="section5"
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

        $(function() {

            $("#section2Tabs").sortable({
                update: function(event, ui) {
                    var tabOrder = [];
                    $("#section2Tabs li").each(function() {
                        tabOrder.push($(this).data('tab-id'));
                    });
                    saveTabOrder(tabOrder);
                }
            });
        });

        function saveTabOrder(order) {

            $.ajax({
                url: '{{route('admin.course.tabchange')}}',
                method: 'POST',
                data: {
                    order: order,
                },
                success: function(response) {

                    console.log('Tab order saved successfully');

                },
                error: function(xhr) {

                    console.error('Error saving tab order');
                }
            });
        }




        // Function to remove the Section image from the server when the delete button is clicked
function removeSectionImage() {
    const imagePath = "{{ optional($course)->image }}";
    // Set the correct image path for the Section image

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteImage') }}', // Ensure this route matches the backend route for deleting Section image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
        success: function(response) {
            if (response.success) {
                $('#imgid1').hide();  // Hide the image preview container
                document.getElementById('imagePreview-save').style.display = 'none'; // Hide the image preview
                document.querySelector('#imagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
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




    {{-- <script>
        function removePrivateImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deletePrivateImage', ':id') }}'.replace(':id',
                courseId); // Construct the URL

            $.ajax({
                type: 'POST',
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
    </script> --}}


    {{-- <script>
        function removeLogicalImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteLogicalImage') }}'; // Construct the URL with the course ID

            $.ajax({
                type: 'POST',
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
    </script> --}}


   


    <script>
        function removeAbstractImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteAbstractImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'POST',
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
    function removeLearnImage() {
        const imagePath = "{{ optional($course)->learnimage }}";


        
            $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteLearnImage') }}', // Ensure this route matches the backend route for deleting Section image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
            success: function(response) {
                if (response.success) {
                    $('#learnimgid1').hide();  // Hide the image preview container
                document.getElementById('learnImagePreview-save').style.display = 'none'; // Hide the image preview
                document.querySelector('#learnImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
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



    {{-- <script>
        function removeQuestionBankImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteQuestionBankImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'POST',
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
    </script> --}}

    {{-- <script>
        function removeTopicImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteTopicImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'POST',
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
    </script> --}}


    {{-- <script>
        function removeFullmockImage(button) {
            const courseId = button.value; // Get the course ID from the button value
            const url = '{{ route('admin.course.deleteFullmockImage', ':id') }}'.replace(':id',
            courseId); // Construct the URL with the course ID

            $.ajax({
                type: 'POST',
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
 --}}





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






<script>


    $(function() {

        $("#section3Tabs").sortable({
            update: function(event, ui) {
                var tabOrder = [];
                $("#section3Tabs li").each(function() {
                    tabOrder.push($(this).data('tab-id'));
                });
                saveTabOrder1(tabOrder);
            }
        });
    });

    function saveTabOrder1(order) {

        $.ajax({
            url: '{{route('admin.course.tabchange1')}}',
            method: 'POST',
            data: {
                order: order,
            },
            success: function(response) {

                console.log('Tab order saved successfully');

            },
            error: function(xhr) {

                console.error('Error saving tab order');
            }
        });
    }




    
    // Function to preview the image when the file input changes
function previewImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#imgid1').show();
        $('#deleteicon1').show(); // Show delete button for the preview image
        $('#icondelete1').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the preview image when the delete button is clicked
function removeImage() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('imagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#imgid1').hide(); // Hide preview container
    $('#deleteicon1').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('image').value = '';
}




// Function to preview the Learn Image
function previewLearnImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#learnimgid1').show();
        $('#deleteiconlearnimg').show(); // Show delete button for the preview image
        $('#icondeletelearnimg').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the Learn Image preview when the delete button is clicked
function removeImage1() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('learnImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#learnimgid1').hide(); // Hide preview container
    $('#deleteiconlearnimg').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('learnimage').value = '';
}

    


// Function to remove the Question Bank image from the server when the delete button is clicked
function removeQuestionBankImage() {
    const imagePath = "{{ optional($course)->questionbankimage }}";
    // Set the correct image path for the Question Bank image

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteQuestionBankImage') }}', // Ensure this route matches the backend route for deleting the Question Bank image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
        success: function(response) {
            if (response.success) {
                $('#imgid10').hide();  // Hide the image preview container
                document.getElementById('questionbankImagePreview-save').style.display = 'none'; // Hide the saved image preview
                document.querySelector('#questionbankImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}






// Function to preview the Question Bank image when the file input changes
function previewQuestionBankImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button for the preview image
        $('#imgid10').show();
        $('#deleteiconquestionbankimg').show(); // Show delete button for the preview image
        $('#icondeletequestionbankimg').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the Question Bank preview image when the delete button is clicked
function removeQuestionImage() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('questionbankImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#imgid10').hide(); // Hide preview container
    $('#deleteiconquestionbankimg').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('questionbankimage').value = '';
}



// // Function to remove the Topic image from the server when the delete button is clicked
// function removeTopicImage() {
//     const courseId = button.value; // Get the course ID from the delete button value


//     $.ajax({
//         type: 'POST',
//         url: '{{ route('admin.course.deleteTopicImage') }}', // Ensure this route matches the backend route for deleting the Topic image
//         data: {
//             _token: '{{ csrf_token() }}',
           
//             image_path: imagePath
//         },
//         success: function(response) {
//             if (response.success) {
//                 $('#imgid20').hide(); // Hide the image preview container
//                 document.getElementById('topicImagePreview-save').style.display = 'none'; // Hide the saved image preview
//                 document.querySelector('#topicImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
//             } else {
//                 alert('Image could not be deleted. Please try again.');
//             }
//         },
//         error: function(xhr) {
//             alert('An error occurred. Please try again.');
//         }
//     });
// }




function removeTopicImage() {
    console.log('y');

    const courseId = "{{ optional($course)->id }}"; // Get the course ID from the delete button value
const imagePath = "{{ optional($course)->topicimage }}"; // Set the correct image path for the Topic image



    

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteTopicImage') }}', // Ensure this route matches the backend route for deleting the Question Bank image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
        success: function(response) {
            if (response.success) {
                $('#imgid20').hide();  // Hide the image preview container
                document.getElementById('topicImagePreview-save').style.display = 'none'; // Hide the saved image preview
                document.querySelector('#topicImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}





// Function to preview the Topic image when the file input changes
function previewTopicImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button for the preview image
        $('#imgid20').show(); // Ensure the preview container ID matches your markup
        $('#deleteIconTopicImage').show(); // Show delete button for the preview image
        $('#iconDeleteTopicImage').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the Topic preview image when the delete button is clicked
function removeDynamicTopicImage() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('topicImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#imgid20').hide(); // Hide preview container
    $('#iconDeleteTopicImage').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('topicimage').value = '';
}



function removeFullmockImage() {
    console.log('Removing full mock image');

    const courseId = "{{ optional($course)->id }}"; // Get the course ID
const imagePath = "{{ optional($course)->fullmockimage }}"; // Set the image path for full mock image


    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteFullmockImage') }}', // Ensure this route matches the backend route for deleting the full mock image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
        success: function(response) {
            if (response.success) {
                $('#fullmockPreviewContainer').hide();  // Hide the preview container
                document.getElementById('fullmockImagePreview-save').style.display = 'none'; // Hide the saved image preview
                document.querySelector('#fullmockPreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}



// Function to preview the Full Mock image when the file input changes
function previewFullmockImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button for the preview image
        $('#fullmockPreviewContainer').show(); // Ensure the preview container ID matches your markup
        $('#deleteDynamicFullmockImage').show(); // Show delete button for the preview image
        $('#iconDeleteFullmockImage').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the Full Mock preview image when the delete button is clicked
function removeDynamicFullmockImage() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('fullmockImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#fullmockPreviewContainer').hide(); // Hide preview container
    $('#iconDeleteFullmockImage').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('fullmockimage').value = '';
}




// Function to remove the Private Image from the server when the delete button is clicked
function removePrivateImage(button) {
    const imagePath = "{{ optional($course)->privateimage }}";
    // Set the correct image path for the Private Image
    const courseId = button.value; // Get the course ID from the delete button value

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deletePrivateImage') }}', // Ensure this route matches the backend route for deleting Private Image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath,
            course_id: courseId
        },
        success: function(response) {
            if (response.success) {
                $('#privateimgid').hide(); // Hide the image preview container
                document.getElementById('privateImagePreview-save').style.display = 'none'; // Hide the saved image preview
                document.querySelector('#privateImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide the delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}


// Function to preview the private image when the file input changes
function previewImageprivate(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#privateimgid').show();
        $('#deleteicon2').show(); // Show delete button for the preview image
        $('#icondelete2').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the private preview image when the delete button is clicked
function removeImageprivate() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('privateImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#privateimgid').hide(); // Hide preview container
    $('#deleteicon2').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('privateimage').value = '';
}





    function removeLogicalImage() {
        const imagePath = "{{ optional($course)->logicalimage }}";


        $.ajax({
            type: 'POST',
            url: '{{ route('admin.course.deleteLogicalImage') }}', // Ensure this route matches the backend route for deleting logical image
            data: {
                _token: '{{ csrf_token() }}',
                image_path: imagePath
            },
            success: function(response) {
                if (response.success) {
                    $('#logicalimgid1').hide();  // Hide the image preview container
                    document.getElementById('logicalImagePreview-save').style.display = 'none'; // Hide the image preview
                    document.querySelector('#logicalImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
                } else {
                    alert('Image could not be deleted. Please try again.');
                }
            },
            error: function(xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    }



// Function to preview the Logical Image
function previewLogicalImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function () {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#logicalimgid1').show();
        $('#deleteiconlogicalimg').show(); // Show delete button for the preview image
        $('#icondeletelogicalimg').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the Logical Image preview when the delete button is clicked
function removeImage2() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('logicalImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#logicalimgid1').hide(); // Hide preview container
    $('#deleteiconlogicalimg').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('logicalimage').value = '';
}


function removeCriticalImage() {
    const imagePath = "{{ optional($course)->criticalimage }}";


    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteCriticalImage') }}', // Ensure this route matches the backend route for deleting critical image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
        success: function(response) {
            if (response.success) {
                $('#criticalimgid1').hide();  // Hide the image preview container
                document.getElementById('criticalImagePreview-save').style.display = 'none'; // Hide the image preview
                document.querySelector('#criticalImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}



// Function to preview the Critical Image
function previewCriticalImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function () {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#criticalimgid1').show();
        $('#deleteiconcriticalimg').show(); // Show delete button for the preview image
        $('#icondeletecriticalimg').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}


// Function to remove the Critical Image preview when the delete button is clicked
function removeImagecritical() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('criticalImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#criticalimgid1').hide(); // Hide preview container
    $('#deleteiconcriticalimg').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('criticalimage').value = '';
}




function removeAbstractImage() {
    const imagePath = "{{ optional($course)->abstractimage }}";
    // Get the path of the abstract image

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteAbstractImage') }}',  // Ensure this route matches the backend route for deleting abstract image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath  // Send the image path to the backend
        },
        success: function(response) {
            if (response.success) {
                $('#abstractimgid1').hide();  // Hide the image preview container
                document.getElementById('abstractImagePreview-save').style.display = 'none';  // Hide the saved image preview
                document.querySelector('#abstractImagePreviewContainer button.btn-danger').style.display = 'none';  // Hide delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}



// Function to preview the Abstract Image
function previewAbstractImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function () {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#abstractimgid1').show();
        $('#deleteiconabstractimg').show(); // Show delete button for the preview image
        $('#icondeleteabstractimg').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}

// Function to remove the Abstract Image preview when the delete button is clicked
function removeImageabstract() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('abstractImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#abstractimgid1').hide(); // Hide preview container
    $('#deleteiconabstractimg').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('abstractimage').value = '';
}




function removeNumericalImage() {
    const imagePath = "{{ optional($course)->numericalimage }}";


    $.ajax({
        type: 'POST',
        url: '{{ route('admin.course.deleteNumericalImage') }}', // Ensure this route matches the backend route for deleting numerical image
        data: {
            _token: '{{ csrf_token() }}',
            image_path: imagePath
        },
        success: function(response) {
            if (response.success) {
                $('#numericalimgid2').hide();  // Hide the image preview container
                document.getElementById('numericalImagePreview-save').style.display = 'none'; // Hide the image preview
                document.querySelector('#numericalImagePreviewContainer button.btn-danger').style.display = 'none'; // Hide delete button
            } else {
                alert('Image could not be deleted. Please try again.');
            }
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
}


// Function to preview the Numerical Image
function previewNumericalImage(event, previewId, element) {
    const reader = new FileReader();

    reader.onload = function () {
        const output = document.getElementById(previewId);
        output.src = reader.result; // Set the preview image source
        output.style.display = 'block'; // Display the preview image

        // Show the preview container and delete button
        $('#numericalimgid2').show();
        $('#deleteiconnumericalimg').show(); // Show delete button for the preview image
        $('#icondeletenumericalimg').hide(); // Hide delete button for the saved image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]); // Read the selected image
    }
}
// Function to remove the Numerical Image preview when the delete button is clicked
function removeImagenumerical() {
    // Clear the preview image and hide the preview container and delete button
    const output = document.getElementById('numericalImagePreview');
    output.src = '';
    output.style.display = 'none'; // Hide the preview image

    $('#numericalimgid2').hide(); // Hide preview container
    $('#deleteiconnumericalimg').hide(); // Hide delete button for the preview image

    // Clear the file input field
    document.getElementById('numericalimage').value = '';
}


</script>

@endpush
