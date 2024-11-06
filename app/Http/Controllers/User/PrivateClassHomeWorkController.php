<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitHomeWorkReview;
use App\Models\HomeWork;
use App\Models\HomeWorkAnswer;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Models\HomeWorkReview;
use App\Models\HomeWorkReviewAnswer;
use App\Models\HomeWorkReviewQuestion;
use App\Models\TermAccess;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PrivateClassHomeWorkController extends Controller
{
    public function index(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user(); 
        $homeWorks=HomeWork::whereIn('id',TermAccess::where('type','home-work')->where('user_id',$user->id)->select('term_id'))->get();
        return view('user.home-work.index',compact('homeWorks','user'));
    }
    public function show(Request $request,HomeWork $homeWork){       
        /**
         *  @var User
         */
        $user=Auth::user();
        if(TermAccess::where('type','home-work')->where('term_id',$homeWork->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
       



        $booklets=HomeWorkBook::whereIn('id',HomeWorkQuestion::where('home_work_id',$homeWork->id)->pluck('home_work_book_id'))->get();

        return view('user.home-work.show',compact('homeWork','booklets','user'));
    }
    
    public function booklet(Request $request,HomeWork $homeWork,HomeWorkBook $homeWorkBook){ 
        /**
         *  @var User
         */
        $user=Auth::user();

        if(TermAccess::where('type','home-work')->where('term_id',$homeWork->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        if($request->ajax()){      
            
            if(!empty($request->question)){
                $question=HomeWorkQuestion::findSlug($request->question);
                return HomeWorkAnswer::where('home_work_question_id',$question->id)->get(['slug','title']);
            }
            return HomeWorkQuestion::where('home_work_id',$homeWork->id)->where('home_work_book_id',$homeWorkBook->id)->paginate(1,['slug','title','description','duration']);
        } 
        $questioncount=HomeWorkQuestion::where('home_work_id',$homeWork->id)->where('home_work_book_id',$homeWorkBook->id)->count();
        return view('user.home-work.booklet',compact('homeWork','homeWorkBook','questioncount','user'));
    }

    public function bookletverify(Request $request,HomeWork $homeWork,HomeWorkBook $homeWorkBook){ 
        $request->validate([
            "question"=>'required'
        ]);
        /**
        * @var User
        */
       $user=Auth::user();  
       
       if(TermAccess::where('type','home-work')->where('term_id',$homeWork->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        } 
        $question=HomeWorkQuestion::findSlug($request->question);
        $ans=HomeWorkAnswer::findSlug($request->answer);
        if(empty($ans)||$ans->home_work_id!=$homeWorkBook->id||$ans->home_work_question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false]);
        }else{
            return response()->json(["iscorrect"=>true]);
        }
    }

    public function bookletsubmit(Request $request,HomeWork $homeWork,HomeWorkBook $homeWorkBook){ 
        /**
         * @var User
         */
        $user=Auth::user(); 

        if(TermAccess::where('type','home-work')->where('term_id',$homeWork->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        $review=HomeWorkReview::store([
            "title"=>$homeWorkBook->title,
            "name"=>'home-work-booklet',
            "progress"=>$user->progress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}",0),
            "user_id"=>$user->id,
            "home_work_id"=>$homeWork->id,
            "home_work_book_id"=>$homeWorkBook->id,
        ]); 
        $user->setProgress("home-work-review-{$review->id}-timed",'timed');
        $user->setProgress("home-work-review-{$review->id}-timetaken",$request->input("timetaken",'0'));
        $user->setProgress("home-work-review-{$review->id}-flags",$request->input("flags",'[]'));
        $user->setProgress("home-work-review-{$review->id}-times",$request->input("times",'[]'));
        $user->setProgress("home-work-review-{$review->id}-passed",$request->input("passed",'0'));
         
        if($user->progress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-complete-date","")==""){
            $user->setProgress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-complete-date",date('Y-m-d H:i:s'));
        }
        $user->setProgress("home-work-{$homeWork->id}-booklet-{$homeWorkBook->id}-complete-review",'yes');
        dispatch(new SubmitHomeWorkReview($review)); 
        if($request->ajax()){
            return  response()->json(["success"=>"{$review->title} Submited","preview"=>route('home-work.preview',$review->slug)]);    
        }
        return  redirect()->route('home-work.preview',$review->slug)->with("success","{$review->title} Submited");
    }

    public function preview(Request $request,HomeWorkReview $homeWorkReview){
        $homeWork=HomeWork::find( $homeWorkReview->home_work_id );
        $homeWorkBook=HomeWorkBook::find( $homeWorkReview->home_work_book_id );
        /**
         * @var User
         */
        $user=Auth::user();
        
        if($request->ajax()){
            if(!empty($request->question)){
                $question=HomeWorkReviewQuestion::findSlug($request->question);
                return HomeWorkReviewAnswer::where('home_work_review_question_id',$question->id)->where('home_work_review_id',$homeWorkReview->id)->get();
            }
            return HomeWorkReviewQuestion::whereIn('review_type',['mcq'])->where('home_work_review_id',$homeWorkReview->id)->where('user_id',$user->id)->paginate(1);
        }




        $useranswer=HomeWorkReviewQuestion::leftJoin('user_review_answers','user_review_answers.user_review_question_id','user_review_questions.id')
        ->where('user_review_answers.user_answer',true)
        ->whereIn('user_review_questions.review_type',['mcq'])
        ->where('user_review_questions.user_id',$user->id)
        
        ->select('user_review_questions.id','user_review_questions.time_taken','user_review_answers.iscorrect')->get();
$examtime=0;
if($user->progress("exam-review-".$homeWorkReview->id."-timed",'')=="timed"){
$times=explode(':',$user->progress("exam-review-".$homeWorkReview->id."-time_of_exam",'0:0'));
if(count($times)>0){
$examtime+=intval(trim($times[0]??"0"))*60;
$examtime+=intval(trim($times[1]??"0"));
}
if($examtime>0&&count($useranswer)>0){
$examtime=$examtime/count($useranswer);
}
}



        return view("user.home-work.preview",compact('homeWork','homeWorkBook','user','homeWorkReview','useranswer'));
    }

    public function booklethistory(Request $request,HomeWork $homeWork,HomeWorkBook $homeWorkBook){ 
        /**
         * @var User
         */
        $user=Auth::user(); 

        if(TermAccess::where('type','home-work')->where('term_id',$homeWork->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        return DataTables::of(HomeWorkReview::where('user_id',$user->id)->where('home_work_id',$homeWork->id)->where('home_work_book_id',$homeWorkBook->id)->select('slug','created_at','progress'))
        ->addColumn('progress',function($data){

            // $numberformat=number_format($data->progress,2);
            // return $numberformat."%";
            if ($data->progress == 100) {
                return "100%"; // Return without decimals
            } else {
                $numberformat = number_format($data->progress, 2);
                return $numberformat . "%";
            }
        })
            ->addColumn('date',function($data){
                return Carbon::parse($data->created_at)->format('Y-m-d h:i a');
            })
            ->addColumn('action',function($data){
                return '<a type="button" href="'.route('home-work.preview',$data->slug).'" class="btn btn-warning btn-sm">Review</a>';
            })
            ->rawColumns(['action'])
            ->with('url',route('home-work.booklet',['home_work'=>$homeWork->slug,'home_work_book'=>$homeWorkBook->slug]))
            ->with('name',$homeWorkBook->title)
            ->addIndexColumn()
            ->make(true);
    }
}
