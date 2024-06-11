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
            "title"=>['required'],
            "description"=>['nullable'],
            "duration"=>["required"],
            "answer.*"=>["required"],
        ]);
        $question=Question::store($questiondat);
        foreach($request->answer as $k =>$ans){
            Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>$k==$questiondat["choice_answer"]?true:false,
                "title"=>$ans
            ]);
        }

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
