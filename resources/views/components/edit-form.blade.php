<div class="row"> 
    <div class="card">
        <div class="card-body">
            <form  @if (!empty($params))   action="{{route("$name.update",$params)}}"    @else action="{{route("$name.update",$id)}}" @endif class="form" id="{{$frmID}}" method="post" enctype="multipart/form-data">
                @csrf 
                @method("PUT")
                <div class="row">
                    @php 
                    if(count($fields[7]->value)>0){
                        $choice = 1;
                    }else{
                        $choice = 0;
                    }
                    @endphp
                    @foreach ($fields as $item)
                        @if (($item->type??"text")=="hidden")
                            <input type="hidden" name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}" value="{{old($item->name,$item->value??"")}}">
                        @elseif(($item->type??"text")=="choice")
                        <div class="choice @if(!empty($item->addclass)) {{ $item->addclass }} @endif"  @if(!empty($item->display)) style="display:none" @endif>
                            <h3>{{ucfirst($item->label??$item->name)}}</h3>
                            <div class="choice-group col-md-12" id="{{$item->name}}-{{$frmID}}-choice-group" >
                                @if (count(old($item->name,[]))>0) 
                                    @foreach(old($item->name,[]) as $k=> $v) 
                                    <div class="choice-item mt-2" id="{{$item->name}}-{{$frmID}}-choice-item-{{$k}}"  >
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4"> 
                                                    <label for="{{$item->name}}-{{$frmID}}-{{$k}}">Choice</label>
                                                    <input type="hidden" name="choice_{{$item->name}}_id[]"  value="{{old('choice_'.$item->name."_id",[])[$k]??""}}">
                                                    <input type="hidden" name="choice_{{$item->name}}_image[]"  value="{{old('choice_'.$item->name."_image",[])[$k]??""}}">

                                                    <div class="input-group">
                                                        <div class="input-group-prepend choice-check-group">
                                                            <label class="input-group-label choice-label" for="{{$item->name}}-{{$frmID}}-{{$k}}-check"></label>
                                                            <input type="radio" class="input-group-label choice-label"  name="choice_{{$item->name}}" id="{{$item->name}}-{{$frmID}}-{{$k}}-check" value="{{$k}}" @checked(old('choice_'.$item->name)==$k) >
                                                        </div>
                                                        <input type="text" name="{{$item->name}}[]" id="{{$item->name}}-{{$frmID}}-{{$k}}" value="{{old($item->name)[$k]}}"  class="form-control  @error($item->name.".$k") is-invalid @enderror " placeholder="{{ucfirst($item->label??$item->name)}}" aria-placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                        <input type="file" name="file_{{$item->name}}[]" id="file_{{$item->name}}-{{$frmID}}-{{$k}}" value=""  data-existing-file="{{old('choice_'.$item->name."_image",[])[$k]??""}}"  accept="image/jpeg, image/png, image/gif"  class="form-control  @error('file_'.$item->name.".$k") is-invalid @enderror " onchange="previewImage(this, 'preview-{{$item->name}}-{{$frmID}}-{{$k}}')">
                                                            <img id="preview-{{ $item->name }}-{{ $frmID }}-{{ $k }}" src="{{old('choice_'.$item->name."_image",[])[$k]??""}}" alt="Image Preview"  style="width: 100px; height: 40px; object-fit: cover; margin-top: 10px; display: block;">
                                                        {{-- @if ($k!=0) --}}
                                                        <div class="input-group-append choice-check-group">
                                                            <button type="button" onclick="removeChoice{{$frmID}}('#{{$item->name}}-{{$frmID}}-choice-item-{{$k}}','#{{$item->name}}-{{$frmID}}-{{$k}}-check','#{{$item->name}}-{{$frmID}}-choice-group')" class="btn btn-danger "><img src="{{asset("assets/images/delete-black.svg")}}"></button>
                                                        </div>
                                                        {{-- @endif --}}
                                                        @error($item->name.".$k")
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    
                                @forelse ($item->value??[] as $k=> $v) 
                                <div class="choice-item mt-2" id="{{$item->name}}-{{$frmID}}-choice-item-{{$k}}"  >
                                    <div class="form-group">
                                        <div class="form-data">
                                            <div class="forms-inputs mb-4"> 
                                                <label for="{{$item->name}}-{{$frmID}}-{{$k}}">Choice</label>
                                                <input type="hidden" name="choice_{{$item->name}}_id[]"  value="{{$v->id}}">
                                                <input type="hidden" name="choice_{{$item->name}}_image[]"  value="{{$v->image}}">
                                                <div class="input-group">
                                                    <div class="input-group-prepend choice-check-group">
                                                        <label class="input-group-label choice-label" for="{{$item->name}}-{{$frmID}}-{{$k}}-check"></label>
                                                        <input type="radio" class="input-group-check choice-check" name="choice_{{$item->name}}" id="{{$item->name}}-{{$frmID}}-{{$k}}-check" value="{{$k}}" @checked($v->choice) >
                                                    </div>
                                                    <input type="text" name="{{$item->name}}[]" id="{{$item->name}}-{{$frmID}}-{{$k}}" value="{{$v->value}}"  class="form-control  @error($item->name.".$k") is-invalid @enderror " placeholder="{{ucfirst($item->label??$item->name)}}" aria-placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                    <input type="file" name="file_{{$item->name}}[]" id="file_{{$item->name}}-{{$frmID}}-0" value="" @if($v->image) data-existing-file="{{$v->image}}" @else data-existing-file=""@endif accept="image/jpeg, image/png, image/gif" class="form-control" onchange="previewImage(this, 'preview-{{$item->name}}-{{$frmID}}-{{ $k }}')">
                                                    <div class="invalid-feedback" id="upload-file-{{ $item->name }}-{{ $frmID }}-0">Please upload a valid image file (JPEG, PNG, GIF).</div>

                                                    @isset($v->image)
                                                        <img id="preview-{{ $item->name }}-{{ $frmID }}-{{ $k }}" src="{{url($v->image)}}" alt="Image Preview"  style="width: 100px; height: 40px; object-fit: cover; margin-top: 10px; display: block;">
                                                    @endisset

                                                    {{-- @if ($k!=0) --}}
                                                    <div class="input-group-append choice-check-group">
                                                        <button type="button" onclick="removeChoice{{$frmID}}('#{{$item->name}}-{{$frmID}}-choice-item-{{$k}}','#{{$item->name}}-{{$frmID}}-{{$k}}-check','#{{$item->name}}-{{$frmID}}-choice-group')" class="btn btn-danger "><img src="{{asset("assets/images/delete-black.svg")}}"></button>
                                                    </div>
                                                    {{-- @endif --}}
                                                    @error($item->name.".$k")
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                @empty
                                <div class="choice-item mt-2" id="{{$item->name}}-{{$frmID}}-choice-item-0"  @if(!empty($item->display)) style="display:none" @endif>
                                    <div class="form-group">
                                        <div class="form-data">
                                            <div class="forms-inputs mb-4"> 
                                                <label for="{{$item->name}}-{{$frmID}}-0">Choice</label>
                                                <input type="hidden" name="choice_{{$item->name}}_id[]"  value="">
                                                <div class="input-group">
                                                    <div class="input-group-prepend choice-check-group">
                                                        <label class="input-group-label choice-label"  for="{{$item->name}}-{{$frmID}}-0-check"></label>
                                                        <input type="radio" class="input-group-check choice-check"  id="{{$item->name}}-{{$frmID}}-0-check" name="choice_{{$item->name}}" value="0" checked >
                                                    </div>
                                                    <input type="text" name="{{$item->name}}[]" id="{{$item->name}}-{{$frmID}}-0" value="" class="form-control  " placeholder="{{ucfirst($item->label??$item->name)}}" aria-placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                    <div class="input-group-append choice-check-group">
                                                        <button type="button" onclick="removeChoice{{$frmID}}('#{{$item->name}}-{{$frmID}}-choice-item-0','#{{$item->name}}-{{$frmID}}-0-check','#{{$item->name}}-{{$frmID}}-choice-group')" class="btn btn-danger "><img src="{{asset("assets/images/delete-black.svg")}}"></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>      
                                @endforelse

                                @endif
                            </div>

                            <div class="choice-button">
                                <button class="btn btn-dark btn-sm float-end" type="button" onclick="addChoice{{$frmID}}('{{$item->name}}','{{ucfirst($item->label??$item->name)}}','#{{$item->name}}-{{$frmID}}-choice-group')"> <img src="{{asset("assets/images/plus.svg")}}" alt=""> Add </button>
                            </div>
                        </div>
                        @else
                            
                        <div class="col-md-{{$item->size??4}}  @if(!empty($item->addclass)) {{ $item->addclass }} @endif" @if(!empty($item->display)) style="display:none" @endif>
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <label for="{{$item->name}}-{{$frmID}}">{{ucfirst($item->label??$item->name)}}</label>
                                          
                                        @switch($item->type??"text")
                                            @case('maskinput')
                                                <input type="text" name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}" value="{{old($item->name,$item->value??"")}}" class="form-control maskinput @error($item->name) is-invalid @enderror " placeholder="{{ucfirst($item->placeholder??$item->name)}}" aria-placeholder="{{ucfirst($item->placeholder??$item->name)}}" @if(isset($item->options)) @foreach ($item->options as $opk=> $opt) data-{{$opk}}="{{$opt}}" @endforeach  @endif @readonly($item->readonly??false) >
                                                @break
                                            @case('editor')
                                                <textarea name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}"  class="form-control texteditor @error($item->name) is-invalid @enderror "  rows="5" @readonly($item->readonly??false)>{{old($item->name,$item->value??"")}}</textarea>
                                                @break
                                            @case('textarea')
                                                <textarea name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}"  class="form-control @error($item->name) is-invalid @enderror "  @readonly($item->readonly??false) rows="5">{{old($item->name,$item->value??"")}}</textarea>
                                                @break
                                            @case('select')
                                                <input type="hidden" class="select-val" value="{{old("selectval".$item->name)}}" name="selectval{{$item->name}}" id="select-val-{{$item->name}}-{{$frmID}}">
                                                <select name="{{$item->name}}" @readonly($item->readonly??false)  @isset($item->event) @foreach ($item->event as $e=>$cbk) on{{ucfirst($e)}}='{{$cbk}}(this)' @endforeach @endisset  @isset($item->child) data-child="{{$item->child}}" @endisset @isset($item->parent) data-parent="{{$item->parent}}" @endisset data-value="{{old($item->name,$item->value??"")}}" id="{{$item->name}}-{{$frmID}}" @if(isset($item->ajaxurl)) data-ajaxurl="{{$item->ajaxurl}}" data-ajax--cache="true" @endif  class="form-control select2 @if(isset($item->ajaxurl)) ajax @endif @error($item->name) is-invalid @enderror " data-placeholder="{{ucfirst($item->label??$item->name)}}" placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                    @if(isset($item->options)) 
                                                        @foreach ($item->options as $opt)
                                                        <option value="{{$opt->value}}" @selected(old($item->name,$item->value??"")==$opt->value)>{{$opt->text}}</option>                                                            
                                                        @endforeach
                                                    @elseif(!empty(old($item->name,$item->value??"")))
                                                        <option value="{{old($item->name,$item->value??"")}}">{{old("selectval".$item->name,$item->valuetext??"")}}</option>
                                                    @endif
                                                </select>
                                                @break
                                            @default
                                                <input type="{{$item->type??"text"}}" name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}" value="{{old($item->name,$item->value??"")}}" class="form-control @error($item->name) is-invalid @enderror " placeholder="{{ucfirst($item->placeholder??$item->name)}}" aria-placeholder="{{ucfirst($item->placeholder??$item->name)}}" @readonly($item->readonly??false)>        
                                        @endswitch
                                        
                                        @error($item->name)
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>    
                        </div> 
                        @endif
                    @endforeach
                     
                </div>

                <div class="mb-3"> 
                    <a href="{{$cancel??route("$name.index")}}"  class="btn btn-secondary">Cancel</a> <button type="submit" class="btn btn-dark">{{$btnsubmit}}</button> 
                </div>
            </form>
        </div>
    </div> 
