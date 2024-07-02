<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitReview;
use App\Models\Answer;
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

class MockExamController extends Controller
{
    
    use ResourceController; 
 
    public function index(Request $request){
        self::reset();
        self::$model = Exam::class; 

        $exams=$this->where("name",'full-mock-exam')->where(function($qry){
            $qry->whereIn("id",Question::select('exam_id'));
        })->buildPagination();
         
        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.full-mock-exam.index",compact('exams','user'));
    } 

    public function show(Request $request,Exam $exam){ 
        /**
         * @var User
         */
        $user=Auth::user(); 
        if($request->ajax()){ 
            if(!empty($request->question)){
                $question=Question::findSlug($request->question);
                return Answer::where('question_id',$question->id)->get(['slug','title']);
            }
            return Question::where('exam_id',$exam->id)->paginate(1,['slug','title','description','duration']);
        }
        $questioncount=Question::where('exam_id',$exam->id)->count();
        $endtime=0;
        foreach (Question::where('exam_id',$exam->id)->get() as $d) {
            $endtime+=intval(explode(' ',$d->duration)[0]);
            $user->setProgress("exam-{$exam->id}-answer-of-{$d->slug}",null);
        }
        $attemtcount=UserExamReview::where('exam_id',$exam->id)->count()+1;
        return view("user.full-mock-exam.show",compact('exam','user','questioncount','endtime','attemtcount'));
    } 

    public function examverify(Request $request,Exam $exam){
        $request->validate([
            "question"=>'required'
        ]);
        /**
        * @var User
        */
       $user=Auth::user();   
        $question=Question::findSlug($request->question);
        $ans=Answer::findSlug($request->answer);
        if(empty($ans)||$ans->exam_id!=$exam->id||$ans->question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false]);
        }else{
            return response()->json(["iscorrect"=>true]);
        }
    }

    public function examsubmit(Request $request,Exam $exam){
        /**
         * @var User
         */
        $user=Auth::user(); 
        $review=UserExamReview::store([
            "title"=>$exam->title,
            "name"=>$exam->name,
            "progress"=>$user->progress("exam-".$exam->id,0),
            "user_id"=>$user->id,
            "exam_id"=>$exam->id,   
        ]); 
        $user->setProgress("exam-review-".$review->id."-timed",'timed');
        $user->setProgress("exam-review-".$review->id."-timetaken",$request->input("timetaken",'0'));
        $user->setProgress("exam-review-".$review->id."-flags",$request->input("flags",'[]'));
        $user->setProgress("exam-review-".$review->id."-times",$request->input("times",'[]'));
        $user->setProgress("exam-review-".$review->id."-passed",$request->input("passed",'0'));
         
        if($user->progress('exam-'.$exam->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-complete-review",'yes');
        dispatch(new SubmitReview($review)); 
        if($request->ajax()){
            return  response()->json(["success"=>$exam->title." Submited","preview"=>route('full-mock-exam.preview',$review->slug)]);    
        }
        return  redirect()->route('full-mock-exam.complete',$exam->slug)->with("success",$exam->title." Submited")->with("review",$review->id);
    }


    public function examcomplete(Request $request,Exam $exam){
        $review=UserExamReview::find(session('review',0));
        /**
         * @var User
         */
        $user=Auth::user();   
        if(!empty($review)){
            $user->progress("exam-review-".$review->id."-timed",'timed');
            $tmtk=intval($user->progress("exam-review-".$review->id."-timetaken",0)); 
            $passed=$user->progress("exam-review-".$review->id."-passed",0);
            
            $m=sprintf("%02d",intval($tmtk/60));
            $s=sprintf("%02d",intval($tmtk%60));

            $attemttime="$m:$s";
            $questioncount=Question::where('exam_id',$exam->id)->count();
            $attemtcount=UserExamReview::where('exam_id',$exam->id)->count();
            return view('user.full-mock-exam.resultpage',compact('review','passed','attemttime','questioncount','attemtcount'));
        }else{
            return redirect()->route('full-mock-exam.index');
        }
    }
    public function preview(Request $request,UserExamReview $userExamReview){
        $exam=Exam::find( $userExamReview->exam_id );
        /**
         * @var User
         */
        $user=Auth::user();
        
        if($request->ajax()){
            if(!empty($request->question)){
                $question=UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get();
            }
            return UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_exam_review_id',$userExamReview->id)->paginate(1);
        }
        return view("user.full-mock-exam.preview",compact('exam','user','userExamReview'));
    }
    public function examhistory(Request $request,Exam $exam){
        /**
         * @var User
         */
        $user=Auth::user();
        $data=[];
        foreach(UserExamReview::where('user_id',$user->id)->where('exam_id',$exam->id)->get() as  $row){
            $data[]=[
                'slug'=>$row->slug,
                'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
                'progress'=>$row->progress,
                'url'=>route('full-mock-exam.preview',$row->slug),
            ];
        }
        return [
            'data'=>$data,
            'url'=>route('full-mock-exam.show',$exam->slug),
            'name'=>$exam->name
        ];
    }
    
}
