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

            "name"=>"required",
        ]);

        $sub = SubCategory::where('slug',$slug)->first();

        $set_data['sub_category_id'] = $sub->id;
        
        $set = new Setname;

        $set->store($set_data);
        
        return response()->json(['success' => 'Set Name Added Successfully']);

    }


    public function show(Request $request,Setname $setname){    

        // dd($learn->slug);
        
        if($request->ajax()){

            if(!empty($request->set))
            {
                
                $set = SubCategory::findSlug($request->set);

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

        $edit_data = $request->validate([

            "name"=>"required",
        ]);

        $set = Setname::findSlug($slug);

        if(!empty($set))
        {
           $set->update($edit_data);

        }

        return response()->json(['success',"Sub Category Updated Successfully",'type'=>'set']);
    }


}
