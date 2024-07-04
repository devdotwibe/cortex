<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveClassPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LiveClassController extends Controller
{
    public function index()
    {

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.index',compact('live_class'));
    }

    public function store(Request $request)
    {
        $live_class = LiveClassPage::first();

        if(empty( $live_class))
        {
            $live_class = new LiveClassPage;
            
        }

        if(!empty($request->class_title_1))
        {
            $live_class->class_title_1 = $request->class_title_1;
        }

        if(!empty($request->class_title_2))
        {
            $live_class->class_title_2 = $request->class_title_2;
        }

        if(!empty($request->class_description_1))
        {
            $live_class->class_description_1 = $request->class_description_1;
        }

        if(!empty($request->class_description_2))
        {
            $live_class->class_description_2 = $request->class_description_2;
        }
       

        if ($request->hasFile('class_image_1')) {

            $imageName = "";

            $avathar = "Live-Class";

            $file = $request->file('class_image_1');

            $imageName = $avathar . "/" . $file->hashName();

            Storage::put("{$avathar}", $file);

            $live_class->class_image_1 = $imageName;
        
        }

        if ($request->hasFile('class_image_2')) {

            $imageName = "";

            $avathar = "Live-Class";

            $file = $request->file('class_image_2');

            $imageName = $avathar . "/" . $file->hashName();

            Storage::put("{$avathar}", $file);

            $live_class->class_image_2 = $imageName;
        
        }

        $live_class->save();

        return redirect()->back()->with('success','Live Teaching Updated Successsfully');
    }

    public function private_class(Request $request)
        {
            $request->validate([

                "private_class" => "required",
            ]);


            $live_class = LiveClassPage::first();

            if(empty( $live_class))
            {
                $live_class = new LiveClassPage;
            }

            $live_class->private_class = $request->private_class;

            $live_class->save();

            return redirect()->back()->with('success','Updated Successfully');

        }


        public function intensive_class(Request $request)
        {
            $request->validate([

                "intensive_class" => "required",
            ]);


            $live_class = LiveClassPage::first();

            if(empty( $live_class))
            {
                $live_class = new LiveClassPage;
            }

            $live_class->intensive_class = $request->intensive_class;
           
            $live_class->save();

            return redirect()->back()->with('success','Updated Successfully');

        }

    public function private_class_create()
    {

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));
    }

}
