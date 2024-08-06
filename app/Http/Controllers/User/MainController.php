<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\Question;
use App\Models\User;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use App\Trait\ResourceController;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{ 
    use ResourceController;
    public function index(Request $request){
        /**
         * @var User
         */
        $user=Auth::user();
        if($request->ajax()){
            $responceData=[];
            $start=Carbon::parse($request->startStr??date("Y-m-d"));
            $end=Carbon::parse($request->endStr??date("Y-m-d"));
            foreach (CarbonPeriod::create($start, $end) as $date) {
                $cnt=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $bgcolor="#808C83";
                if($cnt>0){
                    $bgcolor="#8FFFAD";
                }
                if($cnt>30){
                    $bgcolor="#21853C";
                }
                $responceData[]=[ 
                    "start"=>$date->format('Y-m-d'),
                    "rendering"=> 'background',
                    "elTitle"=> "You completed {$cnt} questions this day",
                    "backgroundColor"=> "$bgcolor", 
                    "borderColor"=>"$bgcolor", 
                    "title"=> "",
                    "textColor"=> '#FFFFFF',
                    "className"=> 'event-full', 
                ];
            }
            return response()->json($responceData);
        }
        $chartlabel=[]; 
        $chartbackgroundColor=[];
        $chartdata=[]; 
        if(UserReviewAnswer::where('user_id',$user->id)->count()>0){
            foreach (UserReviewAnswer::where('user_id',$user->id)->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') ndate"))->groupBy('ndate')->pluck('ndate')->toArray() as $date) {
                $date=Carbon::parse($date);
                $cnt=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $tcnt=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->count();
                if($cnt>0){
                    $chartlabel[]=$date->format('Y-m-d');
                    $chartdata[]=round(($cnt*100)/$tcnt,2);
                    $chartbackgroundColor[]="#21853C";
                }
            }
        }
        self::reset();
        self::$model = Category::class;
        $learnexam=Exam::where("name",'learn')->first();
        if(empty($learnexam)){
            $learnexam=Exam::store([
                "title"=>"Learn",
                "name"=>"learn",
            ]);
            $learnexam=Exam::find( $learnexam->id );
        }
        $learnprogress=0;
        $learncnt=0;
        foreach($this->whereHas('subcategories',function($qry){
            $qry->whereIn("id",Learn::select('sub_category_id'));
        })->buildResult() as $item){
            $learnprogress+=$user->progress('exam-' . $learnexam->id . '-module-' . $item->id,0);
            $learncnt++;
        }
        if($learncnt>0){
            $learnprogress=round($learnprogress/$learncnt,2);
        }
 
        $practiceexam=Exam::where("name",'question-bank')->first();
        if(empty($practiceexam)){
            $practiceexam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $practiceexam=Exam::find( $practiceexam->id );
        }
        $practiceprogress=UserReviewAnswer::whereIn('question_id',Question::where("exam_id",$practiceexam->id)->has('category')->has('subCategory')->has('setname')->select('id'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
        $practicecnt=Question::where("exam_id",$practiceexam->id)->has('category')->has('subCategory')->has('setname')->count();
        if($practicecnt>0){
            $practiceprogress=round($practiceprogress/$practicecnt,2);
        } 
        
        $simulateprogress=UserReviewAnswer::whereIn('question_id',Question::whereIn("exam_id",Exam::whereIn("name",['full-mock-exam','topic-test'])->select('id'))->has('category')->select('id'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
        $simulatecnt=Question::whereIn("exam_id",Exam::whereIn("name",['full-mock-exam','topic-test'])->select('id'))->has('category')->has('subCategory')->has('setname')->count();
        if($simulatecnt>0){
            $simulateprogress=round($simulateprogress/$simulatecnt,2);
        } 
        print_r(UserReviewAnswer::where('user_id',$user->id)->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') ndate"))->pluck('ndate')->toArray());exit;
        return view("user.dashboard",compact('chartdata','chartbackgroundColor','chartlabel','learnprogress','practiceprogress','simulateprogress'));
    }

    public function progress(Request $request){
        $request->validate([
            "name"=>['required']
        ]);
        /**
         *  @var User
         */
        $user=Auth::user();
        $user->setProgress($request->input('name'),$request->input('value'));
    }
    public function getprogress(Request $request){
        $request->validate([
            "name"=>['required']
        ]);
        /**
         *  @var User
         */
        $user=Auth::user();
        return [
            "name"=>$request->input('name'),
            "value"=> $user->progress($request->input('name'),$request->input('value'))
        ];
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
