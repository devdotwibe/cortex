<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\HomeWork;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class HomeWorkController extends Controller
{
    use ResourceController; 
    public function show(Request $request,HomeWork $homeWork){
        self::reset();
        self::$model = HomeWorkQuestion::class;
        self::$routeName = "admin.home-work"; 
        self::$defaultActions=["delete"]; 
        if($request->ajax()){
            return $this->where('home_work_id',$homeWork->id) 
                ->addAction(function($data)use($homeWork){
                    return '
                    <a href="'.route("admin.home-work.edit",["home_work"=>$homeWork->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    ';
                })->addColumn('visibility',function($data)use($homeWork){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.home-work.visibility",$data->slug)."'".')" > 
                        </div>
                    '; 
                })
                ->buildTable(['description','visibility']);
        } 
        return view('admin.home-work.show',compact('homeWork'));
    }
    public function create(Request $request,HomeWork $homeWork){
        if($request->ajax()){
            self::reset();
            self::$model = HomeWorkBook::class; 
            return $this->where('home_work_id',$homeWork->id)->buildSelectOption();
        }  
        return view('admin.home-work.create',compact('homeWork'));
    }
    public function questionvisibility(Request $request,HomeWork $homeWork,HomeWorkQuestion $homeWorkQuestion){
        $homeWorkQuestion->update(['visible_status'=>($homeWorkQuestion->visible_status??"")=="show"?"hide":"show"]);        
        if($request->ajax()){
            return response()->json(["success"=>"Learn visibility change success"]);
        }        
        return redirect()->route('admin.home-work.show',$homeWork->slug)->with("success","Learn visibility change success");
    }
}
