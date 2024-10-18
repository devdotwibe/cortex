<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamCategoryTitle;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankControllerOld extends Controller
{
   
    use ResourceController; 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.question-bank"; 
        $categorys=$this->buildResult();
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }
        return view("admin.question-bank.index",compact('categorys','exam'));
    }
    public function subtitle(Request $request){
        $data=$request->validate([
            "exam_id"=>['required'],
            "category_id"=>['required'],
            "title"=>['required'],
        ]);
        $categorytitle=ExamCategoryTitle::where('exam_id',$data['exam_id'])->where('category_id',$data['category_id'])->first();
        if(empty($categorytitle)){
            $categorytitle=ExamCategoryTitle::store($data);
        }else{
            $categorytitle->update($data);
        }
        return $data;
    }
    public function show(Request $request,Category $category){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        self::$defaultActions=["delete"];
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }
        if($request->ajax()){ 
            if(!empty($request->sub_category_id)){
                $this->where('sub_category_id',$request->sub_category_id);
            }
            if(!empty($request->sub_category_set)){
                $this->where('sub_category_set',$request->sub_category_set);
            }
            return  $this->where('exam_id',$exam->id)->where('category_id',$category->id)->addAction(function($data)use($category){
                    return '
                    
                    <a href="'.route("admin.question-bank.edit",["category"=>$category->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active">
    </span>
</a>

                    ';
                })->addColumn('subcategoryname',function($data){
                    return optional($data->subCategory)->name;
                })->addColumn('visibility',function($data){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.question.visibility",$data->slug)."'".')" > 
                        </div>
                    ';
                })
                ->buildTable(['description','visibility']);
        } 
        return view("admin.question-bank.show",compact('category','exam'));
    }
    public function create(Request $request,Category $category){ 
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
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.question-bank.create",compact('category','exam'));
    } 

    public function edit(Request $request,Category $category,Question $question){ 
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
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.question-bank.edit",compact('category','exam','question'));
    }
    
}
