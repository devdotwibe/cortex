<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPolls;
use App\Models\Poll;
use App\Models\AdminPost;
use App\Models\AdminPoll;
use App\Models\Post;
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
        return view('user.community.create');
    }

}
