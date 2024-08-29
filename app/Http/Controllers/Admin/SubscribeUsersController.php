<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SubscribeUsersController extends Controller
{
    use ResourceController;
    public function index(Request $request){
        if($request->ajax()){
            self::$model=User::class;
            self::$defaultActions=[''];
            return $this->buildTable();
        }
        return view('admin.subscriber.index');
    }
}
