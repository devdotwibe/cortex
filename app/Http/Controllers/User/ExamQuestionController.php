<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamQuestionController extends Controller
{
    use ResourceController; 
 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class; 

        $categorys=$this->buildResult();
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }
        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.question-bank.index",compact('categorys','exam','user'));
    }

    public function show(Request $request,Category $category){
        $lessons=SubCategory::where('category_id',$category->id)->get();
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        } 

        /**
         *  @var User
         */
        $user=Auth::user(); 
        return view("user.question-bank.show",compact('category','exam','lessons','user'));
    } 
    public function setshow(Request $request,Category $category,SubCategory $subCategory,Setname $setname){

        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        } 

        /**
         * @var User
         */
        $user=Auth::user(); 
        if($request->ajax()){            
            if($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',"")==""){
                $lessons=SubCategory::where('category_id',$category->id)->get();
                $lessencount=count($lessons);
                $totalprogres=0;
                foreach ($lessons as $lesson) {
                    $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
                }
                $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount);
            } 
            
            if(!empty($request->question)){
                $question=Question::findSlug($request->question);
                return Answer::where('question_id',$question->id)->get(['slug','title']);
            }
            return Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->paginate(1,['slug','title','description','duration']);
        }
        $questioncount=Question::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        return view("user.question-bank.set",compact('category','exam','subCategory','user','setname','questioncount'));
    }
}
