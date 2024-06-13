<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\Setname;
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

    public function show(Request $request,Category $category){

        self::reset();
        self::$model = Learn::class;
        self::$routeName = "learn.show"; 
        self::$defaultActions=["delete"];
       
        if($request->ajax()){
            return $this ->where('category_id',$category->id)
                ->addAction(function($data)use($category){
                    return '
                    <a href="'.route("admin.question-bank.edit",["category"=>$category->slug,"learn"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    ';
                })
                ->buildTable(['title']);  
        } 
        
        return view("admin.learn.show",compact('category'));
    }


    public function create(Request $request, $category)
        {
                self::reset();
                self::$model = Category::class;
                self::$routeName = "admin.learn";
                
                $category = Category::findSlug($category);
               
                if($request->ajax()){
                    $name=$request->name??"";
                    if($name=="sub_category_set"){
                        self::reset();
                        self::$model = Setname::class; 
                        return $this->where('sub_category_id',$request->parent_id??0)/*->where('category_id',$category->id)*/->buildSelectOption();
                    }else{
                        self::reset();
                        self::$model = SubCategory::class; 
                        return $this->where('category_id',$category->id)->buildSelectOption();
                    }
                } 
                // if($request->ajax()){
                //     return $this->where('category_id',$category->id)->buildTable();
                // } 
                return view("admin.learn.create",compact('category'));
        }


}

