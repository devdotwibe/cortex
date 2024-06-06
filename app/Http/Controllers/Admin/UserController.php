<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=User::class;
        self::$routeName="admin.user";
    }
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        return view("admin.user.index");
    }
}
