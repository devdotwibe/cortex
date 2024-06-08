<div class="row"> 
    <div class="card">
        <div class="card-body">

                <div class="row">
                    @foreach ($fields as $item)
                        <div class="col-md-{{$item->size??4}}">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <label for="{{$item->name}}-{{$frmID}}">{{ucfirst($item->label??$item->name)}}</label>
                                        <span class="form-control  field-view" id="{{$item->name}}-{{$frmID}}">
                                            {{ $item->value??"" }}
                                        </span> 
                                    </div>
                                </div>
                            </div>    
                        </div> 
                    @endforeach                     
                </div>            
        </div>
    </div> 
</div>