<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ImportQuestions;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamCategoryTitle;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopicTestController extends Controller
{
    
    use ResourceController; 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.topic-test"; 
        $categorys=$this->buildResult();
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        return view("admin.topic-test.index",compact('categorys','exam'));
    }
    public function show(Request $request,Category $category){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        self::$defaultActions=["delete"];
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        if($request->ajax()){
            if(!empty($request->sub_category_id)){
                $this->where('sub_category_id',$request->sub_category_id);
            }
            return $this->where('exam_id',$exam->id)
                ->where('category_id',$category->id)
                ->addAction(function($data)use($category){
                    return '
                    <a href="'.route("admin.topic-test.edit",["category"=>$category->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
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
        return view("admin.topic-test.show",compact('category','exam'));
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
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.topic-test.create",compact('category','exam'));
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
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.topic-test.edit",compact('category','exam','question'));
    }
    public function subtitle(Request $request){
        $data=$request->validate([
            "exam_id"=>['required'],
            "category_id"=>['required'],
            "title"=>['required'],
        ]);
        $icon=$request->icon;
        if(!empty($icon)){
            $data['icon']=$icon=="delete"?"":$icon;
        }
        $categorytitle=ExamCategoryTitle::where('exam_id',$data['exam_id'])->where('category_id',$data['category_id'])->first();
        if(empty($categorytitle)){
            $categorytitle=ExamCategoryTitle::store($data);
        }else{
            $categorytitle->update($data);
        }
        if(!empty($icon)){
            $data['icon']=$icon=="delete"?"":url('d0/'.$icon);
        }
        return $data;
    }
    public function updatetime(Request $request,Category $category){
        $data=$request->validate([
            'time_of_exam'=>"required"
        ]);
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $category->update($data); 
        dd($category);
        return redirect()->back()->with("success","Topic Test Time has been successfully updated");
    }


    public function importquestion(Request $request,Category $category){ 
        $request->validate([
            'import_fields'=>['required'],
            'import_fields.*'=>['required'],
            'import_datas'=>['required','file','mimes:json']
        ]);
 
        $file = $request->file('import_datas');
        $name = $file->hashName();
        Storage::put("importfile", $file); 
        
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        
        dispatch(new ImportQuestions(
            filename:$name,
            exam:$exam,
            category:$category, 
            fields:$request->import_fields
        ));

        return response()->json([
            'success'=>"Import started"
        ]);
    } 
}
