<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class SubscriptionPaymentController extends Controller
{
    use ResourceController;
    public function index(Request $request){
        $plans=SubscriptionPlan::where('id','>',0)->get();
        return view('admin.payment-price.index',compact('plans'));
    }
    public function store(Request $request){
        $request->validate([
            "payment"=>['required'],
            "payment.basic_amount"=>['required','numeric','min:1','max:100000'],
            "payment.combo_amount"=>['required','numeric','min:1','max:100000'],
            'payment.title'=>['required'],
            'payment.content'=>['nullable'],
            'payment.icon'=>['nullable']
        ]);
        $basic_amount=$request->payment["basic_amount"];
        $combo_amount=$request->payment["combo_amount"];
        $title=$request->payment["title"];
        $content=$request->payment["content"];
        $icon=$request->payment["icon"];
        $price1=Payment::stripe()->prices->create([
            'currency' => config('stripe.currency'),
            'unit_amount' => intval($combo_amount*100),
            'product_data' => ['name' => config('app.name','Cortex').' Amount :'.(intval($combo_amount*100)/100).' For '.ucfirst($title)],
            'metadata'=>[
                'modify_time'=>date('Y-m-d h:i a'),
                'title'=>$title, 
            ]
        ]); 
        $price2=Payment::stripe()->prices->create([
            'currency' => config('stripe.currency'),
            'unit_amount' => intval($combo_amount*100),
            'product_data' => ['name' => config('app.name','Cortex').' Amount :'.(intval($combo_amount*100)/100).' For '.ucfirst($title)],
            'metadata'=>[
                'modify_time'=>date('Y-m-d h:i a'),
                'title'=>$title, 
            ]
        ]); 
        SubscriptionPlan::store([
            "name"=>Str::slug($title),
            "title"=>$title,
            "content"=>$content,
            'basic_amount'=>$price1->unit_amount/100,
            'basic_amount_id'=>$price1->id,
            'combo_amount'=>$price2->unit_amount/100,
            'combo_amount_id'=>$price2->id,
            'icon'=>$icon,
        ]);

        if($request->ajax()){
            return response()->json([
                'success'=>"Amount Updated",
            ]);
        }
        return redirect()->back()->with('success',"Amount Updated");
    }
    public function history(Request $request){
        if($request->ajax()){
            self::$model=SubscriptionPlan::class;
            self::$defaultActions=[''];  
            return $this->buildTable();
        }
        return view('admin.payment-price.history');
    }
}
