<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Stripe\Stripe;

class ExamController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=Exam::class;
        self::$routeName="admin.exam";
    } 
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        $totalexam=$this->totalCount();
        return view("admin.exam.index",compact('totalexam'));
    }
    public function create(Request $request){
        return view("admin.exam.create");
    }
    public function show(Request $request,Exam $exam){
        return view("admin.exam.show",compact('exam'));
    }
    public function edit(Request $request,Exam $exam){
        return view("admin.exam.edit",compact('exam'));
    }
    public function update(Request $request,Exam $exam){
        $examdat=$request->validate([
            "name"=>"required"
        ]);
        $exam->update($examdat);
        
        return redirect()->route('admin.exam.index')->with("success","Exam updated success");
    }

    public function destroy(Request $request,Exam $exam){ 
        $exam->delete();        
        return redirect()->route('admin.question-bank.chapter.index')->with("success","QuestionBankChapter deleted success");
    }
}
