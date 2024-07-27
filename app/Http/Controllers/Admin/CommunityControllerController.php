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
            public function index(Request $request)
        {
            /**
             * @var User
             */
            $user = Auth::user();

            
            $data = Poll::with('options')->get();

            return view('admin.community.index', compact('user', 'data'));
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

    public function edit($id)
    { 
        $poll = Poll::findOrFail($id); 
        
        $user=Auth::user();
        
        return view('admin.community.edit', compact('poll','user'));
    }

    public function update(Request $request,$id)
    {
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
        return redirect()->route('admin.community.index')->with('success', 'Post deleted successfully');
    }

    public function destroy($id)
  {
    $poll = Poll::findOrFail($id);
    
        $poll->delete();
    return redirect()->route('admin.community.index')
      ->with('success', 'poll deleted successfully');
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
