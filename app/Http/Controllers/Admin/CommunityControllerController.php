<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPolls;
use App\Models\Poll;
use App\Models\AdminPost;
use App\Models\AdminPoll;
use App\Models\PollOption;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommunityControllerController extends Controller
{ 
    
    public function index(Request $request){ 
        if($request->ajax()){   
            $posts=Post::where('id','>',0)->orderBy('id','DESC')->paginate();
            $results=[];
            foreach ($posts->items() as $row) { 
                $options=[];
                $tvotes=$row->pollOption->sum('votes');
                foreach($row->pollOption as $opt){
                    $options[]=[
                        "slug"=>$opt->slug,
                        "option"=>$opt->option,
                        "votes"=>$opt->votes,
                        'percentage'=>$tvotes>0?round(($opt->votes*100)/$tvotes,2):0,
                    ];
                }
                $results[]=[
                    "slug"=>$row->slug,
                    "title"=>$row->title,
                    "type"=>$row->type,
                    "description"=>$row->description,
                    "likes"=>$row->likes()->count(),
                    "comments"=>$row->comments()->whereNull('post_comment_id')->count(),
                    "image"=>$row->image,
                    "video"=>$row->video,
                    "status"=>$row->status,
                    "poll"=>$options,
                    "showUrl"=>route('admin.community.post.show',$row->slug),
                    "createdAt"=>$row->created_at->diffInMinutes(now())>1? $row->created_at->diffForHumans(now(), true)." ago":'Just Now',
                    "user"=>[
                        "name"=>optional($row->user)->name
                    ],
                    "editUrl"=>route('admin.community.post.edit',$row->slug),
                     
                ];
            }
            return [ 
                'current_page' => $posts->currentPage(),
                'total_pages' => $posts->lastPage(),
                'total_items' => $posts->total(),
                'items_per_page' => $posts->perPage(),
                'data' => $results, 
                'prev' => $posts->previousPageUrl(),
                'next' => $posts->nextPageUrl()
            ];
        } 
        return view('admin.community.index');
    }
    public function create(Request $request){
        return view('admin.community.create');
    }
    public function store(Request $request){ 
        $type=$request->type??"post";
        if($type=="post"){
            $data=$request->validate([
                'title'=>["required","max:255"],
                'type'=>["required"],
                'description'=>["required"], 
            ]);
        }else{

            $data=$request->validate([
                'title'=>["required","max:255"],
                'type'=>["required"], 
                'option'=>["required",'array','min:2'],
                'option.*'=>["required",'max:255'],
            ],[
                'option.required'=>"This field is required",
                'option.*.required'=>"This field is required",
            ]);
        }
  
        $data['status']="publish";
        $post=Post::store($data);
        if($request->type=="poll"){
            foreach ($request->input('option',[]) as $k=>$v) {
                PollOption::store([
                    'option'=>$v,
                    'post_id'=>$post->id
                ]);
            }
        }
        return redirect()->route('admin.community.index')->with('success',"Post published");
    }

    public function show(Request $request,Post $post){
        if($request->ajax()){
            $comments=PostComment::where('post_id',$post->id)->whereNull('post_comment_id')->orderBy('id','DESC')->paginate();
            $results=[];
            foreach ($comments->items() as $row) { 
                $results[]=[
                    'slug'=>$row->slug,
                    'comment'=>$row->comment,
                    'user'=>optional($row->user)->name,
                    "likes"=>$row->likes()->count(),
                    "replys"=>$row->replys()->count(),
                    'createdAt'=>$row->created_at->diffInMinutes(now())>1? $row->created_at->diffForHumans(now(), true)." ago":'Just Now',
                    'replyUrl'=>route("admin.community.post.comment.reply",['post'=>$post->slug,'post_comment'=>$row->slug]),
                    'likeUrl'=>route("admin.community.post.comment.like",['post'=>$post->slug,'post_comment'=>$row->slug]),
                ];
            }
            
            return [ 
                'current_page' => $comments->currentPage(),
                'total_pages' => $comments->lastPage(),
                'total_items' => $comments->total(),
                'items_per_page' => $comments->perPage(),
                'data' => $results, 
                'prev' => $comments->previousPageUrl(),
                'next' => $comments->nextPageUrl()
            ]; 
        }
        return view('admin.community.show',compact('post'));
    }

}
