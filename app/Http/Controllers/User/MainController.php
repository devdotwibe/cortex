<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\CalculateExamAverage;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\Question;
use App\Models\Reminder;
use App\Models\User;
use App\Models\UserExamQuestion;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use App\Models\UserReviewQuestion;
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
                        $chartbackgroundColor[]="#f24600";
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
                    $bgcolor="#FFFFFF";
                    $borderColor="#E1E1E1";
                    // if($date->format('Y-m-d')==date('Y-m-d')){
                    //     $bgcolor="#FFFFFF";
                    // }
                    if($cnt>0){
                        $borderColor="#91C188";
                        $bgcolor="#91C188"; 

                        if($cnt>30){
                            $borderColor="#4B9773";
                            $bgcolor="#4B9773"; 

                        } 
                        if(Reminder::where("remind_date",$date->format('Y-m-d'))
                                    ->where('user_id',$user->id)
                                    ->count()>0 && $date > date('Y-m-d')){
                            $borderColor="#FFCD56"; 
                        }
                    }else{
                        if($date < date('Y-m-d')){
                            $bgcolor="#E1E1E1"; 
                        }
                        if(Reminder::where("remind_date",$date->format('Y-m-d'))
                                    ->where('user_id',$user->id)
                                    ->count()>0){
                            $borderColor="#FFCD56";
                            $bgcolor="#FFCD56"; 
                        }
                    }
                    $responceData[]=[ 
                        "start"=>$date->format('Y-m-d'),
                        "rendering"=> 'background',
                        "elTitle"=> "You completed {$cnt} questions this day",
                        "backgroundColor"=> "$bgcolor", 
                        "borderColor"=>"$borderColor", 
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

        //Learn Progress 
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

        // Practise Progress
        $practiceexam=Exam::where("name",'question-bank')->first();
        if(empty($practiceexam)){
            $practiceexam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $practiceexam=Exam::find( $practiceexam->id );
        }
        $questions = Question::where("exam_id",$practiceexam->id)
                                ->has('category')
                                ->has('subCategory')
                                ->has('setname')
                                ->select('id');

        $userExamReviews = UserExamReview::where('name','question-bank')
                                            ->where('user_id',$user->id)
                                            ->select('id'); 
                                                             
        $practices = UserReviewQuestion::whereIn('question_id',$questions)
                                            ->where('user_id',$user->id)
                                            ->whereIn('user_exam_review_id',$userExamReviews);
                                            
        $count = [];
        foreach($practices->get() as $i){
                if($i->user_answer != Null){
                    $count[$i->question_id] = true;
                }
        }
        $practicecnt=$questions ? count($questions->get()) : 0;
        $practiceprogress= $count ? count($count) :  0; 
        if($practicecnt>0){
            $practiceprogress=round($practiceprogress*100/$practicecnt,2);
        } 

        //Simulate
        $simu=UserReviewAnswer::whereIn('question_id',Question::whereIn("exam_id",Exam::whereIn("name",['full-mock-exam','topic-test'])->select('id'))->has('category')->select('id'))->where('user_id',$user->id)->where(function($qry)use($user){
            $qry->whereIn('user_exam_review_id',UserExamReview::where('name','full-mock-exam')->where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('MAX(id)')));
            $qry->orWhereIn('user_exam_review_id',UserExamReview::where('name','topic-test')->where('user_id',$user->id)->groupBy('category_id')->select(DB::raw('MAX(id)')));
        })->where('iscorrect',true);
        $simulatecnt=$simu->count();
        $simulateprogress=$simu->where('user_answer',true)->count();
        if($simulatecnt>0){
            $simulateprogress=round($simulateprogress*100/$simulatecnt,2);
        } 

        // Calculation of Topic test percentage
        $exams = Exam::where("name", 'topic-test')
                        ->select('id');
        $questions = Question::whereIn("exam_id",$exams)
                                ->has('category')
                                ->select('id');
        $userExamReviews = UserExamReview::where('name','topic-test')
                                            ->where('user_id',$user->id)
                                            ->select('id');

        $topics = UserReviewQuestion::whereIn('question_id',$questions)
                                    ->where('user_id',$user->id)
                                    ->whereIn('user_exam_review_id',$userExamReviews);
        $count = [];
        foreach($topics->get() as $i){
            if($i->user_answer != Null){
                $count[$i->question_id] = true;
            }
        }
        $topic_count = $questions ? count($questions->get()) :0;      
        $topicprogress= $count ? count($count) :  0; 

        $topiclateprogress=0;
        if($topic_count>0){
            $topiclateprogress=round($topicprogress * 100/$topic_count ,2);
        } 

        // Calculation of Mock test percentage
        $exams =Exam::where("name", 'full-mock-exam')
                    ->select('id'); 
        $questions = Question::whereIn("exam_id",$exams)
                                        ->select('id');
        $userExamReviews = UserExamReview::where('name','full-mock-exam')
                                        ->where('user_id',$user->id)
                                        ->select('id');
        $moc = UserReviewQuestion::whereIn('question_id',$questions)
                            ->where('user_id',$user->id)
                            ->whereIn('user_exam_review_id',$userExamReviews);
                           
        $count = [];
        foreach($moc->get() as $i){
            if($i->user_answer != Null){
                $count[$i->question_id] = true;
            }
        } 

        $moc_count= $questions ? count($questions->get()) :0;
        $mocprogress= $count ? count($count) :  0; 

         $moclateprogress=0;
        if($moc_count>0){
            $moclateprogress=round($mocprogress*100/$moc_count,2);
        } 

        $maxretry=(optional(UserExamReview::where('name','full-mock-exam')->where('user_id',$user->id)->groupBy('exam_id')->select(DB::raw('count(exam_id) as cnt'))->first())->cnt??0)+(optional(UserExamReview::where('name','question-bank')->where('user_id',$user->id)->groupBy('sub_category_set')->select(DB::raw('count(sub_category_set) as cnt'))->first())->cnt??0)+(optional(UserExamReview::where('name','topic-test')->where('user_id',$user->id)->groupBy('category_id')->select(DB::raw('count(category_id)  as cnt'))->first())->cnt??0);
        
           
        // CalculateExamAverage::dispatch();

        return view("user.dashboard",compact('user','maxretry','learnprogress','practiceprogress','simulateprogress','moclateprogress','topiclateprogress'));
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

            if ($date->isToday())
            {
                $reminder->title="{$reminder->name} Today ( ".$date->format('jS F')." )";
            }
            elseif ($date->isPast()) 
            {
                $reminder->title="{$reminder->name} Expired ( ".$date->format('jS F')." )";
            }
            else
            {
                $reminder->title="{$reminder->name} in ".($date->diffForHumans(null,[
                    'syntax' => Carbon::DIFF_ABSOLUTE,
                ]))." ( ".$date->format('jS F')." )";
            }

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
        $reminder->title="{$reminder->name} in ".($date->diffForHumans(null,[
            'syntax' => Carbon::DIFF_ABSOLUTE,
        ]))." ( ".$date->format('jS F')." )";
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
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function tips_n_advice(Request $request){
        return view('user.tips_n_advice');
    }
}
