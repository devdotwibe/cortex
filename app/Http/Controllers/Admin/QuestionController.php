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
                    "answer.*" => ["required_without:file_answer", 'string', 'max:150','nullable'],
                    "file_answer.*" => ["required_without:answer", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    'answer.*.max' => 'sample.',

                    'file_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            case 'full-mock-exam':
                $questiondat=$request->validate([
                    "exam_id"=>['required'],
                    "category_id"=>['required'],
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*" => ["required_without:file_answer", 'string', 'max:150','nullable'],
                    "file_answer.*" => ["required_without:answer", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    'answer.*.max' => 'sample.',
                    'file_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            case 'topic-test':
                $questiondat=$request->validate([
                    "exam_id"=>['required'],
                    "category_id"=>['required'], 
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*" => ["required_without:file_answer", 'string', 'max:150','nullable'],
                    "file_answer.*" => ["required_without:answer", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    'file_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
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
                    "answer.*" => ["required_without:file_answer", 'string', 'max:150','nullable'],
                    "file_answer.*" => ["required_without:answer", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                ],[
                    'answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    'file_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;
        }

       

        $featureimages = $request->file('file_answer', []);

        

        $question = Question::store($questiondat);
        foreach ($request->answer as $k => $ans) {
            $imageName = "";
        
            if (isset($featureimages[$k])) {
                $featureImage = $featureimages[$k];
                $featureImageName = "questionimages/" . $featureImage->hashName();
                Storage::put('questionimages', $featureImage);
                $imageName = $featureImageName;
            }
            $answer = Answer::create([
                "exam_id" => $question->exam_id,
                "question_id" => $question->id,
                "iscorrect" => $k == ($request->choice_answer ?? 0),
                "title" => $ans,
                'image' => $imageName,
            ]);
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
                    "answer.*" => [ 'string', 'max:150','nullable'],
                    "file_answer.*" => [ 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048','nullable'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    // 'answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    // 'file_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            case 'full-mock-exam':
                $questiondat=$request->validate([ 
                    "category_id"=>['required'],
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*" => [ 'string', 'max:150','nullable'],
                    "file_answer.*" => [ 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048','nullable'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            case 'topic-test':
                $questiondat=$request->validate([ 
                    "category_id"=>['required'], 
                    "description"=>['required'],
                    // "duration"=>["required"],
                    "answer.*" => [ 'string', 'max:150','nullable'],
                    "file_answer.*" => [ 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048','nullable'],
                    "explanation"=>['nullable'],
                    "title_text"=>['nullable'],
                    "sub_question"=>['nullable'],
                ],[
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;
            
            default:
                $questiondat=$request->validate([ 
                    "category_id"=>['required'],
                    "sub_category_id"=>['required'],
                    "sub_category_set"=>['nullable'],
                    "description"=>['required'],
                    "duration"=>["required"],
                    "answer.*" => [ 'string', 'max:150','nullable'],
                    "file_answer.*" => [ 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048','nullable'],
                    "explanation"=>['nullable'],
                ],[
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;
        }
        $question->update($questiondat);
        $ansIds=[];

      
        $featureimages = $request->file('file_answer', []);
        foreach($request->answer as $k =>$ans){
            $answer=null;
            if(!empty($request->choice_answer_id[$k]??"")){
                $answer=Answer::find($request->choice_answer_id[$k]??"");
            }

             // Handle image upload if provided
             if (isset($featureimages[$k])) {
                $featureImage = $featureimages[$k];
                $featureImageName = "questionimages/" . $featureImage->hashName();
                Storage::put('questionimages', $featureImage);
                $imageName = $featureImageName;
            }
            if(empty($answer)){
                $answer=Answer::store([
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>$k==($request->choice_answer??0)?true:false,
                    "title"=>$ans,
                   'image' => $imageName,
                ]);

            }else{
                $data = [
                    "exam_id"=>$question->exam_id,
                    "question_id"=>$question->id,
                    "iscorrect"=>$k==($request->choice_answer??0)?true:false,
                    "title"=>$ans,
                ];
                if(isset($imageName)){
                    $data['image']=$imageName;
                }
                $answer->update($data);
            }
            $imageName = Null;
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
