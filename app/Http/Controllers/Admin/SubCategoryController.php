<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    use ResourceController;
    function __construct()
    {
        self::$model=SubCategory::class;
        self::$routeName="admin.subcategory";
        self::$defaultActions=[''];

    }

    
    function subcategory_table(Request $request)

    {
        if($request->ajax()){

            if(!empty($request->category))
            {
                
                $category = Category::findSlug($request->category);

               
                    return $this->where('category_id',$category->id)
                ->addAction(function($data){

                    if(!empty($data->setname) && count($data->setname) > 0)
                    {

                    return '<a onclick="AddSet(\''.route('admin.set.set_store', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>'.

                    '<a onclick="EditSub(\''.route('admin.subcategory.update', $data->slug).'\', \''.$data->slug.'\' , \'subcategory\')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>';

                    }
                    else
                    {

                        return '<a onclick="AddSet(\''.route('admin.set.set_store', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>'.

                        '<a onclick="EditSub(\''.route('admin.subcategory.update', $data->slug).'\', \''.$data->slug.'\' , \'subcategory\')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>'.

                        '<a  class="btn btn-icons dlt_btn" onclick="deleteRecord('."'".route("admin.subcategory.destroy",$data->slug)."'".')">
                        <img src="'.asset("assets/images/delete.svg").'" alt="">
                        </a> ';

                    }
        
                    }) ->buildTable();

             

                
                   
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

        $sub = SubCategory::findSlug($slug);

        if(!empty($sub))
        {
           $sub->update($edit_data);

        }

        return response()->json(['success',"Sub Category Updated Successfully",'type'=>'subcategory']);
    
    }


}
