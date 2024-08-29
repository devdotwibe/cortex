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
                if(!empty($data->user)){
                    $name.="<span class='badge bg-secondary' >".$data->user->email."</span>";
                    $compo=$data->user->progress('cortext-subscription-payment-email','');
                    if(!empty($compo)){
                        $name.="<span class='badge bg-secondary' >".$compo."</span>";                        
                    }
                }

                return $name;
            })->buildTable();
        }
        return view('admin.subscriber.index');
    }
}
