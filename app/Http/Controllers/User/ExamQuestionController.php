<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitReview;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use App\Models\UserReviewQuestion;
use App\Trait\ResourceController;
use Carbon\Carbon;
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
            if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',"")==""){
                $lessons=SubCategory::where('category_id',$category->id)->get();
                $lessencount=count($lessons);
                $totalprogres=0;
                foreach ($lessons as $lesson) {
                    $sets=Setname::where('category_id',$category->id)->where('sub_category_id',$lesson->id)->get();
                    $setcount=count($sets);
                    $catprogres=0;
                    foreach ($sets as $sitm) {
                        $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);
                    }
                    $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);
                    $totalprogres+=$catprogres;
                }
                $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id,$totalprogres/$lessencount);
            } 
            
            if(!empty($request->question)){
                $question=Question::findSlug($request->question);
                return Answer::where('question_id',$question->id)->get(['slug','title']);
            }
            return Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->paginate(1,['slug','title','description','duration']);
        }
        $questioncount=Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->count();
        $endtime=0;
        foreach (Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->get() as $d) {
            $endtime+=intval(explode(' ',$d->duration)[0]);
            $user->setProgress("exam-{$exam->id}-topic-{$category->id}-lesson-{$subCategory->id}-set-{$setname->id}-answer-of-{$d->slug}",null);
        }
        $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->count()+1;
        return view("user.question-bank.set",compact('category','exam','subCategory','user','setname','questioncount','endtime','attemtcount'));
    } 
    public function preview(Request $request,UserExamReview $userExamReview){ 
        $category=Category::find($userExamReview->category_id);
        $subCategory=SubCategory::find($userExamReview->sub_category_id);
        $setname=Setname::find($userExamReview->sub_category_set);

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
            if(!empty($request->question)){
                $question=UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get(['slug','title','user_answer','iscorrect']);
            }
            return UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_exam_review_id',$userExamReview->id)->paginate(1,['title','note','slug','explanation']);
        }
        return view("user.question-bank.preview",compact('category','exam','subCategory','setname','user','userExamReview'));
    }
    
    public function setreview(Request $request,Category $category,SubCategory $subCategory,Setname $setname){

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
            if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',"")==""){
                $lessons=SubCategory::where('category_id',$category->id)->get();
                $lessencount=count($lessons);
                $totalprogres=0;
                foreach ($lessons as $lesson) {
                    $sets=Setname::where('category_id',$category->id)->where('sub_category_id',$lesson->id)->get();
                    $setcount=count($sets);
                    $catprogres=0;
                    foreach ($sets as $sitm) {
                        $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);
                    }
                    $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);
                    $totalprogres+=$catprogres;
                }
                $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id,$totalprogres/$lessencount);
            } 

            return Question::with('answers')->where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->paginate(1);
        }
        $questioncount=Question::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        return view("user.question-bank.set",compact('category','exam','subCategory','user','questioncount','setname'));
    } 
    public function setsubmit(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        /**
         * @var User
         */
        $user=Auth::user();        
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $review=UserExamReview::store([
            "title"=>"Question Bank",
            "name"=>"question-bank",
            "progress"=>$user->progress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id.'-set-'.$setname->id,0),
            "user_id"=>$user->id,
            "exam_id"=>$exam->id,
            "category_id"=>$category->id,
            "sub_category_id"=>$subCategory->id, 
            "sub_category_set"=>$setname->id,            
        ]); 
        $user->setProgress("exam-review-".$review->id."-timed",$request->input("timed",'timed'));
        $user->setProgress("exam-review-".$review->id."-timetaken",$request->input("timetaken",'timetaken'));
        $user->setProgress("exam-review-".$review->id."-flags",json_encode($request->input("flags",[])));
        $user->setProgress("exam-review-".$review->id."-times",json_encode($request->input("times",[])));
        $lessons=SubCategory::where('category_id',$category->id)->get();
        $lessencount=count($lessons);
        $totalprogres=0;
        foreach ($lessons as $lesson) {
            $sets=Setname::where('category_id',$category->id)->where('sub_category_id',$lesson->id)->get();
            $setcount=count($sets);
            $catprogres=0;
            foreach ($sets as $sitm) {
                $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);
            }
            $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);
            $totalprogres+=$catprogres;
        }
        $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id,$totalprogres/$lessencount);
        if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id.'-set-'.$setname->id."-complete-review",'yes');
        dispatch(new SubmitReview($review)); 
        if($request->ajax()){
            return  response()->json(["success"=>"Question set Submited","preview"=>route('question-bank.preview',$review->slug)]);    
        }
        return  redirect()->route('question-bank.show',['category'=>$category->slug])->with("success","Question set Submited");
    }
    public function sethistory(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        /**
         * @var User
         */
        $user=Auth::user();       
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $data=[];
        foreach(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->where('exam_id',$exam->id)->get() as  $row){
            $data[]=[
                'slug'=>$row->slug,
                'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
                'progress'=>$row->progress,
                'url'=>route('question-bank.preview',$row->slug),
            ];
        }
        return [
            'data'=>$data,
            'url'=>route('question-bank.set.show',[
                'category'=>$category->slug,
                'sub_category'=>$subCategory->slug,
                'setname'=>$setname->slug
            ]),
            'name'=>$subCategory->name
        ];
    }

    public function setverify(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        $request->validate([
            "question"=>'required'
        ]);
        /**
        * @var User
        */
       $user=Auth::user();       
       $exam=Exam::where("name",'question-bank')->first();
       if(empty($exam)){
           $exam=Exam::store([
               "title"=>"Question Bank",
               "name"=>"question-bank",
           ]);
           $exam=Exam::find( $exam->id );
       } 
        $question=Question::findSlug($request->question);
        $ans=Answer::findSlug($request->answer);
        if(empty($ans)||$ans->exam_id!=$exam->id||$ans->question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false,'s'=>$ans]);
        }else{
            return response()->json(["iscorrect"=>true]);
        }
    }
}
