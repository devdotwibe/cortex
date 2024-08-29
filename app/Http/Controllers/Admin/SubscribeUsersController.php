<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransation;
use App\Models\User;
use App\Models\UserProgress;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SubscribeUsersController extends Controller
{
    use ResourceController;
    public function index(Request $request){ 
        $year=$request->year??((date('Y')+0)."-".(date('Y')+1));
        if($request->ajax()){
            self::$model=User::class;
            self::$defaultActions=[''];  
            return $this->where(function($qry){
                $qry->whereIn('id',UserProgress::where('name',"cortext-subscription-payment")->where('value','paid')->select('user_id'));
            })->addColumn('subscriber',function($data){
                $name="";
                if(!empty($data->user)){
                    $name.="<span class='badge bg-secondary' >".$data->user->email."</span>";
                    $compo=$data->user->progress('cortext-subscription-payment-email','');
                    if(!empty($compo)){
                        $name.="<span class='badge bg-secondary' >".$compo."</span>";                        
                    }
                }

                return $name;
            })->buildTable(['subscriber']);
        }
        return view('admin.subscriber.index');
    }
}
