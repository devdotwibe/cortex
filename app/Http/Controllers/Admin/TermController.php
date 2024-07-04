<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;
use App\Models\LiveClassPage;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class TermController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=ClassDetail::class;

        self::$routeName="admin.term";

        self::$defaultActions=[''];

    }
    
   
    public function store(Request $request)
    {

        if($request->term_type ==='class_detail')
        {
            $request->validate([

                "term_name" => "required|unique:class_details,term_name",
            ]);
            
            $classdetail = new ClassDetail;

            $classdetail->term_name = $request->term_name;

            $classdetail->save();
            
            return response()->json(['success' => 'Term Added Successfully']);

        }
        elseif($request->term_type ==='lesson_material')
        {
            $request->validate([

                "term_name" => "required|unique:lesson_materials,term_name",
            ]);
            
            $LessonMaterial = new LessonMaterial;

            $LessonMaterial->term_name = $request->term_name;

            $LessonMaterial->save();
            
            return response()->json(['success' => 'Term Added Successfully']);

        }
        elseif($request->term_type ==='home_work')
        {
            $request->validate([

                "term_name" => "required|unique:home_works,term_name",
            ]);
            
            $HomeWork = new HomeWork;

            $HomeWork->term_name = $request->term_name;

            $HomeWork->save();
            
            return response()->json(['success' => 'Term Added Successfully']);

        }
        elseif($request->term_type ==='lesson_recording')
        {
            
            $request->validate([

                "term_name" => "required|unique:lesson_recordings,term_name",
            ]);
            
            $Lesson_recording = new LessonRecording;

            $Lesson_recording->term_name = $request->term_name;

            $Lesson_recording->save();
            
            return response()->json(['success' => 'Term Added Successfully']);

        }
        else
        {
            return response()->json(['error' => 'Failled']);
        }
      
    }

    public function show_table(Request $request)
    {
        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                    <a onclick="subcategorylist(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>
                    <a onclick="updatecategory('."'".route('admin.category.edit', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                ';
                return $action;
            })->buildTable();
        }

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));

    }

    public function show_table_lesson_material(Request $request)
    {

        self::reset();

        self::$model = LessonMaterial::class;
        self::$routeName="admin.term";

        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                    <a onclick="subcategorylist(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>
                    <a onclick="updatecategory('."'".route('admin.category.edit', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                ';
                return $action;
            })->buildTable();
        }

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));

    }

    public function show_table_home_work(Request $request)
    {
        self::reset();

        self::$model = HomeWork::class;
        self::$routeName="admin.term";

        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                    <a onclick="subcategorylist(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>
                    <a onclick="updatecategory('."'".route('admin.category.edit', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                ';
                return $action;
            })->buildTable();
        }

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));

    }

    public function show_table_lesson_recording(Request $request)
    {

        self::reset();

        self::$model = LessonRecording::class;
        self::$routeName="admin.term";

        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                    <a onclick="subcategorylist(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>
                    <a onclick="updatecategory('."'".route('admin.category.edit', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                ';
                return $action;
            })->buildTable();
        }

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));

    }

}
