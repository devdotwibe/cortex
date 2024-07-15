<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveClassPage;
use App\Models\PrivateClass;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LiveClassController extends Controller
{
    use ResourceController;
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
    public function private_class_request(Request $request){
        if($request->ajax()){
            self::reset();
            self::$model=PrivateClass::class;
            self::$defaultActions=[''];
            return $this->addAction(function($data){
                $action="";
                if($data->status=="pending"){
                    $action.='
                    <a  class="btn btn-danger btn-sm" href="'.route("admin.live-class.request.reject",$data->slug).'" > Reject </a> 
                    <a  class="btn btn-success btn-sm" href="'.route("admin.live-class.request.accept",$data->slug).'" > Accept </a> 
                    ';
                }
                $action.='
                 <a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.live-class.request.destroy",$data->slug).'">
                    <img src="'.asset("assets/images/delete.svg").'" alt="">
                </a> 
                ';
                return $action;
            })->addColumn('timeslottext',function($data){
                return implode('<br> ',$data->timeslot);
            })->addColumn('statushtml',function($data){
                switch ($data->status) {
                    case 'approved':
                        return '<input type="checkbox" data-toggle="switchbutton" checked data-onlabel="Ready" data-offlabel="Not Ready" data-onstyle="success" data-offstyle="danger">'; 
                    case 'pending';
                        return '<span class="badge text-bg-warning">'.ucfirst($data->status).'</span>';
                    case 'rejected';
                        return '<span class="badge text-bg-danger">'.ucfirst($data->status).'</span>';
                    default:
                        return '<span class="badge text-bg-secondary">'.ucfirst($data->status).'</span>'; 
                } 
            })->buildTable(['timeslottext','statushtml']);
        }
        $live_class =  LiveClassPage::first();
        return view('admin.live-class.private-class-request',compact('live_class'));

    }
    public function private_class_request_export(Request $request){
        if($request->ajax()){ 
            return PrivateClass::select('`email` as `Email`','`full_name` as `Full Name`','`parent_name` as `Parent Name`','`phone as `Phone`',DB::raw("REPLACE(REPLACE(JSON_EXTRACT(timeslot, '$'), '\"', ''), '[', '') as `Available Timeslote`"),'`status` as `Status`')->get();
        }
    }
    public function private_class_request_accept(Request $request,PrivateClass $privateClass){
        $privateClass->update(['status'=>"approved"]);

        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully approved"]);
        }  
        return redirect()->back()->with('success','Request has been successfully approved');
    }
    public function private_class_request_reject(Request $request,PrivateClass $privateClass){
        $privateClass->update(['status'=>"rejected"]);

        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully rejected"]);
        }  
        return redirect()->back()->with('success','Request has been successfully rejected');
    }
    public function private_class_request_destroy(Request $request,PrivateClass $privateClass){
        $privateClass->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully deleted"]);
        }  
        return redirect()->back()->with('success','Request has been successfully deleted');
    }

}
