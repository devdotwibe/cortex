<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\Question;
use App\Models\Reminder;
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
            if($request->input("chart","")=="Y"){
                $chartlabel=[]; 
                $chartbackgroundColor=[];
                $chartdata=[]; 
                if(UserReviewAnswer::where('user_id',$user->id)->count()>0){
                    $examsdata=UserReviewAnswer::where('user_id',$user->id); 
                    switch ($request->input('filter')) {
                        case '1week':                            
                            $examsdata->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()]);
                            break;
                        case '1month':                            
                            $examsdata->whereBetween('created_at',[Carbon::now()->subMonth(),Carbon::now()]);
                            break;                        
                        case '3months':                            
                            $examsdata->whereBetween('created_at',[Carbon::now()->subMonths(3),Carbon::now()]);
                            break;                                                   
                        case '1year':                            
                            $examsdata->whereBetween('created_at',[Carbon::now()->subYear(),Carbon::now()]);
                            break;
                        default: 
                            break;
                    }
                    foreach ($examsdata->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') ndate"))->groupBy('ndate')->pluck('ndate')->toArray() as $date) {
                        $date=Carbon::parse($date);
                        $ans=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->where(function($qry)use($user,$date){
                            $qry->whereIn('user_exam_review_id',UserExamReview::where('name','full-mock-exam')->whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')));
                            $qry->orWhereIn('user_exam_review_id',UserExamReview::where('name','question-bank')->whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->groupBy('sub_category_set')->select(DB::raw('MAX(id)'))); 
                            $qry->orWhereIn('user_exam_review_id',UserExamReview::where('name','topic-test')->whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->groupBy('category_id')->select(DB::raw('MAX(id)')));
                        })->where('iscorrect',true);
                        $tcnt=$ans->count();
                        $cnt=$ans->where('user_answer',true)->count();
                        $chartlabel[]=$date->format('Y-m-d');
                        $chartdata[]=$tcnt>0?round(($cnt*100)/$tcnt,2):0;
                        $chartbackgroundColor[]="#21853C";
                    }
                }
                $responceData["label"]=$chartlabel;
                $responceData["data"]=$chartdata;
                $responceData["borderColor"]=$chartbackgroundColor;
            }
            if($request->input("calendar","")=="Y"){

                $start=Carbon::parse($request->startStr??date("Y-m-d"));
                $end=Carbon::parse($request->endStr??date("Y-m-d"));
                foreach (CarbonPeriod::create($start, $end) as $date) {
                    $cnt=UserReviewAnswer::whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->where(function($qry)use($user,$date){
                        $qry->whereIn('user_exam_review_id',UserExamReview::where('name','full-mock-exam')->whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')));
                        $qry->orWhereIn('user_exam_review_id',UserExamReview::where('name','question-bank')->whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->groupBy('sub_category_set')->select(DB::raw('MAX(id)'))); 
                        $qry->orWhereIn('user_exam_review_id',UserExamReview::where('name','topic-test')->whereDate('created_at',$date->format('Y-m-d'))->where('user_id',$user->id)->groupBy('category_id')->select(DB::raw('MAX(id)')));
                    })->where('iscorrect',true)->where('user_answer',true)->count();
                    $bgcolor="#808C83";
                    if($cnt>0){
                        $bgcolor="#8FFFAD";
                    }
                    if($cnt>30){
                        $bgcolor="#21853C";
                    } 
                    if(Reminder::where("remind_date",$date)->where('user_id',$user->id)->count()>0){
                        $bgcolor="#FC0317"; 
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
            }
            return response()->json($responceData);
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

        $practice=UserReviewAnswer::whereIn('question_id',Question::where("exam_id",$practiceexam->id)->has('category')->has('subCategory')->has('setname')->select('id'))->where('user_id',$user->id)->whereIn('user_exam_review_id',UserExamReview::where('name','question-bank')->where('user_id',$user->id)->groupBy('sub_category_set')->select(DB::raw('MAX(id)')))->where('iscorrect',true);
        $practicecnt=$practice->count();
        $practiceprogress=$practice->where('user_answer',true)->count();        
        if($practicecnt>0){
            $practiceprogress=round($practiceprogress*100/$practicecnt,2);
        } 
        
        $simu=UserReviewAnswer::whereIn('question_id',Question::whereIn("exam_id",Exam::whereIn("name",['full-mock-exam','topic-test'])->select('id'))->has('category')->select('id'))->where('user_id',$user->id)->where(function($qry)use($user){
            $qry->whereIn('user_exam_review_id',UserExamReview::where('name','full-mock-exam')->where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')));
            $qry->orWhereIn('user_exam_review_id',UserExamReview::where('name','topic-test')->where('user_id',$user->id)->groupBy('category_id')->select(DB::raw('MAX(id)')));
        })->where('iscorrect',true);
        $simulatecnt=$simu->count();
        $simulateprogress=$simu->where('user_answer',true)->count();
        if($simulatecnt>0){
            $simulateprogress=round($simulateprogress*100/$simulatecnt,2);
        } 

        $maxretry=(optional(UserExamReview::where('name','full-mock-exam')->where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('count(exam_id) as cnt'))->first())->cnt??0)+(optional(UserExamReview::where('name','question-bank')->where('user_id',$user->id)->groupBy('sub_category_set')->select(DB::raw('count(sub_category_set) as cnt'))->first())->cnt??0)+(optional(UserExamReview::where('name','topic-test')->where('user_id',$user->id)->groupBy('category_id')->select(DB::raw('count(category_id)  as cnt'))->first())->cnt??0);
           

        return view("user.dashboard",compact('maxretry','learnprogress','practiceprogress','simulateprogress'));
    }
    public function reminder(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user();
        $reminder=Reminder::where('user_id',$user->id); 
        $reminder=$reminder->first();        
        if(!empty($reminder)){ 
            $date = Carbon::parse($reminder->remind_date); 
            $reminder->showUrl=route('reminder.show',$reminder->slug);
            $reminder->updateUrl=route('reminder.update',$reminder->slug);
            $reminder->title="{$reminder->name} in ".($date->diffForHumans())." ".$date->format('jS F');
        }
        return response()->json([
            "reminder"=>$reminder
        ]);
    }

    public function showreminder(Request $request,Reminder $reminder){
        /**
         *  @var User
         */
        $user=Auth::user();  
        $date = Carbon::parse($reminder->remind_date); 
        $reminder->showUrl=route('reminder.show',$reminder->slug);
        $reminder->updateUrl=route('reminder.update',$reminder->slug);
        $reminder->title="{$reminder->name} in ".($date->diffForHumans())." ".$date->format('jS F');
        return response()->json($reminder);
    }
    public function editreminder(Request $request,Reminder $reminder){
        $data= $request->validate([
                'name'=>"required",
                'remind_date'=>"required",
        ]);
        /**
         *  @var User
         */
        $user=Auth::user();  
        $reminder->update($data); 
        return response()->json(['success'=>"Date updated success"]);
    }

    public function addreminder(Request $request){
        $data= $request->validate([
                'name'=>"required",
                'remind_date'=>"required",
        ]);
        /**
         *  @var User
         */
        $user=Auth::user();  
        $data['user_id']=$user->id;
        Reminder::store($data); 
        return response()->json(['success'=>"Date added success"]);
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
