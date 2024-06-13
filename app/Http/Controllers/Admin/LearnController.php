<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\LearnAnswer;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    
    use ResourceController; 

    function __construct()
    {
        self::$model = Learn::class;
        self::$routeName = "admin.learn";
    } 
    
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


        public function store(Request $request){

            switch ($request->input('learn_type',"")) {

                case 'video':
                    $learn_data=$request->validate([
                        "category_id"=>['required'],
                        "sub_category_id"=>['required'],
                        "video_url"=>['required'],  
                    ]);
                    break;
    
                case 'notes':
                    $learn_data=$request->validate([
                        "category_id"=>['required'],
                        "sub_category_id"=>['required'],
                        "short_question"=>['required'],
                        "short_answer"=>["required"],
                    ]);
                    break;
    
                case 'mcq':
                    $learn_data=$request->validate([
                        "category_id"=>['required'],
                        "sub_category_id"=>['required'],
                        "mcq_question"=>['required'],
                        "mcq_answer.*"=>["required"],
                    ],[
                        'mcq_answer.*.required'=>['The answer field is required.']
                    ]);
                    break;
                
                default:
                    $learn_data=$request->validate([
                        "category_id"=>['required'],
                        "sub_category_id"=>['required'],
                        "title"=>['required'],
                        "learn_type"=>["required"],
                    ]);
                    break;
            }
            $learn=Learn::store($learn_data);

            foreach($request->answer as $k =>$ans){
                LearnAnswer::store([
                    "learn_id"=>$learn->id,
                    "iscorrect"=>$k==($request->choice_mcq_answer??0)?true:false,
                    "title"=>$ans
                ]);
            }
    
            $redirect=$request->redirect??route('admin.learn.index');
            return redirect($redirect)->with("success","Learn has been successfully created");
        }

}

