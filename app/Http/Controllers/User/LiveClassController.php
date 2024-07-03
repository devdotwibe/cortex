<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LiveClassPage;
use Illuminate\Http\Request;

class LiveClassController extends Controller
{
    
    public function index()
    {

        $live_class =  LiveClassPage::first();
        
        return view('user.live-class.index',compact('live_class'));
    }



}
