<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class FullMockExamController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Question::class;
        self::$routeName="admin.question";
    } 

    public function index(Request $request,Exam $exam){ 
        self::$defaultActions=["delete"];

        if($request->ajax()){
            return $this->where('exam_id',$exam->id) 
                ->addAction(function($data)use($exam){
                    return '
                    <a href="'.route("admin.full-mock-exam.edit",["exam"=>$exam->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    ';
                })
                ->buildTable(['description']);
        } 
        return view("admin.full-mock-exam.index",compact('exam'));
    }
    public function create(Request $request,Exam $exam){
        if($request->ajax()){
            $name=$request->name??"";
            if($name=="category_id"){
                self::reset();
                self::$model = Category::class; 
                return $this->buildSelectOption();
            }else{
                self::reset();
                self::$model = SubCategory::class; 
                return $this->where('category_id',$request->parent_id??0)->buildSelectOption();
            }
        }  
        return view("admin.full-mock-exam.create",compact('exam'));
    }
}
