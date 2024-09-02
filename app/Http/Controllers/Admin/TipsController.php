<?php

namespace App\Http\Controllers\admin;

use App\Models\Tips;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Trait\ResourceController;

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

    // public function create(Request $request,$id){

    //     $tip = Category::find($id);

    //     return view("admin.tip.create",compact('tip'));
    // }


    public function create(Request $request, $id)
{
    $tip = Category::find($id);
    $tips = Tips::where('category_id', $id)->get();

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

            'tip' => 'nullable|string|max:65535',
            'advice' => 'nullable|string|max:65535',
        ]);

        $tips = new Tips;

        $tips->category_id =$id;
        $tips->tip =$request->tip;
        $tips->advice =$request->advice;
        $tips->save();


        // Redirect or respond as needed
        return back()->with('success', 'Tip and advice saved successfully.');

    }
}


