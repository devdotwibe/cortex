<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    
    function index(Request $request)
    {
        return view('admin.learn.index');
    }
}
