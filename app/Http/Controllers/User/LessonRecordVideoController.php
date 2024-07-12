<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LessonRecording;
use App\Models\RecordVideo;
use Illuminate\Http\Request;

class LessonRecordVideoController extends Controller
{
    public function index(Request $request){
        $lessonRecordings=LessonRecording::all();
        return view('user.lesson-record.index',compact('lessonRecordings'));
    }
    public function show(Request $request,LessonRecording $lessonRecording){
        $recordVideos=RecordVideo::where('lesson_recording_id',$lessonRecording->id)->get();
        return view('user.lesson-record.show',compact('lessonRecording','recordVideos'));
    }
}
