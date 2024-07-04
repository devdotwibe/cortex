<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
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

}
