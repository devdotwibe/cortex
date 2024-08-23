<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ReportPost;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class PostReportController extends Controller
{
    use ResourceController;

    public function __construct(){
        self::$model=ReportPost::class;
        self::$defaultActions=['delete','view'];
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
    public function show(Request $request,ReportPost $reportPost){
        $post=Post::find($reportPost->post_id);
        $user=User::find($reportPost->user_id);
        $postUser=User::find($post->user_id);
        return view('admin.report-post.show',compact('postUser','post','user','reportPost'));
    }
    public function banuser(Request $request,User $user){
        $user->update([
            'post_status'=>"banned"
        ]); 
        if($request->ajax()){
            return response()->json(["success"=>"User has been banned"]);
        }        
        return redirect()->back()->with("success","User has been banned");
    }
    public function hidepost(Request $request,Post $post){
        $post->update([
            'visible_status'=>"hide"
        ]); 
        print_r($post);
        // if($request->ajax()){
        //     return response()->json(["success"=>"Post has been blocked"]);
        // }        
        // return redirect()->back()->with("success","Post has been blocked");
    }
    public function destroy(Request $request,ReportPost $reportPost){
        $reportPost->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Report has been deleted"]);
        }        
        return redirect()->route('admin.report-post.index')->with("success","Report has been deleted");
    }
}
