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
                    <a href="'.route("admin.home-work.edit",["home_work"=>$homeWork->slug,"home_work_question"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                    ';
                })->addColumn('visibility',function($data)use($homeWork){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.home-work.visibility",["home_work"=>$homeWork->slug,"home_work_question"=>$data->slug])."'".')" > 
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
            return $this->where('home_work_id',$homeWork->id)->buildSelectOption('title');
        }  
        return view('admin.home-work.create',compact('homeWork'));
    }
    public function store(Request $request,HomeWork $homeWork){
        $data=$request->validate([
            'home_work_book_id'=>['required'],
            'description'=>['required'],
            'answer'=>['required'],
            'answer.*'=>['required'],
            'explanation'=>['required']
        ],[
            'answer.*.required'=>['The answer field is required.']
        ]);
        $data['home_work_id']=$homeWork->id;
        $data=HomeWorkQuestion::store($data);

        $redirect=$request->redirect??route('admin.home-work.show',$homeWork->slug);
        return redirect($redirect)->with("success","Question has been successfully created");
    }
    public function destroy(Request $request,HomeWork $homeWork,HomeWorkQuestion $homeWorkQuestion){
        $homeWorkQuestion->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Question has been deleted"]);
        }        
        return redirect()->route('admin.home-work.show',$homeWork->slug)->with("success","Question has been deleted");
    }
    public function storebooklet(Request $request){
        $data=$request->validate([
            'home_work'=>['required'],
            'title'=>['required'], 
        ]);
        $homeWork=HomeWork::findSlug($data['home_work']);
        $data['home_work_id']=$homeWork->id;
        HomeWorkBook::store($data);
        if($request->ajax()){
            return response()->json(["success"=>"Week Booklet has been successfully created"]);
        }        
        return redirect()->route('admin.live-class.private_class_create')->with("success","Week Booklet has been successfully created");
    }
    public function updatebooklet(Request $request,HomeWorkBook $homeWorkBook){
        $data=$request->validate([ 
            'title'=>['required'], 
        ]); 
        $homeWorkBook->update($data);
        if($request->ajax()){
            return response()->json(["success"=>"Week Booklet has been successfully created"]);
        }        
        return redirect()->route('admin.live-class.private_class_create')->with("success","Week Booklet has been successfully created");
    }
    public function showbooklet(Request $request,HomeWorkBook $homeWorkBook){
        $homeWorkBook->updateUrl=route('admin.home-work.updatebooklet',$homeWorkBook->slug);
        return $homeWorkBook;
    }
    public function destroybooklet(Request $request,HomeWorkBook $homeWorkBook){
        $homeWorkBook->delete();
        if($request->ajax()){
            return response()->json(["success"=>"{$homeWorkBook->title} has been deleted"]);
        }        
        return redirect()->route('admin.live-class.private_class_create')->with("success","{$homeWorkBook->title} has been deleted");
    }
    public function questionvisibility(Request $request,HomeWork $homeWork,HomeWorkQuestion $homeWorkQuestion){
        $homeWorkQuestion->update(['visible_status'=>($homeWorkQuestion->visible_status??"")=="show"?"hide":"show"]);        
        if($request->ajax()){
            return response()->json(["success"=>" Question visibility change success"]);
        }        
        return redirect()->route('admin.home-work.show',$homeWork->slug)->with("success"," Question visibility change success");
    }
}
