<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportPost;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class PostReportController extends Controller
{
    use ResourceController;

    public function __construct(){
        self::$model=ReportPost::class;
        self::$defaultActions=['delete'];
        self::$routeName="admin.community.report";
    }
    public function index(Request $request){
        if($request->ajax()){
            return $this->addColumn('post',function($data){
                return optional($data->post)->title;
            })->buildTable();
        }
        return view('admin.report-post.index');
    }
    public function destroy(Request $request,ReportPost $reportPost){
        $reportPost->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Report has been deleted"]);
        }        
        return redirect()->route('admin.report-post.index')->with("success","Report has been deleted");
    }
}
