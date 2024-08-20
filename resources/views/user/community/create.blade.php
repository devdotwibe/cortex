@extends('layouts.user')
@section('title', 'Create Post')
@section('content') 
 <section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="form-group">
                <select id="selection"  onchange="changeFormType(this.value)" class="form-control">
                    <option value="post" @selected(old('type','post')=="post")>Post</option>
                    <option value="poll" @selected(old('type','')=="poll")>Poll</option> 
                </select>
            </div>
        </div>
    </div>

 </section>
 @if ($errors->any())
 <div class="alert alert-danger">
     <ul>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </ul>
 </div>
@endif
<section class="header_nav community-post-type community-post-type-poll"    @if(old('type','')!="poll") style="display:none" @endif >
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Create Poll</h2>
        </div>
    </div>
</section> 

<section class="header_nav community-post-type community-post-type-post"  @if(old('type','post')!="post") style="display:none" @endif >
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Create Post</h2>
        </div>
    </div>
</section>

<section class="invite-wrap mt-2" >
    <div class="container">
        <div class="row"> 
            <div class="card">
                <div class="card-body">
                    <form action="{{route('community.post.store')}}" class="form" id="post-section-crete-form" method="post">
                        @csrf 
                        <input type="hidden" name="type" class="community-post-type" value="{{old('type','post')}}">
                        <div class="row">

                            <div class="col-md-12" >
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="title-community-post-type">Title</label> 
                                            <input type="text" name="title" id="title-community-post-type" value="{{old('title')}}" class="form-control  @error('title') is-invalid @enderror " placeholder="Title" aria-placeholder="Title" >
                                            @error('title')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div> 

                            <div class="col-md-12 community-post-type community-post-type-post" @if(old('type','post')!="post") style="display:none" @endif >
                                <div class="form-group">
                                    <div class="form-data">
                                        <div class="forms-inputs mb-4"> 
                                            <label for="description-community-post-type">Description</label> 
                                            <textarea name="description" id="description-community-post-type"  class="form-control texteditor @error('description') is-invalid @enderror "  rows="5">{{old('description')}}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="choice community-post-type community-post-type-poll"  @if(old('type','')!="poll") style="display:none" @endif>
                                <h3>Choices</h3>
                                <div class="choice-group col-md-12" id="option-community-post-type-choice-group" >
                                    @forelse (old('option',[]) as $k=> $v)
                                    <div class="choice-item mt-2" id="option-community-post-type-choice-item-{{$k}}"  >
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4"> 
                                                    <label for="option-community-post-type-{{$k}}">Choice</label>
                                                    <div class="input-group"> 
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
                                    @empty
                                    <div class="choice-item mt-2" id="option-community-post-type-choice-item-0">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4"> 
                                                    <label for="option-community-post-type-0">Choice</label>
                                                    <div class="input-group">
                                                        <input type="text" name="option[]" id="option-community-post-type-0" value="" class="form-control  " placeholder="Choice" aria-placeholder="Choice" >                                                        
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                    @endforelse
                                </div>
    
                                <div class="choice-button">
                                    <button class="btn btn-dark btn-sm float-end" type="button" onclick="addChoice('option','Choice','#option-community-post-type-choice-group')"> <img src="{{asset("assets/images/plus.svg")}}" alt=""> Add </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 community-post-type community-post-type-poll"  @if(old('type','')!="poll") style="display:none" @endif >  
                            <a href="{{ route('community.index') }}"  class="btn btn-secondary">Cancel</a> 
                            <button type="submit" class="btn btn-dark">Create Poll</button> 
                        </div>
                        <div class="mb-3 community-post-type community-post-type-post"  @if(old('type','post')!="post") style="display:none" @endif >  
                            <a href="{{ route('community.index') }}"  class="btn btn-secondary">Cancel</a> 
                            <button type="submit" class="btn btn-dark">Create Post</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('footer-script')
<script>
    function changeFormType(val) {
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
        } 
        function addChoice(name,label,target){    
            var ln=$(target).find(".choice-item .choice-check").length;
            $(target).append(
            `
            <div class="choice-item mt-2" id="${name}-community-post-type-choice-item-chcnt-${chcnt}"  >
                <div class="form-group">
                    <div class="form-data">
                        <div class="forms-inputs mb-4"> 
                            <label for="${name}-community-post-type-chcnt-${chcnt}">Choice</label>
                            <div class="input-group"> 
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
            chcnt++;
        }

         
        CKEDITOR.replace($('#description-community-post-type')[0],{
            extraPlugins: 'uploadButton',
            removePlugins: 'easyimage',
            toolbarGroups: [ 
                { name: 'toolbarInsert', groups: [ 'Source','UploadButton','Smiley' ] }
            ],
            toolbar: [
                { name: 'toolbarInsert', items: ['Source','UploadButton','Smiley'] }, // Add buttons to the custom group
            ],
            allowedContent: true, 
        })
</script>
@endpush
