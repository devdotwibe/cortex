<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Learn;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Category::class;
        self::$routeName="admin.options";
        self::$defaultActions=['delete'];

    }
    
    
    function index(Request $request)
    {
        if($request->ajax()){
            return $this->addAction(function($data){

                return '<a onclick="SubCat(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>'.

                     '<a onclick="EditSub(\''.route('admin.options.update', $data->slug).'\', \''.$data->slug.'\' , \'category\')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>';


            })->buildTable();
        }

        return view('admin.options.index');
    }


    function store(Request $request)
    {
       
        $options_data = $request->validate([

            "name"=>"required",
        ]);
        
        $option = new Category;

        $option->store($options_data);
        
        return response()->json(['success' => 'Module Added Successfully']);

    }

    function update(Request $request, $slug)
        {

            $edit_data = $request->validate([

                "name"=>"required",
            ]);

            $category = Category::findSlug($slug);

            if(!empty($category))
            {
               $category->update($edit_data);

            }

            return response()->json(['success',"Category Updated Successfully",'type'=>'category']);
        
        }

    public function show(Request $request,Category $option){

        // dd($learn->slug);
        
        return view("admin.options.show",compact('option'));

    }

    public function destroy(Request $request,Category $category){ 
        $category->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Category deleted success"]);
        }        
        return redirect()->route('admin.options.index')->with("success","Category deleted success");
    }

    
    function add_subcatecory(Request $request,$slug)
    {
       
        $sub_data = $request->validate([

            "name"=>"required",
        ]);

        $option = Category::where('slug',$slug)->first();

        $sub_data['category_id'] = $option->id;
        
        $sub = new SubCategory;

        $sub->store($sub_data);
        
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

            }
            else
            {

            }
            
            
        }

        
}
