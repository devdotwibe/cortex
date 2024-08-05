<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{ 
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
            foreach (CarbonPeriod::create(Carbon::parse(UserReviewAnswer::where('user_id',$user->id)->min('created_at')), Carbon::parse(UserReviewAnswer::where('user_id',$user->id)->max('created_at'))) as $date) {
                $cnt=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $tcnt=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->count();
                if($cnt>0){
                    $chartlabel[]=$date->format('Y-m-d');
                    $chartdata[]=round(($cnt*100)/$tcnt,2);
                    $chartbackgroundColor[]="#21853C";
                }
            }
        }
        return view("user.dashboard",compact('chartdata','chartbackgroundColor','chartlabel'));
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
