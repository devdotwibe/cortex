@extends('layouts.admin')
@section('title', 'Edit Post')
@section('content')

{{-- <section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="form-group">
                <select id="selection"  onchange="changeFormType(this.value)" class="form-control">
                    <option value="post" @selected(old('type',$post->type)=="post")>Post</option>
                    <option value="poll" @selected(old('type',$post->type)=="poll")>Poll</option> 
                </select>
            </div>
        </div>
    </div>

 </section> --}}
 

<section class="header_nav community-post-type community-post-type-post"  @if(old('type',$post->type)!="post") style="display:none" @endif >
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Update Post</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2" >
    <div class="container">
        <div class="row"> 
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.community.post.update',$post->slug)}}" class="form" id="post-section-crete-form" method="post">
                        @csrf 
                        @method('PUT')
                        <input type="hidden" name="type" class="community-post-type" value="{{old('type',$post->type)}}">
                        <div class="row"> 

                            <div class="col-md-12 " >
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="description-community-post-type">Description</label> 
                                            <textarea name="description" id="description-community-post-type"  class="form-control texteditor @error('description') is-invalid @enderror "  rows="5">{{old('description',$post->description)}}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div>


                            {{-- <div class="col-md-12 " >
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="hashtag-community-post-type">Hashtag</label> 
                                            <textarea name="hashtag" id="hashtag-community-post-type"  class="form-control texteditor @error('hashtag') is-invalid @enderror "  rows="5">{{old('hashtag',$post->hashtag)}}</textarea>
                                            @error('hashtag')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div> --}}


                            {{-- <div class="col-md-12 " >
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="Hashtag-community-post-type">Hashtag</label> 
                                            <textarea name="hashtag" id="Hashtag"  class="form-control texteditor @error('Hashtag') is-invalid @enderror "  rows="5">{{old('hashtag',implode(" ",$post->hashtaglist()->pluck('hashtag')->toArray()))}}</textarea>
                                            @error('hashtag')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div>  --}}

                            <div class="form-group">
                                <label for="hashtag-select">Select Hashtag</label>
                                <select  name="hashtag_id" class="form-control" >
                                    <option value="">Select a hashtag</option>
                                    @foreach($hashtags as $hashtag)
                                        <option value="{{ $hashtag->id }}" 
                                            {{ $hashtag->id == $post->hashtag_id ? 'selected' : '' }}>
                                            {{ $hashtag->hashtag }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                       

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-data"> 
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" onchange="changeFormType(this.checked?'poll':'post')" role="switch" id="active-toggle"  @checked(old('type',$post->type)=="poll")  />
                                            <label class="form-check-label" for="active-toggle">Add Poll</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="choice community-post-type community-post-type-poll"  @if(old('type',$post->type)!="poll") style="display:none" @endif>
                                <h3>Choices</h3>
                                <div class="choice-group col-md-12" id="option-community-post-type-choice-group" >
                                    @if(count(old('option',[]))>0)
                                        @foreach(old('option',[]) as $k=> $v)
                                        <div class="choice-item mt-2" id="option-community-post-type-choice-item-{{$k}}"  >
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4"> 
                                                        <label for="option-community-post-type-{{$k}}">Choice</label>
                                                        <div class="input-group"> 
                                                            <input type="hidden" name="option_id[]" id="option-community-post-type-{{$k}}-id" value="{{old('option_id',[])[$k]}}"   >
                                                            <input type="text" name="option[]" id="option-community-post-type-{{$k}}" value="{{old('option')[$k]}}"  class="form-control  @error("option.$k") is-invalid @enderror " placeholder="Choice" aria-placeholder="Choice" >
                                                            @if ($k!=0)
                                                            <div class="input-group-append choice-check-group">
                                                                <button type="button" onclick="removeChoice('#option-community-post-type-choice-item-{{$k}}','#option-community-post-type-{{$k}}-check','#option-community-post-type-choice-group')" class="btn btn-danger "><img src="{{asset("assets/images/delete-icon.svg")}}"></button>
                                                            </div>
                                                            @endif
                                                            @error("option.$k")
                                                            <div class="invalid-feedback">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        @endforeach
                                    @else
                                        @forelse ($post->pollOption as $k=> $opt)
                                        <div class="choice-item mt-2" id="option-community-post-type-choice-item-{{$k}}"  >
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4"> 
                                                        <label for="option-community-post-type-{{$k}}">Choice</label>
                                                        <div class="input-group"> 
                                                            <input type="hidden" name="option_id[]" id="option-community-post-type-{{$k}}-id" value="{{$opt->slug}}"   >
                                                            <input type="text" name="option[]" id="option-community-post-type-{{$k}}" value="{{$opt->option}}"  class="form-control" placeholder="Choice" aria-placeholder="Choice" >
                                                            @if ($k!=0)
                                                            <div class="input-group-append choice-check-group">
                                                                <button type="button" onclick="removeChoice('#option-community-post-type-choice-item-{{$k}}','#option-community-post-type-{{$k}}-check','#option-community-post-type-choice-group')" class="btn btn-danger "><img src="{{asset("assets/images/delete-icon.svg")}}"></button>
                                                            </div>
                                                            @endif 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        @empty
                                        <div class="choice-item mt-2" id="option-community-post-type-choice-item-0">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4"> 
                                                        <label for="option-community-post-type-0">Choice</label>
                                                        <div class="input-group">
                                                            <input type="hidden" name="option_id[]" id="option-community-post-type-0-id" value=""   >
                                                            <input type="text" name="option[]" id="option-community-post-type-0" value="" class="form-control  " placeholder="Choice" aria-placeholder="Choice" >                                                        
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>      
                                        @endforelse
                                    @endif
                                </div>
    
                                <div class="choice-button" id="option-community-post-type-choice-group-btn"  @if(count(old('option',$post->pollOption??[]))>4) style="display:none" @endif>
                                    <button class="btn btn-dark btn-sm float-end" type="button" onclick="addChoice('option','Choice','#option-community-post-type-choice-group')"> <img src="{{asset("assets/images/plus.svg")}}" alt=""> Add </button>
                                </div>
                            </div>

                            <div class="col-md-12 " >
                                <div class="form-group">
                                    <div class="form-data"> 
                                        <div class="forms-inputs mb-8">
                                            <small>note: Max image size 5MB | supported files: .png, .jpg, .jpge</small>
                                            <label class="dropzone form-control @error('image') is-invalid @enderror" for="image"> 
                                                <p>Drag & Drop your Image file here or click to upload</p>
                                                <input type="file"  id="image" style="display: none" accept=".png,.jpg,.jpeg" >
                                                <input type="hidden" id="image-url"  name="image" value="{{old('image',$post->image)}}">
                                            </label> 
                                            @error('image')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @else
                                            <div class="invalid-feedback" id="error-image">The field is required</div>
                                            @enderror
                                            <div id="selected-files" class="selected-files">
                                                @if(!empty(old('image',$post->image)))
                                                <div class="selected-item">
                                                    <button type="button" class="close" onclick="removeimage()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <img src="{{old('image',$post->image)}}" alt="img" >
                                                </div>
                                                @endif
                                            </div>
                                        </div>
        
                                    </div>
                                 </div>
                            </div>
                            
                            {{-- <div class="col-md-12 community-post-type community-post-type-poll"  @if(old('type',$post->type)!="poll") style="display:none" @endif>
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="title-community-post-type">Title</label> 
                                            <input type="text" name="title" id="title-community-post-type" value="{{old('title',$post->title)}}" class="form-control  @error('title') is-invalid @enderror " placeholder="Title" aria-placeholder="Title" >
                                            @error('title')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div> --}}

                            
                        </div>
 
                        <div class="mb-3" >  
                            <a href="{{route('admin.community.post.show',$post->slug)}}"  class="btn btn-secondary">Cancel</a> 
                            <button type="submit" class="btn btn-dark">Update Post</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
 
@endsection

@push('footer-script')
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#hashtag-select').select2(); // Initialize Select2 on your select element
    });    function changeFormType(val) {
        $('.community-post-type').val(val);
        $('.community-post-type').hide();
        $('.community-post-type-'+val).fadeIn();
    }  
    var chcnt=$('.choice-item').length;
        function removeChoice(target,checkbox,parent){
            if($(checkbox).is(":checked")){
                $(parent).find(".choice-item:first .choice-check").prop("checked",true)
            }
            $(target).remove()
            $(parent).find(".choice-item .choice-check").each(function(k,v){
                $(v).val(k)
            })
            $(parent+"-btn").show()
        } 
        function addChoice(name,label,target){    
            $(target).append(
            `
            <div class="choice-item mt-2" id="${name}-community-post-type-choice-item-chcnt-${chcnt}"  >
                <div class="form-group">
                    <div class="form-data">
                        <div class="forms-inputs mb-4"> 
                            <label for="${name}-community-post-type-chcnt-${chcnt}">Choice</label>
                            <div class="input-group"> 
                                <input type="hidden" name="option_id[]" id="${name}-community-post-type-chcnt-${chcnt}-id" value=""   >
                                <input type="text" name="${name}[]" id="${name}-community-post-type-chcnt-${chcnt}" value="" class="form-control" placeholder="${label}" aria-placeholder="${label}" >
                                <div class="input-group-append choice-check-group">
                                    <button type="button" onclick="removeChoice('#${name}-community-post-type-choice-item-chcnt-${chcnt}','#${name}-community-post-type-chcnt-${chcnt}-check','${target}')" class="btn btn-danger "><img src="{{asset("assets/images/delete-icon.svg")}}"></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
            
            `)    
            var len=$(target).find(".choice-item").length;
            if(len>4){
                $(target+"-btn").hide()
            }
            chcnt++;
        }

        
        CKEDITOR.replace($('#description-community-post-type')[0],{ 
            toolbarGroups: [ 
                { name: 'toolbarInsert', groups: ['Smiley' ] }
            ],
            toolbar: [
                { name: 'toolbarInsert', items: ['Smiley'] }, 
            ],
            allowedContent: true, 
        })

        function removeimage(){
            $('#selected-files').html(``)
            $('#image-url').val("") 
            $('#image').val("")
        }
        $(function(){

            $('#image').change(function(e){
                if(this.files.length>0){ 
                    let imgUrl=URL.createObjectURL(this.files[0]);
                    let oldhtml=$('#selected-files').html();
                    $('#selected-files').html(`                        
                        <div class="selected-item loading">
                            <img src="${imgUrl}" alt="img" > 
                        </div>
                    `)
                    var toastId = showToast('Uploading... 0%', 'info', false);

                    var formData = new FormData();
                    formData.append("file", this.files[0]);
                    formData.append("foldername", "post");
                    formData.append("file_type","image");
                    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                    $.ajax({
                        url : "{{route('admin.upload')}}",
                        type : 'POST',
                        data : formData,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(event) {
                                if (event.lengthComputable) {
                                    var percentComplete = Math.round((event.loaded / event.total) * 100);
                                    updateToast(toastId, `Uploading... ${percentComplete}%`, 'info');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            updateToast(toastId, 'Upload complete!', 'success');
                            if(typeof response=="string"){
                                response=JSON.parse(response);
                            }
                            $('#image-url').val(response.url) 
                            $('#image').val("")
                            $('#selected-files').html(`                        
                                <div class="selected-item">
                                    <button type="button" class="close" onclick="removeimage()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <img src="${response.url}" alt="img" > 
                                </div>
                            `)
                        },
                        error: function(xhr, status, error) { 
                            $('#image').val("")
                            $('#selected-files').html(oldhtml)
                            updateToast(toastId, 'Upload failed.', 'danger');
                            try {
                                var ermsg= JSON.parse(xhr.responseText)
                                if(ermsg.errors){
                                    $('#error-image').tex(ermsg.errors.file[0])
                                }
                            } catch (error) {
                                
                            }
                        }
                    });
                }
                
            })
            $('.dropzone').on('dragover', function(e) { 
                e.preventDefault();
                $(this).addClass('dragover');
            }); 
            $('.dropzone').on('dragleave', function(e) { 
                e.preventDefault();
                $(this).removeClass('dragover');
            });
            $('.dropzone').on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                var files = e.originalEvent.dataTransfer.files;
                if(files.length>0){
                    $('#image').prop('files',files).change()
                }
            })
        })
</script>
@endpush
