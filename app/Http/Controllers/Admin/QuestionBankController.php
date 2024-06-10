<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learn;
use App\Models\Question;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankController extends Controller
{
   
    use ResourceController; 
    public function index(Request $request){
        self::reset();
        self::$model = Learn::class;
        self::$routeName = "admin.question-bank"; 
        $categorys=$this->buildResult();
        return view("admin.question-bank.index",compact('categorys'));
    }
    public function show(Request $request,Learn $category){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        if($request->ajax()){
            return $this->where('category_id',$category->id)->buildTable();
        } 
        return view("admin.question-bank.show",compact('category'));
    }
    public function create(Request $request,Learn $category){ 
        return view("admin.question-bank.create",compact('category'));
    }
}
