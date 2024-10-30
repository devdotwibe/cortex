<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hashtag;
use App\Trait\ResourceController;

class HashtagController extends Controller
{
    


    use ResourceController;
    function __construct()
    {
        self::$model=Hashtag::class;
        self::$routeName="admin.community.hashtags.store";
        self::$defaultActions=[''];

    }



    public function hashtags()
    {

        return view('admin.community.hashtags'); 
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:hashtags,name',
        ]);

        // Create a new hashtag
        Hashtag::create([
            'name' => $request->name,
        ]);

        // Return a response, e.g., redirect back with success message
        return redirect()->back()->with('success', 'Hashtag added successfully!');
    }

}
