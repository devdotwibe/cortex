<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hashtag;

class HashtagController extends Controller
{
    //
    public function hashtags()
    {

        return view('admin.community.hashtags'); 
    }


}
