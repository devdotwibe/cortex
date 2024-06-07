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
    public function create(Request $request){
        return view("admin.user.create");
    }
    public function show(Request $request,User $user){
        return view("admin.user.show",compact('user'));
    }
    public function edit(Request $request,User $user){
        return view("admin.user.edit",compact('user'));
    }
    public function update(Request $request,User $user){
        $userdat=$request->validate([
            "name"=>"required"
        ]);
        $user->update($userdat);
        return redirect()->route('admin.user.index')->with("success","User updated success");
    }
}
