<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class UserAccessController extends Controller
{
    use ResourceController;
    public function index(Request $request,$type,$term){
        if($request->ajax()){
            self::$model = User::class;
            self::$defaultActions=[''];
            return $this->addAction(function($data){

            })->buildTable();
        }
    }
}
