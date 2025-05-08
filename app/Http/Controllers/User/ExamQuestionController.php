<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\CalculateExamAverage;
use App\Jobs\SubmitReview;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
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

class ExamQuestionController extends Controller
{
    use ResourceController;

    public function index(Request $request){
        self::reset();
        self::$model = Category::class;

        Session::forget("question-bank-attempt");
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
            $qry->whereHas('setname', function ($setnameQuery) {
                $setnameQuery->where(function ($query) {
                    $query->where('time_of_exam', '!=', '00:00')
                          ->where('time_of_exam', '!=', '00 : 00');
                });
            });
        })->buildResult();

        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.question-bank.index",compact('categorys','exam','user'));
    }

    public function show(Request $request,Category $category){

        Session::forget("question-bank-attempt");
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
            $qry->where('time_of_exam', '!=', '00:00')
            ->where('time_of_exam', '!=', '00 : 00');
        })
        ->orderBy('created_at', 'asc')->get();

        /**
         *  @var User
         */
        $user=Auth::user();


        return view("user.question-bank.show",compact('category','exam','lessons','user'));
    }
    public function setattempt(Request $request,Category $category,SubCategory $subCategory,Setname $setname){

            $exam=Exam::where("name",'question-bank')->first();
            if(empty($exam)){
                $exam=Exam::store([
                    "title"=>"Question Bank",
                    "name"=>"question-bank",
                ]);
                $exam=Exam::find( $exam->id );
            }
            $user = Auth::user();
            $user->setProgress("exam-{$exam->id}-topic-{$category->id}-lesson-{$subCategory->id}-set-{$setname->id}-progress-url", null);

            $userExam = UserExam::store([
                'name'=>$exam->name,
                'title'=>$exam->title,
                'timed'=>$request->timed,
                'user_id'=>$user->id,
                'exam_id'=>$exam->id,
                'progress'=>0,
                'category_id'=>$category->id,
                'sub_category_id'=>$subCategory->id,
                'sub_category_set'=>$setname->id,
                'time_of_exam'=>$setname->time_of_exam,
            ]);
            Session::put("question-bank-attempt",$userExam->slug);

            $questions = Question::with('answers')
                                ->where('exam_id',$exam->id)
                                ->where('category_id',$category->id)
                                ->where('sub_category_id',$subCategory->id)
                                ->where('sub_category_set',$setname->id)
                                ->get();
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
                    'user_id'=>$user->id,
                    'order_no'=>$question->order_no
                ]);
                foreach($question->answers as $answer){
                    UserExamAnswer::store([
                        'title'=>$answer->title,
                        'description'=>$answer->description,
                        'image'=>$answer->image,
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

        return redirect()->route('question-bank.set.show',
                                    ['category'=>$category->slug,
                                                'sub_category'=>$subCategory->slug,
                                                'setname'=>$setname->slug,
                                                'user_exam'=>$userExam->slug]);
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

            // if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',"")==""){
            //     $lessons=SubCategory::where('category_id',$category->id)->get();
            //     $lessencount=count($lessons);
            //     $totalprogres=0;

            //     $totalSetCount = 0;

            //     foreach ($lessons as $lesson) {
            //         $sets=Setname::where('category_id',$category->id)->where('sub_category_id',$lesson->id)->get();
            //         $setcount=count($sets);
            //         $catprogres=0;
            //         foreach ($sets as $sitm) {
            //             $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);
            //         }
            //         $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);
            //         $totalprogres+=$catprogres;

            //         $totalSetCount += $setcount;
            //     }
            //     $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id,$totalprogres/$totalSetCount);
            // // }

            $user->setProgress("attempt-recent-link",route('question-bank.show',['category'=>$category->slug]));
            $userExam = UserExam ::findSlug($request->user_exam);
            if($request->ajax()){
                $userExam = UserExam ::findSlug($request->user_exam);
                if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',"")==""){
                    $lessons=SubCategory::where('category_id',$category->id)->get();
                    $lessencount=count($lessons);
                    $totalprogres=0;

                    $totalSetCount = 0;

                    $totalAttended = 0;

                    foreach ($lessons as $lesson) {
                        $sets=Setname::where('category_id',$category->id)->where('sub_category_id',$lesson->id)->get();
                        $setcount=count($sets);
                        // $catprogres=0;
                        $attendedCount = 0;
                        foreach ($sets as $sitm) {

                            $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);

                            if ($catprogres > 0) {

                                $attendedCount += 1;
                            }
                        }
                        $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);

                        $totalAttended += $attendedCount;

                        $totalSetCount += $setcount;
                    }

                    $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id,$totalAttended/$totalSetCount);
                }
                if(!empty($request->question)){
                    $question=UserExamQuestion::findSlug($request->question);
                    // return UserExamAnswer::where('user_exam_question_id',$question->id)->get(['slug','title']);
                    return UserExamAnswer::where('user_exam_question_id', $question->id)->with('answer')->select(['slug', 'title', 'answer_id','image'])->get();
                }
                return UserExamQuestion::where('user_exam_id',$userExam->id)
                                ->where('category_id',$category->id)
                                ->where('sub_category_id',$subCategory->id)
                                ->where('sub_category_set',$setname->id)
                                ->orderBy('order_no')
                                ->paginate(1,['slug','title','description','duration','title_text','sub_question']);
            }
            $questioncount=UserExamQuestion::where('user_exam_id',$userExam->id)
                                    ->where('category_id',$category->id)
                                    ->where('sub_category_id',$subCategory->id)
                                    ->where('sub_category_set',$setname->id)
                                    ->count();
            $endtime=0;
            $times=explode(':',$setname->time_of_exam);
            if(count($times)>0){
                $endtime+=intval(trim($times[0]??"0"))*60;
                $endtime+=intval(trim($times[1]??"0"));
            }
            foreach (Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->get() as $d) {
                $user->setProgress("exam-{$exam->id}-topic-{$category->id}-lesson-{$subCategory->id}-set-{$setname->id}-answer-of-{$d->slug}",null);
            }

            $slug = $request->user_exam;
            $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->count()+1;
            return view("user.question-bank.set",compact('category','exam','subCategory','user','setname','questioncount','endtime','attemtcount','slug','userExam'));
        }
        else{
            return  redirect()->route('question-bank.index')->with("error","Question set not initialized");
        }
    }
    public function preview(Request $request,UserExamReview $userExamReview){

        $category=Category::find($userExamReview->category_id);
        $subCategory=SubCategory::find($userExamReview->sub_category_id);
        $setname=Setname::find($userExamReview->sub_category_set);
        // Session::forget("question-bank-attempt");

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



            $data = UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->orderBy('order_no')->paginate(1);

            $data_questions = UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->orderBy('order_no')->get();

            $user_review = UserReviewAnswer::where('user_id',$user->id)->where('user_answer',true)->where('user_exam_review_id',$userExamReview->id)->get();

            $data_ids = [];

            foreach ($data_questions as $k => $item) {

                $user_answer = $user_review->where('user_review_question_id', $item->id)->first();

                if ($user_answer) {
                    $data_ids[$k] = $user_answer->id;

                } else {
                    $data_ids[$k] = null;
                }
            }

            $links = collect(range(1, $data->lastPage()))->map(function ($page ,$i) use ($data,$data_ids) {

                $value = isset($data_ids[$i]) ? $data_ids[$i] : null;

                return [
                    'url' => $data->url($page),
                    'label' => (string) $page,
                    'ans_id' => $value,
                    'active' => $page === $data->currentPage(),
                ];
            });

            $paginationLinks = collect([
                [
                    'url' => $data->previousPageUrl(),
                    'label' => '&laquo; Previous',
                    'active' => false,
                ],
            ])
            ->merge($links)
            ->merge([
                [
                    'url' => $data->nextPageUrl(),
                    'label' => 'Next &raquo;',
                    'active' => false,
                ],
            ]);

            // Build the response structure
            return response()->json([
                'current_page' => $data->currentPage(),
                'data' => $data->items(),
                'first_page_url' => $data->url(1),
                'from' => $data->firstItem(),
                'last_page' => $data->lastPage(),
                'last_page_url' => $data->url($data->lastPage()),
                'links' => $paginationLinks,
                'next_page_url' => $data->nextPageUrl(),
                'path' => $data->path(),
                'per_page' => $data->perPage(),
                'prev_page_url' => $data->previousPageUrl(),
                'to' => $data->lastItem(),
                'total' => $data->total(),
            ]);
        }

        $total_questions = UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->count();

        $useranswer=UserReviewQuestion::leftJoin('user_review_answers','user_review_answers.user_review_question_id','user_review_questions.id')
                        ->where('user_review_answers.user_answer',true)
                        ->whereIn('user_review_questions.review_type',['mcq'])
                        ->where('user_review_questions.user_id',$user->id)
                        ->where('user_review_questions.user_exam_review_id',$userExamReview->id)
                        ->select('user_review_questions.id','user_review_questions.time_taken','user_review_answers.iscorrect','user_review_answers.id')->get();

        $examtime=0;

        $exam_time_sec = 0;

        if($user->progress("exam-review-".$userExamReview->id."-timed",'')=="timed"){

            // $times=explode(':',$user->progress("exam-review-".$userExamReview->id."-time_of_exam",'0:0'));
            // if(count($times)>0){
            //     $examtime+=intval(trim($times[0]??"0"))*60;
            //     $examtime+=intval(trim($times[1]??"0"));
            // }

            $times=explode(':',$setname->time_of_exam);

            if(count($times)>0){
                $examtime+=intval(trim($times[0]??"0"))*60;
                $examtime+=intval(trim($times[1]??"0"));
            }

            $exam_time_sec = $examtime *60;
            // $examtime= $exam->time_of_exam;

            if($exam_time_sec>0&& $total_questions>0 ){
                $examtime=$exam_time_sec/$total_questions;
            }
        }
        return view("user.question-bank.preview",compact('category','exam','subCategory','setname','user','userExamReview','useranswer','examtime'));
    }

    public function setreview(Request $request,Category $category,SubCategory $subCategory,Setname $setname){
        Session::forget("question-bank-attempt");
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
                $lessons=SubCategory::where('category_id',$category->id)
                                    ->whereHas('setname',function($qry)use($exam){
                                        $qry->whereHas("questions",function($qry)use($exam){
                                            $qry->where('exam_id',$exam->id);
                                        });
                                        $qry->where('time_of_exam', '!=', '00:00')
                                        ->where('time_of_exam', '!=', '00 : 00');
                                    })
                                    ->get();
                $lessencount=count($lessons);
                $totalprogres=0;
                foreach ($lessons as $lesson) {
                    $sets=Setname::where('category_id',$category->id)
                                    ->where('sub_category_id',$lesson->id)
                                    ->whereHas("questions",function($qry)use($exam){
                                        $qry->where('exam_id',$exam->id);
                                    })
                                    ->where('time_of_exam', '!=', '00:00')
                                    ->where('time_of_exam', '!=', '00 : 00')
                                    ->get();
                    $setcount=count($sets);
                    $catprogres=0;
                    foreach ($sets as $sitm) {
                        $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);
                    }
                    $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);
                    $totalprogres+=$catprogres/$setcount;
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
        $userExam=UserExam::findSlug(session("question-bank-attempt"));
        $exam=Exam::where("name",'question-bank')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $review=UserExamReview::store([
            "ticket" => session("question-bank-attempt"),
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
        $lessons=SubCategory::where('category_id',$category->id)
                            ->whereHas('setname',function($qry)use($exam){
                                $qry->whereHas("questions",function($qry)use($exam){
                                    $qry->where('exam_id',$exam->id);
                                });
                                $qry->where('time_of_exam', '!=', '00:00')
                                ->where('time_of_exam', '!=', '00 : 00');
                            })->get();
        $lessencount=count($lessons);
        $totalprogres=0;
        foreach ($lessons as $lesson) {
            $sets=Setname::where('category_id',$category->id)
                        ->where('sub_category_id',$lesson->id)
                        ->whereHas("questions",function($qry)use($exam){
                            $qry->where('exam_id',$exam->id);
                        })
                        ->where('time_of_exam', '!=', '00:00')
                        ->where('time_of_exam', '!=', '00 : 00')
                        ->get();
            $setcount=count($sets);
            $catprogres=0;
            foreach ($sets as $sitm) {
                $catprogres+=$user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id.'-set-'.$sitm->id,0);
            }
            $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$lesson->id,$catprogres>0?($catprogres/$setcount):0);
            $totalprogres+=$catprogres/$setcount;
        }
        $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id,$totalprogres/$lessencount);
        if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-lesson-'.$subCategory->id.'-set-'.$setname->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id.'-set-'.$setname->id."-complete-review",'yes');
        dispatch(new SubmitReview($review,$userExam))->onConnection('sync');
        Session::forget("question-bank-attempt");

        dispatch(new CalculateExamAverage())->onConnection('database');

        if($request->ajax()){
            return  response()->json(["success"=>"Question set Submited","preview"=>route('question-bank.preview',$review->slug)]);
        }
        return  redirect()->route('question-bank.set.complete',$review->slug)->with("success","Question set Submited")->with("review",$review->id);
    }
    public function setcomplete(Request $request,UserExamReview $userExamReview){
        Session::forget("question-bank-attempt");
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
        Session::forget("question-bank-attempt");
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
        $userExamReviews = UserExamReview::where('user_id',$user->id)
                                            ->where('category_id',$category->id)
                                            ->where('sub_category_id',$subCategory->id)
                                            ->where('sub_category_set',$setname->id)
                                            ->where('exam_id',$exam->id)
                                            ->select('slug','created_at','progress','id','exam_id','ticket')
                                            ->orderBy('created_at','ASC');
        return DataTables::of($userExamReviews)
            ->addColumn('progress',function($data){
                if($data->ticket){
                    $userExam = UserExam::findSlug($data->ticket);
                    $questions = UserExamQuestion::where('user_exam_id',$userExam->id)->select('question_id');
                    $question_count =  UserReviewQuestion::where('user_exam_review_id',$data->id)
                                                            ->where('exam_id',$data->exam_id)
                                                            ->whereIn('question_id',$questions)
                                                            ->count();
                                                            // dd($userExam->id);

                    if($question_count>0){
                        $right_answers =  UserReviewAnswer::where('user_exam_review_id',$data->id)
                                                    ->where('exam_id',$data->exam_id)
                                                    ->whereIn('question_id',$questions)
                                                    ->where('iscorrect',true)
                                                    ->where('user_answer',true)
                                                    ->count();
                        $progress = $right_answers * 100 / $question_count;
                        $data->progress = (floor($progress) == $progress) ? number_format($progress, 0) : number_format($progress, 2);
                        return $data->progress."%";
                    }
                    return 0;
                }

                return 0;
            })
            ->addColumn('timed',function($data)use($user){
                return ucfirst($user->progress("exam-review-".(optional(UserExamReview::findSlug($data->slug))->id??"")."-timed"));
            })
            ->addColumn('date',function($data){
                return Carbon::parse($data->created_at)->format('d-m-Y h:i a');
            })
            ->addColumn('action',function($data){
                return '<a type="button" href="'.route('question-bank.set.complete',$data->slug).'" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action'])
            ->with('url',route('question-bank.set.attempt',[
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
       $question = UserExamQuestion::findSlug($request->question);
       $ans = UserExamAnswer::findSlug($request->answer);
       if (empty($ans) || $ans->exam_id != $exam->id || $ans->user_exam_question_id != $question->id || !$ans->iscorrect) {
           return response()->json(["iscorrect" => false]);
       } else {
           return response()->json(["iscorrect" => true]);
       }
    }
}
