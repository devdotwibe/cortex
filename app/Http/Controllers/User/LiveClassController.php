<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiveClassController extends Controller
{
    
    public function index()
    {
        return view('user.live-class.index');
    }


    
}
