<div class="row"> 
    <div class="card">
        <div class="card-body">
            <form action="{{$url}}" class="form" id="{{$frmID}}" method="post">
                @csrf 
              
                <div class="row">
                    @foreach ($fields as $item)
                        <div class="col-md-{{$item->size??4}}">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <label for="{{$item->name}}-{{$frmID}}">{{ucfirst($item->label??$item->name)}}</label>
                                        @switch($item->type??"text")
                                            @case('textarea')
                                                <textarea name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}"  class="form-control @error($item->name) is-invalid @enderror "  rows="5" @readonly($item->readonly??false) >{{old($item->name)}}</textarea>
                                                @break
                                            @case('select')
                                                <select name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}">

                                                </select>
                                                @break
                                            @default
                                                <input type="{{$item->type??"text"}}" name="{{$item->name}}" id="{{$item->name}}-{{$frmID}}" value="{{old($item->name,$item->value??"")}}" class="form-control @error($item->name) is-invalid @enderror " @readonly($item->readonly??false) >        
                                        @endswitch
                                        
                                        @error($item->name)
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>    
                        </div> 
                    @endforeach
                     
                </div>

                <div class="mb-3"> 
                    @if(!empty($cancel))
                        <a href="{{ $cancel }}"  class="btn btn-secondary">Cancel</a>
                    @endif

                    @if(!empty($onclick))

                        <a  onclick="{{ $onclick }}" class="btn btn-secondary">Cancel</a>

                    @endif

                     <button type="submit" class="btn btn-dark">{{$btnsubmit}}</button> 
                </div>
            </form>
        </div>
    </div> 
</div>