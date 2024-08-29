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
                $qry->whereIn('id',PaymentTransation::where('stype','subscription')->where('status','paid')->select('user_id'));
            })->addColumn('plan',function($data){
                $type=$data->progress('cortext-subscription-payment-plan','');
                if($type=="combo"){
                    $email=$data->user->progress('cortext-subscription-payment-email','');
                    $type.="  &nbsp:<span class='badge bg-secondary' >".$email."</span>"; 
                }
                return $type;
            })->addColumn('payid',function($data){
                return $data->progress('cortext-subscription-payment');
            })->addColumn('amount',function($data){
                $payid = $data->progress('cortext-subscription-payment');
                $payment=PaymentTransation::where('slug',$payid)->first();
                return optional($payment)->amount;
            })->buildTable(['payid','plan']);
        }
        return view('admin.subscriber.index');
    }
}
