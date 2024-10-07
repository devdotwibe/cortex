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


        $hashtags = Hashtag::groupBy('hashtag')->pluck('hashtag');


        $hashtag = $request->input('hashtag');


        /**
         *  @var User
         */
        $user = Auth::user();

        if ($request->ajax()) {
            $post = Post::where('id', '>', 0);
            if (!empty($hashtag)) {
                $post->whereIn('id', Hashtag::where('hashtag', 'like', "%$hashtag%")->select('post_id'));
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




        if ($request->ajax() && (!empty($request->ref)) ) {
            $post = Post::where('id', '>', 0);
            if (!empty($hashtag)) {
                $post->whereIn('id', Hashtag::where('hashtag', 'like', "%$hashtag%")->select('post_id'));
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
                    "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug),
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
        $hashtags = Hashtag::whereIn('post_id', Post::where('user_id',$user->id)->select('id'))->groupBy('hashtag')->pluck('hashtag');


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
        return view('user.community.create', compact('user'));
    }
    public function store(Request $request)
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


        // // Extract and store hashtags from the description
        // preg_match_all('/#\w+/', $data['description'], $hashtags);
        // $extractedHashtags = $hashtags[0];
        // foreach ($extractedHashtags as $hashtag) {
        //     Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id' => $post->id]);
        // }
        // Split hashtags by commas or spaces   
        $extractedHashtags = array_filter(array_map('trim', preg_split('/[,\s]+/', $request->input('hashtag', ''))));
        foreach ($extractedHashtags as $hashtag) {
            if (!empty($hashtag)) {
                Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id' => $post->id]);
            }
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
                "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug),
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
                "editUrl" => $row->user_id == $user->id ? route('community.post.edit', $row->slug),
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
        return view('user.community.edit', compact('post', 'user'));
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

        // preg_match_all('/#\w+/',  $data['description'], $hashtags);
        // $extractedHashtags = $hashtags[0];
        // $hashIds = [];
        // foreach ($extractedHashtags as $hashtag) {

        //     $hash = Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id' => $post->id]);
        //     $hashIds[] = $hash->id;
        // }
        // Hashtag::where('post_id', $post->id)->whereNotIn('id', $hashIds)->delete();

        $hashIds=[];
        $extractedHashtags = array_filter(array_map('trim', preg_split('/[,\s]+/', $request->input('hashtag', ''))));
        foreach ($extractedHashtags as $hashtag) {
            if (!empty($hashtag)) {
                $hash=Hashtag::firstOrCreate(['hashtag' => $hashtag, 'post_id' => $post->id]);
                $hashIds[]=$hash->id;
            }
        }
        Hashtag::where('post_id',$post->id)->whereNotIn('id',$hashIds)->delete();
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
