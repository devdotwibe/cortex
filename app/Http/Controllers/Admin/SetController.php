<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SetController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=Setname::class;
        self::$routeName="admin.set";
        self::$defaultActions=['delete'];
    }
    
    function set_store(Request $request,$slug)
    {
       
        $sub = SubCategory::where('slug',$slug)->first();
        $set_data = $request->validate([
            "name" => "required|unique:setnames,name,NULL,id,sub_category_id,".$sub->id,
            'time_of_exam'=>"required"
        ]);


        $set_data['sub_category_id'] = $sub->id;

        $set_data['category_id'] = $sub->category_id;
        
        Setname::store($set_data);
        
        return response()->json(['success' => 'Set Name Added Successfully']);

    }


    public function show(Request $request){    

        // dd($learn->slug);
        
        if($request->ajax()){

            if(!empty($request->subcategory))
            {
                
                $set = SubCategory::findSlug($request->subcategory);

                return $this->where('sub_category_id',$set->id)
                ->addAction(function($data){

                    return 

                    '<a onclick="updatesubcategoryset(\''.route('admin.set.edit', $data->slug).'\', \''.$data->slug.'\' , \'set\')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>';;

                    })->addColumn('visibility',function($data){
                        return '                
                            <div class="form-check ">
                                <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="subcatsetvisiblechangerefresh('."'".route("admin.set.visibility",$data->slug)."'".')" > 
                            </div>
                        ';
                    })->buildTable(['visibility']);
            }
            else
            {
                return $this->addColumn('visibility',function($data){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="subcatsetvisiblechangerefresh('."'".route("admin.set.visibility",$data->slug)."'".')" > 
                        </div>
                    ';
                })->buildTable(['visibility']);
            }
           
        }

    }

    public function visibility(Request $request,Setname $setname){
        $setname->update(['visible_status'=>($setname->visible_status??"")=="show"?"hide":"show"]);        
        if($request->ajax()){
            return response()->json(["success"=>"Set visibility change success"]);
        }        
        return redirect()->route('admin.options.index')->with("success","Set visibility change success");
    }

    public function edit(Request $request,Setname $setname){
        if($request->ajax()){
            $setname->updateUrl=route('admin.set.update', $setname->slug);
            return response()->json($setname);
        }
    }
    function update(Request $request, $slug)
    {

        $set = Setname::findSlug($slug);

        $edit_data = $request->validate([
            "name" => "required|unique:setnames,name,".$set->id.",id,sub_category_id,".$set->sub_category_id,
            'time_of_exam'=>"required"
        ]);


        if(!empty($set))
        {
           $set->update($edit_data);

        }

        return response()->json(['success',"Set Name Updated Successfully",'type'=>'set']);
    }

    public function destroy(Request $request,Setname $setname)
    { 
        
        $setname->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Set Name deleted success"]);
        }        
        return redirect()->route('admin.options.index')->with("success","Set Name deleted success");
    }


}
