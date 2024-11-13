<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class AdminUserController extends Controller
{
    
    public Function index (Request $request)
    {
        return view('admin.admin_users.index');
    }
}
