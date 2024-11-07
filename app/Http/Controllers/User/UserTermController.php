<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;

class UserTermController extends Controller
{
    public function class_detail(Request $request){ 

        $term_names=[];

        $Class_detail = ClassDetail::get();

        foreach ($Class_detail as $row) {
           
            $row->inner_url=route('live-class.privateclass.term', $row->slug);
            
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function lesson_material(Request $request){ 

        $term_names=[];

        $LessonMaterial = LessonMaterial::get();

        foreach ($LessonMaterial as $row) {
          
            $row->inner_url=route('admin.lesson-material.show', $row->slug);
           
            $term_names[]=$row;
        }
        return $term_names;
    } 

    public function home_work(Request $request){ 

        $term_names=[];

        $HomeWork = HomeWork::get();

        foreach ($HomeWork as $row) {
          
            $row->inner_url=route('admin.home-work.show', $row->slug);
           
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
