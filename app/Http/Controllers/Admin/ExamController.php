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
        return view("admin.exam.index");
    }
    public function create(Request $request){
        return view("admin.exam.create");
    }
    public function show(Request $request,Exam $user){
        return view("admin.exam.show",compact('user'));
    }
    public function edit(Request $request,Exam $user){
        return view("admin.exam.edit",compact('user'));
    }
    public function update(Request $request,Exam $user){
        $userdat=$request->validate([
            "name"=>"required"
        ]);
        $user->update($userdat);
        
        return redirect()->route('admin.exam.index')->with("success","Exam updated success");
    }
}
