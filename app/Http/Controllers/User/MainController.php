<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        /**
         *  @var User
         */
        $user=Auth::user();
        $user->setProgress($request->input('name'),$request->input('value'));
    }
    public function getprogress(Request $request){
        $request->validate([
            "name"=>['required']
        ]);
        /**
         *  @var User
         */
        $user=Auth::user();
        return [
            "name"=>$request->input('name'),
            "value"=> $user->progress($request->input('name'),$request->input('value'))
        ];
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
