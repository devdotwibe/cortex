<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitReview;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\LearnAnswer;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExamReview;
use App\Models\UserReviewQuestion;
use App\Models\Subscription;
use App\Models\Settings;
use App\Models\UserReviewAnswer;
use App\Trait\ResourceController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

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
        /**
         *  @var User
         */
        $user=Auth::user();

        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }

        $categorys=[];
        foreach($this->whereHas('subcategories',function($qry){
            $qry->whereIn("id",Learn::select('sub_category_id'));
        })->buildResult() as $row){
            // if(UserExamReview::whereIn("id",UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$row->id)->groupBy('sub_category_id')->select(DB::raw('MAX(id)')) )->where('user_id',$user->id)->where('category_id',$row->id)->where('exam_id',$exam->id)->count()==0){
            //     $row->progress=$user->progress('exam-'.$exam->id.'-module-'.$row->id,0);
            // }else{
            //     $row->progress=UserExamReview::whereIn("id",UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$row->id)->groupBy('sub_category_id')->select(DB::raw('MAX(id)')) )->where('user_id',$user->id)->where('category_id',$row->id)->where('exam_id',$exam->id)->avg('progress');
            // }
            $row->progress=$user->progress('exam-'.$exam->id.'-module-'.$row->id,0);
            $categorys[]=$row;
        }
        return view("user.learn.index",compact('categorys','exam','user'));

    }
    public function show(Request $request,Category $category){ 
        /**
         *  @var User
         */
        $user=Auth::user();
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $lessons=[];
        foreach (SubCategory::where('category_id',$category->id)->where(function($qry){
            $qry->whereIn("id",Learn::select('sub_category_id'));
        })->get() as $row) {
            if(UserExamReview::whereIn("id",UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$row->category_id)->groupBy('sub_category_id')->select(DB::raw('MAX(id)')) )->where('user_id',$user->id)->where('category_id',$row->category_id)->where('sub_category_id',$row->id)->where('exam_id',$exam->id)->count()==0){
                $row->progress=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$row->id,0);
            }else{
                $row->progress=UserExamReview::whereIn("id",UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$row->category_id)->groupBy('sub_category_id')->select(DB::raw('MAX(id)')) )->where('user_id',$user->id)->where('category_id',$row->category_id)->where('sub_category_id',$row->id)->where('exam_id',$exam->id)->avg('progress');
            }
            $lessons[]=$row;
        }

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
        /**
         * @var User
         */
        $user=Auth::user();
        if($request->start){
            DB::table('user_progress')
                ->where('user_id',$user->id)
                ->where('name','LIKE','exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'%')
                ->where('name', '!=', 'exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date')
                ->delete();
            return redirect()->route('learn.lesson.show', ['category' => $category->slug, 'sub_category' => $subCategory->slug]);
        }
        $user->setProgress("attempt-recent-link",route('learn.lesson.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug]));
        if($request->ajax()){
            if($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',"")==""){
                $lessons=SubCategory::has('learns')->where('category_id',$category->id)->get();
                $lessencount=count($lessons);
                $totalprogres=0;
                foreach ($lessons as $lesson) {
                    $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
                }
                $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount);
            }

            if(!empty($request->question)){
                $learn=Learn::findSlug($request->question);
                return LearnAnswer::where('learn_id',$learn->id)->get(['slug','title','image']);
            }
            return Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->paginate(1,['slug','learn_type','title','short_question','video_url','note','mcq_question']);
        }
        $learncount=Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        $review=Learn::where('category_id',$category->id)
                        ->where('sub_category_id',$subCategory->id)
                        ->where(function($query) {
                            $query->whereNotNull('short_question')
                                  ->orWhereNotNull('mcq_question');
                        })->count();
        return view("user.learn.lesson",compact('category','exam','subCategory','user','learncount','review'));
    }

    public function preview(Request $request,UserExamReview $userExamReview){
        $category=Category::find($userExamReview->category_id);
        $subCategory=SubCategory::find($userExamReview->sub_category_id);

        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }
        /**
         * @var User
         */
        $user=Auth::user();
        $user->setProgress("review-recent-link",route('learn.preview',['user_exam_review'=>$userExamReview->slug]));
        if($request->ajax()){
            if(!empty($request->question)){
                $question=UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get(['slug','title','user_answer','iscorrect','description','image']);
            }
            $data = UserReviewQuestion::whereIn('review_type',['mcq','short_notes'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->paginate(1,['title','note','slug','review_type','user_answer','currect_answer','explanation']);

            $data_questions = UserReviewQuestion::whereIn('review_type',['mcq','short_notes'])->where('user_id',$user->id)->where('user_exam_review_id',$userExamReview->id)->get();

            $user_review = UserReviewAnswer::where('user_id',$user->id)->where('user_answer',true)->where('user_exam_review_id',$userExamReview->id)->get();

            $data_ids = [];

            $que_types = [];

            foreach ($data_questions as $k => $item) {
               
                $user_answer = $user_review->where('user_review_question_id', $item->id)->first();

                $user_ques_type = $user_review->where('user_review_question_id', $item->id)->where('review_type',['short_notes'])->first();
            
                if ($user_answer) {
                    $data_ids[$k] = $user_answer->id;
                    
                } else {
                    $data_ids[$k] = null;
                }

                if ($user_ques_type) {

                    $que_types[$k] = true;
                    
                } else {
                    $que_types[$k] = false;
                }
            }

            $links = collect(range(1, $data->lastPage()))->map(function ($page ,$i) use ($data,$data_ids,$que_types) {

                $value = isset($data_ids[$i]) ? $data_ids[$i] : null;

                $ques_value = isset($que_types[$i]) ? $que_types[$i] : null;

                return [
                    'url' => $data->url($page),
                    'label' => (string) $page,
                    'ans_id' => $value,
                    'ques_type' => $ques_value,
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

        $useranswer=UserReviewQuestion::leftJoin('user_review_answers','user_review_answers.user_review_question_id','user_review_questions.id')
                            ->where('user_review_answers.user_answer',true)
                            ->whereIn('user_review_questions.review_type',['mcq'])
                            ->where('user_review_questions.user_id',$user->id)
                            ->where('user_review_questions.user_exam_review_id',$userExamReview->id)
                            ->select('user_review_questions.id','user_review_questions.time_taken','user_review_answers.iscorrect','user_review_answers.id')->get();
        
        return view("user.learn.preview",compact('category','exam','subCategory','user','userExamReview','useranswer'));
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
        /**
         * @var User
         */
        $user=Auth::user();
        if($request->ajax()){ 

            return Learn::with('learnanswers')->whereIn('learn_type',['mcq','short_notes'])->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->paginate(1);
        }
        $learncount=Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        return view("user.learn.lesson",compact('category','exam','subCategory','user','learncount'));
    }

    public function lessonsubmit(Request $request,Category $category,SubCategory $subCategory){
        /**
         * @var User
         */
        $user=Auth::user();
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $review=UserExamReview::store([
            "title"=>"Learn",
            "name"=>"learn",
            "progress"=>$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id,0),
            "user_id"=>$user->id,
            "exam_id"=>$exam->id,
            "category_id"=>$category->id,
            "sub_category_id"=>$subCategory->id,
        ]);
        $lessons=SubCategory::has('learns')->where('category_id',$category->id)->get();
        $lessencount=count($lessons);
        $totalprogres=0;
        foreach ($lessons as $lesson) {
            $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
        }
        $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount);
        if($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-complete-review",'yes');
        dispatch(new SubmitReview($review));
        return  redirect()->route('learn.show',$category->slug)->with("success","Lesson Completed");
    }
    public function lessonreviewsubmit(Request $request,Category $category,SubCategory $subCategory){
        /**
         * @var User
         */
        $user=Auth::user();
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $review=UserExamReview::store([
            "title"=>"Learn",
            "name"=>"learn",
            "progress"=>$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id,0),
            "user_id"=>$user->id,
            "exam_id"=>$exam->id,
            "category_id"=>$category->id,
            "sub_category_id"=>$subCategory->id,
        ]);
        $lessons=SubCategory::has('learns')->where('category_id',$category->id)->get();
        $lessencount=count($lessons);
        $totalprogres=0;
        foreach ($lessons as $lesson) {
            $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
        }
        $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount);
        if($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-complete-review",'yes');
        (new SubmitReview($review))->handle();
        //route('learn.show',['category'=>$category->slug])
        return  redirect()->route('learn.preview',$review->slug)->with("success","Lesson Submited")->with("delay", true);
    }
    public function lessonhistory(Request $request,Category $category,SubCategory $subCategory){
        /**
         * @var User
         */
        $user=Auth::user();
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $data=[];
        foreach(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('exam_id',$exam->id)->get() as  $row){
            $questions = UserReviewQuestion::where('user_exam_review_id',$row->id)
                                            ->where(function($query) {
                                                $query->where('review_type','short_notes')
                                                    ->orWhere('review_type','mcq');
                                            })->count();
            $data[]=[
                'slug'=>$row->slug,
                'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
                'progress'=>round($row->progress,2),
                'url'=>route('learn.preview',$row->slug),
                'questions'=>$questions
            ];
        }
        $progress =  $user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-progress-url',0);
        if($progress){
            $start_url = route('learn.lesson.show',[
                                        'category'=>$category->slug,
                                        'sub_category'=>$subCategory->slug,
                                        'start' => true
                                    ]);
        }else{
            $start_url = Null;
        }
        return [
            'data'=>$data,
            'starturl'=>$start_url,
            'url'=>route('learn.lesson.show',[
                'category'=>$category->slug,
                'sub_category'=>$subCategory->slug,
            ]),
            'name'=>$subCategory->name
        ];
    }

}
