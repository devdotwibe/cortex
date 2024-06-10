<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            "category_id"=>['required'],
            "sub_category_id"=>['required'],
            "title"=>['required'],
        ]);
        Question::store($questiondat);
        $redirect=$request->redirect??route('admin.question.index');
        return redirect($redirect)->with("success","QuestionBankSection updated success");
    }
}
