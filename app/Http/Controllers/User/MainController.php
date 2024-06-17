<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{ 
    public function index(Request $request){
        return view("user.dashboard");
    }

    public function progress(Request $request){
        $request->validate([
            "name"=>['required']
        ]);
        $user=Auth::user();
        $user->setProgress($request->input('name'),$request->input('value'));
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
