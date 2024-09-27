<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransation;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\UserSubscription;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SubscribeUsersController extends Controller
{
    use ResourceController;
    public function index(Request $request){ 
        if($request->ajax()){ 
            self::$model=UserSubscription::class;
            self::$defaultActions=[''];  
            return $this->whereHas('user')
                ->addColumn("usermail",function($data){
                    return $data->user->email;
                })
                ->addColumn("username",function($data){
                    return $data->user->name;
                })
                ->addColumn('plan',function($data){
                    return optional(SubscriptionPlan::find($data->subscription_plan_id))->title;
                })->buildTable();
        }
        return view('admin.subscriber.index');
    }
}
