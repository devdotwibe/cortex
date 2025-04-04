<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\SubscriptionPlan;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class SubscriptionPaymentController extends Controller
{
    use ResourceController;
    public function index(Request $request){
        $price = Pricing::first();
        $plans=SubscriptionPlan::where('id','>',0)->get();
        return view('admin.payment-price.index',compact('plans','price'));
    }
    public function store(Request $request){ 
        $field='payment';
        Session::put("__payment_price___","payment");
        Session::put("__payment_price_form___","payment");
        
        if(($request->$field['is_external']??"")=="Y"){

            $request->validate([
                "$field"=>['required'],
                "$field.external_label"=>['required'],
                "$field.external_link"=>['required'],
                "$field.title"=>['required'],
                "$field.content"=>['nullable'],
                "$field.icon"=>['nullable']
            ],[
                "$field.required"=>"The field is required",
                "$field.external_label.required"=>"This external label field is required",
                "$field.external_link.required"=>"This external link field is required",
                "$field.title.required"=>"This basic title is required",
                "$field.content.required"=>"This content field is required",
                "$field.icon.required"=>"This icon field is required",
            ]);
        }else{

            $request->validate([
                "$field"=>['required'],
                "$field.basic_amount"=>['required','numeric','min:1','max:100000'],
                "$field.combo_amount"=>['required','numeric','min:1','max:100000'],
                // "$field.start_plan"=>['required'],
                "$field.end_plan"=>['required'],
                "$field.title"=>['required'],
                "$field.content"=>['nullable'],
                "$field.icon"=>['nullable']
            ],[
                "$field.required"=>"The field is required",
                "$field.basic_amount.required"=>"This basic amount field is required",
                "$field.combo_amount.required"=>"This combo amount field is required",
                "$field.title.required"=>"This basic title is required",
                "$field.content.required"=>"This content field is required",
                "$field.icon.required"=>"This icon field is required",
                "$field.end_plan.required"=>"This end plan field is required",
                "$field.start_plan.required"=>"This start plan field is required",
            ]);
        }
        $title=$request->$field["title"];
        $content=$request->$field["content"];
        $icon=$request->$field["icon"];
        $start_plan=null;
        $end_plan=null;
        $basic_amount=null;
        $combo_amount=null;
        $external_label=null;
        $external_link=null;
        $basic_amount_id=null;
        $combo_amount_id=null;

        if(($request->$field['is_external']??"")!=="Y"){
            $basic_amount=$request->$field["basic_amount"];
            $combo_amount=$request->$field["combo_amount"];
            $end_plan=$request->$field["end_plan"];
            // $start_plan=$request->$field["start_plan"];
                
            $price1=Payment::stripe()->prices->create([
                'currency' => config('stripe.currency'),
                'unit_amount' => intval($basic_amount*100),
                'product_data' => ['name' => ' Amount :'.(intval($basic_amount*100)/100).' For '.ucfirst($title)],
                'metadata'=>[
                    'modify_time'=>date('Y-m-d h:i a'),
                    'title'=>$title,
                    "old_key"=>$subscriptionPlan->basic_amount_id??"-", 
                ]
            ]); 
            $basic_amount_id=$price1->id; 
            $price2=Payment::stripe()->prices->create([
                'currency' => config('stripe.currency'),
                'unit_amount' => intval($combo_amount*100),
                'product_data' => ['name' => ' Amount :'.(intval($combo_amount*100)/100).' For '.ucfirst($title)],
                'metadata'=>[
                    'modify_time'=>date('Y-m-d h:i a'),
                    'title'=>$title, 
                    "old_key"=>$subscriptionPlan->combo_amount_id??"-",
                ]
            ]);  
            $combo_amount_id=$price2->id;
        }else{
            $external_label=$request->$field["external_label"];
            $external_link=$request->$field["external_link"];
        }

        $subscriptionPlan=SubscriptionPlan::store([
            "name"=>Str::slug($title),
            "title"=>$title,
            "content"=>$content,
            'basic_amount'=>$basic_amount,
            'basic_amount_id'=>$basic_amount_id,
            'combo_amount'=>$combo_amount,
            'combo_amount_id'=>$combo_amount_id,
            // 'start_plan'=>$start_plan,
            'end_plan'=>$end_plan,
            'icon'=>$icon,
            'external_link'=>$external_link,
            'external_label'=>$external_label,
            'is_external'=>(($request->$field['is_external']??"")=="Y")?true:false,
        ]);
        Session::put("__payment_price_form___",$subscriptionPlan->slug);

        if($request->ajax()){
            return response()->json([
                'success'=>"Plan created",
            ]);
        }
        return redirect()->back()->with('success',"Plan created");
    }
    
    public function storesection1(Request $request)

    {

        
        Session::put("__payment_price___","section1"); 
        // Validate the request data for price information
        $request->validate([
            'pricebannertitle' => 'nullable|string',
            'pricebuttonlabel' => 'nullable|string|max:255',
            'pricebuttonlink' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'pricetitle' => 'nullable|string',
            'pricetitlebuttonlabel' => 'nullable|string|max:255',
            'pricetitlebuttonlink' => 'nullable|url|max:255',
        ]);
    
        // Retrieve the first record or create a new one
        $price = Pricing::first();
    
        if (empty($price)) {
            $price = new Pricing;
        }
    
        // Update fields
        $price->pricebannertitle = $request->input('pricebannertitle');
        $price->pricebuttonlabel = $request->input('pricebuttonlabel');
        $price->pricebuttonlink = $request->input('pricebuttonlink');
        $price->pricetitle = $request->input('pricetitle');
        $price->pricetitlebuttonlabel = $request->input('pricetitlebuttonlabel');
        $price->pricetitlebuttonlink = $request->input('pricetitlebuttonlink');
        
    

        if ($request->hasFile('image')) {
            $imageName = "price/" . $request->file('image')->hashName();
            Storage::put('price', $request->file('image'));
            $price->image = $imageName;
        }



      



       
    
        // Save the price record
        $price->save();
    
        // Redirect with success message
        return redirect()->route('admin.payment-price.index')->with('success', 'Section 1  has been successfully saved.');
    }
    


    public function storesection3(Request $request)

    {

        
        Session::put("__payment_price___","section3"); 
        // Validate the request data for price information
        $request->validate([
            'feelingtitle' => 'nullable|string',
           
            'feelingimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'grouptitle' => 'nullable|string',
           
        ]);
    
        // Retrieve the first record or create a new one
        $price = Pricing::first();
    
        if (empty($price)) {
            $price = new Pricing;
        }
    
        // Update fields
        $price->feelingtitle = $request->input('feelingtitle');
      
        $price->grouptitle = $request->input('grouptitle');
     
        if ($request->hasFile('feelingimage')) {
            $imageName = "price/" . $request->file('feelingimage')->hashName();
            Storage::put('price', $request->file('feelingimage'));
            $price->feelingimage = $imageName;
        }
    
        // Save the price record
        $price->save();
    
        // Redirect with success message
        return redirect()->route('admin.payment-price.index')->with('success', 'Section 3 has been successfully saved.');
    }
    




    public function storesection4(Request $request)

    {

        
        Session::put("__payment_price___","section4"); 
        // Validate the request data for price information
        $request->validate([
            'exceltitle' => 'nullable|string',
           
            'excelimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'excelbuttonlabel' => 'nullable|string',
            'excelbuttonlink' => 'nullable|string',
            'coursetitle' => 'nullable|string',
           
        ]);
    
        // Retrieve the first record or create a new one
        $price = Pricing::first();
    
        if (empty($price)) {
            $price = new Pricing;
        }
    
        $price->ourcoursetitle = $request->input('coursetitle');

        $price->exceltitle = $request->input('exceltitle');
      
        $price->excelbuttonlabel = $request->input('excelbuttonlabel');
        $price->excelbuttonlink = $request->input('excelbuttonlink');
     
       

        if ($request->hasFile('excelimage')) {
            $imageName = "price/" . $request->file('excelimage')->hashName();
            Storage::put('price', $request->file('excelimage'));
            $price->excelimage = $imageName;
        }
    
        // Save the price record
        $price->save();
    
        // Redirect with success message
        return redirect()->route('admin.payment-price.index')->with('success', 'Section 4 has been successfully saved.');
    }
    


    // public function deleteImage()
    // {
    //     // Retrieve the Pricing record
    //     $price = Pricing::first();

    //     // Check if the image exists and is not null
    //     if ($price && $price->excelimage) {
    //         // Get the full path of the image
    //         $imagePath = public_path($price->excelimage);

    //         // Check if the file exists in the storage
    //         if (Storage::exists('public/price/' . basename($price->excelimage))) {
    //             // Delete the file from storage
    //             Storage::delete('public/price/' . basename($price->excelimage));
    //         }

    //         // Set the excelimage field to null in the database
    //         $price->excelimage = null;
    //         $price->save();

    //         return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    //     }

    //     // If no image exists, return an error response
    //     return response()->json(['success' => false, 'message' => 'No image found to delete'], 404);
    // }

    public function deleteImage()
    {
        $price = Pricing::first();
    
        if ($price && $price->excelimage) {
            if (Storage::exists($price->excelimage)) {
                Storage::delete($price->excelimage);
            }
    
            // Set excelimage to null and save the change
            $price->excelimage = null;
            $price->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }
    



    public function update(Request $request,SubscriptionPlan $subscriptionPlan){
        $field=$subscriptionPlan->slug;
        
        Session::put("__payment_price___","payment");
        Session::put("__payment_price_form___","$field");
        
        if(($request->$field['is_external']??"")=="Y"){

            $request->validate([
                "$field"=>['required'],
                "$field.external_label"=>['required'],
                "$field.external_link"=>['required'],
                "$field.title"=>['required'],
                "$field.content"=>['nullable'],
                "$field.icon"=>['nullable']
            ],[
                "$field.required"=>"The field is required",
                "$field.external_label.required"=>"This external label field is required",
                "$field.external_link.required"=>"This external link field is required",
                "$field.title.required"=>"This basic title is required",
                "$field.content.required"=>"This content field is required",
                "$field.icon.required"=>"This icon field is required",
            ]);
        }else{

            $request->validate([
                "$field"=>['required'],
                "$field.basic_amount"=>['required','numeric','min:1','max:100000'],
                "$field.combo_amount"=>['required','numeric','min:1','max:100000'],
                // "$field.start_plan"=>['required'],
                "$field.end_plan"=>['required'],
                "$field.title"=>['required'],
                "$field.content"=>['nullable'],
                "$field.icon"=>['nullable']
            ],[
                "$field.required"=>"The field is required",
                "$field.basic_amount.required"=>"This basic amount field is required",
                "$field.combo_amount.required"=>"This combo amount field is required",
                "$field.title.required"=>"This basic title is required",
                "$field.content.required"=>"This content field is required",
                "$field.icon.required"=>"This icon field is required",
                "$field.end_plan.required"=>"This end plan field is required",
                "$field.start_plan.required"=>"This start plan field is required",
            ]);
        }
        $title=$request->$field["title"];
        $content=$request->$field["content"];
        $icon=$request->$field["icon"];
        $basic_amount=null;
        $combo_amount=null;
        $start_plan=null;
        $end_plan=null;
        $external_label=null;
        $external_link=null;
        $basic_amount_id=null;
        $combo_amount_id=null;

        if(($request->$field['is_external']??"")!=="Y"){
            $basic_amount=$request->$field["basic_amount"];
            $combo_amount=$request->$field["combo_amount"];
            // $start_plan=$request->$field["start_plan"];
            $end_plan=$request->$field["end_plan"];
                
            $price1=Payment::stripe()->prices->create([
                'currency' => config('stripe.currency'),
                'unit_amount' => intval($basic_amount*100),
                'product_data' => ['name' => ' Amount :'.(intval($basic_amount*100)/100).' For '.ucfirst($title)],
                'metadata'=>[
                    'modify_time'=>date('Y-m-d h:i a'),
                    'title'=>$title,
                    "old_key"=>$subscriptionPlan->basic_amount_id??"-", 
                ]
            ]); 
            $basic_amount_id=$price1->id; 
            $price2=Payment::stripe()->prices->create([
                'currency' => config('stripe.currency'),
                'unit_amount' => intval($combo_amount*100*2),
                'product_data' => ['name' => ' Amount :'.(intval($combo_amount*100)/100).' For '.ucfirst($title)],
                'metadata'=>[
                    'modify_time'=>date('Y-m-d h:i a'),
                    'title'=>$title, 
                    "old_key"=>$subscriptionPlan->combo_amount_id??"-",
                ]
            ]);  
            $combo_amount_id=$price2->id;
        }else{
            $external_label=$request->$field["external_label"];
            $external_link=$request->$field["external_link"];
        }

        $subscriptionPlan->update([
            "name"=>Str::slug($title),
            "title"=>$title,
            "content"=>$content,
            'basic_amount'=>$basic_amount,
            'basic_amount_id'=>$basic_amount_id,
            'combo_amount'=>$combo_amount,
            'combo_amount_id'=>$combo_amount_id,
            'icon'=>$icon,
            // 'start_plan'=>$start_plan,
            'end_plan'=>$end_plan,
            'external_link'=>$external_link,
            'external_label'=>$external_label,
            'is_external'=>(($request->$field['is_external']??"")=="Y")?true:false,
        ]);
        if($request->ajax()){
            return response()->json([
                'success'=>"Plan Updated",
            ]);
        }
        return redirect()->back()->with('success',"Plan Updated");
    }
    public function destroy(Request $request,SubscriptionPlan $subscriptionPlan){
        $subscriptionPlan->delete();
        if($request->ajax()){
            return response()->json([
                'success'=>"Plan Deleted",
            ]);
        }
        return redirect()->back()->with('success',"Plan Deleted");
    }




    // public function deleteFeelingImage()
    // {
    //     // Retrieve the Pricing record
    //     $price = Pricing::first();

    //     // Check if the image exists and is not null
    //     if ($price && $price->feelingimage) {
    //         // Get the full path of the image
    //         $imagePath = public_path($price->feelingimage);

    //         // Check if the file exists in the storage
    //         if (Storage::exists('public/price/' . basename($price->feelingimage))) {
    //             // Delete the file from storage
    //             Storage::delete('public/price/' . basename($price->feelingimage));
    //         }

    //         // Set the excelimage field to null in the database
    //         $price->feelingimage = null;
    //         $price->save();

    //         return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    //     }

    //     // If no image exists, return an error response
    //     return response()->json(['success' => false, 'message' => 'No image found to delete'], 404);
    // }

    public function deleteFeelingImage()
    {
        $price = Pricing::first();
    
        if ($price && $price->feelingimage) {
            if (Storage::exists($price->feelingimage)) {
                Storage::delete($price->feelingimage);
            }
    
            // Set feelingimage to null and save the change
            $price->feelingimage = null;
            $price->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }
    
    

    // public function deleteImage2()
    // {
    //     // Retrieve the Pricing record
    //     $price = Pricing::first();

       

    //     // Check if the image exists and is not null
    //     if ($price && $price->image) {

           
    //         // Get the full path of the image
    //         $imagePath = public_path($price->image);

    //         // Check if the file exists in the storage
    //         if (Storage::exists('public/price/' . basename($price->image))) {
    //             // Delete the file from storage
    //             Storage::delete('public/price/' . basename($price->image));
    //         }
       
    //         // Set the excelimage field to null in the database
    //         $price->image = null;
    //         $price->save();

    //         return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    //     }

    //     // If no image exists, return an error response
    //     return response()->json(['success' => false, 'message' => 'No image found to delete'], 404);
    // }



    public function deleteImage2()
{
    $price = Pricing::first();

    if ($price && $price->image) {
        if (Storage::exists($price->image)) {
            Storage::delete($price->image);
        }

        // Set image to null and save the change
        $price->image = null;
        $price->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}




}


