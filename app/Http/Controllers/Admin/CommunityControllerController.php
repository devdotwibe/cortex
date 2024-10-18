<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\AdminPolls;
use App\Models\Poll;
use App\Models\Hashtag;
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

        // $hashtags = Hashtag::groupBy('hashtag')->pluck('hashtag');
    

        $hashtags = Hashtag::where('hashtag', 'LIKE', '#%')
        ->groupBy('hashtag')
        ->pluck('hashtag');
       
        $hashtag = $request->input('hashtag');

        $userid = $request->input('user_id');


        if($request->ajax()){   
            $posts=Post::where('id','>',0);
            if(!empty($hashtag))
            {
                $posts->whereIn('id',Hashtag::where('hashtag', 'like', "%$hashtag%")->select ('post_id'));
            }

            if(!empty($userid))
            {
                $posts->where('user_id',$userid);
            }


            $posts=$posts->orderBy('id','DESC')->paginate();
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
                   "hashtags"=>$row->hashtaglist()->pluck('hashtag'),
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
        return view('admin.community.index',compact('hashtags'));
    }
    public function create(Request $request){
        return view('admin.community.create');
    }
 
    public function store(Request $request)
{


    
    /**
     * @var Admin
     */
    $admin = Auth::guard('admin')->user();
    $type = $request->type ?? "post";

    if ($type == "post") {
        $data = $request->validate([
            'type' => ["required"],
           
           'description' => ["required", 'string', "max:300", function ($attribute, $value, $fail) {
    if (preg_match('/#/', $value)) {
        $fail('Hashtags are not allowed in the description.');
    }
}],

            'hashtag' => ["nullable", 'string', 'max:500'],
            'image' => ["nullable"], 
        ]);
    } else {
        $data = $request->validate([
            // 'description' => ["required"],
          'description' => ["required", 'string', "max:300", function ($attribute, $value, $fail) {
    if (preg_match('/#/', $value)) {
        $fail('Hashtags are not allowed in the description.');
    }
}],

            'type' => ["required"],
            'option' => ["required", 'array', 'min:2', 'max:5'],
            'option.*' => ["required", 'max:255'],
            'image' => ["nullable"], 
        ], [
            'option.required' => "This field is required",
            'option.*.required' => "This field is required",
        ]);
    }

   

    $data['status'] = "publish";
    $data['admin_id'] = $admin->id;

    // Create the post
    $post = Post::store($data);

    // Handle poll options if the type is "poll"
    if($request->type=="poll"){
        foreach ($request->input('option',[]) as $k=>$v) {
            PollOption::store([
                'option'=>$v,
                'post_id'=>$post->id
            ]);
        }
    }
 
  
$extractedHashtags = array_filter(array_map('trim', preg_split('/[,\s]+/', $request->input('hashtag', ''))));

foreach ($extractedHashtags as $hashtag) {
    if (!empty($hashtag)) {
        Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id' => $post->id]);
    }
}



    return redirect()->route('admin.community.index')->with('success', "Post published");
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
                    'deleteUrl'=>route('admin.community.post.comment.destroy',['post'=>$post->slug,'post_comment'=>$row->slug]),
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

    public function postCommentReplay(Request $request,Post $post,PostComment $postComment){ 
        if($request->ajax()){
            $comments=PostComment::where('post_id',$post->id)->where('post_comment_id',$postComment->id)->orderBy('id','DESC')->paginate();
            $results=[];
            foreach ($comments->items() as $row) { 
                $results[]=[
                    'slug'=>$row->slug,
                    'comment'=>$row->comment,
                    'user'=>optional($row->user)->name??'(deleted user)',
                    'createdAt'=>$row->created_at->diffInMinutes(now())>1? $row->created_at->diffForHumans(now(), true)." ago":'Just Now',
                    'deleteUrl'=>route('admin.community.post.comment.destroy',['post'=>$post->slug,'post_comment'=>$row->slug]),
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
    }

    public function edit(Request $request,Post $post){
        return view('admin.community.edit',compact('post'));
    }
    public function update(Request $request,Post $post){
        $type=$request->type??"post";
        if($type=="post"){
            $data=$request->validate([ 
                'type'=>["required"],
                // 'description'=>["required"], 
                 'description' => ["required",  'string',"max:300", function ($attribute, $value, $fail) {
    if (preg_match('/#/', $value)) {
        $fail('Hashtags are not allowed in the description.');
    }
}],

                'image'=>["nullable"], 
                'hashtag' => ["nullable", 'string', 'max:500'],
            ]);
        }else{

            $data=$request->validate([
               'description' => ["required", 'string', "max:300", function ($attribute, $value, $fail) {
    if (preg_match('/#/', $value)) {
        $fail('Hashtags are not allowed in the description.');
    }
}],

                
                'type'=>["required"], 
                'option'=>["required",'array','min:2','max:5'],
                'option.*'=>["required",'max:255'],
                'image'=>["nullable"], 
            ],[
                'option.required'=>"This field is required",
                'option.*.required'=>"This field is required",
            ]);
        }

        $post->update($data);
        $ids=[];
        if($request->type=="poll"){
            $optid=$request->input('option_id',[]);
            foreach ($request->input('option',[]) as $k=>$v) {
                $opt=null;
                if(!empty($optid[$k])){
                    $opt=PollOption::findSlug($optid[$k]);
                }
                if(empty($opt)){
                    $opt=PollOption::store([
                        'option'=>$v,
                        'post_id'=>$post->id
                    ]);
                }else{
                    $opt->update([
                        'option'=>$v, 
                    ]);
                }

                $ids[]=$opt->id;
            }
        }
        PollOption::where('post_id',$post->id)->whereNotIn('id',$ids)->delete();
 
        // preg_match_all('/#\w+/',  $data['description'], $hashtags);
        // $extractedHashtags = $hashtags[0]; 
        // $hashIds=[];
        // foreach ($extractedHashtags as $hashtag) {
            
        //    $hash= Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id'=>$post->id]);
        //    $hashIds[]=$hash->id;
        // }
        // Hashtag::where('post_id',$post->id)->whereNotIn('id',$hashIds)->delete();
        $hashIds=[];
        // $extractedHashtags = array_map('trim', explode(',', $request->input('hashtag','')));
        $extractedHashtags = array_filter(array_map('trim', preg_split('/[,\s]+/', $request->input('hashtag', ''))));
        foreach ($extractedHashtags as $hashtag) {
            if (!empty($hashtag)) {
                $hash=Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id' => $post->id]);
                $hashIds[]=$hash->id;
            }
        }
        Hashtag::where('post_id',$post->id)->whereNotIn('id',$hashIds)->delete();
        return redirect()->route('admin.community.index')->with('success',"Post updated");
    }
    public function destroy(Request $request,Post $post){ 
        $post->delete();
        return redirect()->route('admin.community.index')->with('success',"Post Deleted");
    }
    public function commentDestroy(Request $request,Post $post,PostComment $postComment){ 
        PostComment::where('post_comment_id',$postComment->id)->delete();
        PostComment::where('id',$postComment->id)->delete();
        return redirect()->route('admin.community.index')->with('success',"Post Comment Deleted");
    }




    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Fetch users whose name matches the query
        $users = User::where('name', 'like', '%' . $query . '%')->get();
    
        // Filter the posts based on the selected user's ID
        $posts = Post::whereIn('user_id', $users->pluck('id'))
            ->with('user') // Eager load user data
            ->get();
    
        // Return unique users and posts
        return response()->json(['users' => $users->unique('id'), 'posts' => $posts]);
    }
    
    

// YourController.php


    public function store2(Request $request)
{
    $post = Post::create([
        'description' => $request->description,
        'hashtags' => json_encode($this->extractHashtags($request->description)),
        // Other fields
    ]);

    // Update or create hashtags
    foreach ($post->hashtags as $hashtag) {
        Hashtag::firstOrCreate(['hashtag' => $hashtag]);
    }

    // Redirect or return response
}

private function extractHashtags($text)
{
    preg_match_all('/#\w+/', $text, $matches);
    return array_unique($matches[0]);
}



}
