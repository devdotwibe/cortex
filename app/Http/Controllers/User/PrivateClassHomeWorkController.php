<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HomeWork;
use App\Models\HomeWorkBook;
use Illuminate\Http\Request;

class PrivateClassHomeWorkController extends Controller
{
    public function index(Request $request){
        $homeWorks=HomeWork::all();
        return view('user.home-work.index',compact('homeWorks'));
    }
    public function show(Request $request,HomeWork $homeWork){
        $booklets=HomeWorkBook::where('home_work_id',$homeWork->id)->get();
        return view('user.home-work.show',compact('homeWork','booklets'));
    }
}
