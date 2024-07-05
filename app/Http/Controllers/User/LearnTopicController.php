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

        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }

        $categorys=$this->whereHas('subcategories',function($qry){
            $qry->whereIn("id",Learn::select('sub_category_id'));
        })->buildResult();
        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.learn.index",compact('categorys','exam','user'));

    }
    public function show(Request $request,Category $category){
        $lessons=SubCategory::where('category_id',$category->id)->where(function($qry){
            $qry->whereIn("id",Learn::select('sub_category_id'));
        })->get();
        $exam=Exam::where("name",'learn')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $exam=Exam::find( $exam->id );
        }

        /**
         *  @var User
         */
        $user=Auth::user();
        // $subscription = Subscription::where('user_id', $user->id)
        //     ->where('status', 'active')
        //     ->orderBy('id','desc')
        //     ->first();
        //    $firstlesson = $lessons->first();
        //    $hasFreeAccess = $user->hasSubscriptionForCategory($category->id);
           $settings = Settings::first();
        //   if ($firstlesson && $hasFreeAccess){
            return view("user.learn.show",compact('category','exam','lessons','user'));
        //   }

        //  else{
        //     return redirect()->route('learn.index')->with('showStripePopup', true)->with('settings',$settings->amount);
        // }
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

        if($request->ajax()){
            if(!empty($request->question)){
                $question=UserReviewQuestion::findSlug($request->question);
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get(['slug','title','user_answer','iscorrect','description']);
            }
            return UserReviewQuestion::whereIn('review_type',['mcq','short_notes'])->where('user_exam_review_id',$userExamReview->id)->paginate(1,['title','note','slug','review_type','user_answer','currect_answer','explanation']);
        }
        return view("user.learn.preview",compact('category','exam','subCategory','user','userExamReview'));
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
            if($user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$subCategory->id.'-complete-date',"")==""){
                $lessons=SubCategory::where('category_id',$category->id)->get();
                $lessencount=count($lessons);
                $totalprogres=0;
                foreach ($lessons as $lesson) {
                    $totalprogres+=$user->progress('exam-'.$exam->id.'-module-'.$category->id.'-lesson-'.$lesson->id,0);
                }
                $user->setProgress('exam-'.$exam->id.'-module-'.$category->id,$totalprogres/$lessencount);
            }

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
        return  redirect()->route('learn.show',['category'=>$category->slug])->with("success","Lesson Submited");
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
                'progress'=>$row->progress,
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
