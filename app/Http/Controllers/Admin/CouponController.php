<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponOffer;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ResourceController;
    public function index(Request $request)
    { 
        if($request->ajax()){
            self::$model=CouponOffer::class;
            self::$routeName="admin.coupon";
            self::$defaultActions=["delete"];
            return  $this->buildTable();
        }
        return view('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $offer=$request->validate([
            'name'=>['required','string','max:50'],
            'amount'=>['required','numeric','min:0'],
            'expire'=>['required']
        ]);
        $coupen=CouponOffer::store($offer);   
        if($request->ajax()){
            return response()->json(["success","Coupon created success"]);
        }
        return redirect()->route('admin.coupon.index')->with("success","Coupon created success");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CouponOffer $couponOffer)
    {
        return $couponOffer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CouponOffer $couponOffer)
    {
        return $couponOffer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CouponOffer $couponOffer)
    {        
        $offer=$request->validate([
            'name'=>['required','string','max:50'],
            'amount'=>['required','numeric','min:0'],
            'expire'=>['required']
        ]);
        $couponOffer->update($offer);   
        if($request->ajax()){
            return response()->json(["success","Coupon updated success"]);
        }
        return redirect()->route('admin.coupon.index')->with("success","Coupon updated success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CouponOffer $couponOffer)
    {
        $couponOffer->delete();   
        if($request->ajax()){
            return response()->json(["success","Coupon deleted success"]);
        }
        return redirect()->route('admin.coupon.index')->with("success","Coupon deleted success");
    }
}
