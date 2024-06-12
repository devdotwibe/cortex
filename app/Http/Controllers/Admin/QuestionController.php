<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    
    use ResourceController;
    function __construct()
    {
        self::$model = Question::class;
        self::$routeName = "admin.question-bank.section";
    } 
    public function store(Request $request){
        $questiondat=$request->validate([
            "exam_id"=>['required'],
            "category_id"=>['required'],
            "sub_category_id"=>['required'],
            "sub_category_set"=>['nullable'],
            "description"=>['required'],
            "duration"=>["required"],
            "answer.*"=>["required"],
        ]);
        $question=Question::store($questiondat);
        foreach($request->answer as $k =>$ans){
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>$k==($request->choice_answer??0)?true:false,
                "title"=>$ans
            ]);
        }

        $redirect=$request->redirect??route('admin.question.index');
        return redirect($redirect)->with("success","Question updated success");
    }
    public function update(Request $request,Question $question){
        $questiondat=$request->validate([ 
            "category_id"=>['required'],
            "sub_category_id"=>['required'],
            "sub_category_set"=>['nullable'],
            "description"=>['required'],
            "duration"=>["required"],
            "answer.*"=>["required"],
        ]);
        $question->update($questiondat);
        $ansIds=[];
        foreach($request->answer as $k =>$ans){
            $answer=null;
            if(!empty($request->choice_answer_id[$k]??"")){
                $answer=Answer::find($request->choice_answer_id[$k]??"");
            }
            if(empty($answer)){
                $answer=Answer::store([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>$k==($request->choice_answer??0)?true:false,
                    "title"=>$ans
                ]);

            }else{
                $answer->update([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>$k==($request->choice_answer??0)?true:false,
                    "title"=>$ans
                ]);
            }
            $ansIds[]=$answer->id;
        }
        Answer::where('question_id',$question->id)->whereNotIn('id',$ansIds)->delete();
        

        $redirect=$request->redirect??route('admin.question.index');
        return redirect($redirect)->with("success","Question updated success");
    }
    public function destroy(Request $request,Question $question){ 
        Answer::where("question_id",$question->id)->delete();
        $question->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Question deleted success"]);
        }        
        $redirect=$request->redirect??route('admin.question.index');
        return redirect($redirect)->with("success","Question deleted success");
    }
}