</div>




@push('footer-script')

    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Set the image source to the loaded file
                    preview.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#'; // Reset the image source
                preview.style.display = 'none'; // Hide the image preview if no file is selected
            }
        }
        var chcnt=$('.choice-item').length;
        function removeChoice{{$frmID}}(target,checkbox,parent){
            if($(checkbox).is(":checked")){
                $(parent).find(".choice-item:first .choice-check").prop("checked",true)
            }
            $(target).remove()
            $(parent).find(".choice-item .choice-check").each(function(k,v){
                $(v).val(k)
            })
        }
        function addChoice{{$frmID}}(name,label,target){    
            var ln=$(target).find(".choice-item .choice-check").length;
            let el=`${name}-{{$frmID}}-chcnt-${chcnt}`;
            $(target).append(
            `
            <div class="choice-item mt-2" id="${name}-{{$frmID}}-choice-item-chcnt-${chcnt}"  >
                <div class="form-group">
                    <div class="form-data">
                        <div class="forms-inputs mb-4"> 
                            <label for="${el}">Choice</label>
                            <input type="hidden" name="choice_{{$item->name}}_id[]"  value="">
                            <div class="input-group">
                                 <div class="input-group-prepend choice-check-group">
                                    <label class="input-group-label choice-label"  for="${el}-check"></label>
                                    <input type="radio" class="input-group-check choice-check"  id="${el}-check" name="choice_${name}" value="${ln}" >
                                </div>
                                <input type="text" name="${name}[]" id="${el}" value="" class="form-control" placeholder="${label}" aria-placeholder="${label}" >
                                    <input type="file" name="file_${name}[]" id="${el}-file" onchange="validateImage(this, 'upload-file-${name}-{{$frmID}}-${chcnt}')"  accept="image/jpeg, image/png, image/gif" value="" class="form-control" >
                                    <div class="invalid-feedback" id="upload-file-${name}-{{$frmID}}-${chcnt}">Please upload a valid image file (JPEG, PNG, GIF).</div>

                                    <img id="${el}-preview" src="#" alt="Image Preview" style="display:none; width: 100px; height: auto; margin-top: 10px;"/>

                                <div class="input-group-append choice-check-group">
                                    <button type="button" onclick="removeChoice{{$frmID}}('#${name}-{{$frmID}}-choice-item-chcnt-${chcnt}','#${el}-check','${target}')" class="btn btn-danger "><img src="{{asset("assets/images/delete-black.svg")}}"></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
            
            `)    
            setTimeout(() => {
                $('#'+el).focus()                
            }, 500);  
            chcnt++;
        }
        $(function(){
            $("#{{$frmID}} .select2").each(function(){
                var selectval=$(this).parent().find("input.select-val");
                var thisname=$(this).attr("name")
                $(this).val($(this).data("value"))
                var parentel=$(this).data('parent')
                if($(this).hasClass('ajax')){
                    $(this).select2({
                        ajax:{
                            // url: $(this).data('ajaxurl'),
                            data:function (params) { 
                                params.parent_id=$("#{{$frmID}} .select2[name='"+parentel+"']").val()||0
                                params.name=thisname;
                                return params;
                            }
                        }
                    })
                }else{
                    $(this).select2()
                }
                
                $(this).change(function(){ 
                    $(selectval).val($(this).find('option:selected').text())
                    var childel= $(this).data('child')
                    var thisval=$(this).val()
                    if(childel){
                        if($("#{{$frmID}} .select2[name='"+childel+"']").hasClass('ajax')){
                            $("#{{$frmID}} .select2[name='"+childel+"']").val('').select2({
                                ajax:{
                                    // url: $(this).data('ajaxurl'),
                                    data:function (params) { 
                                        params.parent_id=thisval||0
                                        params.name=childel;
                                        return params;
                                    }
                                }
                            })
                        }else{

                            $("#{{$frmID}} .select2[name='"+childel+"']").val('').select2()
                        }
                    }
                })
            })

            $('#{{$frmID}} .maskinput').each(function(){
                var mask = $(this).data('mask');
                var placeholder = $(this).data('placeholder')||" ";
                $(this).inputmask({
                    placeholder:placeholder,
                    regex: mask,  
                    showMaskOnFocus: false
                });
            }) 
        })
        function validateImage(input,id) {
            const file = input.files[0];
            const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
            const feedbackElement = document.getElementById(id);
            if (file && !validImageTypes.includes(file.type)) {
                input.classList.add('is-invalid');
                feedbackElement.style.display = 'block';
                $(input).data("valid", false); // Mark input as invalid
                input.value = ""; // Clear the input
            } else {
                input.classList.remove('is-invalid');
                feedbackElement.style.display = 'none';
                $(input).data("valid", true); // Mark input as valid

            }
        }

        CKEDITOR.replaceAll('texteditor')
        $(document).ready(function () {
            let choice = "{{ $choice }}"
            if (choice != 0) {
                $("#{{$frmID}}").on("submit", function (e) {
                    let isValid = true;
                    const hasAtLeastOne = false;

                    $("input[name='answer[]']").each(function (index) {
                        const answerField = $(this);
                        const fileField = $("input[name='file_answer[]']").eq(index);

                        const answerValue = answerField.val().trim();
                        const fileValue = fileField.val();
                        const existingFile = fileField.data("existing-file"); 

                        if (!answerValue && !fileValue && !existingFile) {
                            isValid = false;

                            answerField.addClass("is-invalid");
                            fileField.addClass("is-invalid");
                            const feedbackElement = fileField.next(".invalid-feedback");

                        } else {
                            answerField.removeClass("is-invalid");
                            fileField.removeClass("is-invalid");
                            fileField.next(".invalid-feedback").hide(); 
                            hasAtLeastOne = true;

                        }
                    });
                    if (!hasAtLeastOne) {
                        isValid = false;
                        e.preventDefault(); // Prevent form submission
                        alert("At least one answer or file must be provided.");
                    }
                    else if (!isValid) {
                        e.preventDefault(); // Prevent form submission
                        alert("Please ensure all fields are properly filled.");
                    }
                });
            }
        });
    </script>
 
@endpush