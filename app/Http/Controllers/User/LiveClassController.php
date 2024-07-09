<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LiveClassPage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveClassController extends Controller
{
    
    public function index()
    { 
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first(); 
        return view('user.live-class.index',compact('live_class','user'));
    }
    public function workshop(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first(); 
        return view('user.live-class.workshop',compact('user','live_class'));
    }
 
    public function workshopform(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first(); 
        if ($user->progress('intensive-workshop-payment','')=="paid"){
            return view('user.live-class.workshopform',compact('user','live_class'));
        }else{
            return redirect()->back()->with("error","Workshop Payment required");
        }
    }

    public function privateclass(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first(); 
        return view('user.live-class.private',compact('user','live_class'));
    }
 
    public function privateclassform(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();  
        return view('user.live-class.privateform',compact('user','live_class')); 
    }
 
    public function privateclassroom(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();  
        return view('user.live-class.privateclass',compact('user','live_class')); 
    }
}
