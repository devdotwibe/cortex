<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Polls;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{  
    public function index(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user();
        if($request->ajax()){   
            $posts=Post::where('id','>',0)->orderBy('id','DESC')->paginate();
            $results=[];
            foreach ($posts->items() as $row) { 
                $results[]=[
                    "slug"=>$row->slug,
                    "title"=>$row->title,
                    "type"=>$row->type,
                    "description"=>$row->description,
                    "image"=>$row->image,
                    "video"=>$row->video,
                    "status"=>$row->status,
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
       
        $data = Polls::where('id','>',0)->orderBy('id','DESC')->paginate();
        
        return view('user.community.index',compact('user','data'));
    }
    public function create(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('user.community.create',compact('user'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'title'=>["required","max:255"],
            'description'=>["required"],
        ]);

        /**
         *  @var User
         */
        $user=Auth::user();

        $data['user_id']=$user->id;
        $data['status']="publish";
        $post=Post::store($data);
        return redirect()->route('community.post.show',$post->slug)->with('success',"Post published");
    }
    public function show(Request $request,Post $post){
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('user.community.show',compact('post','user'));
    }
    public function edit(Request $request,Post $post){
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('user.community.edit',compact('post','user'));
    }
    public function update(Request $request,Post $post){
        $data=$request->validate([
            'title'=>["required","max:255"],
            'description'=>["required"],
        ]);
 
        $post->update($data);
        return redirect()->route('community.post.show',$post->slug)->with('success',"Post updated");
    }
    public function destroy(Request $request,Post $post){ 
        $post->delete();
        return redirect()->route('community.index')->with('success',"Post Deleted");
    }

    public function pollcreate()
    {
        return view('create');
    }

    public function storePoll(Request $request)
    { 
        $request->validate([
            'question' => 'required|string|max:255',
            'option1' => 'required|string|max:255',
            'option2' => 'required|string|max:255',
        ]);

        Polls::create([
            'question' => $request->input('question'),
            'option1' => $request->input('option1'),
            'option2' => $request->input('option2'),
        ]);

        $user=Auth::user(); 
        return to_route('community.index')->with('success','Failed to Update Event Details');
        
    }

    public function votePoll(Request $request)
    {
        $poll = Polls::find($request->poll_id);
        if ($poll) {
            if ($request->option === 'option1') {
                $poll->increment('option1_votes');
            } elseif ($request->option === 'option2') {
                $poll->increment('option2_votes');
            }
            $poll->save();
    
            $totalVotes = $poll->option1_votes + $poll->option2_votes;
            $option1Percentage = $totalVotes ? ($poll->option1_votes / $totalVotes * 100) : 0;
            $option2Percentage = $totalVotes ? ($poll->option2_votes / $totalVotes * 100) : 0;
    
            return response()->json([
                'option1_percentage' => $option1Percentage,
                'option2_percentage' => $option2Percentage,
            ]);
        }
        return response()->json(['error' => 'Poll not found'], 404);
    }
    
    
    
}
