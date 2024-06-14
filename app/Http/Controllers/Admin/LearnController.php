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
      
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.learn.index",compact('categorys','exam'));
    }

    public function show(Request $request,Category $category){

        self::reset();
        self::$model = Learn::class;
        self::$routeName = "admin.learn"; 
        self::$defaultActions=[];
       
        if($request->ajax()){
            return $this ->where('category_id',$category->id)
                ->addAction(function($data)use($category){
                    return '
                    <a href="'.route("admin.learn.edit",["category"=>$category->slug,"learn"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    <a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.learn.destroy",["category"=>$category->slug,"learn"=>$data->slug]).'">
                        <img src="'.asset("assets/images/delete.svg").'" alt="">
                    </a> 
                    ';
                })
                ->buildTable(['title']);  
        } 
        
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.learn.show",compact('category','exam'));
    }


        public function create(Request $request,Category $category)
        {
                self::reset();
                self::$model = Category::class;
                self::$routeName = "admin.learn";
                 
               
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

                $exam=Exam::where("name",'learn')->first();
                if(empty($exam)){
                    $exam=Exam::store([
                        "title"=>"Learn",
                        "name"=>"learn",
                    ]);
                    $exam=Exam::find( $exam->id );
                } 
                return view("admin.learn.create",compact('category','exam'));
        }

        public function edit(Request $request,Category $category,Learn $learn )
        {
                self::reset();
                self::$model = Category::class;
                self::$routeName = "admin.learn";
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

                $exam=Exam::where("name",'learn')->first();
                if(empty($exam)){
                    $exam=Exam::store([
                        "title"=>"Learn",
                        "name"=>"learn",
                    ]);
                    $exam=Exam::find( $exam->id );
                } 
                return view("admin.learn.edit",compact('category','learn','exam'));
        }


        public function store(Request $request,Category $category){

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


            $learn_data['title'] = $request->title;

            $learn_data['learn_type'] = $request->learn_type;

            $learn=Learn::store($learn_data);

            if($request->learn_type ==="mcq")
                {
                    foreach($request->mcq_answer as $k =>$ans){
                        LearnAnswer::store([
                            "learn_id"=>$learn->id,
                            "iscorrect"=>$k==($request->choice_mcq_answer??0)?true:false,
                            "title"=>$ans
                        ]);
                    }
                }
           
            $redirect=$request->redirect??route('admin.learn.index');
            return redirect($redirect)->with("success","Learn has been successfully created");
        }
        public function update(Request $request,Category $category,Learn $learn){

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


            $learn_data['title'] = $request->title;

            $learn_data['learn_type'] = $request->learn_type;

            $learn->update($learn_data);

            $ansIds=[];
            if($request->learn_type ==="mcq")
                {
                    foreach($request->mcq_answer as $k =>$ans){
                        $learnAns=null;
                        if(!empty($request->choice_mcq_answer_id[$k]??"")){
                            $learnAns=LearnAnswer::find($request->choice_mcq_answer_id[$k]);
                        }
                        if(empty($learnAns)){
                            $learnAns=LearnAnswer::store([
                                "learn_id"=>$learn->id,
                                "iscorrect"=>$k==($request->choice_mcq_answer??0)?true:false,
                                "title"=>$ans
                            ]);
                        }else{
                            $learnAns->update([ 
                                "learn_id"=>$learn->id,
                                "iscorrect"=>$k==($request->choice_mcq_answer??0)?true:false,
                                "title"=>$ans
                            ]);
                        }
                        $ansIds[]=$learnAns->id;
                    }
                }
                LearnAnswer::where('learn_id',$learn->id)->whereNotIn('id',$ansIds)->delete();
           
            $redirect=$request->redirect??route('admin.learn.index');
            return redirect($redirect)->with("success","Learn has been successfully updated");
        }
        public function destroy(Request $request,Category $category,Learn $learn){
            LearnAnswer::where('learn_id',$learn->id)->delete();
            $learn->delete();
            if($request->ajax()){
                return response()->json(["success"=>"Learn has been successfully deleted"]);
            }        
            $redirect=$request->redirect??route('admin.learn.index');
            return redirect($redirect)->with("success","Learn has been successfully deleted");
        }

}

