<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        return view("welcome");
    }
    public function login(Request $request){
        return view("auth.login");
    }
}
