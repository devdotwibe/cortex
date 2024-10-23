<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitRetryReview;
use App\Jobs\SubmitReview;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamRetryAnswer;
use App\Models\ExamRetryQuestion;
use App\Models\ExamRetryReview;
use App\Models\Question;
use App\Models\User;
use App\Models\UserExam;
use App\Models\UserExamAnswer;
use App\Models\UserExamQuestion;
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

class MockExamController extends Controller
{
    
    use ResourceController; 
 
    public function index(Request $request){
        self::reset();
        self::$model = Exam::class; 
        Session::remove("full-mock-exam-attempt");
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
        $user->setProgress("attempt-recent-link",route('full-mock-exam.index'));
        $questioncount=Question::where('exam_id',$exam->id)->count();
        $endtime=0;
        $times=explode(':',$exam->time_of_exam);
        if(count($times)>0){
            $endtime+=intval(trim($times[0]??"0"))*60;
            $endtime+=intval(trim($times[1]??"0"));
        }
        foreach (Question::where('exam_id',$exam->id)->get() as $d) { 
            $user->setProgress("exam-{$exam->id}-answer-of-{$d->slug}",null);
        }
        $user->setProgress('exam-'.$exam->id.'-progress-url',null);
        $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->count()+1;
        $attemt=UserExam::store([ 
            'name'=>$exam->name,
            'title'=>$exam->title,
            'timed'=>"timed",
            'user_id'=>$user->id,
            'exam_id'=>$exam->id,
            'progress'=>0, 
            'time_of_exam'=>$exam->time_of_exam, 
        ]);
        Session::put("full-mock-exam-attempt",$attemt->slug);
        return view("user.full-mock-exam.summery",compact('exam','user','questioncount','endtime','attemtcount'));
    }

    public function questions(Request $request,UserExam $userExam){
        if(session("full-mock-exam-attempt")){
            /**
             * @var User
             */
            $user = Auth::user();
            $exam = Exam::find($userExam->exam_id); 
            $questions=Question::with('answers')->where('exam_id', $exam->id)->paginate(50);
            foreach ($questions as $question) {
                $userQuestion=UserExamQuestion::store([
                    'title'=>$question->title, 
                    'description'=>$question->description, 
                    'duration'=>$question->duration, 
                    'exam_id'=>$userExam->exam_id, 
                    'user_exam_id'=>$userExam->id, 
                    'category_id'=>$question->category_id, 
                    'sub_category_id'=>$question->sub_category_id, 
                    'sub_category_set'=>$question->sub_category_set,  
                    'explanation'=>$question->explanation,  
                    'title_text'=>$question->title_text, 
                    'sub_question'=>$question->sub_question, 
                    'question_id'=>$question->id,
                    'user_id'=>$user->id
                ]);
                foreach($question->answers as $answer){
                    UserExamAnswer::store([
                        'title'=>$answer->title, 
                        'description'=>$answer->description,  
                        'user_exam_question_id'=>$userQuestion->id, 
                        'iscorrect'=>$answer->iscorrect, 
                        'question_id'=>$question->id,
                        'answer_id'=>$answer->id,
                        'user_id'=>$user->id,
                        'exam_id'=>$userExam->exam_id, 
                        'user_exam_id'=>$userExam->id, 
                    ]);
                }
            }
            return response()->json([
                'next_page_url'=>$questions->nextPageUrl()
            ]);
        }else{
            abort(403);
        }        
    }

    public function confirmshow(Request $request,Exam $exam){ 
        if(session("full-mock-exam-attempt")){
            $attemt=UserExam::findSlug(session("full-mock-exam-attempt"));
            /**
             * @var User
             */
            $user=Auth::user(); 
            if($request->ajax()){ 
                if(!empty($request->question)){
                    $question=UserExamQuestion::findSlug($request->question);
                    return UserExamAnswer::where('user_exam_question_id',$question->id)->get(['slug','title']);
                }
                return UserExamQuestion::where('user_exam_id',$attemt->id)->paginate(1,['slug','title','description','duration','title_text','sub_question']);
            }
            $questioncount=UserExamQuestion::where('user_exam_id',$attemt->id)->count();
            $endtime=0;
            $times=explode(':',$exam->time_of_exam);
            if(count($times)>0){
                $endtime+=intval(trim($times[0]??"0"))*60;
                $endtime+=intval(trim($times[1]??"0"));
            } 
            $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->count()+1;
            
            return view("user.full-mock-exam.show",compact('exam','user','questioncount','endtime','attemtcount'));
        }
        else{
            return  redirect()->route('full-mock-exam.index')->with("error","Exam not initialized");
        }
    } 

