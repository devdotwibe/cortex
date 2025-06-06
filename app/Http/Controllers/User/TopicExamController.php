<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\CalculateExamAverage;
use App\Jobs\SubmitRetryReview;
use App\Jobs\SubmitReview;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamRetryAnswer;
use App\Models\ExamRetryQuestion;
use App\Models\ExamRetryReview;
use App\Models\Question;
use App\Models\Setname;
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
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TopicExamController extends Controller
{
    use ResourceController;

    public function index(Request $request)
    {
        self::reset();
        self::$model = Category::class;
        Session::forget("topic-test-attempt");
        $exam = Exam::where("name", 'topic-test')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }
        $categorys = $this->where(function ($qry) use ($exam) {
            $qry->whereIn("id", Question::where('exam_id', $exam->id)->select('category_id'));
        })->buildResult();

        /**
         *  @var User
         */
        $user = Auth::user();
        return view("user.topic-test.index", compact('categorys', 'exam', 'user'));
    }
    public function show(Request $request, Category $category)
    {

        $exam = Exam::where("name", 'topic-test')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }

        /**
         * @var User
         */
        $user = Auth::user();
        $user->setProgress("attempt-recent-link", route('topic-test.index'));
        $questioncount = Question::where('exam_id', $exam->id)->where('category_id', $category->id)->count();
        $endtime = 0;
        $times = explode(':', $category->time_of_exam);
        if (count($times) > 0) {
            $endtime += intval(trim($times[0] ?? "0")) * 60;
            $endtime += intval(trim($times[1] ?? "0"));
        }
        foreach (Question::where('exam_id', $exam->id)->where('category_id', $category->id)->get() as $d) {
            $user->setProgress("exam-{$exam->id}-topic-{$category->id}-answer-of-{$d->slug}", null);
        }
        $user->setProgress("exam-{$exam->id}-topic-{$category->id}-progress-url", null);
        $attemtcount = UserExamReview::where('exam_id', $exam->id)->where('user_id', $user->id)->where('category_id', $category->id)->count() + 1;
        $attemt=UserExam::store([
            'name'=>$exam->name,
            'title'=>$exam->title,
            'timed'=>"timed",
            'user_id'=>$user->id,
            'exam_id'=>$exam->id,
            'progress'=>0,
            'category_id'=>$category->id,
            'time_of_exam'=>$category->time_of_exam,
        ]);
        Session::put("topic-test-attempt",$attemt->slug);
        return view("user.topic-test.summery", compact('category', 'exam', 'user', 'questioncount', 'endtime', 'attemtcount'));
    }
    public function questions(Request $request,UserExam $userExam){
        if(session("topic-test-attempt")){
            /**
             * @var User
             */
            $user = Auth::user();
            $exam = Exam::find($userExam->exam_id);
            $category =Category::find($userExam->category_id);
            $questions=Question::with('answers')->where('exam_id', $exam->id)->where('category_id', $category->id)->paginate(50);
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
            return response()->json([
                'next_page_url'=>$questions->nextPageUrl()
            ]);
        }else{
            abort(403);
        }
    }

    public function confirmshow(Request $request, Category $category)
    {
        if(session("topic-test-attempt")){
            $attemt=UserExam::findSlug(session("topic-test-attempt"));
            $exam = Exam::where("name", 'topic-test')->first();
            if (empty($exam)) {
                $exam = Exam::store([
                    "title" => "Topic Test",
                    "name" => "topic-test",
                ]);
                $exam = Exam::find($exam->id);
            }

            /**
             * @var User
             */
            $user = Auth::user();
            if ($request->ajax()) {

                if (!empty($request->question)) {
                    $question = UserExamQuestion::findSlug($request->question);
                    // return UserExamAnswer::where('user_exam_question_id', $question->id)->with('answer')->get(['slug', 'title']);
                    return UserExamAnswer::where('user_exam_question_id', $question->id)->with('answer')->select(['slug', 'title', 'answer_id'])->get();
                }
                return UserExamQuestion::where('user_exam_id', $attemt->id)->orderBy('order_no')->paginate(1, ['slug', 'title', 'description', 'duration','title_text','sub_question']);
            }
            $questioncount = UserExamQuestion::where('user_exam_id', $attemt->id)->where('exam_id', $exam->id)->count();
            $endtime = 0;
            $times = explode(':', $category->time_of_exam);
            if (count($times) > 0) {
                $endtime += intval(trim($times[0] ?? "0")) * 60;
                $endtime += intval(trim($times[1] ?? "0"));
            }
            $attemtcount = UserExamReview::where('exam_id', $exam->id)->where('user_id', $user->id)->where('category_id', $category->id)->count() + 1;
            return view("user.topic-test.show", compact('category', 'exam', 'user', 'questioncount', 'endtime', 'attemtcount'));
        }
        else{
            return  redirect()->route('topic-test.index')->with("error","Topic not initialized");
        }
    }
    public function topicsubmit(Request $request, Category $category)
    {
        if(session("topic-test-attempt")){
            $attemt=UserExam::findSlug(session("topic-test-attempt"));
            /**
             * @var User
             */
            $user = Auth::user();
            $exam = Exam::where("name", 'topic-test')->first();
            if (empty($exam)) {
                $exam = Exam::store([
                    "title" => "Topic Test",
                    "name" => "topic-test",
                ]);
                $exam = Exam::find($exam->id);
            }
            $review = UserExamReview::store([
                "ticket" => session("topic-test-attempt"),
                "title" => "Topic Test",
                "name" => "topic-test",
                "progress" => $user->progress("exam-" . $exam->id . "-topic-" . $category->id, 0),
                "user_id" => $user->id,
                "exam_id" => $exam->id,
                "category_id" => $category->id,
                "timed"=>'timed',
                "timetaken"=>$request->input("timetaken",'0'),
                "flags"=>$request->input("flags",'[]'),
                "times"=>$request->input("times",'[]'),
                "passed"=>$request->input("passed",'0'),
                "time_of_exam"=>$category->time_of_exam,
            ]);
            $passed = $request->input("passed", '0');
            $questions = $request->input("questions", '[]');
            $questioncnt = UserExamQuestion::where('user_exam_id', $attemt->id)->count();
            $user->setProgress("exam-review-" . $review->id . "-timed", 'timed');
            $user->setProgress("exam-review-" . $review->id . "-timetaken", $request->input("timetaken", '0'));
            $user->setProgress("exam-review-" . $review->id . "-flags", $request->input("flags", '[]'));
            $user->setProgress("exam-review-" . $review->id . "-times", $request->input("times", '[]'));
            $user->setProgress("exam-review-" . $review->id . "-questions", $questions);
            $user->setProgress("exam-review-" . $review->id . "-passed", $passed);
            $user->setProgress("exam-review-" . $review->id . "-time_of_exam", $category->time_of_exam);

            if ($user->progress('exam-' . $exam->id . '-topic-' . $category->id . '-complete-date', "") == "") {
                $user->setProgress('exam-' . $exam->id . '-topic-' . $category->id . '-complete-date', date('Y-m-d H:i:s'));
            }
            $user->setProgress("exam-" . $exam->id . "-topic-" . $category->id . "-complete-review", 'yes');
            dispatch(new SubmitReview($review,$attemt))->onConnection('sync');
            Session::forget("topic-test-attempt");
            if ($questioncnt > $passed) {
                $key = md5("exam-retry-" . $review->id);
                Session::put("exam-retry-" . $review->id, $key);
                Session::put("exam-retry-questions" . $review->id, json_decode($questions, true));
                Session::put($key, []);
            }

            dispatch(new CalculateExamAverage())->onConnection('database');

            if ($request->ajax()) {
                return response()->json(["success" => "Topic Test Submited", "preview" => route('topic-test.preview', $review->slug)]);
            }
            return redirect()->route('topic-test.complete', $review->slug)->with("success", "Topic Test Submited")->with("review", $review->id);
        }else{
            if ($request->ajax()) {
                return response()->json([
                    'error'=>"Topic not initialized"
                ]);
            }
            return  redirect()->route('topic-test.index')->with("error","Topic not initialized");
        }
    }

    public function topiccomplete(Request $request, UserExamReview $userExamReview)
    {
        Session::forget("topic-test-attempt");
        /**
         * @var User
         */
        $user = Auth::user();
        $user->progress("exam-review-" . $userExamReview->id . "-timed", 'timed');
        $tmtk = intval($user->progress("exam-review-" . $userExamReview->id . "-timetaken", 0));
        $passed = $user->progress("exam-review-" . $userExamReview->id . "-passed", 0);

        $m = sprintf("%02d", intval($tmtk / 60));
        $s = sprintf("%02d", intval($tmtk % 60));

        $attemttime = "$m:$s";
        $questioncount = UserReviewQuestion::where('user_exam_review_id', $userExamReview->id)->count();


        // $chartlabel = [];
        // $chartbackgroundColor = [];
        // $chartdata = [];
        // foreach (UserReviewAnswer::select('mark', DB::raw('count(mark) as marked_users'))->fromSub(function ($query) use ($userExamReview) {
        //     $query->from('user_review_answers')->where('user_exam_review_id', '<=', $userExamReview->id)->whereIn('user_exam_review_id', UserExamReview::where('name', 'topic-test')->where('user_exam_review_id', '<=', $userExamReview->id)->where('exam_id', $userExamReview->exam_id)->where('category_id', $userExamReview->category_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))
        //     ->where('iscorrect', true)->where('user_answer', true)->select(DB::raw('count(user_id) as mark'));
        // }, 'subquery')->groupBy('mark')->get() as $row) {
        //     $chartlabel[] = strval($row->mark);
        //     $chartbackgroundColor[] = $passed == $row->mark ? "#ef9b10" : '#dfdfdf';
        //     $chartdata[] = $row->marked_users;
        // }

        $chartlabel = [];
        $chartbackgroundColor = [];
        $chartdata = [];

        $latestUserReviewIds = UserExamReview::where('name', 'topic-test')
            ->where('exam_id', $userExamReview->exam_id)
            ->where('category_id', $userExamReview->category_id)
            ->where('user_exam_review_id', '<=', $userExamReview->id)
            ->groupBy('user_id')
            ->selectRaw('MAX(id) as id');

        $userReviewAnswers = UserReviewAnswer::whereIn('user_exam_review_id', $latestUserReviewIds)
            ->where('iscorrect', true)
            ->where('user_answer', true)
            ->groupBy('user_id')
            ->select('user_id', DB::raw('COUNT(*) as mark'))
            ->get()
            ->groupBy('mark')
            ->map(function ($group) {
                return count($group);
            })->sortKeys();
        foreach ($userReviewAnswers as $mark => $count) {
            $chartlabel[] = (string)$mark;
            $chartbackgroundColor[] = ($mark == $passed) ? "#ef9b10" : "#dfdfdf";
            $chartdata[] = $count;
        }


        $attemtcount = UserExamReview::where('exam_id', $userExamReview->exam_id)->where('category_id', $userExamReview->category_id)->where('user_id', $user->id)->where('id', '<', $userExamReview->id)->count() + 1;
        $categorylist = Category::all();
        return view('user.topic-test.resultpage', compact('chartdata', 'chartbackgroundColor', 'chartlabel', 'categorylist', 'userExamReview', 'passed', 'attemttime', 'questioncount', 'attemtcount'));

    }

    public function preview(Request $request, UserExamReview $userExamReview)
    {
        $category = Category::find($userExamReview->category_id);
        // Session::forget("topic-test-attempt");
        $exam = Exam::where("name", 'topic-test')->first();

        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }
        /**
         * @var User
         */
        $user = Auth::user();
        $user->setProgress("review-recent-link", route('topic-test.preview', ['user_exam_review' => $userExamReview->slug]));
        if ($request->ajax()) {
            if (!empty($request->question)) {
                $question = UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id', $question->id)->get();
            }

            $data = UserReviewQuestion::whereIn('review_type', ['mcq'])->where('user_exam_review_id', $userExamReview->id)->where('user_id', $user->id)->orderBy('order_no')->paginate(1);

            $data_questions = UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->orderBy('order_no')->get();

            $user_review = UserReviewAnswer::where('user_id',$user->id)->where('user_answer',true)->where('user_exam_review_id',$userExamReview->id)->get();

            $data_ids = [];

            foreach ($data_questions as $k => $item) {

                $user_answer = $user_review->where('user_review_question_id', $item->id)->first();

                if ($user_answer) {
                    $data_ids[$k] = $user_answer->id;
                    $index[] = $k;
                } else {
                    $data_ids[$k] = null;
                    $index[] = $k;
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

            // Add navigation links for Previous and Next
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

        $useranswer = UserReviewQuestion::leftJoin('user_review_answers', 'user_review_answers.user_review_question_id', 'user_review_questions.id')
            ->where('user_review_answers.user_answer', true)
            ->whereIn('user_review_questions.review_type', ['mcq'])
            ->where('user_review_questions.user_id', $user->id)
            ->where('user_review_questions.user_exam_review_id', $userExamReview->id)
            ->select('user_review_questions.id', 'user_review_questions.time_taken', 'user_review_answers.iscorrect','user_review_answers.id')->get();

        $examtime = 0;

        $exam_time_sec = 0;

        if ($user->progress("exam-review-" . $userExamReview->id . "-timed", '') == "timed") {

            // $times = explode(':', $user->progress("exam-review-" . $userExamReview->id . "-time_of_exam", '0:0'));

            // if (count($times) > 0) {
            //     $examtime += intval(trim($times[0] ?? "0")) * 60;
            //     $examtime += intval(trim($times[1] ?? "0"));
            // }
            // if ($examtime > 0 && count($useranswer) > 0) {
            //     $examtime = $examtime / count($useranswer);
            // }
            $times=explode(':',$category->time_of_exam);

            if(count($times)>0){
                $examtime+=intval(trim($times[0]??"0"))*60;
                $examtime+=intval(trim($times[1]??"0"));
            }
            $exam_time_sec = $examtime *60;

            if($exam_time_sec>0&& $total_questions>0 ){
                $examtime=$exam_time_sec/$total_questions;
            }
        }
        return view("user.topic-test.preview", compact('category', 'exam', 'user', 'userExamReview', 'useranswer', 'examtime'));
    }

    public function topicverify(Request $request, Category $category)
    {
        $request->validate([
            "question" => 'required',
        ]);
        /**
         * @var User
         */
        $user = Auth::user();
        $exam = Exam::where("name", 'topic-test')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }
        $question = UserExamQuestion::findSlug($request->question);
        $ans = UserExamAnswer::findSlug($request->answer);
        if (empty($ans) || $ans->exam_id != $exam->id || $ans->user_exam_question_id != $question->id || !$ans->iscorrect) {
            return response()->json(["iscorrect" => false]);
        } else {
            return response()->json(["iscorrect" => true]);
        }
    }
    public function retryhistory(Request $request,UserExamReview $userExamReview){
        Session::forget("topic-test-attempt");
        /**
         * @var User
         */
        $user = Auth::user();
        $exam = Exam::where("name", 'topic-test')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }

        return DataTables::of(ExamRetryReview::where('user_id', $user->id)->where('user_exam_review_id', $userExamReview->id)->where('exam_id', $exam->id)->select('slug', 'created_at', 'progress'))
            ->addColumn('progress', function ($data) {
                return round($data->progress,2) . "%";
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->created_at)->format('d-m-Y h:i a');
            })
            ->addColumn('action', function ($data) use($userExamReview){
                return '<a type="button" href="' . route('topic-test.retry.preview', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $data->slug]) . '" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function topichistory(Request $request, Category $category)
    {
        Session::forget("topic-test-attempt");
        /**
         * @var User
         */
        $user = Auth::user();
        $exam = Exam::where("name", 'topic-test')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }
        $userExamReviews = UserExamReview::where('user_id', $user->id)
                                            ->where('category_id', $category->id)
                                            ->where('exam_id', $exam->id)
                                            ->select('slug', 'created_at', 'progress','id','exam_id')
                                            ->orderBy('created_at','ASC');
        return DataTables::of($userExamReviews)
            ->addColumn('progress', function ($data) {
                $questions = Question::where('exam_id',$data->exam_id)->select('id');
                $question_count =  UserReviewQuestion::where('user_exam_review_id',$data->id)
                                                        ->where('exam_id',$data->exam_id)
                                                        ->whereIn('question_id',$questions)
                                                        ->count();
                if($question_count>0){
                    $questions = UserExamQuestion::where('exam_id',$data->exam_id)
                                            ->select('question_id');
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
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->created_at)->format('d-m-Y h:i a');
            })
            ->addColumn('retries',function($data){
                if(ExamRetryReview::where('user_exam_review_id', UserExamReview::findSlug($data->slug)->id)->count()>0){

                return '<a onclick="loadretry('."'".route('topic-test.retryhistory', $data->slug) ."'".')" class="btn btn-icons view_btn">
                            <img src="'.asset("assets/images/eye.svg").'" alt="">
                        </a>';
                    }else{
                        return "";
                    }
            })
            ->addColumn('action', function ($data) {
                return '<a type="button" href="' . route('topic-test.complete', $data->slug) . '" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action','retries'])
            ->with('url', route('topic-test.show', [
                'category' => $category->slug,
            ]))
            ->with('name', $category->name)
            ->addIndexColumn()
            ->make(true);
        // $data=[];
        // foreach(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('exam_id',$exam->id)->get() as  $row){
        //     $data[]=[
        //         'slug'=>$row->slug,
        //         'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
        //         'progress'=>$row->progress,
        //         'url'=>route('topic-test.preview',$row->slug),
        //     ];
        // }
        // return [
        //     'data'=>$data,
        //     'url'=>route('topic-test.show',[
        //         'category'=>$category->slug,
        //     ]),
        //     'name'=>$category->name
        // ];
    }
    public function topicretry(Request $request, UserExamReview $userExamReview)
    {
        if (session("exam-retry-" . $userExamReview->id)) {
            $category = Category::find($userExamReview->category_id);
            $exam = Exam::where("name", 'topic-test')->first();
            if (empty($exam)) {
                $exam = Exam::store([
                    "title" => "Topic Test",
                    "name" => "topic-test",
                ]);
                $exam = Exam::find($exam->id);
            }

            $userExam=UserExam::findSlug($userExamReview->ticket);

            /**
             * @var User
             */
            $user = Auth::user();
            if ($request->ajax()) {
                if (!empty($request->question)) {
                    $question = UserExamQuestion::findSlug($request->question);
                    return UserExamAnswer::where('user_exam_question_id', $question->id)->get(['slug', 'title','image']);
                }
                return UserExamQuestion::whereNotIn('slug', session("exam-retry-questions" . $userExamReview->id, []))->where('user_exam_id',$userExam->id)->orderBy('order_no')->paginate(1, ['slug', 'title', 'description', 'duration','title_text','sub_question']);
            }
            $questioncount = UserExamQuestion::whereNotIn('slug', session("exam-retry-questions" . $userExamReview->id, []))->where('user_exam_id',$userExam->id)->count();
            $endtime = 1 * $questioncount;
            $attemtcount = UserExamReview::where('exam_id', $exam->id)->where('user_id', $user->id)->where('category_id', $category->id)->count() + 1;
            return view("user.topic-test.retry", compact('category', 'exam', 'user', 'questioncount', 'endtime', 'attemtcount', 'userExamReview'));
        }
        return redirect()->route('topic-test.index')->with("error", "Retry Attempt Failed");
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
            $category = Category::find($userExamReview->category_id);
            $userExam=UserExam::findSlug($userExamReview->ticket);
            $attemt = session("exam-retry-" . $userExamReview->id);
            /**
             * @var User
             */
            $user = Auth::user();
            $exam = Exam::where("name", 'topic-test')->first();
            if (empty($exam)) {
                $exam = Exam::store([
                    "title" => "Topic Test",
                    "name" => "topic-test",
                ]);
                $exam = Exam::find($exam->id);
            }
            $answers = Session::get($attemt, []);
            $passed = $request->input("passed", '0');
            $questions = $request->input("questions", '[]');
            $questioncnt = UserExamQuestion::whereNotIn('slug', session("exam-retry-questions" . $userExamReview->id, []))->where('user_exam_id',$userExam->id)->count();
            // dd($request->input("times", '[]'));
            $review = ExamRetryReview::store([
                "title" => "Topic Test",
                "name" => "topic-test",
                "user_id" => $user->id,
                "exam_id" => $exam->id,
                "progress" =>$questioncnt>0&&$passed>0? ($passed * 100) / $questioncnt:0,
                "timetaken" => $request->input("timetaken", '0'),
                "flags" => $request->input("flags", '[]'),
                "times" => $request->input("times", '[]'),
                "passed" => $passed,
                "questions" => $questions,
                "time_of_exam" => "$questioncnt:00",
                "user_exam_review_id" => $userExamReview->id,
                "category_id" => $category->id,
            ]);

            dispatch(new SubmitRetryReview(
                        $review,
                        session("exam-retry-questions" . $userExamReview->id, []),
                        $answers))->onConnection('sync');

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
            return redirect()->route('topic-test.retry.result', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $review->slug])->with("success", "Topic Test Submited")->with("review", $review->id);
        }
        return redirect()->route('topic-test.index');
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
        $chartlabel = [];
        $chartbackgroundColor = [];
        $chartdata = [];
        foreach (UserReviewAnswer::select('mark', DB::raw('count(mark) as marked_users'))->fromSub(function ($query) use ($userExamReview) {
            $query->from('user_review_answers')->where('user_exam_review_id', '<=', $userExamReview->id)->whereIn('user_exam_review_id', UserExamReview::where('name', 'topic-test')->where('user_exam_review_id', '<=', $userExamReview->id)->where('exam_id', $userExamReview->exam_id)->where('category_id', $userExamReview->category_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))
            ->where('iscorrect', true)->where('user_answer', true)->select(DB::raw('count(user_id) as mark'));
        }, 'subquery')->groupBy('mark')->get() as $row) {
            $chartlabel[] = strval($row->mark);
            $chartbackgroundColor[] = $passed == $row->mark ? "#ef9b10" : '#dfdfdf';
            $chartdata[] = $row->marked_users;
        }
        $attemtcount = ExamRetryReview::where('user_exam_review_id', $userExamReview->id)->where('user_id', $user->id)->where('id', '<', $examRetryReview->id)->count() + 1;
        $categorylist = Category::all();

        return view('user.topic-test.retry-result', compact('passed', 'categorylist', 'questioncount', 'attemttime', 'attemtcount', 'userExamReview', 'examRetryReview','chartlabel','chartbackgroundColor','chartdata'));
    }

    public function retrypreview(Request $request, UserExamReview $userExamReview, ExamRetryReview $examRetryReview)
    {

        $category = Category::find($examRetryReview->category_id);

        $exam = Exam::where("name", 'topic-test')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $exam = Exam::find($exam->id);
        }
        /**
         * @var User
         */
        $user = Auth::user();
        $user->setProgress("review-recent-link", route('topic-test.retry.preview', ['user_exam_review' => $userExamReview->slug, 'exam_retry_review' => $examRetryReview->slug]));
        if ($request->ajax()) {
            if (!empty($request->question)) {
                $question = ExamRetryQuestion::findSlug($request->question);
                return ExamRetryAnswer::where('exam_retry_question_id', $question->id)->get();
            }

            $data = ExamRetryQuestion::whereIn('review_type', ['mcq'])->where('exam_retry_review_id', $examRetryReview->id)->where('user_id', $user->id)->orderBy('order_no')->paginate(1);

            $data_questions = ExamRetryQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('exam_retry_review_id',$examRetryReview->id)->orderBy('order_no')->get();

            $exam_review = ExamRetryAnswer::where('user_id',$user->id)->where('user_answer',true)->where('exam_retry_review_id',$examRetryReview->id)->get();

            $data_ids = [];

            foreach ($data_questions as $k => $item) {

                $exam_answer = $exam_review->where('exam_retry_question_id', $item->id)->first();

                if ($exam_answer) {
                    $data_ids[$k] = $exam_answer->id;

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

            // Add navigation links for Previous and Next
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

        $total_questions = ExamRetryQuestion::whereIn('review_type',['mcq'])->where('user_id',$user->id)->where('exam_retry_review_id',$examRetryReview->id)->count();

        $useranswer = ExamRetryQuestion::leftJoin('exam_retry_answers', 'exam_retry_answers.exam_retry_question_id', 'exam_retry_questions.id')
            ->where('exam_retry_answers.user_answer', true)
            ->whereIn('exam_retry_questions.review_type', ['mcq'])
            ->where('exam_retry_questions.user_id', $user->id)
            ->where('exam_retry_questions.exam_retry_review_id', $examRetryReview->id)
            ->select('exam_retry_questions.id', 'exam_retry_questions.time_taken', 'exam_retry_answers.iscorrect','exam_retry_answers.id')->get();

        $examtime = 0;

        $exam_time_sec = 0;

        $times = explode(':', $examRetryReview->time_of_exam ?? '0:0');

        if (count($times) > 0) {
            $examtime += intval(trim($times[0] ?? "0")) * 60;
            $examtime += intval(trim($times[1] ?? "0"));
        }

        $exam_time_sec = $examtime *60;

        if($exam_time_sec>0&& $total_questions>0 ){
            $examtime=$exam_time_sec/$total_questions;
        }

        // if ($examtime > 0 && count($useranswer) > 0) {
        //     $examtime = $examtime / count($useranswer);
        // }

        return view("user.topic-test.retry-preview", compact('category', 'exam', 'user', 'userExamReview', 'useranswer', 'examtime', 'examRetryReview'));

    }
}
