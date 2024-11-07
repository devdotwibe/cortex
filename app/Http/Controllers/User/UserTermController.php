<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\User;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;
use App\Models\LiveClassPage;
use Illuminate\Support\Facades\Auth;

class UserTermController extends Controller
{
    public function class_detail(Request $request){ 

        $term_names=[];

        $Class_detail = ClassDetail::get();

        $live_class =  LiveClassPage::first(); 

        /**
        * @var User
        */
        $user=Auth::user(); 

        foreach ($Class_detail as $row) {
           
            $row->inner_url=route('live-class.privateclass.term', ['live'=>$user->slug,'class_detail'=>$row->slug]);
          
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function lesson_material(Request $request){ 

        $term_names=[];

        $LessonMaterial = LessonMaterial::get();

         /**
        * @var User
        */
        $user=Auth::user(); 



        foreach ($LessonMaterial as $row) {
          
            // $row->inner_url=route('admin.lesson-material.show', $row->slug);
            $row->inner_url=route('homework.show',$row->slug);
           
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function home_work(Request $request){ 

        $term_names=[];

        $HomeWork = HomeWork::get();

          /**
        * @var User
        */
        $user=Auth::user(); 



        foreach ($HomeWork as $row) {
          
            $row->inner_url=route('admin.home-work.show', $row->slug);

            $row->inner_url=route('live-class.privateclass.lessonshow', ['live'=>$user->slug,'lesson_material'=>$row->slug]);
           
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function lesson_recording(Request $request){ 

        $term_names=[];

        $Lesson_Recording = LessonRecording::get();

        foreach ($Lesson_Recording as $row) {
          
            $row->inner_url=route('admin.lesson-record.show', $row->slug);
           
            $term_names[]=$row;
        }
        return $term_names;
    } 
}
