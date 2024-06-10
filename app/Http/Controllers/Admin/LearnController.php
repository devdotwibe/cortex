<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learn;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Learn::class;
        self::$routeName="admin.learn";
    }
    
    function index(Request $request)
    {
        if($request->ajax()){
            return $this->addAction(function($data){
              return  "<a>".$data->slug."</a>";
            })->buildTable();
        }

        return view('admin.learn.index');
    }

    function store(Request $request)
    {
       
        $learn_data = $request->validate([

            "subject"=>"required",
        ]);
        
        $learn = new Learn;

        $learn->store($learn_data);
        
        return redirect()->back()->with('success',"Subject Added Successfully");
    }

    public function show(Request $request,Learn $learn){

        // dd($learn->slug);
        
        return view("admin.learn.show",compact('learn'));

    }

    public function destroy(Request $request,Learn $exam){ 
        $exam->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Learn deleted success"]);
        }        
        return redirect()->route('admin.learn.index')->with("success","QuestionBankChapter deleted success");
    }

}

