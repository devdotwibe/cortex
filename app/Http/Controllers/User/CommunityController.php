<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommentLike;
use App\Models\Poll;
use App\Models\Post;
use App\Models\User;
use App\Models\Hashtag;
use App\Models\PollOption;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\ReportPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommunityController extends Controller
{
    public function posts(Request $request)
    {


        // $hashtags = Hashtag::groupBy('hashtag')->pluck('hashtag');

        $hashtags = Hashtag::where('hashtag', 'LIKE', '#%')
        ->groupBy('hashtag')
        ->pluck('hashtag');
       


        $hashtag = $request->input('hashtag');

        $userid = $request->input('user_id');


        /**
         *  @var User
         */
        $user = Auth::user();

        if ($request->ajax()) {
            $post = Post::where('id', '>', 0);
            if (!empty($hashtag)) {
                $post->whereIn('id', Hashtag::where('hashtag', 'like', "%$hashtag%")->select('post_id'));
            }

            if(!empty($userid))
            {
                $post->where('user_id',$userid);
            }


            $posts = $post->orderBy('id', 'DESC')->paginate();
            $results = [];
            foreach ($posts->items() as $row) {
                $options = [];
                $tvotes = $row->pollOption->sum('votes');
                foreach ($row->pollOption as $opt) {
                    $options[] = [
                        "slug" => $opt->slug,
                        "option" => $opt->option,
                        "votes" => $opt->votes,
                        'percentage' => $tvotes > 0 ? round(($opt->votes * 100) / $tvotes, 2) : 0,
                        'voteUrl' => route('community.poll.vote', $opt->slug),
                    ];
                }
                $vote = Poll::where('user_id', $user->id)->where('post_id', $row->id)->first();
                if (!empty($vote)) {
                    $vote = [
                        'slug' => $vote->slug,
                        'option' => optional($vote->pollOption)->slug,
                    ];
                }
                $results[] = [
                    "slug" => $row->slug,
                    "title" => $row->title,
                    "type" => $row->type,
                    "description" => $row->description,
                    "hashtags"=>$row->hashtaglist()->pluck('hashtag'),
                    "likes" => $row->likes()->count(),
                    "comments" => $row->comments()->whereNull('post_comment_id')->count(),
                    "image" => $row->image,
                    "video" => $row->video,
                    "status" => $row->status,
                    "vote" => $vote,
                    "poll" => $options,
                    "showUrl" => route('community.post.show', $row->slug),
                    "createdAt" => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                    "user" => [
                        "name" => optional($row->user)->name ?? optional($row->admin)->name ?? "(deleted user)"
                    ],
                    "liked" => $row->likes()->where('user_id', $user->id)->count() > 0 ? true : false,
                    "likeUrl" => route('community.post.like', $row->slug),
                    "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug) : null,

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
        return view('user.community.posts', compact('user','hashtags'));
    }

    public function index(Request $request)
    {

        /**
         *  @var User
         */
        $user = Auth::user();
        $hashtag = $request->input('hashtag');

        $userid = $request->input('user_id');




        if ($request->ajax() && (!empty($request->ref)) ) {
            $post = Post::where('id', '>', 0);
            if (!empty($hashtag)) {
                $post->whereIn('id', Hashtag::where('hashtag', 'like', "%$hashtag%")->select('post_id'));
            }

            if(!empty($userid))
            {
                $post->where('user_id',$userid);
            }


            $posts = $post->where('user_id', $user->id)->orderBy('id', 'DESC')->paginate();
            $results = [];
            foreach ($posts->items() as $row) {
                $options = [];
                $tvotes = $row->pollOption->sum('votes');
                foreach ($row->pollOption as $opt) {
                    $options[] = [
                        "slug" => $opt->slug,
                        "option" => $opt->option,
                        "votes" => $opt->votes,
                        'percentage' => $tvotes > 0 ? round(($opt->votes * 100) / $tvotes, 2) : 0,
                        'voteUrl' => route('community.poll.vote', $opt->slug),
                    ];
                }
                $vote = Poll::where('user_id', $user->id)->where('post_id', $row->id)->first();
                if (!empty($vote)) {
                    $vote = [
                        'slug' => $vote->slug,
                        'option' => optional($vote->pollOption)->slug,
                    ];
                }
                $results[] = [
                    "slug" => $row->slug,
                    "title" => $row->title,
                    "type" => $row->type,
                    "description" => $row->description,
                    "hashtags"=>$row->hashtaglist()->pluck('hashtag'),
                    "likes" => $row->likes()->count(),
                    "comments" => $row->comments()->whereNull('post_comment_id')->count(),
                    "image" => $row->image,
                    "video" => $row->video,
                    "status" => $row->status,
                    "vote" => $vote,
                    "poll" => $options,
                    "showUrl" => route('community.post.show', $row->slug),
                    "createdAt" => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                    "user" => [
                        "name" => optional($row->user)->name ?? optional($row->admin)->name ?? "(deleted user)"
                    ],
                    "liked" => $row->likes()->where('user_id', $user->id)->count() > 0 ? true : false,
                    "likeUrl" => route('community.post.like', $row->slug),
                    "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug) : null,
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
        // $hashtags = Hashtag::whereIn('post_id', Post::where('user_id',$user->id)->select('id'))->groupBy('hashtag')->pluck('hashtag');
        $hashtags = Hashtag::whereIn('post_id', Post::where('user_id', $user->id)->select('id'))
        ->where('hashtag', 'LIKE', '#%') // Add LIKE condition to filter hashtags starting with '#'
        ->groupBy('hashtag') // Group by hashtag to get unique values
        ->pluck('hashtag'); // Retrieve the hashtags as a collection
    

        return view('user.community.index', compact('user','hashtags'));
    }
    public function create(Request $request)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        if ($user->post_status !== "active") {
            return redirect()->route('community.index')->with('error', "Admin Banned from Community post");
        }
        $hashtags = Hashtag::all();
        return view('user.community.create', compact('hashtags'));
    }
    public function store(Request $request)
    {
        $type = $request->type ?? "post";
            $data = $request->validate([
                'type' => ["required"],
             
                'description' => ["required", 'string', "max:300", function ($attribute, $value, $fail) {
                    if (preg_match('/#/', $value)) {
                        $fail('Hashtags are not allowed in the description.');
                    }
                }],
                'hashtags' => ['nullable', 'array'],
                'hashtags.*' => ['exists:hashtags,id'],
                'image' => ["nullable"],
            ]);
      

        /**
         *  @var User
         */
        $user = Auth::user();

        $data['user_id'] = $user->id;
        $data['status'] = "publish";
        $post = Post::store($data);
        if ($request->type == "poll") {
            foreach ($request->input('option', []) as $k => $v) {
                PollOption::store([
                    'option' => $v,
                    'post_id' => $post->id
                ]);
            }
        }


        

    // Attempt to find the hashtag and associate it with the post
    if ($request->has('hashtag') && $hashtag = Hashtag::find($request->hashtag)) {
        $hashtag->post_id = $post->id;
        $hashtag->save();
    } else {
        // Handle case if the hashtag was not found, if needed
        // Example: log an error or ignore
    }
        return redirect()->route('community.index')->with('success', "Post published");
    }
    public function pollVote(Request $request, PollOption $pollOption)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        $vote = Poll::where('user_id', $user->id)->where('post_id', $pollOption->post_id)->first();
        if (empty($vote)) {
            $vote = Poll::store([
                'user_id' => $user->id,
                'post_id' => $pollOption->post_id,
                'poll_option_id' => $pollOption->id
            ]);
        } else {
            $vote->update([
                'poll_option_id' => $pollOption->id
            ]);
        }
        foreach (PollOption::where('post_id', $pollOption->post_id)->get() as $opt) {
            $opt->update([
                'votes' => Poll::where('post_id', $pollOption->post_id)->where('poll_option_id', $opt->id)->count()
            ]);
        }
        if ($request->ajax()) {

            $row = Post::find($pollOption->post_id);
            $options = [];
            $tvotes = $row->pollOption->sum('votes');
            foreach ($row->pollOption as $opt) {
                $options[] = [
                    "slug" => $opt->slug,
                    "option" => $opt->option,
                    "votes" => $opt->votes,
                    'percentage' => $tvotes > 0 ? round(($opt->votes * 100) / $tvotes, 2) : 0,
                    'voteUrl' => route('community.poll.vote', $opt->slug),
                ];
            }

            $vote = Poll::where('user_id', $user->id)->where('post_id', $pollOption->post_id)->first();
            return response()->json([
                "slug" => $row->slug,
                "title" => $row->title,
                "type" => $row->type,
                "description" => $row->description,
                "hashtags"=>$row->hashtaglist()->pluck('hashtag'),
                "likes" => $row->likes()->count(),
                "comments" => $row->comments()->whereNull('post_comment_id')->count(),
                "image" => $row->image,
                "video" => $row->video,
                "status" => $row->status,
                "vote" => [
                    'slug' => $vote->slug,
                    'option' => optional($vote->pollOption)->slug,
                ],
                "poll" => $options,
                "showUrl" => route('community.post.show', $row->slug),
                "createdAt" => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                "user" => [
                    "name" => optional($row->user)->name ?? optional($row->admin)->name ?? "(deleted user)"
                ],
                "liked" => $row->likes()->where('user_id', $user->id)->count() > 0 ? true : false,
                "likeUrl" => route('community.post.like', $row->slug),
                "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug) : null,
            ]);
        } else {
            return redirect()->back()->with('success', "Voted");
        }
    }
    public function postLike(Request $request, Post $post)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        $like = PostLike::where('user_id', $user->id)->where('post_id', $post->id)->first();
        if (empty($like)) {
            $like = PostLike::store([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        } else {
            $like->delete();
        }
        $row = Post::find($post->id);
        if ($request->ajax()) {

            $options = [];
            $tvotes = $row->pollOption->sum('votes');
            foreach ($row->pollOption as $opt) {
                $options[] = [
                    "slug" => $opt->slug,
                    "option" => $opt->option,
                    "votes" => $opt->votes,
                    'percentage' => $tvotes > 0 ? round(($opt->votes * 100) / $tvotes, 2) : 0,
                    'voteUrl' => route('community.poll.vote', $opt->slug),
                ];
            }

            $vote = Poll::where('user_id', $user->id)->where('post_id', $row->id)->first();
            if (!empty($vote)) {
                $vote = [
                    'slug' => $vote->slug,
                    'option' => optional($vote->pollOption)->slug,
                ];
            }
            return response()->json([
                "slug" => $row->slug,
                "title" => $row->title,
                "type" => $row->type,
                "description" => $row->description,
                "hashtags"=>$row->hashtaglist()->pluck('hashtag'),
                "likes" => $row->likes()->count(),
                "comments" => $row->comments()->whereNull('post_comment_id')->count(),
                "image" => $row->image,
                "video" => $row->video,
                "status" => $row->status,
                "vote" => $vote,
                "poll" => $options,
                "showUrl" => route('community.post.show', $row->slug),
                "createdAt" => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                "user" => [
                    "name" => optional($row->user)->name ?? optional($row->admin)->name ?? "(deleted user)"
                ],
                "liked" => $row->likes()->where('user_id', $user->id)->count() > 0 ? true : false,
                "likeUrl" => route('community.post.like', $row->slug),
                "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug) : null,
            ]);
        } else {
            return redirect()->back()->with('success', $row->likes()->where('user_id', $user->id)->count() > 0 ? "Liked" : "Removed");
        }
    }

    public function commentLike(Request $request, Post $post, PostComment $postComment)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        $like = CommentLike::where('user_id', $user->id)->where('post_id', $post->id)->where('post_comment_id', $postComment->id)->first();
        if (empty($like)) {
            $like = CommentLike::store([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'post_comment_id' => $postComment->id,
            ]);
        } else {
            $like->delete();
        }
        $row = PostComment::find($postComment->id);
        if ($request->ajax()) {


            return response()->json([
                'slug' => $row->slug,
                'comment' => $row->comment,
                'user' => optional($row->user)->name ?? "(deleted user)",
                "likes" => $row->likes()->count(),
                "replys" => $row->replys()->count(),
                'createdAt' => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                'replyUrl' => route("community.post.comment.reply", ['post' => $post->slug, 'post_comment' => $row->slug]),
                'likeUrl' => route("community.post.comment.like", ['post' => $post->slug, 'post_comment' => $row->slug]),
                'liked' => $row->likes()->where('user_id', $user->id)->count() > 0 ? true : false,
            ]);
        } else {
            return redirect()->back()->with('success', $row->likes()->where('user_id', $user->id)->count() > 0 ? "Liked" : "Removed");
        }
    }
    public function postComment(Request $request, Post $post)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        $data = $request->validate([
            "comment" => 'required'
        ]);
        if (!empty(($request->reply))) {
            $replay = PostComment::findSlug($request->reply);
            $data['post_comment_id'] = $replay->id;
        }
        $data['post_id'] = $post->id;
        $data['user_id'] = $user->id;
        PostComment::store($data);
        if ($request->ajax()) {
            return response()->json(['success' => "Comment Added"]);
        } else {
            return redirect()->back()->with('success', "Comment Added");
        }
    }
    public function postReport(Request $request, Post $post)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        $data = $request->validate([
            "type" => ['required'],
            "reason" => ['required']
        ]);
        $data['user_id'] = $user->id;
        $data['post_id'] = $post->id;
        ReportPost::store($data);
        if ($request->ajax()) {
            return response()->json(['success' => "Report Submited"]);
        } else {
            return redirect()->back()->with('success', "Report Submited");
        }
    }

    public function postCommentReplay(Request $request, Post $post, PostComment $postComment)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        if ($request->ajax()) {
            $comments = PostComment::where('post_id', $post->id)->where('post_comment_id', $postComment->id)->orderBy('id', 'DESC')->paginate();
            $results = [];
            foreach ($comments->items() as $row) {
                $results[] = [
                    'slug' => $row->slug,
                    'comment' => $row->comment,
                    'user' => optional($row->user)->name ?? '(deleted user)',
                    'createdAt' => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
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
    public function show(Request $request, Post $post)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        if ($request->ajax()) {
            $comments = PostComment::where('post_id', $post->id)->whereNull('post_comment_id')->orderBy('id', 'DESC')->paginate();
            $results = [];
            foreach ($comments->items() as $row) {
                $results[] = [
                    'slug' => $row->slug,
                    'comment' => $row->comment,
                    'user' => optional($row->user)->name ?? "(deleted user)",
                    "likes" => $row->likes()->count(),
                    "replys" => $row->replys()->count(),
                    'createdAt' => $row->created_at->diffInMinutes(now()) > 1 ? $row->created_at->diffForHumans(now(), true) . " ago" : 'Just Now',
                    'replyUrl' => route("community.post.comment.reply", ['post' => $post->slug, 'post_comment' => $row->slug]),
                    'likeUrl' => route("community.post.comment.like", ['post' => $post->slug, 'post_comment' => $row->slug]),
                    'liked' => $row->likes()->where('user_id', $user->id)->count() > 0 ? true : false,
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
        $vote = Poll::where('user_id', $user->id)->where('post_id', $post->id)->first();
        return view('user.community.show', compact('post', 'user', 'vote'));
    }
    public function edit(Request $request, Post $post)
    {
        /**
         *  @var User
         */
        $user = Auth::user();
        $hashtags = Hashtag::all();
        return view('user.community.edit', compact('post', 'user','hashtags'));
    }
    public function update(Request $request, Post $post)
    {
        $type = $request->type ?? "post";
        if ($type == "post") {
            $data = $request->validate([
                'type' => ["required"],
                // 'description' => ["required"],
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

        $post->update($data);
        $ids = [];
        if ($request->type == "poll") {
            $optid = $request->input('option_id', []);
            foreach ($request->input('option', []) as $k => $v) {
                $opt = null;
                if (!empty($optid[$k])) {
                    $opt = PollOption::findSlug($optid[$k]);
                }
                if (empty($opt)) {
                    $opt = PollOption::store([
                        'option' => $v,
                        'post_id' => $post->id
                    ]);
                } else {
                    $opt->update([
                        'option' => $v,
                    ]);
                }

                $ids[] = $opt->id;
            }
        }
        PollOption::where('post_id', $post->id)->whereNotIn('id', $ids)->delete();

        

    // Update or associate the selected hashtag with the post
    if ($request->filled('hashtag')) {
        Hashtag::where('post_id', $post->id)->update(['post_id' => null]); // Remove previous association
        $hashtag = Hashtag::find($request->hashtag);
        $hashtag->post_id = $post->id;
        $hashtag->save();
    }
    
        return redirect()->route('community.index')->with('success', "Post updated");
    }
    public function destroy(Request $request, Post $post)
    {
        $post->delete();
        return redirect()->route('community.index')->with('success', "Post Deleted");
    }


    public function store2(Request $request)
    {
        $post = Post::create([
            'description' => $request->description,
            'hashtags' => json_encode($this->extractHashtags($request->description)),
           
        ]);

        foreach ($post->hashtags as $hashtag) {
            Hashtag::firstOrCreate(['hashtag' => $hashtag]);
        }

  
    }

    private function extractHashtags($text)
    {
        preg_match_all('/#\w+/', $text, $matches);
        return array_unique($matches[0]);
    }


    
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        
        $users = User::where('name', 'like', '%' . $query . '%')->get();
    
        
        $posts = Post::whereIn('user_id', $users->pluck('id'))
            ->with('user') 
            ->get();
    
       
        return response()->json(['users' => $users->unique('id'), 'posts' => $posts]);
    }
    
    



}
