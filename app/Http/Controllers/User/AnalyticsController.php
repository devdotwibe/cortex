<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user(); 
        $category = Category::all();
        

        $topic_exam = Exam::where("name", 'topic-test')->first();
        if (empty($topic_exam)) {
            $topic_exam = Exam::store([
                "title" => "Topic Test",
                "name" => "topic-test",
            ]);
            $topic_exam = Exam::find($topic_exam->id);
        }
    
        $category_topic = Category::where(function ($qry) use ($topic_exam) {
            $qry->whereIn("id", Question::where('exam_id', $topic_exam->id)->select('category_id'));
        })->get();


        $question_bank_exam=Exam::where("name",'question-bank')->first();
        if(empty($question_bank_exam)){
            $question_bank_exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $question_bank_exam=Exam::find( $question_bank_exam->id );
        }

        $category_question_bank=Category::whereHas('subcategories',function($qry)use($question_bank_exam){
            $qry->whereIn("id",Question::where('exam_id',$question_bank_exam->id)->select('sub_category_id'));
            $qry->whereHas('setname', function ($setnameQuery) {
                $setnameQuery->where(function ($query) {
                    $query->where('time_of_exam', '!=', '00:00')
                          ->where('time_of_exam', '!=', '00 : 00');
                });
            });
        })->get();

        
        $mockExams = Exam::where('name', "full-mock-exam")->whereHas('questions')->get();

        if($request->ajax()){
            $page=$request->page??1;
            $data = Exam::where('name',"full-mock-exam")->whereHas('questions')->get()->skip($page-1)->take(1)->first();
            $categorydata=[];
            foreach ($category as $cat) {
                $categorydata[]=[
                    'title'=>ucfirst($cat->name),
                    'max'=> $data->categoryCount($cat->id),
                    'avg'=>$data->getExamAvg($cat->id),
                    'mark'=>$data->getExamMark($user->id,$cat->id),
                ];
            }
            $next = null;
            $prev = null;
            if(Exam::where('name',"full-mock-exam")->count()>$page){
                $next=route('analytics.index',["page"=> $page+1]);
            }
            if($page>1){
                $prev=route('analytics.index',["page"=> $page-1]);
            }
            return [
                'data'=>[
                    'title'=>ucfirst($data->title),
                    'max'=> $data->categoryCount(),
                    'avg'=>$data->getExamAvg(),
                    'mark'=>$data->getExamMark($user->id),
                    'category'=>$categorydata
                ],
                "next"=>$next,
                "prev"=>$prev,
            ];
        }
        return view('user.analytics.index',compact('category_question_bank','category_topic','mockExams'));   
    }
}