    public function examverify(Request $request,Exam $exam){
        $request->validate([
            "question"=>'required'
        ]); 
        /**
        * @var User
        */
        $user=Auth::user();   
        $question=UserExamQuestion::findSlug($request->question);
        $ans=UserExamAnswer::findSlug($request->answer);
        if(empty($ans)||$ans->exam_id!=$exam->id||$ans->user_exam_question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false]);
        }else{
            return response()->json(["iscorrect"=>true]);
        } 
    }

    public function examsubmit(Request $request,Exam $exam){
        if(session("full-mock-exam-attempt")){
            $attemt=UserExam::findSlug(session("full-mock-exam-attempt"));
            /**
             * @var User
             */
            $user=Auth::user(); 
            $review=UserExamReview::store([
                "ticket" => session("full-mock-exam-attempt"),
                "title"=>$exam->title,
                "name"=>$exam->name,
                "progress"=>$user->progress("exam-".$exam->id,0),
                "user_id"=>$user->id,
                "exam_id"=>$exam->id,  
                "timed"=>'timed',
                "timetaken"=>$request->input("timetaken",'0'),
                "flags"=>$request->input("flags",'[]'),
                "times"=>$request->input("times",'[]'),
                "passed"=>$request->input("passed",'0'),
                "time_of_exam"=>$exam->time_of_exam, 
            ]); 
            $passed = $request->input("passed", '0');
            $questions = $request->input("questions", '[]');
            $questioncnt = UserExamQuestion::where('user_exam_id', $attemt->id)->count();
            $user->setProgress("exam-review-".$review->id."-timed",'timed');
            $user->setProgress("exam-review-".$review->id."-timetaken",$request->input("timetaken",'0'));
            $user->setProgress("exam-review-".$review->id."-flags",$request->input("flags",'[]'));
            $user->setProgress("exam-review-".$review->id."-times",$request->input("times",'[]'));
            $user->setProgress("exam-review-".$review->id."-questions", $questions);
            $user->setProgress("exam-review-".$review->id."-passed",$passed);
            $user->setProgress("exam-review-".$review->id."-time_of_exam",$exam->time_of_exam);
            if($user->progress('exam-'.$exam->id.'-complete-date',"")==""){
                $user->setProgress('exam-'.$exam->id.'-complete-date',date('Y-m-d H:i:s'));
            }
            $user->setProgress("exam-".$exam->id."-complete-review",'yes');
            dispatch(new SubmitReview($review,$attemt)); 
            Session::remove("full-mock-exam-attempt");
            if ($questioncnt > $passed) {
                $key = md5("exam-retry-" . $review->id);
                Session::put("exam-retry-" . $review->id, $key);
                Session::put("exam-retry-questions" . $review->id, json_decode($questions, true));
                Session::put($key, []);
            }
            if($request->ajax()){
                return  response()->json(["success"=>$exam->title." Submited","preview"=>route('full-mock-exam.preview',$review->slug)]);    
            }
            return  redirect()->route('full-mock-exam.complete',$review->slug)->with("success",$exam->title." Submited")->with("review",$review->id);
        }
    }


    public function examcomplete(Request $request,UserExamReview $userExamReview){ 
        Session::remove("full-mock-exam-attempt");
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
        $chartlabel=[];
        $chartbackgroundColor=[];
        $chartdata=[];
        $userReviewAnswers = UserReviewAnswer::select('mark',DB::raw('count(mark) as marked_users'))
                                                ->fromSub(function ($query)use($userExamReview){
                                                    $query->from('user_review_answers')
                                                            ->where('user_exam_review_id','<=',$userExamReview->id)
                                                            ->whereIn('user_exam_review_id',UserExamReview::where('name','full-mock-exam')
                                                                                                            ->where('user_exam_review_id','<=',$userExamReview->id)
                                                                                                            ->where('exam_id',$userExamReview->exam_id)
                                                                                                            ->groupBy('user_id')
                                                                                                            ->select(DB::raw('MAX(id)')))
                                                            ->where('iscorrect',true)
                                                            ->where('user_answer',true)
                                                            ->select(DB::raw('count(user_id) as mark'));
                                                }, 'subquery')
                                                ->groupBy('mark')
                                                ->get();
        foreach ($userReviewAnswers as  $row) { 
            $chartlabel[]=strval($row->mark);
            $chartbackgroundColor[]=$passed==$row->mark? "#ef9b10" : '#dfdfdf';
            $chartdata[]=$row->marked_users;
        } 
        $attemtcount=UserExamReview::where('exam_id',$userExamReview->exam_id)
                                    ->where('user_id',$user->id)
                                    ->count();
        $category=Category::all();
        return view('user.full-mock-exam.resultpage',compact('chartdata','chartbackgroundColor','chartlabel','category','userExamReview','passed','attemttime','questioncount','attemtcount'));
        
    }
    public function preview(Request $request,UserExamReview $userExamReview){
        $exam=Exam::find( $userExamReview->exam_id );
        Session::remove("full-mock-exam-attempt");
        /**
         * @var User
         */
        $user=Auth::user();
        $user->setProgress("review-recent-link",route('full-mock-exam.preview',['user_exam_review'=>$userExamReview->slug]));
        if($request->ajax()){
            if(!empty($request->question)){
                $question=UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get();
            }
            return UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_exam_review_id',$userExamReview->id)->where('user_id',$user->id)->paginate(1);
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
        return view("user.full-mock-exam.preview",compact('exam','user','userExamReview','useranswer','examtime'));
    }
    public function examhistory(Request $request,Exam $exam){
        Session::remove("full-mock-exam-attempt");
        /**
         * @var User
         */
        $user=Auth::user();
        // $data=[];
        // foreach(UserExamReview::where('user_id',$user->id)->where('exam_id',$exam->id)->get() as  $row){
        //     $data[]=[
        //         'slug'=>$row->slug,
        //         'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
        //         'progress'=>$row->progress,
        //         'url'=>route('full-mock-exam.preview',$row->slug),
        //     ];
        // }
        // return [
        //     'data'=>$data,
        //     'url'=>route('full-mock-exam.show',$exam->slug),
        //     'name'=>$exam->name
        // ];
        return DataTables::of(UserExamReview::where('user_id',$user->id)->where('exam_id',$exam->id)->select('slug','created_at','progress'))
            ->addColumn('progress',function($data){
                // $numberformat=number_format($data->progress,2);
                // return $numberformat."%";
                if ($data->progress == 100) {
                    return "100%"; // Return without decimals
                } else {
                    $numberformat = number_format($data->progress, 2);
                    return $numberformat . "%";
                }
            })
            ->addColumn('date',function($data){
                return Carbon::parse($data->created_at)->format('Y-m-d h:i a');
            })
            ->addColumn('action',function($data){
                return '<a type="button" href="'.route('full-mock-exam.complete',$data->slug).'" class="btn btn-warning btn-sm">Review</a>';
            })
            ->addColumn('retries',function($data){
                if(ExamRetryReview::where('user_exam_review_id', UserExamReview::findSlug($data->slug)->id)->count()>0){
                    
                    return '<a onclick="loadretry('."'".route('full-mock-exam.retryhistory', $data->slug) ."'".')" class="btn btn-icons view_btn">
                        <img src="'.asset("assets/images/eye.svg").'" alt="">
                    </a>';
                }else{
                    return "";
                }
            })
            ->rawColumns(['action','retries'])
            ->with('url',route('full-mock-exam.show',$exam->slug))
            ->with('name',$exam->title)
            ->addIndexColumn()
            ->make(true);
    }

    public function retryhistory(Request $request,UserExamReview $userExamReview){
        Session::remove("full-mock-exam-attempt");

        /**
         * @var User
         */
        $user = Auth::user();
        $exam=Exam::find( $userExamReview->exam_id );
        return DataTables::of(ExamRetryReview::where('user_id', $user->id)->where('user_exam_review_id', $userExamReview->id)->where('exam_id', $exam->id)->select('slug', 'created_at', 'progress'))
            ->addColumn('progress', function ($data) {
                return round($data->progress,2) . "%";
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d h:i a');
            }) 
            ->addColumn('action', function ($data) use($userExamReview){
                return '<a type="button" href="' . route('full-mock-exam.retry.preview', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $data->slug]) . '" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action'])  
            ->addIndexColumn()
            ->make(true);
    }
    
    public function mocexamretry(Request $request, UserExamReview $userExamReview)
    {
        if (session("exam-retry-" . $userExamReview->id)) { 
            $exam=Exam::find( $userExamReview->exam_id );
            $userExam=UserExam::findSlug($userExamReview->ticket);
            /**
             * @var User
             */
            $user = Auth::user();
            if ($request->ajax()) {
                if (!empty($request->question)) {
                    $question = UserExamQuestion::findSlug($request->question);
                    return UserExamAnswer::where('user_exam_question_id', $question->id)->get(['slug', 'title']);
                }
                return UserExamQuestion::whereNotIn('slug', session("exam-retry-questions" . $userExamReview->id, []))->where('user_exam_id', $userExam->id)->paginate(1, ['slug', 'title', 'description', 'duration']);
            }
            $questioncount = UserExamQuestion::whereNotIn('slug', session("exam-retry-questions" . $userExamReview->id, []))->where('user_exam_id', $userExam->id)->count();
            $endtime = 1 * $questioncount;
            $attemtcount = UserExamReview::where('exam_id', $exam->id)->where('user_id', $user->id)->count() + 1;
            return view("user.full-mock-exam.retry", compact(  'exam', 'user', 'questioncount', 'endtime', 'attemtcount', 'userExamReview'));
        }
        return redirect()->route('full-mock-exam.index')->with("error", "Retry Attempt Failed");
    }
    public function updateprogress(Request $request, $attemt)
    {
        $request->validate([
            "name" => ['required'],
        ]);
        /**
         *  @var User
         */
        $user = Auth::user();
        $answers = Session::get($attemt, []);
        $answers[$request->input('name', '')] = $request->input('value', '');
        Session::put($attemt, $answers);
        return [
            "name" => $request->input('name', ''),
            "value" => $request->input('value', ''),
        ];
    }
    public function getprogress(Request $request, $attemt)
    {
        $request->validate([
            "name" => ['required'],
        ]);
        /**
         *  @var User
         */
        $user = Auth::user();
        return [
            "name" => $request->input('name'),
            "value" => session($attemt, [])[$request->input('name', '')] ?? ""
        ];
    }

    public function retrysubmit(Request $request, UserExamReview $userExamReview)
    {
        if (session("exam-retry-" . $userExamReview->id)) { 
            $attemt = session("exam-retry-" . $userExamReview->id);
            $userExam=UserExam::findSlug($userExamReview->ticket);
            /**
             * @var User
             */
            $user = Auth::user();
            $exam=Exam::find( $userExamReview->exam_id ); 
            $answers = Session::get($attemt, []);
            $passed = $request->input("passed", '0');
            $questions = $request->input("questions", '[]');
            $questioncnt = UserExamQuestion::whereNotIn('slug', session("exam-retry-questions" . $userExamReview->id, []))
                                            ->where('user_exam_id', $userExam->id)
                                            ->count();
            $review = ExamRetryReview::store([
                "title" => $exam->title,
                "name" => $exam->name,
                "user_id" => $user->id,
                "exam_id" => $exam->id,
                "progress" => $questioncnt>0&&$passed>0?(($passed * 100) / $questioncnt):0,
                "timetaken" => $request->input("timetaken", '0'),
                "flags" => $request->input("flags", '[]'),
                "times" => $request->input("times", '[]'),
                "passed" => $passed,
                "questions" => $questions,
                "time_of_exam" => "$questioncnt:00",
                "user_exam_review_id" => $userExamReview->id, 
            ]);
            
            dispatch(new SubmitRetryReview($review, session("exam-retry-questions" . $userExamReview->id, []), $answers));

            
            if ($questioncnt > $passed) {
                $key = md5("exam-retry-repeat-" . $review->id);
                Session::put("exam-retry-" . $userExamReview->id, $key);
                Session::put("exam-retry-questions" . $userExamReview->id, array_merge(session("exam-retry-questions" . $userExamReview->id, []), json_decode($questions, true)));
                Session::put($key, []);
            } else {
                Session::put($attemt, null);
                Session::put("exam-retry-" . $userExamReview->id, null);
                Session::put("exam-retry-questions" . $userExamReview->id, []);
            }
            return redirect()->route('full-mock-exam.retry.result', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $review->slug])->with("success", "Topic Test Submited")->with("review", $review->id);
        }
        return redirect()->route('full-mock-exam.index');
    }
    public function retryresult(Request $request, UserExamReview $userExamReview, ExamRetryReview $examRetryReview)
    {
        /**
         * @var User
         */
        $user = Auth::user();
        $tmtk = intval($examRetryReview->timetaken ?? 0);
        $passed = $examRetryReview->passed ?? 0;

        $m = sprintf("%02d", intval($tmtk / 60));
        $s = sprintf("%02d", intval($tmtk % 60));

        $attemttime = "$m:$s";
        $questioncount = ExamRetryQuestion::where('exam_retry_review_id', $examRetryReview->id)->count();
        $attemtcount = ExamRetryReview::where('user_exam_review_id', $userExamReview->id)->where('user_id', $user->id)->where('id', '<', $examRetryReview->id)->count() + 1;
        $categorylist = Category::all();

        return view('user.full-mock-exam.retry-result', compact('passed', 'categorylist', 'questioncount', 'attemttime', 'attemtcount', 'userExamReview', 'examRetryReview'));
    }

    public function retrypreview(Request $request, UserExamReview $userExamReview, ExamRetryReview $examRetryReview)
    {
   
        $exam=Exam::find( $userExamReview->exam_id );  
        /**
         * @var User
         */
        $user = Auth::user();
        $user->setProgress("review-recent-link", route('full-mock-exam.retry.preview', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $examRetryReview->slug]));
        if ($request->ajax()) {
            if (!empty($request->question)) {
                $question = ExamRetryQuestion::findSlug($request->question);
                return ExamRetryAnswer::where('exam_retry_question_id', $question->id)->get();
            }
            return ExamRetryQuestion::whereIn('review_type', ['mcq'])->where('exam_retry_review_id', $examRetryReview->id)->where('user_id', $user->id)->paginate(1);
        }
        $useranswer = ExamRetryQuestion::leftJoin('exam_retry_answers', 'exam_retry_answers.exam_retry_question_id', 'exam_retry_questions.id')
            ->where('exam_retry_answers.user_answer', true)
            ->whereIn('exam_retry_questions.review_type', ['mcq'])
            ->where('exam_retry_questions.user_id', $user->id)
            ->where('exam_retry_questions.exam_retry_review_id', $examRetryReview->id)
            ->select('exam_retry_questions.id', 'exam_retry_questions.time_taken', 'exam_retry_answers.iscorrect')->get();
        $examtime = 0;

        $times = explode(':', $examRetryReview->time_of_exam ?? '0:0');
        if (count($times) > 0) {
            $examtime += intval(trim($times[0] ?? "0")) * 60;
            $examtime += intval(trim($times[1] ?? "0"));
        }
        if ($examtime > 0 && count($useranswer) > 0) {
            $examtime = $examtime / count($useranswer);
        }
        return view("user.full-mock-exam.retry-preview", compact(  'exam', 'user', 'userExamReview', 'useranswer', 'examtime', 'examRetryReview'));

    }
}
