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
            if(UserExamReview::whereIn("id",UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$row->id)->groupBy('sub_category_id')->select(DB::raw('MAX(id)')) )->where('user_id',$user->id)->where('category_id',$row->id)->where('exam_id',$exam->id)->count()==0){
                $row->progress=$user->progress('exam-'.$exam->id.'-module-'.$row->id,0);
            }else{
                $row->progress=UserExamReview::whereIn("id",UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$row->id)->groupBy('sub_category_id')->select(DB::raw('MAX(id)')) )->where('user_id',$user->id)->where('category_id',$row->id)->where('exam_id',$exam->id)->avg('progress');
            }
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

        $user->setProgress("attempt-recent-link",route('learn.lesson.show',['category'=>$category->slug,'sub_category'=>$subCategory->slug]));
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
                $learn=Learn::findSlug($request->question);
                return LearnAnswer::where('learn_id',$learn->id)->get(['slug','title']);
            }
            return Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->paginate(1,['slug','learn_type','title','short_question','video_url','note','mcq_question']);
        }
        $learncount=Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->count();
        return view("user.learn.lesson",compact('category','exam','subCategory','user','learncount'));
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
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get(['slug','title','user_answer','iscorrect','description']);
            }
            return UserReviewQuestion::whereIn('review_type',['mcq','short_notes'])->where('user_exam_review_id',$userExamReview->id)->paginate(1,['title','note','slug','review_type','user_answer','currect_answer','explanation']);
        }

        $useranswer=UserReviewQuestion::leftJoin('user_review_answers','user_review_answers.user_review_question_id','user_review_questions.id')
        ->where('user_review_answers.user_answer',true)
        ->whereIn('user_review_questions.review_type',['mcq'])
        ->where('user_review_questions.user_id',$user->id)
        ->where('user_review_questions.user_exam_review_id',$userExamReview->id)
        ->select('user_review_questions.id','user_review_questions.time_taken','user_review_answers.iscorrect')->get();
        
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
        $lessons=SubCategory::where('category_id',$category->id)->get();
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
        //route('learn.show',['category'=>$category->slug])
        return  redirect()->route('learn.preview',$review->slug)->with("success","Lesson Submited");
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
            $data[]=[
                'slug'=>$row->slug,
                'date'=>Carbon::parse($row->created_at)->format('Y-m-d h:i a'),
                'progress'=>round($row->progress,2),
                'url'=>route('learn.preview',$row->slug),
            ];
        }
        return [
            'data'=>$data,
            'url'=>route('learn.lesson.show',[
                'category'=>$category->slug,
                'sub_category'=>$subCategory->slug,
            ]),
            'name'=>$subCategory->name
        ];
    }

}
