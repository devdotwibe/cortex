<div class="row"> 
    <div class="card">
        <div class="card-body">
            <form @if (!empty($params))   action="{{route("$name.store",...$params)}}"    @else   action="{{route("$name.store")}}"   @endif class="form" id="{{$frmID}}" method="post">
                @csrf 
                <div class="row">
                    @foreach ($fields as $item)
                        @if (($item->type??"text")=="hidden")
                            <input type="hidden" name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}" value="{{old($item->name,$item->value??"")}}">
                        @elseif(($item->type??"text")=="choice")
                        <div class="choice">
                            <h3>{{ucfirst($item->label??$item->name)}}</h3>
                            <div class="choice-group col-md-12" id="{{$item->name}}-{{$frmID}}-choice-group" >
                                @forelse (old($item->name,[]) as $k=> $item)
                                <div class="choice-item mt-2" id="{{$item->name}}-{{$frmID}}-choice-item-{{$k}}"  >
                                    <div class="form-group">
                                        <div class="form-data">
                                            <div class="forms-inputs mb-4"> 
                                                <label for="{{$item->name}}-{{$frmID}}-{{$k}}">Choice</label>
                                                <div class="input-group">
                                                    <input type="text" name="{{$item->name}}[]" id="{{$item->name}}-{{$frmID}}-{{$k}}" value="{{old($item->name)[$k]}}" class="form-control @error($item->name) is-invalid @enderror " placeholder="{{ucfirst($item->label??$item->name)}}" aria-placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                    <div class="input-group-append">
                                                        <label class="input-group-label choice-label" for="{{$item->name}}-{{$frmID}}-{{$k}}-check"></label>
                                                        <input type="radio"  name="choice_{{$item->name}}" id="{{$item->name}}-{{$frmID}}-{{$k}}-check" value="{{$k}}" >
                                                    </div>
                                                </div>
                                                @error($item->name.".$k")
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                @empty
                                <div class="choice-item mt-2" id="{{$item->name}}-{{$frmID}}-choice-item-0"  >
                                    <div class="form-group">
                                        <div class="form-data">
                                            <div class="forms-inputs mb-4"> 
                                                <label for="{{$item->name}}-{{$frmID}}-0">Choice</label>
                                                <div class="input-group">
                                                    <input type="text" name="{{$item->name}}[]" id="{{$item->name}}-{{$frmID}}-0" value="" class="form-control" placeholder="{{ucfirst($item->label??$item->name)}}" aria-placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                    <div class="input-group-append choice-check-group">
                                                        <label class="input-group-label choice-label"  for="{{$item->name}}-{{$frmID}}-0-check"></label>
                                                        <input type="radio" class="input-group-check choice-check"  id="{{$item->name}}-{{$frmID}}-0-check" name="choice_{{$item->name}}" value="0" >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>      
                                @endforelse
                            </div>

                            <div class="choice-button">
                                <button class="btn btn-dark btn-sm float-end" type="button" onclick="addChoice('{{$item->name}}','{{$frmID}}','#{{$item->name}}-{{$frmID}}-choice-group')"> <img src="{{asset("assets/images/plus.svg")}}" alt=""> Add </button>
                            </div>
                        </div>
                        @else
                            
                        <div class="col-md-{{$item->size??4}}">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <label for="{{$item->name}}-{{$frmID}}">{{ucfirst($item->label??$item->name)}}</label>
                                        @switch($item->type??"text")
                                            @case('editor')
                                                <textarea name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}"  class="form-control texteditor @error($item->name) is-invalid @enderror "  rows="5">{{old($item->name)}}</textarea>
                                                @break
                                            @case('textarea')
                                                <textarea name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}"  class="form-control @error($item->name) is-invalid @enderror "  rows="5">{{old($item->name)}}</textarea>
                                                @break
                                            @case('select')
                                                <input type="hidden" class="select-val" value="{{old("selectval".$item->name)}}" name="selectval{{$item->name}}" id="select-val-{{$item->name}}-{{$frmID}}">
                                                <select name="{{$item->name}}" data-value="{{old($item->name)}}" id="{{$item->name}}-{{$frmID}}" @if(isset($item->ajaxurl)) data-ajax--url="{{$item->ajaxurl}}" data-ajax--cache="true" @endif  class="form-control select2 @error($item->name) is-invalid @enderror " data-placeholder="{{ucfirst($item->label??$item->name)}}" placeholder="{{ucfirst($item->label??$item->name)}}" >
                                                    @if(isset($item->options)) 
                                                        @foreach ($item->options as $opt)
                                                        <option value="{{$opt->value}}">{{$opt->text}}</option>                                                            
                                                        @endforeach
                                                    @endif
                                                    @if(!empty(old($item->name)))
                                                        <option value="{{old($item->name)}}">{{old("selectval".$item->name)}}</option>
                                                    @endif
                                                </select>
                                                {{-- @if(isset($item->options)) 
                                                    <data-option data-type="array" data-target="{{$item->name}}-{{$frmID}}" data-selected="{{old($item->name)}}">
                                                        @json($item->options)
                                                    </data-option>
                                                @elseif(isset($item->srcUrl))
                                                    <data-option data-type="url"  data-target="{{$item->name}}-{{$frmID}}"></data-option>
                                                @endif                                                 --}}
                                                @break
                                            @default
                                                <input type="{{$item->type??"text"}}" name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}" value="{{old($item->name)}}" class="form-control @error($item->name) is-invalid @enderror " placeholder="{{ucfirst($item->placeholder??$item->name)}}" aria-placeholder="{{ucfirst($item->placeholder??$item->name)}}" >        
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
        CKEDITOR.replaceAll('texteditor')
        var cnt=0;
        function addChoice(name,label,target){        
            cnt++;
            `
            <div class="choice-item mt-2" id="${name}-{{$frmID}}-choice-item-cnt-${cnt}"  >
                <div class="form-group">
                    <div class="form-data">
                        <div class="forms-inputs mb-4"> 
                            <label for="${name}-{{$frmID}}-cnt-${cnt}">Choice</label>
                            <div class="input-group">
                                <input type="text" name="${name}[]" id="${name}-{{$frmID}}-cnt-${cnt}" value="" class="form-control" placeholder="${label}" aria-placeholder="${label}" >
                                <div class="input-group-append choice-check-group">
                                    <label class="input-group-label choice-label"  for="${name}-{{$frmID}}-cnt-${cnt}-check"></label>
                                    <input type="radio" class="input-group-check choice-check"  id="${name}-{{$frmID}}-cnt-${cnt}-check" name="choice_${name}" value="${cnt}" >
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
            
            `
        }
        $(function(){
            $("#{{$frmID}} .select2").each(function(){
                var selectval=$(this).parent().find("input.select-val");
                $(this).val($(this).data("value")).select2().change(function(){ 
                    $(selectval).val($(this).find('option:selected').text())
                })
            })
        })

    </script>

    {{-- <script> 
        if(!customElements.get('data-option')){
            class DataOption extends HTMLElement {
                constructor() {
                    super();  
                    var selectElement = document.getElementById(this.dataset.target)
                    var selected = this.dataset.selected||"";
                    if(this.dataset.type=="array"){
                        try {
                            var datalist = JSON.parse((this.textContent||"").trim()); 
                            console.log(typeof datalist,"datalist")
                            
                            datalist.forEach(v => {
                                if(typeof v=="object"){
                                }else{
                                    var option = document.createElement('option');
                                    option.textContent = v;
                                    if(selected==v){
                                        option.selected =true;
                                    }
                                    selectElement.appendChild(option);
                                }
                            });
                        }catch (error) {
                            
                        }
                    } 
                    selectElement.classList.add('array-select2')
                }  
            } 
            customElements.define('data-option', DataOption); 
        }

        $(function(){

        })

    </script> --}}
@endpush