<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            
            $faq = FaqCategory::where('id','>',0)->orderBy('id', 'asc');

            return DataTables::of($faq)

            ->addColumn("action", function ($data) {

                return

                '<a onclick="addsubfaq(\''.route('admin.faq.add_subfaq', $data->id).'\', \''.$data->id.'\')" class="btn btn-icons view_btn">Add</a>'.
               

  '<a onclick="updatefaq('."'".route('admin.faq.edit_faq', $data->id)."'".')"  class="btn btn-icons edit_btn">
    <span class="adminside-icon">
        <img src="'.asset('assets/images/icons/iconamoon_edit.svg').'" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="'.asset('assets/images/iconshover/iconamoon_edit-yellow.svg').'" alt="Edit Active">
    </span>
</a>'.





                '<a onclick="delfaq('."'".route('admin.faq.del_faq', $data->id)."'".')"  class="btn btn-icons edit_btn">
                <span class="adminside-icon">
                    <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                </span>
                <span class="adminactive-icon">
                    <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active">
                </span>
            </a>'; 


            })


            ->addIndexColumn()
            ->rawColumns([
                'action'
            ])

            ->make(true);

        }

        return view('admin.faq.index');
    }

    public function store(Request $request)
{
    $options_data = $request->validate([
        "name" => "required|unique:faq_categories,name", 
    ]);

    $option = new FaqCategory;

    // Assign the validated data to the model's properties
    $option->name = $request->name;
    
    // Save the model to the database
    $option->save();
    
    return response()->json(['success' => 'Module Added Successfully']);
}
public function edit_faq(Request $request,FaqCategory $faq){
    if($request->ajax()){
        $faq->updateUrl=route('admin.faq.update_faq', $faq->id);
        return response()->json($faq);
    }
}

function update_faq(Request $request, $id)
        {

            $faq = FaqCategory::find($id);

            $edit_data = $request->validate([

                "name" => "required|unique:faq_categories,name,".$faq->id,
            ]);

            if(!empty($faq))
            {
               $faq->update($edit_data);

            }

            return response()->json(['success',"Faq Updated Successfully",'type'=>'faq']);

        }

        public function destroy_faq(Request $request,FaqCategory $faq)
    { 
        
        // print_r($category);

        $faq->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Faq deleted success"]);
        }        
        return redirect()->route('admin.faq.index')->with("success","Faq deleted success");
    }

    public function del_faq(Request $request,FaqCategory $faq)
    {
        Faq::where('faq_category_id', $faq->id)->delete();
        
        $faq->delete();

        return redirect()->back()->with("success","Faq deleted success");
    }


}
