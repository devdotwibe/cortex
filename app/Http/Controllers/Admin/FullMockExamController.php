<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ImportQuestions;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            if(!empty($request->category)){
                $this->where('category_id',$request->category);
            }
            return $this->where('exam_id',$exam->id) 
                ->addAction(function($data)use($exam){
                    return '
                    

                      <a href="'.route("admin.full-mock-exam.edit",["exam"=>$exam->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active">
    </span>
</a>


                    ';
                })->addColumn('visibility',function($data){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.question.visibility",$data->slug)."'".')" > 
                        </div>
                    ';
                })
                ->buildTable(['description','visibility']);
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

    public function edit(Request $request,Exam $exam,Question $question){ 
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
        return view("admin.full-mock-exam.edit",compact('exam','question'));
    }


    public function importquestion(Request $request,Exam $exam){ 
        $request->validate([
            'import_fields'=>['required'],
            'import_fields.*'=>['required'],
            'import_datas'=>['required','file','mimes:json']
        ]);
 
        $file = $request->file('import_datas');
        $name = $file->hashName();
        Storage::put("importfile", $file); 
          
        dispatch(new ImportQuestions(
            filename:$name,
            exam:$exam, 
            fields:$request->import_fields
        ));

        return response()->json([
            'success'=>"Import started"
        ]);
    } 
}
