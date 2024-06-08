<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionBankSection;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankSectionController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model = QuestionBankSection::class;
        self::$routeName = "admin.question-bank.section";
    } 
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        return view("admin.question-bank.section.index");
    }
    public function create(Request $request){
        return view("admin.question-bank.section.create");
    }
    public function store(Request $request){
        $sectiondat=$request->validate([
            "title"=>"required"
        ]);
        QuestionBankSection::store($sectiondat);        
        return redirect()->route('admin.question-bank.section.index')->with("success","QuestionBankSection updated success");
    }
    public function show(Request $request,QuestionBankSection $section){
        return view("admin.question-bank.section.show",compact('section'));
    }
    public function edit(Request $request,QuestionBankSection $section){
        return view("admin.question-bank.section.edit",compact('section'));
    }
    public function update(Request $request,QuestionBankSection $section){
        $sectiondat=$request->validate([
            "title"=>"required"
        ]);
        $section->update($sectiondat);        
        return redirect()->route('admin.question-bank.section.index')->with("success","QuestionBankSection updated success");
    }

    public function destroy(Request $request,QuestionBankSection $chapter){ 
        $chapter->delete();        
        return redirect()->route('admin.question-bank.chapter.index')->with("success","QuestionBankChapter deleted success");
    }
}
