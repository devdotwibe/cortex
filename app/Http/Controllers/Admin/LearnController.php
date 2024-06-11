<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    
    use ResourceController; 
    
    public function index(Request $request){
        self::reset();

        self::$model = Category::class;
        self::$routeName = "admin.learn"; 

        $categorys=$this->buildResult();
      
        return view("admin.learn.index",compact('categorys'));
    }



    public function show(Request $request, $slug)
        {
                self::reset();
                self::$model = Category::class;
                self::$routeName = "admin.learn";
                
                $category = Category::findSlug($slug);
               
                // if($request->ajax()){
                //     return $this->where('category_id',$category->id)->buildTable();
                // } 
                return view("admin.learn.show",compact('category'));
        }


    public function destroy(Request $request,Learn $exam){ 
        $exam->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Learn deleted success"]);
        }        
        return redirect()->route('admin.learn.index')->with("success","QuestionBankChapter deleted success");
    }

    
    function add_subcatecory(Request $request,$slug)
    {
       
        $sub_data = $request->validate([

            "name"=>"required",
        ]);

        $learn = Learn::where('slug',$slug)->first();

        $sub_data['learn_id'] = $learn->id;
        
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
                    $category = Learn::findSlug($request->category);

                    return $this->where('learn_id',$category->id)->buildTable();
                }
                else
                {
                    return $this->buildTable();
                }
               
            }
            
        }
    

}

