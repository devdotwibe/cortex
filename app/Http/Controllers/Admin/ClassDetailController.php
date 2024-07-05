<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
use App\Models\SubClassDetail;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class ClassDetailController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=SubClassDetail::class;
        self::$routeName="admin.class-detail";
        self::$defaultActions=[''];

    }
   

    public function show(Request $request , $slug)
    {  
        
        $class_detail = ClassDetail::findSlug($slug);

        if($request->ajax()){  

            return  $this->where('class_detail_id',$class_detail->id)

            ->addAction(function($data){ 

                $action= ' 
                        <a onclick="update_sub_class('."'".route('admin.class-detail.edit_sub_class', $data->slug)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>
                    ';

                    // if(empty($data->subcategories) || count($data->subcategories) == 0)
                    // { 
                        $action.=  '<a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.class-detail.destroy_sub_class",$data->slug).'" >
                                <img src="'.asset("assets/images/delete.svg").'" alt="">
                            </a> '; 
                    // } 
            
                    return $action;
                })

                ->buildTable();
        } 


        return view('admin.class-detail.view',compact('class_detail'));
    }

    public function store(Request $request)
    { 
        
        $request->validate([

            "meeting_id" => "required",
            "passcode" => "required",
            "zoom_link" => "required",
        ]);

        $sub_class_detail = new SubClassDetail;

        $sub_class_detail->meeting_id = $request->meeting_id;
        $sub_class_detail->passcode = $request->passcode;
        $sub_class_detail->zoom_link = $request->zoom_link;

        $sub_class_detail->class_detail_id = $request->class_detail_id;

        $sub_class_detail->save();

        return response()->json(['success' => 'Sub Class Details Added Successfully']);

    }


    public function destroy_sub_class(Request $request,$subclass)
    { 
        
        $sub_detail = SubClassDetail::findSlug($subclass);

        $sub_detail->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Sub Class Details deleted success"]);
        }        
        return redirect()->back();
    }

    public function edit_sub_class(Request $request,$subclass){

        $sub_detail = SubClassDetail::findSlug($subclass);

        if($request->ajax()){

            $sub_detail->updateUrl=route('admin.class-detail.update_sub_class', $sub_detail->slug);

            return response()->json($sub_detail);
        }

        return redirect()->back();
    }

    function update_sub_class(Request $request, $subclass)
    {

        $sub_detail = SubClassDetail::findSlug($subclass);

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
