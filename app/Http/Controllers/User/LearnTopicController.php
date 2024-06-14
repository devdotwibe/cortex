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
        return view("user.learn.index",compact('categorys','exam'));
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
        return view("user.learn.show",compact('category','exam','lessons'));
    } 
    public function lessonshow(Request $request,Category $category,SubCategory $subCategory){
        if($request->ajax()){
            if(!empty($request->question)){
                $learn=Learn::findSlug($request->question);
                return LearnAnswer::where('learn_id',$learn->id)->get(['slug','title']);
            }
            return Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->paginate(1,['slug','learn_type','title','short_question','video_url','mcq_question']);
        }
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("user.learn.lesson",compact('category','exam','subCategory'));
    }
    
}
