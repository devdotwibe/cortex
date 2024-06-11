<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankController extends Controller
{
   
    use ResourceController; 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.question-bank"; 
        $categorys=$this->buildResult();
        return view("admin.question-bank.index",compact('categorys'));
    }
    public function show(Request $request,Category $category){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        if($request->ajax()){
            return $this->where('category_id',$category->id)->buildTable();
        } 
        return view("admin.question-bank.show",compact('category'));
    }
    public function create(Request $request,Category $category){ 
        self::reset();
        self::$model = SubCategory::class; 
        if($request->ajax()){
            return $this->where('category_id',$category->id)->buildSelectOption();
        } 
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
        }
        return view("admin.question-bank.create",compact('category'));
    }
    public function subcat(Request $request,Category $category){ 
        return view("admin.question-bank.create",compact('category'));
    }
    
}
