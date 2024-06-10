<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learn;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class QuestionBankController extends Controller
{
   
    use ResourceController;
    function __construct()
    {
        self::$model = Learn::class;
        self::$routeName = "admin.question-bank";
    } 
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        return view("admin.question-bank.index");
    }
}
