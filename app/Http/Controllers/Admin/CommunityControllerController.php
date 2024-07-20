<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPolls;
use App\Models\Polls;
use App\Models\AdminPost;
use App\Models\AdminPoll;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommunityControllerController extends Controller
{
            public function index(Request $request)
        {
            /**
             * @var User
             */
            $user = Auth::user();

            if ($request->ajax()) {
                $adminPosts = AdminPost::orderBy('id', 'DESC')->paginate();
                $userPosts = Post::orderBy('id', 'DESC')->paginate();

                $adminResults = $this->formatPosts($adminPosts);
                $userResults = $this->formatPosts($userPosts);

                return [
                    'current_page' => $userPosts->currentPage(),
                    'total_pages' => $userPosts->lastPage(),
                    'total_items' => $userPosts->total(),
                    'items_per_page' => $userPosts->perPage(),
                    'data' => array_merge($adminResults, $userResults),
                    'prev' => $userPosts->previousPageUrl(),
                    'next' => $userPosts->nextPageUrl()
                ];
            }

            $adminPolls = AdminPolls::orderBy('id', 'DESC')->paginate();
            $userPolls = Polls::orderBy('id', 'DESC')->paginate();

            $polls = array_merge($adminPolls->items(), $userPolls->items());

            return view('admin.community.index', compact('user', 'polls'));
        }

        private function formatPosts($posts)
        {
            $results = [];
            foreach ($posts->items() as $row) {
                $results[] = [
                    "slug" => $row->slug,
                    "title" => $row->title,
                    "type" => $row->type,
                    "description" => $row->description,
                    "image" => $row->image,
                    "video" => $row->video,
                    "status" => $row->status,
                    "createdAt" => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                    "user" => [
                        "name" => optional($row->user)->name
                    ],
                ];
            }
            return $results;
        }

    public function create(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('admin.community.create',compact('user'));
    }
    public function store(Request $request) { 
        $data = $request->validate([
            'title' => ["required", "max:255"],
            'description' => ["required"],
        ]);
    
        /**
         *  @var User
         */
        $user = Auth::user();
    
        $data['user_id'] = $user->id;
        $data['status'] = "publish";
    
        // Use the create method instead of store
        $post = AdminPost::create($data);
    
        return redirect()->route('admin.community.show', $post->slug)->with('success', "Post published");
    }
    public function show(Request $request,AdminPost $post){
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('admin.community.show',compact('post','user'));
    }
    public function edit(Request $request,AdminPost $post){
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('admin.community.edit',compact('post','user'));
    }
    public function update(Request $request,AdminPost $post){
        $data=$request->validate([
            'title'=>["required","max:255"],
            'description'=>["required"],
        ]);
 
        $post->update($data);
        return redirect()->route('community.post.show',$post->slug)->with('success',"Post updated");
    }
    public function destroy(Request $request,AdminPost $post){ 
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

        AdminPolls::create([
            'question' => $request->input('question'),
            'option1' => $request->input('option1'),
            'option2' => $request->input('option2'),
        ]);

        $user=Auth::user();  
        return to_route('admin.community.index')->with('success','Failed to Update Event Details');
        
    }

    public function votePoll(Request $request)
    {
        $poll = AdminPolls::find($request->poll_id);
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
