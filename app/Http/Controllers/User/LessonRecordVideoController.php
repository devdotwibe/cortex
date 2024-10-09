<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LessonRecording;
use App\Models\RecordVideo;
use App\Models\TermAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonRecordVideoController extends Controller
{
    public function index(Request $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $lessonRecordings=LessonRecording::whereIn('id',TermAccess::where('type','lesson-record')->where('user_id',$user->id)->select('term_id'))->get();
        return view('user.lesson-record.index',compact('lessonRecordings','user'));
    }
    public function show(Request $request,LessonRecording $lessonRecording){
        /**
         * @var User
         */
        $user=Auth::user();

        if(TermAccess::where('type','lesson-record')->where('term_id',$lessonRecording->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        $recordVideos=RecordVideo::where('lesson_recording_id',$lessonRecording->id)->get();
        return view('user.lesson-record.show',compact('lessonRecording','recordVideos'));
    }
}
