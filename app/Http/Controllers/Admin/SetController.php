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
    }
    
    function store(Request $request,$slug)
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
                
                $category = SubCategory::findSlug($request->set);

                return $this->buildTable();
            }
            else
            {
                return $this->buildTable();
            }
           
        }

    }


}
