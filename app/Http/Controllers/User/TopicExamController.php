<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitReview;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question; 
use App\Models\User;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use App\Models\UserReviewQuestion;
use App\Trait\ResourceController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicExamController extends Controller
{
    use ResourceController; 
 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class; 

        $categorys=$this->buildResult();
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.topic-test.index",compact('categorys','exam','user'));
    } 
    public function show(Request $request,Category $category){

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }

        /**
         * @var User
         */
        $user=Auth::user(); 
        if($request->ajax()){      
            
            if(!empty($request->question)){
                $question=Question::findSlug($request->question);
                return Answer::where('question_id',$question->id)->get(['slug','title']);
            }
            return Question::where('exam_id',$exam->id)->where('category_id',$category->id)->paginate(1,['slug','title','description','duration']);
        }
        $questioncount=Question::where('exam_id',$exam->id)->where('category_id',$category->id)->count();
        $endtime=0;
        foreach (Question::where('exam_id',$exam->id)->where('category_id',$category->id)->get() as $d) {
            $endtime+=intval(explode(' ',$d->duration)[0]);
            $user->setProgress("exam-{$exam->id}-topic-{$category->id}-answer-of-{$d->slug}",null);
        }
        $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('category_id',$category->id)->count()+1;
        return view("user.topic-test.show",compact('category','exam','user','questioncount','endtime','attemtcount'));
    } 
    

    public function topicsubmit(Request $request,Category $category){
        /**
         * @var User
         */
        $user=Auth::user();
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $review=UserExamReview::store([
            "title"=>"Topic Test",
            "name"=>"topic-test",
            "progress"=>$user->progress("exam-".$exam->id."-topic-".$category->id,0),
            "user_id"=>$user->id,
            "exam_id"=>$exam->id,
            "category_id"=>$category->id,         
        ]); 
        $user->setProgress("exam-review-".$review->id."-timed","untimed");
        $user->setProgress("exam-review-".$review->id."-timetaken",$request->input("timetaken",''));
        $user->setProgress("exam-review-".$review->id."-flags",json_encode($request->input("flags",[])));
        $user->setProgress("exam-review-".$review->id."-times",json_encode($request->input("times",[])));
         
        if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-complete-review",'yes');
        dispatch(new SubmitReview($review)); 
        if($request->ajax()){
            return  response()->json(["success"=>"Topic Test Submited","preview"=>route('topic-test.preview',$review->slug)]);    
        }
        return  redirect()->route('topic-test.index')->with("success","Topic Test Submited");
    }

    public function preview(Request $request,UserExamReview $userExamReview){ 
        $category=Category::find($userExamReview->category_id); 

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
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
            return UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_exam_review_id',$userExamReview->id)->paginate(1,['title','note','slug']);
        }
        return view("user.topic-test.preview",compact('category','exam','user','userExamReview'));
    }
    
    public function topicverify(Request $request,Category $category){
        $request->validate([
            "question"=>'required'
        ]);
        /**
        * @var User
        */
       $user=Auth::user();  
       $exam=Exam::where("name",'topic-test')->first();
       if(empty($exam)){
           $exam=Exam::store([
               "title"=>"Topic Test",
               "name"=>"topic-test",
           ]);
           $exam=Exam::find( $exam->id );
       }
        $question=Question::findSlug($request->question);
        $ans=Answer::findSlug($request->answer);
        if(empty($ans)||$ans->exam_id!=$exam->id||$ans->question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false]);
        }else{
            return response()->json(["iscorrect"=>true]);
        }
    }


    public function topichistory(Request $request,Category $category){
        /**
         * @var User
         */
        $user=Auth::user();       
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $data=[];
        foreach(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('exam_id',$exam->id)->get() as  $row){
            $data[]=[
                'slug'=>$row->slug,
                'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
                'progress'=>$row->progress,
                'url'=>route('topic-test.preview',$row->slug),
            ];
        }
        return [
            'data'=>$data,
            'url'=>route('topic-test.show',[
                'category'=>$category->slug, 
            ]),
            'name'=>$category->name
        ];
    }
}
