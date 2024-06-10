<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionBankTopic;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankTopicController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model = QuestionBankTopic::class;
        self::$routeName = "admin.question-bank.topic";
    } 
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        return view("admin.question-bank.topic.index");
    }
    public function create(Request $request){
        return view("admin.question-bank.topic.create");
    }
    public function store(Request $request){
        $topicdat=$request->validate([
            "title"=>"required"
        ]);
        QuestionBankTopic::store($topicdat);        
        return redirect()->route('admin.question-bank.topic.index')->with("success","QuestionBankTopic updated success");
    }
    public function show(Request $request,QuestionBankTopic $topic){
        return view("admin.question-bank.topic.show",compact('topic'));
    }
    public function edit(Request $request,QuestionBankTopic $topic){
        return view("admin.question-bank.topic.edit",compact('topic'));
    }
    public function update(Request $request,QuestionBankTopic $topic){
        $topicdat=$request->validate([
            "title"=>"required"
        ]);
        $topic->update($topicdat);        
        return redirect()->route('admin.question-bank.topic.index')->with("success","QuestionBankTopic updated success");
    }
    public function destroy(Request $request,QuestionBankTopic $topic){ 
        $topic->delete();
        if($request->ajax()){
            return response()->json(["success"=>"QuestionBankTopic deleted success"]);
        }    
        return redirect()->route('admin.question-bank.topic.index')->with("success","QuestionBankTopic deleted success");
    }
}
