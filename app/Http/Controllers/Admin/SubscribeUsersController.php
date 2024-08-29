<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransation;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SubscribeUsersController extends Controller
{
    use ResourceController;
    public function index(Request $request){
        if($request->ajax()){
            self::$model=PaymentTransation::class;
            self::$defaultActions=['']; 
            
            return $this->where('stype','subscription')->addColumn('subscriber',function($data){
                $name="";

                return $name;
            })->buildTable();
        }
        return view('admin.subscriber.index');
    }
}
