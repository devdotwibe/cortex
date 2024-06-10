<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionBankChapter;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankChapterController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model = QuestionBankChapter::class;
        self::$routeName = "admin.question-bank.chapter";
    } 
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        return view("admin.question-bank.chapter.index");
    }
    public function create(Request $request){
        return view("admin.question-bank.chapter.create");
    }
    public function store(Request $request){
        $chapterdat=$request->validate([
            "title"=>"required"
        ]);
        QuestionBankChapter::store($chapterdat);        
        return redirect()->route('admin.question-bank.chapter.index')->with("success","QuestionBankChapter updated success");
    }
    public function show(Request $request,QuestionBankChapter $chapter){
        return view("admin.question-bank.chapter.show",compact('chapter'));
    }
    public function edit(Request $request,QuestionBankChapter $chapter){
        return view("admin.question-bank.chapter.edit",compact('chapter'));
    }
    public function update(Request $request,QuestionBankChapter $chapter){
        $chapterdat=$request->validate([
            "title"=>"required"
        ]);
        $chapter->update($chapterdat);        
        return redirect()->route('admin.question-bank.chapter.index')->with("success","QuestionBankChapter updated success");
    }
    public function destroy(Request $request,QuestionBankChapter $chapter){ 
        $chapter->delete();
        if($request->ajax()){
            return response()->json(["success"=>"QuestionBankChapter deleted success"]);
        }
        return redirect()->route('admin.question-bank.chapter.index')->with("success","QuestionBankChapter deleted success");
    }
}
