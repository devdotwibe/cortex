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
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class SubscribeUsersController extends Controller
{
    use ResourceController;
    public function index(Request $request){ 
        if($request->ajax()){ 
           
           
            $data = UserSubscription::select('user_subscriptions.*', 'users.name as username', 'users.email as usermail','subscription_plans.title as plan')
                                ->join('users', 'users.id', '=', 'user_subscriptions.user_id') // Join with the users table
                                ->leftjoin('subscription_plans', 'subscription_plans.id', '=', 'user_subscriptions.subscription_plan_id') // Join with the users table
                                ->when(request('search')['value'], function ($query, $search) {
                                    $query->where('users.name', 'like', "%{$search}%")
                                        ->orWhere('users.email', 'like', "%{$search}%")
                                        ->orWhere('subscription_plans.title', 'like', "%{$search}%")
                                        ->orWhere('amount', 'like', "%{$search}%")
                                        ->orWhere('expire_at', 'like', "%{$search}%")
                                        ->orWhere('user_subscriptions.created_at', 'like', "%{$search}%");
                                });
            if(!empty($request->plan)){
                $plan=SubscriptionPlan::findSlug($request->plan);
                $data->where('subscription_plan_id',$plan->id);
            }
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn("usermail",function($data){
                        return $data->usermail;
                    })
                    ->addColumn("username",function($data){
                        return $data->username;
                    })
                    ->addColumn("expire",function($data){
                        return Carbon::parse($data->expire_at)->format("Y-m-d");
                    })
                    ->addColumn("date",function($data){
                        return Carbon::parse($data->created_at)->format("Y-m-d");
                    })
                    ->addColumn('plan',function($data){
                        return optional(SubscriptionPlan::find($data->subscription_plan_id))->title;
                    })
                    ->make(true);
        }
        $plans=SubscriptionPlan::where('is_external',false)->get();
        return view('admin.subscriber.index',compact('plans'));
    }
}
