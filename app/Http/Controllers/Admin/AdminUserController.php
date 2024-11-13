<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class AdminUserController extends Controller
{
    
    public function index (Request $request)
    {
        return view('admin.admin_users.index');
    }

    
    public function store (Request $request)
    {
       
        $request->validate([

            "email"=>["required",'email:rfc,dns','unique:users','unique:admins','max:250'],
            "password"=>["required",'string'],
            "conform_password" => ["required","same:password"]
        ]);

        dd($request);

    }
}
