<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\HomeWorkQuestion;
use App\Models\User;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;
use App\Models\LiveClassPage;
use App\Models\RecordVideo;
use App\Models\TermAccess;
use Illuminate\Support\Facades\Auth;

class UserTermController extends Controller
{
    public function class_detail(Request $request){ 

       

        /**
        * @var User
        */
        $user=Auth::user(); 
        $term_names=[];

        $Class_detail = ClassDetail::whereIn('id',TermAccess::where('type','class-detail')->where('user_id',$user->id)->select('term_id'))->get();



        $live_class =  LiveClassPage::first(); 

        foreach ($Class_detail as $row) {
           
            $row->inner_url=route('live-class.privateclass.term', ['live'=>$user->slug,'class_detail'=>$row->slug]);
          
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function lesson_material(Request $request){ 

      

         /**
        * @var User
        */
        $user=Auth::user(); 
        $term_names=[];

        $LessonMaterial = LessonMaterial::whereIn('id',TermAccess::where('type','lesson-material')->where('user_id',$user->id)->select('term_id'))->get();





        foreach ($LessonMaterial as $row) {
          
            // $row->inner_url=route('admin.lesson-material.show', $row->slug);
            $row->inner_url=route('live-class.privateclass.lessonshow', ['live'=>$user->slug,'lesson_material'=>$row->slug]);
           
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function home_work(Request $request){ 

      

          /**
        * @var User
        */
        $user=Auth::user(); 
        $term_names=[];

        $HomeWork = HomeWork::whereIn('id',HomeWorkQuestion::select('home_work_id'))->whereIn('id',TermAccess::where('type','home-work')->where('user_id',$user->id)->select('term_id'))->get();;



        foreach ($HomeWork as $row) {
          
            // $row->inner_url=route('admin.home-work.show', $row->slug);

            $row->inner_url=route('home-work.show', $row->slug);
          
           
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function lesson_recording(Request $request){ 

     

         /**
        * @var User
        */
        $user=Auth::user(); 
        $term_names=[];

        $Lesson_Recording = LessonRecording::whereIn('id',RecordVideo::select('Lesson_Recording_id'))->whereIn('id',TermAccess::where('type','lesson-record')->where('user_id',$user->id)->select('term_id'))->get();

      
        foreach ($Lesson_Recording as $row) {
          
            $row->inner_url=route('lesson-record.show', $row->slug);
           
            $term_names[]=$row;
        }
        return $term_names;
    } 
}
