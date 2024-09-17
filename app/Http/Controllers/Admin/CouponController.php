<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponOffer;

use App\Models\Settings;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ResourceController;
    public function index(Request $request)
    { 

        $setting = Settings::first();

        if($request->ajax()){
            self::$model=CouponOffer::class;
            self::$routeName="admin.coupon";
            self::$defaultActions=["delete"];
            return  $this->addAction(function($data){
                return '                
                    <a onclick="editcoupon('."'".route("admin.coupon.edit",$data->slug)."'".')" class="btn btn-icons edit_btn">
                        <img src="'.asset("assets/images/edit.svg").'" alt="">
                    </a>
                ';
            })->buildTable();
        }
        return view('admin.coupon.index',compact('setting'));
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
        $couponOffer->updateUrl=route('admin.coupon.update',$couponOffer->slug);
        return $couponOffer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CouponOffer $couponOffer)
    {
        $couponOffer->updateUrl=route('admin.coupon.update',$couponOffer->slug);
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



    public function setting(Request $request)
    {
        // Validate the request data for Section 1
        $request->validate([
            'emailaddress' => 'required|string|max:255',
           

        ]);

        $setting = Settings::first();

        if (empty($setting)) {
            $setting = new Settings;
        }

        $setting->emailaddress = $request->input('emailaddress');
       



        $setting->save();

        return redirect()->route('admin.coupon.index')->with('success', 'Admin Mail Updated Successfully.');
    }





}
