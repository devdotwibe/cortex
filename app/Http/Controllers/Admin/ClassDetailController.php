<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class ClassDetailController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=ClassDetail::class;
        self::$routeName="admin.class-detail";
        self::$defaultActions=[''];

    }
   

    public function show(Request $request , $slug)
    {  
        
        $class_detail = ClassDetail::findSlug($slug);

        // if($request->ajax()){  

        //     return  $this->where('exam_id',$exam->id)->where('category_id',$setname->category_id)->where('sub_category_id',$setname->sub_category_id)->where('sub_category_set',$setname->id)->addAction(function($data)use($setname){
        //             return '
        //             <a href="'.route("admin.question-bank.edit",["setname"=>$setname->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
        //                 <img src="'.asset("assets/images/edit.svg").'" alt="">
        //             </a>
        //             ';
        //         })->addColumn('visibility',function($data){
        //             return '                
        //                 <div class="form-check ">
        //                     <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.question.visibility",$data->slug)."'".')" > 
        //                 </div>
        //             ';
        //         })
        //         ->buildTable(['description','visibility']);
        // } 

        // $category=Category::find($setname->category_id);
        // $subcategory=SubCategory::find($setname->sub_category_id);

        return view('admin.class-detail.view',compact('class_detail'));
    }


}
