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

    public function destroy_class_detail(Request $request,$term_name)
    { 
        
        $Class_detail = ClassDetail::findSlug($term_name);

        $Class_detail->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Category deleted success"]);
        }        
        return redirect()->route('admin.term.index')->with("success","Term deleted success");
    }

    public function destroy_class_detail(Request $request,$term_name)
    { 
        
        $Class_detail = ClassDetail::findSlug($term_name);

        $Class_detail->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Category deleted success"]);
        }        
        return redirect()->route('admin.term.index')->with("success","Term deleted success");
    }

    public function destroy_class_detail(Request $request,$term_name)
    { 
        
        $Class_detail = ClassDetail::findSlug($term_name);

        $Class_detail->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Category deleted success"]);
        }        
        return redirect()->route('admin.term.index')->with("success","Term deleted success");
    }

    public function destroy_class_detail(Request $request,$term_name)
    { 
        
        $Class_detail = ClassDetail::findSlug($term_name);

        $Class_detail->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Category deleted success"]);
        }        
        return redirect()->route('admin.term.index')->with("success","Term deleted success");
    }

    public function show_table(Request $request)
    {
        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                    <a onclick="update_term(\''.route('admin.add_subcatecory', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>
                    <a onclick="update_term('."'".route('admin.term.edit_class', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                ';

                // if(empty($data->subcategories) || count($data->subcategories) == 0)
                // { 
                    $action.=  '<a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.term.destroy_class_detail",$data->slug).'" >
                            <img src="'.asset("assets/images/delete.svg").'" alt="">
                        </a> '; 
                // } 
          
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
                    <a onclick="update_term('."'".route('admin.term.edit_lesson_material', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
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
                    <a onclick="update_term('."'".route('admin.term.edit_home_work', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
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
                    <a onclick="update_term('."'".route('admin.term.edit_lesson_recording', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                ';
                return $action;
            })->buildTable();
        }

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));

    }

    public function edit_class(Request $request,$term_name){

        $ClassDetail = ClassDetail::findSlug($term_name);

        if($request->ajax()){
            $ClassDetail->updateUrl=route('admin.term.update_class_detail', $ClassDetail->slug);
            return response()->json($ClassDetail);
        }

    }

    public function edit_lesson_material(Request $request,$term_name){

        $LessonMaterial = LessonMaterial::findSlug($term_name);

        if($request->ajax()){
            $LessonMaterial->updateUrl=route('admin.term.update_lesson_material', $LessonMaterial->slug);
            return response()->json($LessonMaterial);
        }

    }

    public function edit_home_work(Request $request,$term_name){

        $Home_Work = HomeWork::findSlug($term_name);

        if($request->ajax()){
            $Home_Work->updateUrl=route('admin.term.update_home_work', $Home_Work->slug);
            return response()->json($Home_Work);
        }

    }

    public function edit_lesson_recording(Request $request,$term_name){

        $LessonRecording = LessonRecording::findSlug($term_name);

        if($request->ajax()){
            $LessonRecording->updateUrl=route('admin.term.update_lesson_recording', $LessonRecording->slug);
            return response()->json($LessonRecording);
        }

    }
    

    function update_class_detail(Request $request, $term_name)
    {

        $Class_detail = ClassDetail::findSlug($term_name);

        $request->validate([

            "term_name" => "required|unique:class_details,term_name,".$Class_detail->id,
        ]);

        if(!empty($Class_detail))
        {
           $Class_detail->term_name = $request->term_name;

           $Class_detail->save();

        }

        return response()->json(['success',"Term Name Updated Successfully"]);
    }

    function update_lesson_material(Request $request, $term_name)
    {

        $LessonMaterial = LessonMaterial::findSlug($term_name);

        $request->validate([

            "term_name" => "required|unique:lesson_materials,term_name,".$LessonMaterial->id,
        ]);

        if(!empty($LessonMaterial))
        {
           $LessonMaterial->term_name = $request->term_name;

           $LessonMaterial->save();

        }

        return response()->json(['success',"Term Name Updated Successfully"]);
    }

    function update_home_work(Request $request, $term_name)
    {

        $Home_Work = HomeWork::findSlug($term_name);

        $request->validate([

            "term_name" => "required|unique:home_works,term_name,".$Home_Work->id,
        ]);

        if(!empty($Home_Work))
        {
           $Home_Work->term_name = $request->term_name;

           $Home_Work->save();

        }

        return response()->json(['success',"Term Name Updated Successfully"]);
    }


    function update_lesson_recording(Request $request, $term_name)
    {

        $Lesson_Recording = LessonRecording::findSlug($term_name);

        $request->validate([

            "term_name" => "required|unique:lesson_recordings,term_name,".$Lesson_Recording->id,
        ]);

        if(!empty($Lesson_Recording))
        {
           $Lesson_Recording->term_name = $request->term_name;

           $Lesson_Recording->save();

        }

        return response()->json(['success',"Term Name Updated Successfully"]);
    }


}
