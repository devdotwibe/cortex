<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{

    
    use ResourceController;
    function __construct()
    {
        self::$model = Question::class;
        self::$routeName = "admin.question-bank.section";
    } 
    public function store(Request $request){
        switch ($request->input('exam_type',"")) {
            case 'question-bank':
                $questiondat=$request->validate([
                    "exam_id"=>['required'],
                    "category_id"=>['required'],
                    "sub_category_id"=>['required'],
                    "sub_category_set"=>['required'],
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;

            case 'full-mock-exam':
                $questiondat=$request->validate([
                    "exam_id"=>['required'],
                    "category_id"=>['required'],
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;

            case 'topic-test':
                $questiondat=$request->validate([
                    "exam_id"=>['required'],
                    "category_id"=>['required'], 
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;
            
            default:
                $questiondat=$request->validate([
                    "exam_id"=>['required'],
                    "category_id"=>['required'],
                    "sub_category_id"=>['required'],
                    "sub_category_set"=>['nullable'],
                    "description"=>['required'],
                    "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;
        }
        $question=Question::store($questiondat);
        foreach($request->answer as $k =>$ans){
             $answer=Answer::store([
                "exam_id"=>$question->exam_id,
                "question_id"=>$question->id,
                "iscorrect"=>$k==($request->choice_answer??0)?true:false,
                "title"=>$ans,
         
            ]);
            if ($request->hasFile('image')) {
                $imageName = "questionimages/" . $request->file('image')->hashName();
                Storage::put('questionimages', $request->file('image'));
        
                // Save the image name in the answer
                $answer->image = $imageName;
                $answer->save(); // Save the changes
            }
        }

        $redirect=$request->redirect??route('admin.question.index');


        


        return redirect($redirect)->with("success","Question has been successfully created");
    }
    public function update(Request $request,Question $question){
        
        switch ($request->input('exam_type',"")) {
            case 'question-bank':
                $questiondat=$request->validate([ 
                    "category_id"=>['required'],
                    "sub_category_id"=>['required'],
                    "sub_category_set"=>['required'],
                    "description"=>['required'],
                    //"duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;

            case 'full-mock-exam':
                $questiondat=$request->validate([ 
                    "category_id"=>['required'],
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;

            case 'topic-test':
                $questiondat=$request->validate([ 
                    "category_id"=>['required'], 
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;
            
            default:
                $questiondat=$request->validate([ 
                    "category_id"=>['required'],
                    "sub_category_id"=>['required'],
                    "sub_category_set"=>['nullable'],
                    "description"=>['required'],
                    "duration"=>["required"],
                    "answer.*"=>["required",'string','max:150'],
                    "explanation"=>['nullable'],
                ],[
                    'answer.*.required'=>['The answer field is required.']
                ]);
                break;
        }
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
        return redirect($redirect)->with("success","Question has been successfully updated");
    }

    public function visibility(Request $request,Question $question){
        $question->update(['visible_status'=>($question->visible_status??"")=="show"?"hide":"show"]);        
        if($request->ajax()){
            return response()->json(["success"=>"Question visibility change success"]);
        }        
        return redirect()->route('admin.category.index')->with("success","Question visibility change success");
    }
    
    public function destroy(Request $request,Question $question){ 
        Answer::where("question_id",$question->id)->delete();
        $question->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Question has been successfully deleted"]);
        }        
        $redirect=$request->redirect??route('admin.question.index');
        return redirect($redirect)->with("success","Question has been successfully deleted");
    }
}
