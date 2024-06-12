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
       
        $set_data = $request->validate([

            "name" => "required|unique:setnames,name",
        ]);

        $sub = SubCategory::where('slug',$slug)->first();

        $set_data['sub_category_id'] = $sub->id;

        $set_data['category_id'] = $sub->category_id;
        
        $set = new Setname;

        $set->store($set_data);
        
        return response()->json(['success' => 'Set Name Added Successfully']);

    }


    public function show(Request $request,Setname $setname){    

        // dd($learn->slug);
        
        if($request->ajax()){

            if(!empty($request->set_name))
            {
                
                $set = SubCategory::findSlug($request->set_name);

                return $this->where('sub_category_id',$set->id)
                ->addAction(function($data){

                    return 

                    '<a onclick="EditSub(\''.route('admin.set.update', $data->slug).'\', \''.$data->slug.'\' , \'set\')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>';;

                    })->buildTable();
            }
            else
            {
                return $this->buildTable();
            }
           
        }

    }


    function update(Request $request, $slug)
    {

        $set = SubCategory::findSlug($slug);

        $edit_data = $request->validate([

            "name" => "required|unique:setnames,name".$set->id,
        ]);

        $set = Setname::findSlug($slug);

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
