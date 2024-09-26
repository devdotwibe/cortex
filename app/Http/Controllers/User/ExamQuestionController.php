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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ExamQuestionController extends Controller
{
    use ResourceController;

    public function index(Request $request){
        self::reset();
        self::$model = Category::class;

        Session::remove("question-bank-attempt");
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }

        $categorys=$this->whereHas('subcategories',function($qry)use($exam){
            $qry->whereIn("id",Question::where('exam_id',$exam->id)->select('sub_category_id'));
        })->buildResult();

        /**
         *  @var User
         */
        $user=Auth::user(); 
        return view("user.question-bank.index",compact('categorys','exam','user'));
    }

    public function show(Request $request,Category $category){

        Session::remove("question-bank-attempt");
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }

        $lessons=SubCategory::where('category_id',$category->id)->whereHas('setname',function($qry)use($exam){
            $qry->whereHas("questions",function($qry)use($exam){
                $qry->where('exam_id',$exam->id);
            });
        })->get();

        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.question-bank.show",compact('category','exam','lessons','user'));
    }
    public function setattempt(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        Session::put("question-bank-attempt",$setname->slug);
        return redirect()->route('question-bank.set.attempt',['category'=>$category->slug,'sub_category'=>$subCategory->slug,'setname'=>$setname->slug]);
    }
    public function setshow(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        if(session("question-bank-attempt")){
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
            $user->setProgress("attempt-recent-link",route('question-bank.show',['category'=>$category->slug]));
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
            $times=explode(':',$setname->time_of_exam);
            if(count($times)>0){
                $endtime+=intval(trim($times[0]??"0"))*60;
                $endtime+=intval(trim($times[1]??"0"));
            }
            foreach (Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->get() as $d) {
                $user->setProgress("exam-{$exam->id}-topic-{$category->id}-lesson-{$subCategory->id}-set-{$setname->id}-answer-of-{$d->slug}",null);
            }
            $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->count()+1;
            return view("user.question-bank.set",compact('category','exam','subCategory','user','setname','questioncount','endtime','attemtcount'));
        }
        else{
            return  redirect()->route('question-bank.index')->with("error","Question set not initialized");
        }
    }
    public function preview(Request $request,UserExamReview $userExamReview){
        $category=Category::find($userExamReview->category_id);
        $subCategory=SubCategory::find($userExamReview->sub_category_id);
        $setname=Setname::find($userExamReview->sub_category_set);
        Session::remove("question-bank-attempt");

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
        $user->setProgress("review-recent-link",route('question-bank.preview',['user_exam_review'=>$userExamReview->slug]));
        if($request->ajax()){
            if(!empty($request->question)){
                $question=UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get();
            }
            return UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->paginate(1);
        }
        $useranswer=UserReviewQuestion::leftJoin('user_review_answers','user_review_answers.user_review_question_id','user_review_questions.id')
                        ->where('user_review_answers.user_answer',true)
                        ->whereIn('user_review_questions.review_type',['mcq'])
                        ->where('user_review_questions.user_id',$user->id)
                        ->where('user_review_questions.user_exam_review_id',$userExamReview->id)
                        ->select('user_review_questions.id','user_review_questions.time_taken','user_review_answers.iscorrect')->get();
        $examtime=0;
        if($user->progress("exam-review-".$userExamReview->id."-timed",'')=="timed"){
            $times=explode(':',$user->progress("exam-review-".$userExamReview->id."-time_of_exam",'0:0'));
            if(count($times)>0){
                $examtime+=intval(trim($times[0]??"0"))*60;
                $examtime+=intval(trim($times[1]??"0"));
            }
            if($examtime>0&&count($useranswer)>0){
                $examtime=$examtime/count($useranswer);
            }
        }
        return view("user.question-bank.preview",compact('category','exam','subCategory','setname','user','userExamReview','useranswer','examtime'));
    }

    public function setreview(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        Session::remove("question-bank-attempt");
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
        $questioncount=Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->count();
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
            "timed"=>$request->input("timed",'timed'),
            "timetaken"=>$request->input("timetaken",'0'),
            "flags"=>$request->input("flags",'[]'),
            "times"=>$request->input("times",'[]'),
            "passed"=>$request->input("passed",'0'),
            "time_of_exam"=>$setname->time_of_exam,
        ]);
        $user->setProgress("exam-review-".$review->id."-timed",$request->input("timed",'timed'));
        $user->setProgress("exam-review-".$review->id."-timetaken",$request->input("timetaken",'0'));
        $user->setProgress("exam-review-".$review->id."-flags",$request->input("flags",'[]'));
        $user->setProgress("exam-review-".$review->id."-times",$request->input("times",'[]'));
        $user->setProgress("exam-review-".$review->id."-passed",$request->input("passed",'0'));
        $user->setProgress("exam-review-".$review->id."-time_of_exam",$setname->time_of_exam);
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
        Session::remove("question-bank-attempt");
        if($request->ajax()){
            return  response()->json(["success"=>"Question set Submited","preview"=>route('question-bank.preview',$review->slug)]);
        }
        return  redirect()->route('question-bank.set.complete',$review->slug)->with("success","Question set Submited")->with("review",$review->id);
    }
    public function setcomplete(Request $request,UserExamReview $userExamReview){ 
        Session::remove("question-bank-attempt");
        /**
         * @var User
         */
        $user=Auth::user();  
        $timed=$user->progress("exam-review-".$userExamReview->id."-timed",'timed');
        $tmtk=intval($user->progress("exam-review-".$userExamReview->id."-timetaken",0));
        $passed=$user->progress("exam-review-".$userExamReview->id."-passed",0);

        $m=sprintf("%02d",intval($tmtk/60));
        $s=sprintf("%02d",intval($tmtk%60));

        $attemttime="$m:$s";
        $questioncount=UserReviewQuestion::where('user_exam_review_id',$userExamReview->id)->count();
        $attemtcount=UserExamReview::where('name','question-bank')->where('exam_id',$userExamReview->exam_id)->where('user_id',$user->id)->where('category_id',$userExamReview->category_id)->where('sub_category_id',$userExamReview->sub_category_id)->where('sub_category_set',$userExamReview->sub_category_set)->count();
        $category=Category::find($userExamReview->category_id);
        return view('user.question-bank.resultpage',compact('userExamReview','category','passed','attemttime','questioncount','attemtcount','timed'));
        
    }
    public function sethistory(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        Session::remove("question-bank-attempt");
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
        // $data=[];
        // foreach(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->where('exam_id',$exam->id)->get() as  $row){
        //     $data[]=[
        //         'slug'=>$row->slug,
        //         'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
        //         'progress'=>$row->progress,
        //         'url'=>route('question-bank.preview',$row->slug),
        //     ];
        // }
        // return [
        //     'data'=>$data,
        //     'url'=>route('question-bank.set.show',[
        //         'category'=>$category->slug,
        //         'sub_category'=>$subCategory->slug,
        //         'setname'=>$setname->slug
        //     ]),
        //     'name'=>$subCategory->name
        // ];
        return DataTables::of(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->where('exam_id',$exam->id)->select('slug','created_at','progress'))
            ->addColumn('progress',function($data){
                return $data->progress."%";
            })
            ->addColumn('timed',function($data)use($user){
                return ucfirst($user->progress("exam-review-".(optional(UserExamReview::findSlug($data->slug))->id??"")."-timed"));
            })
            ->addColumn('date',function($data){
                return Carbon::parse($data->created_at)->format('Y-m-d h:i a');
            })
            ->addColumn('action',function($data){
                return '<a type="button" href="'.route('question-bank.set.complete',$data->slug).'" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action'])
            ->with('url',route('question-bank.set.show',[
                'category'=>$category->slug,
                'sub_category'=>$subCategory->slug,
                'setname'=>$setname->slug
            ]))
            ->with('name',$subCategory->name)
            ->addIndexColumn()
            ->make(true);
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
