<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    function index(Request $request)
    {
        $user = Auth::user();
        
        return view('user.profile.edit',compact('user'));
    }
}
