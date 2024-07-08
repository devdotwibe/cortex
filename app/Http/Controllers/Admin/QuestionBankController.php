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

class QuestionBankController extends Controller
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
    public function show(Request $request,Setname $setname){
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
            return  $this->where('exam_id',$exam->id)->where('category_id',$setname->category_id)->where('sub_category_id',$setname->sub_category_id)->where('sub_category_set',$setname->id)->addAction(function($data)use($setname){
                    return '
                    <a href="'.route("admin.question-bank.edit",["setname"=>$setname->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
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
        $category=Category::find($setname->category_id);
        $subcategory=SubCategory::find($setname->sub_category_id);
        return view("admin.question-bank.show",compact('category','subcategory','setname','exam'));
    }
    public function create(Request $request,Setname $setname){ 
        
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }        
        $category=Category::find($setname->category_id);
        $subcategory=SubCategory::find($setname->sub_category_id);
        return view("admin.question-bank.create",compact('category','subcategory','setname','exam'));
    } 

    public function edit(Request $request,Setname $setname,Question $question){  
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $category=Category::find($setname->category_id);
        $subcategory=SubCategory::find($setname->sub_category_id);
        
        return view("admin.question-bank.edit",compact('category','subcategory','setname','exam','question'));
    }


    public function subcategory(Request $request,Category $category){ 
        $subcategory=[];
        foreach ($category->subcategories as $row) {
            // $sets=[];
            // foreach ($row->setname as $set) {
            //     $set->questionsUrl=route('admin.question-bank.show',$set->slug);
            //     $sets[]=$set;
            // }
            $row->subsetUrl=route('admin.set.set_store', $row->slug);
            $row->setUrl=route('admin.question-bank.subcategoryset',$row->slug);
            $subcategory[]=$row;
        }
        return $subcategory;
    } 
    public function subcategoryset(Request $request,SubCategory $subCategory){ 
        $sets=[];
        foreach ($subCategory->setname as $row) {            
            $row->questionsUrl=route('admin.question-bank.show',$row->slug);
            $sets[]=$row; 
        }
        return $sets;
    } 
    public function importquestion(Request $request,Setname $setname){ 
        $request->validate([
            'import_fields'=>['required'],
            'import_fields.*'=>['required'],
            'import_datas'=>['required','file','mimes:json']
        ]);
 
        $file = $request->file('import_datas');
        $name = $file->hashName();
        Storage::put("importfile", $file);
        
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }        
        $category=Category::find($setname->category_id);
        $subcategory=SubCategory::find($setname->sub_category_id); 
        
        dispatch(new ImportQuestions(
            filename:$name,
            exam:$exam,
            category:$category,
            subCategory:$subcategory,
            setname:$setname,
            fields:$request->import_fields
        ));

        return response()->json([
            'success'=>"Import started"
        ]);
    } 
    
}
