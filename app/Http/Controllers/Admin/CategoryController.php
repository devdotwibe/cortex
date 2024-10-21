<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Learn;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Category::class;
        self::$routeName="admin.category";
        self::$defaultActions=[''];

    }
    
    
    function index(Request $request)
    {
        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                    <a onclick="subcategorylist(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\', \''.$data->name.'\')" class="btn btn-icons view_btn" data-id="'.$data->name.'">+</a>



                   <a onclick="updatecategory('."'".route('admin.category.edit', $data->slug)."'".')"  class="btn btn-icons edit_btn">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active">
    </span>
</a>



                ';
                if(empty($data->subcategories) || count($data->subcategories) == 0)
                { 
                    $action.=  

                       '<a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.category.destroy",$data->slug).'" >
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active">
                        </span>
                    </a> '; 


                } 
                return $action;
            })->addColumn('visibility',function($data){
                return '                
                    <div class="form-check ">
                        <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.category.visibility",$data->slug)."'".')" > 
                    </div>
                ';
            })->buildTable(['visibility']);
        }

        // $category = Category::with('subcategories')->where('id',$id)->first();

        return view('admin.category.index');
    }
    

    function store(Request $request)
    {
       
        $options_data = $request->validate([

            "name" => "required|unique:categories,name",
        ]);
        
        $option = new Category;

        $option->store($options_data);
        
        return response()->json(['success' => 'Module Added Successfully']);

    }

    function update(Request $request, $slug)
        {

            $category = Category::findSlug($slug);

            $edit_data = $request->validate([

                "name" => "required|unique:categories,name,".$category->id,
            ]);

            $category = Category::findSlug($slug);

            if(!empty($category))
            {
               $category->update($edit_data);

            }

            return response()->json(['success',"Category Updated Successfully",'type'=>'category']);
        
        }

    public function edit(Request $request,Category $category){
        if($request->ajax()){
            $category->updateUrl=route('admin.category.update', $category->slug);
            return response()->json($category);
        }
    }
    public function show(Request $request,Category $option){

        // dd($learn->slug);
        
        return view("admin.category.show",compact('option'));

    }
    public function visibility(Request $request,Category $category){
        $category->update(['visible_status'=>($category->visible_status??"")=="show"?"hide":"show"]);        
        if($request->ajax()){
            return response()->json(["success"=>"Category visibility change success"]);
        }        
        return redirect()->route('admin.category.index')->with("success","Category visibility change success");
    }
    

    public function destroy(Request $request,Category $category)
    { 
        
        // print_r($category);

        $category->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Category deleted success"]);
        }        
        return redirect()->route('admin.category.index')->with("success","Category deleted success");
    }

    
    function add_subcatecory(Request $request,Category $category)
    {        
        $sub_data = $request->validate([
           "name" => "required|unique:sub_categories,name,NULL,id,category_id,".$category->id,
        ]);
        $sub_data['category_id'] = $category->id;
        SubCategory::store($sub_data);        
        return response()->json(['success' => 'Sub Category Added Successfully']);
    }

   

        function get_edit_details(Request $request)
        {
           
            if($request->type==='category')
            {
                $category = Category::findSlug($request->slug);

                if(!empty($category))
                {
                    $name = $category->name;

                    return response()->json(['name'=>$name]);
                }
                else
                {
                    return response()->json(['fail' => 'Failed to get Category Name']);
                }

            }
            elseif($request->type==='subcategory')
            {

                $sub = SubCategory::findSlug($request->slug);

                if(!empty($sub))
                {
                    $name = $sub->name;

                    return response()->json(['name'=>$name]);
                }
                else
                {
                    return response()->json(['fail' => 'Failed to get Category Name']);
                }

            }
            else
            {

                $set = Setname::findSlug($request->slug);

                if(!empty($set))
                {
                    $name = $set->name;

                    return response()->json(['name'=>$name]);
                }
                else
                {
                    return response()->json(['fail' => 'Failed to get Category Name']);
                }

            }
            
            
        }

        
}
