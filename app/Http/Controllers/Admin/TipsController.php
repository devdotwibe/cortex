<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tips;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Yajra\DataTables\Facades\DataTables;

class TipsController extends Controller
{
    use ResourceController;

    public function index(Request $request){
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.tips";
        $categorys=$this->buildResult();

        return view("admin.tip.index",compact('categorys'));
    }




    public function create(Request $request, $id)
    {
        $tip = Category::find($id);
        $tips = Tips::where('category_id', $id);

        if ($request->ajax()) {
            return DataTables::of($tips)
                ->addColumn("action", function ($data) use($id) {
                    return
                        


                        '<a onclick="delsubfaq('."'".route('admin.tip.del_tip', $data->id)."'".')" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                        </span>
                    </a> '.


                       

                        '<a href="' . route('admin.tip.edit_subfaq', ['tip'=>$data->id,'cat_id'=>$id]) . '" data-id="'. $id.'" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                          <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                        </span>
                    </a>';

                    

                })
                ->addColumn("tips", function ($data) {
                    return strip_tags($data->tip); // Strip HTML tags from the tip
                })
                ->addColumn("advices", function ($data) {
                    return strip_tags($data->advice); // Strip HTML tags from the advice
                })
                ->addIndexColumn()
                ->rawColumns(['action','tips','advices'])
                ->make(true);
        }

        return view("admin.tip.create", compact('tip', 'tips'));
    }


    public function storetip(Request $request,$id){

        //$tip = Category::find($id);
        $tip = Category::find($id);

        return view("admin.tip.storetip",compact('tip'));
    }

    public function store(Request $request,$id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([

            'tip' => 'required|nullable|string|max:500',
            'advice' => 'required|nullable|string|max:2500',
        ]);

        $tips = new Tips;

        $tips->category_id =$id;
        $tips->tip =$request->tip;
        $tips->advice =$request->advice;
        $tips->save();


        // Redirect or respond as needed
        // return back()->with('success', 'Tip and advice saved successfully.');
        return redirect()->route('admin.tip.create', $id)->with('success', 'Tip and advice saved successfully.');

    }


    public function edit_subfaq($id)
{
    $tip = Tips::findOrFail($id);

    return view('admin.tip.edit', compact('tip'));
}



public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'tip' => 'nullable|string|max:65535',
        'advice' => 'nullable|string|max:65535',
    ]);

    // Find the tip by ID
    $tip = Tips::findOrFail($id);

    // Update the tip and advice fields
    $tip->tip = $request->input('tip');
    $tip->advice = $request->input('advice');
    $tip->save();

    // Redirect or respond as needed
    return redirect()->route('admin.tip.create', $tip->category_id)->with('success', 'Tip and advice updated successfully.');
}


public function del_tip(Request $request,Tips $tip)
{
    $tip->delete();

    return redirect()->back()->with("success","Tips and Advise deleted successfully");
}




}


