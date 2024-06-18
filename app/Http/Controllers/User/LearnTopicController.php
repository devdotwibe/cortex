<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\LearnAnswer;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnTopicController extends Controller
{
    use ResourceController; 

    function __construct()
    {
        self::$model = Learn::class; 
    } 
    
    public function index(Request $request){
        self::reset();
        self::$model = Category::class; 

        $categorys=$this->buildResult();
      
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 

        $user=Auth::user();

        return view("user.learn.index",compact('categorys','exam','user'));
    }
    public function show(Request $request,Category $category){
        $lessons=SubCategory::where('category_id',$category->id)->get();
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $user=Auth::user(); 
        return view("user.learn.show",compact('category','exam','lessons','user'));
    } 
    public function lessonshow(Request $request,Category $category,SubCategory $subCategory){

        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $user=Auth::user(); 
        if($request->ajax()){
            $lessons=SubCategory::where('category_id',$category->id)->get();
            $lessencount=count($lessons);
            $totalprogres=0;
            foreach ($lessons as $lesson) {
                $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
            }
            $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount);

            if(!empty($request->question)){
                $learn=Learn::findSlug($request->question);
                return LearnAnswer::where('learn_id',$learn->id)->get(['slug','title']);
            }
            return Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->paginate(1,['slug','learn_type','title','short_question','video_url','mcq_question']);
        }
        $learncount=Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        return view("user.learn.lesson",compact('category','exam','subCategory','user','learncount'));
    } 
    
    public function lessonreview(Request $request,Category $category,SubCategory $subCategory){

        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $user=Auth::user(); 
        if($request->ajax()){
            $lessons=SubCategory::where('category_id',$category->id)->get();
            $lessencount=count($lessons);
            $totalprogres=0;
            foreach ($lessons as $lesson) {
                $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
            }
            $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount); 

            return Learn::with('learnanswers')->whereIn('learn_type',['mcq','short_notes'])->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->paginate(1);
        }
        $learncount=Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        return view("user.learn.lesson",compact('category','exam','subCategory','user','learncount'));
    } 
}
