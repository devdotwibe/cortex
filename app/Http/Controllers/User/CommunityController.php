<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\Post;
use App\Models\User;
use App\Models\PollOption;
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
       
        $data  = Poll::with('options')->get(); 
        
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
            'options' => 'required|array|min:2|max:6', 
            'options.*' => 'required|string|max:255',
        ]); 

        $poll = Poll::create([
            'user_id' => $request->input('user_id'),
            'question' => $request->input('question'),
        ]);

        foreach ($request->input('options') as $option) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option' => $option,
            ]);
        }

        return redirect()->route('community.index')->with('success', 'Poll created successfully.');
        
    }

    public function votePoll(Request $request)
    { 
        $pollId = $request->input('poll_id');
        $optionId = $request->input('option_id');
    
        // Fetch and update poll data
        $poll = Poll::find($pollId);
        $option = $poll->options()->find($optionId);
        $option->increment('votes');
    
        // Recalculate percentages
        $totalVotes = $poll->options()->sum('votes');
        $options = $poll->options->map(function ($option) use ($totalVotes) {
            $option->percentage = ($totalVotes > 0) ? ($option->votes / $totalVotes) * 100 : 0;
            return $option;
        });
    
        return response()->json([
            'options' => $options->map(function ($option, $index) {
                return [
                    'id' => $option->id,
                    'percentage' => $option->percentage
                ];
            })
        ]);

    
    }

    public function polledit($id)
    {
        $poll = Poll::findOrFail($id); 
        
        $user=Auth::user();
        return view('user.community.polledit',compact('poll','user'));
    }

    public function pollUpdate(Request $request, $id)
   { 
    
   
    // Validate the request data
    $request->validate([
        'question' => 'required|string|max:255',
        'options' => 'required|array',
        'options.*' => 'required|string|max:255',
        
    ]);

    // Find the poll by ID
    $poll = Poll::findOrFail($id);

    // Update the poll question
    $poll->question = $request->input('question');
    $poll->save();

    $options = $request->input('options');
    $optionIds = $request->input('option_ids', []);

    foreach ($options as $index => $option) {
        if (isset($optionIds[$index])) {
            $pollOption = $poll->options()->where('id', $optionIds[$index])->first();
            if ($pollOption) {
                $pollOption->option = $option;
                $pollOption->save();
            }
        } else {
            $poll->options()->create(['option' => $option]);
        }
    }
    return back()->with('success', 'Poll updated successfully.');
}


   


    public function pollDestroy($id)
    {
        $poll = Poll::findOrFail($id);
    
        $poll->delete();
    
        return back()->with('success', 'Poll deleted successfully.');
    }

   


    
    
    
}
