<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransation;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ResourceController;
    public function index(Request $request){

        if($request->ajax()){

            self::$model=PaymentTransation::class;
           
            self::$defaultActions=[""];

            if(!empty($request->search['value']))
            {
                $search = $request->search['value'];
                self::$model->whereHas('user', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            }
            
            return  $this->with('user')->whereHas('user')->addColumn('username',function($data){
                return optional($data->user)->name;
            })->buildTable();
        }
        return view('admin.payment.index');
    }
    public function store(Request $request){
        $request->validate([
            "amount"=>['required','numeric','min:1','max:100000'],
            'name'=>['required']
        ]);
        $price=Payment::stripe()->prices->create([
            'currency' => config('stripe.currency'),
            'unit_amount' => intval($request->amount*100),
            'product_data' => ['name' => config('app.name','Cortex').' Amount :'.(intval($request->amount*100)/100).' For '.ucfirst($request->name)],
            'metadata'=>[
                'modify_time'=>date('Y-m-d h:i a'),
                'old_key'=>OptionHelper::getData($request->name,''),
                'old_value'=>OptionHelper::getData($request->name."-price",''),
            ]
        ]);

        OptionHelper::setData($request->name,$price->id);
        OptionHelper::setData($request->name."-price",$price->unit_amount/100);

        if($request->ajax()){
            return response()->json([
                'success'=>"Amount Updated",
            ]);
        }
        return redirect()->back()->with('success',"Amount Updated");
    }






    
}
