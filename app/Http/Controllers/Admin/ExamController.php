<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
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
            self::$defaultActions=["edit","delete"]; 
            return $this->addAction(function($data){
                return '
                <a href="'.route("admin.full-mock-exam.index",["exam"=>$data->slug]).'" class="btn btn-icons view_btn">
                    <img src="'.asset("assets/images/view.svg").'" alt="">
                </a>
                ';
            })->where("name","full-mock-exam")->buildTable();
        }
        $totalexam=$this->where("name","full-mock-exam")->totalCount();
        return view("admin.exam.index",compact('totalexam'));
    }
    public function create(Request $request){
        return view("admin.exam.create");
    }
    public function store(Request $request){
        $examdat=$request->validate([
            "title"=>"required"
        ]);
        $examdat['name']="full-mock-exam";
        $exam=Exam::store($examdat);        
        return redirect()->route('admin.exam.index')->with("success","Exam updated success");
    }
    public function show(Request $request,Exam $exam){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        self::$defaultActions=["delete"];

        if($request->ajax()){
            return $this->where('exam_id',$exam->id) 
                ->addAction(function($data)use($exam){
                    return '
                    <a href="'.route("admin.full-mock-exam.edit",["exam"=>$exam->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    ';
                })
                ->buildTable(['description']);
        } 
        return view("admin.exam.show",compact('exam'));
    }
    public function edit(Request $request,Exam $exam){
        return view("admin.exam.edit",compact('exam'));
    }
    public function update(Request $request,Exam $exam){
        $examdat=$request->validate([
            "title"=>"required"
        ]);
        $exam->update($examdat);
        
        return redirect()->route('admin.exam.index')->with("success","Exam updated success");
    }

    public function destroy(Request $request,Exam $exam){ 
        $exam->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Exam deleted success"]);
        }        
        return redirect()->route('admin.exam.index')->with("success","QuestionBankChapter deleted success");
    }
}
