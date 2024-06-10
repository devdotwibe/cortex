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
    }
    
    
    function index(Request $request)
    {
        if($request->ajax()){
            return $this->addAction(function($data){

            return '<a onclick="SubCat(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>';


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

    function sub_category_table(Request $request)

        {
            if($request->ajax()){

                self::$model=SubCategory::class;

                self::$routeName="admin.sub_category_table";

                if(!empty($request->category))
                {
                    
                    $category = Category::findSlug($request->category);

                    return $this->where('category_id',$category->id)->buildTable();
                }
                else
                {
                    return $this->buildTable();
                }
               
            }
            
        }

        
}
