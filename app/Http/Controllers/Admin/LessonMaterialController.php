<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonMaterial;
use App\Models\SubLessonMaterial;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonMaterialController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=SubLessonMaterial::class;
        self::$routeName="admin.lesson-material";
        self::$defaultActions=[''];

    }
   

    public function show(Request $request , $slug)
    {  
        
        $lession_material = LessonMaterial::findSlug($slug);

        if($request->ajax()){  

            return  $this->where('lesson_material_id',$lession_material->id)

            ->addAction(function($data){ 

                $action= ' 
                        <a onclick="update_lesson_material('."'".route('admin.class-detail.edit_sub_class', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                    ';

                    // if(empty($data->subcategories) || count($data->subcategories) == 0)
                    // { 
                        $action.=  '<a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.lesson-material.destroy_lesson_material",$data->slug).'" >
                                <img src="'.asset("assets/images/delete.svg").'" alt="">
                            </a> '; 
                    // } 
            
                    return $action;
                })

                ->buildTable();
        } 


        return view('admin.lesson-material.view',compact('lession_material'));
    }


    public function store(Request $request)
    { 
        
        $request->validate([

            "pdf_name" => "required",
            "pdf_file" => "required",

        ]);

        $sub_lesson = new SubLessonMaterial;

        $sub_lesson->pdf_name = $request->pdf_name;
       
        
        if ($request->hasFile('pdf_file')) {

            $imageName = "";

            $avathar = "Lesson-Materials";

            $file = $request->file('pdf_file');

            $imageName = $avathar . "/" . $file->hashName();

            Storage::put("{$avathar}", $file);

            $sub_lesson->pdf_file = $imageName;
        
        }

        $sub_lesson->lesson_material_id = $request->lesson_material_id;

        $sub_lesson->save();

        return response()->json(['success' => 'Lesson Materials Details Added Successfully']);

    }


    public function destroy_lesson_material(Request $request,$lesson)
    { 
        
        $sub_lesson = SubLessonMaterial::findSlug($lesson);

        $sub_lesson->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Sub Lesson Material Details deleted success"]);
        }        
        return redirect()->back();
    }

    public function edit_sub_class(Request $request,$subclass){

        $sub_detail = SubLessonMaterial::findSlug($subclass);

        if($request->ajax()){

            $sub_detail->updateUrl=route('admin.class-detail.update_sub_class', $sub_detail->slug);

            return response()->json($sub_detail);
        }

        return redirect()->back();
    }

    function update_sub_class(Request $request, $subclass)
    {

        $sub_detail = SubLessonMaterial::findSlug($subclass);

        $request->validate([

            "meeting_id" => "required",
            "passcode" => "required",
            "zoom_link" => "required",
        ]);

        if(!empty($sub_detail))
        {
           $sub_detail->meeting_id = $request->meeting_id;

           $sub_detail->passcode = $request->passcode;
           $sub_detail->zoom_link = $request->zoom_link;

           $sub_detail->save();

        }

        return response()->json(['success'=>"Sub Class Details Updated Successfully"]);
    }

}
