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
                $options=[];
                $tvotes=$row->pollOption->sum('votes');
                foreach($row->pollOption as $opt){
                    $options[]=[
                        "slug"=>$opt->slug,
                        "option"=>$opt->option,
                        "votes"=>$opt->votes,
                        'percentage'=>$tvotes>0?round(($opt->votes*100)/$tvotes,2):0,
                        'voteUrl'=>route('community.post.show',$row->slug),
                    ];
                }
                $vote=Poll::where('user_id',$user->id)->where('post_id',$row->id)->first();
                if(!empty($vote)){
                    $vote=[
                        'slug'=>$vote->slug, 
                        'option'=>optional($vote->pollOption)->slug,
                    ];
                }
                $results[]=[
                    "slug"=>$row->slug,
                    "title"=>$row->title,
                    "type"=>$row->type,
                    "description"=>$row->description,
                    "image"=>$row->image,
                    "video"=>$row->video,
                    "status"=>$row->status,
                    "vote"=>$vote, 
                    "poll"=>$options,
                    "showUrl"=>route('community.post.show',$row->slug),
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
        return view('user.community.index',compact('user'));
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
            'type'=>["required"],
            'description'=>["required_if:type,'post'"],
            'option'=>["required_if:type,'poll'",'array','min:2'],
            'option.*'=>["required_if:type,'poll'",'max:255'],
        ],[
            'option.required_if'=>"This field is required",
            'option.*.required_if'=>"This field is required",
        ]);

        /**
         *  @var User
         */
        $user=Auth::user();

        $data['user_id']=$user->id;
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
        return redirect()->route('community.post.show',$post->slug)->with('success',"Post published");
    }
    public function pollVote(Request $request,PollOption $pollOption){ 
        /**
         *  @var User
         */
        $user=Auth::user();
        $vote=Poll::where('user_id',$user->id)->where('post_id',$pollOption->post_id)->first();
        if(empty($vote)){
            $vote=Poll::store([
                'user_id'=>$user->id,
                'post_id'=>$pollOption->post_id,
                'poll_option_id'=>$pollOption->id
            ]);
        }else{
            $vote=$vote->update([ 
                'poll_option_id'=>$pollOption->id
            ]);
        }
        $row=Post::find($pollOption->post_id);
        $options=[];
        $tvotes=$row->pollOption->sum('votes');
        foreach($row->pollOption as $opt){
            $options[]=[
                "slug"=>$opt->slug,
                "option"=>$opt->option,
                "votes"=>$opt->votes,
                'percentage'=>$tvotes>0?round(($opt->votes*100)/$tvotes,2):0,
                'voteUrl'=>route('community.post.show',$row->slug),
            ];
        } 
        return response()->json( [
            "slug"=>$row->slug,
            "title"=>$row->title,
            "type"=>$row->type,
            "description"=>$row->description,
            "image"=>$row->image,
            "video"=>$row->video,
            "status"=>$row->status,
            "vote"=>[
                'slug'=>$vote->slug, 
                'option'=>optional($vote->pollOption)->slug,
            ], 
            "poll"=>$options,
            "showUrl"=>route('community.post.show',$row->slug),
            "createdAt"=>$row->created_at->diffInMinutes(now())>1? $row->created_at->diffForHumans(now(), true)." ago":'Just Now',
            "user"=>[
                "name"=>optional($row->user)->name
            ],                
        ]);
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
            'type'=>["required"],
            'option'=>["required_if:type,poll",'array','min:2'],
            'option.*'=>["required_if:type,poll",'max:255'],
        ],[
            'option.required_if'=>"This field is required",
            'option.*.required_if'=>"This field is required",
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
