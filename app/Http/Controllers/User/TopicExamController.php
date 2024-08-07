<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitReview;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question; 
use App\Models\User;
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

class TopicExamController extends Controller
{
    use ResourceController; 
 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class; 

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $categorys=$this->where(function($qry)use($exam){
            $qry->whereIn("id",Question::where('exam_id',$exam->id)->select('category_id'));
        })->buildResult();
        
        /**
         *  @var User
         */
        $user=Auth::user();
        return view("user.topic-test.index",compact('categorys','exam','user'));
    } 
    public function show(Request $request,Category $category){

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }

        /**
         * @var User
         */
        $user=Auth::user();  
        $questioncount=Question::where('exam_id',$exam->id)->where('category_id',$category->id)->count();
        $endtime=0;
        $times=explode(':',$category->time_of_exam);
        if(count($times)>0){
            $endtime+=intval(trim($times[0]??"0"))*60;
            $endtime+=intval(trim($times[1]??"0"));
        }
        foreach (Question::where('exam_id',$exam->id)->where('category_id',$category->id)->get() as $d) {
            $user->setProgress("exam-{$exam->id}-topic-{$category->id}-answer-of-{$d->slug}",null);
        }
        $user->setProgress("exam-{$exam->id}-topic-{$category->id}-progress-url",null);
        $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$category->id)->count()+1;
        return view("user.topic-test.summery",compact('category','exam','user','questioncount','endtime','attemtcount'));
    } 
    

    public function confirmshow(Request $request,Category $category){

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }

        /**
         * @var User
         */
        $user=Auth::user(); 
        if($request->ajax()){      
            
            if(!empty($request->question)){
                $question=Question::findSlug($request->question);
                return Answer::where('question_id',$question->id)->get(['slug','title']);
            }
            return Question::where('exam_id',$exam->id)->where('category_id',$category->id)->paginate(1,['slug','title','description','duration']);
        }  
        $questioncount=Question::where('exam_id',$exam->id)->where('category_id',$category->id)->count();
        $endtime=0;
        $times=explode(':',$category->time_of_exam);
        if(count($times)>0){
            $endtime+=intval(trim($times[0]??"0"))*60;
            $endtime+=intval(trim($times[1]??"0"));
        }
        $attemtcount=UserExamReview::where('exam_id',$exam->id)->where('user_id',$user->id)->where('category_id',$category->id)->count()+1; 
        return view("user.topic-test.show",compact('category','exam','user','questioncount','endtime','attemtcount'));
    } 
    public function topicsubmit(Request $request,Category $category){
        /**
         * @var User
         */
        $user=Auth::user();
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        $review=UserExamReview::store([
            "title"=>"Topic Test",
            "name"=>"topic-test",
            "progress"=>$user->progress("exam-".$exam->id."-topic-".$category->id,0),
            "user_id"=>$user->id,
            "exam_id"=>$exam->id,
            "category_id"=>$category->id,         
        ]); 
        $user->setProgress("exam-review-".$review->id."-timed",'timed');
        $user->setProgress("exam-review-".$review->id."-timetaken",$request->input("timetaken",'0'));
        $user->setProgress("exam-review-".$review->id."-flags",$request->input("flags",'[]'));
        $user->setProgress("exam-review-".$review->id."-times",$request->input("times",'[]'));
        $user->setProgress("exam-review-".$review->id."-passed",$request->input("passed",'0'));
         
        if($user->progress('exam-'.$exam->id.'-topic-'.$category->id.'-complete-date',"")==""){
            $user->setProgress('exam-'.$exam->id.'-topic-'.$category->id.'-complete-date',date('Y-m-d H:i:s'));
        }
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-complete-review",'yes');
        dispatch(new SubmitReview($review)); 
        if($request->ajax()){
            return  response()->json(["success"=>"Topic Test Submited","preview"=>route('topic-test.preview',$review->slug)]);    
        }
        return  redirect()->route('topic-test.complete',$review->slug)->with("success","Topic Test Submited")->with("review",$review->id);
    }

    public function topiccomplete(Request $request,UserExamReview $userExamReview){ 
        /**
         * @var User
         */
        $user=Auth::user();   
        $user->progress("exam-review-".$userExamReview->id."-timed",'timed');
        $tmtk=intval($user->progress("exam-review-".$userExamReview->id."-timetaken",0)); 
        $passed=$user->progress("exam-review-".$userExamReview->id."-passed",0);
        
        $m=sprintf("%02d",intval($tmtk/60));
        $s=sprintf("%02d",intval($tmtk%60));

        $attemttime="$m:$s";
        $questioncount=UserReviewQuestion::where('user_exam_review_id',$userExamReview->id)->count();
        $chartlabel=[];
        $chartbackgroundColor=[];
        $chartdata=[]; 
        foreach (UserReviewAnswer::select('mark',DB::raw('count(mark) as marked_users'))->fromSub(function ($query)use($userExamReview){
            $query->from('user_review_answers')->where('user_exam_review_id','<=',$userExamReview->id)->whereIn('user_exam_review_id',UserExamReview::where('name','topic-test')->where('user_exam_review_id','<=',$userExamReview->id)->where('exam_id',$userExamReview->exam_id)->where('category_id',$userExamReview->category_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))
            ->where('iscorrect',true)->where('user_answer',true)->select(DB::raw('count(user_id) as mark'));
        }, 'subquery')->groupBy('mark')->get() as  $row) { 
            $chartlabel[]=strval($row->mark);
            $chartbackgroundColor[]=$passed==$row->mark? "#ef9b10" : '#dfdfdf';
            $chartdata[]=$row->marked_users;
        } 
        $attemtcount=UserExamReview::where('exam_id',$userExamReview->exam_id)->where('category_id',$userExamReview->category_id)->where('user_id',$user->id)->count();
        $categorylist=Category::all();
        return view('user.topic-test.resultpage',compact('chartdata','chartbackgroundColor','chartlabel','categorylist','userExamReview','passed','attemttime','questioncount','attemtcount'));
      
    }

    public function preview(Request $request,UserExamReview $userExamReview){ 
        $category=Category::find($userExamReview->category_id); 

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
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
                return UserReviewAnswer::where('user_review_question_id',$question->id)->get();
            }
            return UserReviewQuestion::whereIn('review_type',['mcq'])->where('user_exam_review_id',$userExamReview->id)->where('user_id',$user->id)->paginate(1);
        }
        return view("user.topic-test.preview",compact('category','exam','user','userExamReview'));
    }
    
    public function topicverify(Request $request,Category $category){
        $request->validate([
            "question"=>'required'
        ]);
        /**
        * @var User
        */
       $user=Auth::user();  
       $exam=Exam::where("name",'topic-test')->first();
       if(empty($exam)){
           $exam=Exam::store([
               "title"=>"Topic Test",
               "name"=>"topic-test",
           ]);
           $exam=Exam::find( $exam->id );
       }
        $question=Question::findSlug($request->question);
        $ans=Answer::findSlug($request->answer);
        if(empty($ans)||$ans->exam_id!=$exam->id||$ans->question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false]);
        }else{
            return response()->json(["iscorrect"=>true]);
        }
    }


    public function topichistory(Request $request,Category $category){
        /**
         * @var User
         */
        $user=Auth::user();       
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }

        return DataTables::of(UserExamReview::where('user_id',$user->id)->where('category_id',$category->id)->where('exam_id',$exam->id)->select('slug','created_at','progress'))
            ->addColumn('progress',function($data){
                return $data->progress."%";
            })
            ->addColumn('date',function($data){
                return Carbon::parse($data->created_at)->format('Y-m-d h:i a');
            })
            ->addColumn('action',function($data){
                return '<a type="button" href="'.route('topic-test.complete',$data->slug).'" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action'])
            ->with('url',route('topic-test.show',[
                'category'=>$category->slug,  
            ]))
            ->with('name',$category->name)
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
}
