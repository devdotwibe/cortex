<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonRecording;
use App\Models\RecordVideo;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class LessonRecordController extends Controller
{
    use ResourceController; 
    public function show(Request $request,LessonRecording $lessonRecording){
        self::reset();
        self::$model = RecordVideo::class;
        self::$routeName = "admin.lesson-record"; 
        self::$defaultActions=['']; 
        if($request->ajax()){
            return $this->where('lesson_recording_id',$lessonRecording->id) 
                ->addAction(function($data)use($lessonRecording){
                    return '
                    <a href="'.route("admin.lesson-record.edit",["lesson_recording"=>$lessonRecording->slug,"record_video"=>$data->slug]).'" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                     <a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.lesson-record.destroy",["lesson_recording"=>$lessonRecording->slug,"record_video"=>$data->slug]).'">
                        <img src="'.asset("assets/images/delete.svg").'" alt="">
                    </a> 
                    ';
                })->addColumn('visibility',function($data)use($lessonRecording){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.lesson-record.visibility",["lesson_recording"=>$lessonRecording->slug,"record_video"=>$data->slug])."'".')" > 
                        </div>
                    '; 
                })
                ->buildTable(['description','visibility']);
        } 
        return view('admin.lesson-record.show',compact('lessonRecording'));
    }
    public function create(Request $request,LessonRecording $lessonRecording){ 
        return view('admin.lesson-record.create',compact('lessonRecording'));
    }
    public function edit(Request $request,LessonRecording $lessonRecording,RecordVideo $recordVideo){ 
        return view('admin.lesson-record.edit',compact('lessonRecording','recordVideo'));
    }    
    public function store(Request $request,LessonRecording $lessonRecording){ 
        $data=$request->validate([
            'title'=>['required'],
            'source_video'=>['required'],
        ]);
        $data['lesson_recording_id']=$lessonRecording->id;
        RecordVideo::store($data);
        $redirect=$request->redirect??route('admin.lesson-record.show',$lessonRecording->slug);
        return redirect($redirect)->with("success","Video has been successfully created");
    }
    public function update(Request $request,LessonRecording $lessonRecording, RecordVideo $recordVideo){ 
        $data=$request->validate([
            'title'=>['required'],
            'source_video'=>['required'],
        ]); 
        $recordVideo->update($data);
        $redirect=$request->redirect??route('admin.lesson-record.show',$lessonRecording->slug);
        return redirect($redirect)->with("success","Video has been successfully created");
    }
    public function destroy(Request $request,LessonRecording $lessonRecording, RecordVideo $recordVideo){
        $recordVideo->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Video has been deleted"]);
        }        
        return redirect()->route('admin.lesson-record.show',$lessonRecording->slug)->with("success","Video has been deleted");
    }

    public function visibility(Request $request,LessonRecording $lessonRecording, RecordVideo $recordVideo){
        $recordVideo->update(['visible_status'=>($recordVideo->visible_status??"")=="show"?"hide":"show"]);        
        if($request->ajax()){
            return response()->json(["success"=>" Question visibility change success"]);
        }        
        return redirect()->route('admin.lesson-record.show',$lessonRecording->slug)->with("success"," Question visibility change success");
    }
}
