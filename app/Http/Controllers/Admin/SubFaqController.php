<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubFaqController extends Controller
{
    public function subfaq_table(Request $request)
    {
        if ($request->ajax()) {

            $faqid = $request->faqid;

            $faq = Faq::where('id','>',0)->where('faq_category_id',$faqid);

            return DataTables::of($faq)

            ->addColumn("action", function ($data) {

                return

                //'<a onclick="addsubfaq(\''.route('admin.faq.add_subfaq', $data->id).'\', \''.$data->id.'\')" class="btn btn-icons view_btn">+</a>'.
                '<a onclick="delsubfaq('."'".route('admin.faq.del_subfaq', $data->id)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/delete.svg").'" alt=""></a>'.
                '<a onclick="updatesubfaq('."'".route('admin.faq.edit_subfaq', $data->id)."'".')"  class="btn btn-icons edit_btn"><img src="'.asset("assets/images/edit.svg").'" alt=""></a>';
            })


            ->addIndexColumn()
            ->rawColumns([
                'action'
            ])

            ->make(true);

        }

        return view('admin.faq.index');
    }

    public function substore(Request $request)
    {
        
        $faq_data = $request->validate([
            // 'faq_category_id' => 'nullable|exists:faq_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string', 
        ]);
    
        
        $faq = new Faq();
    
        $faq->faq_category_id = $request->faq_id;
        $faq->question = $request->question;
        $faq->answer =$request->answer;
    
        
        $faq->save();
    
        
        return response()->json(['success' => 'FAQ Added Successfully']);
    }
    
    public function edit_subfaq(Request $request,Faq $faq){
        if($request->ajax()){
            $faq->updateUrl=route('admin.faq.update_subfaq', $faq->id);
            return response()->json($faq);
        }
    }

    function update_subfaq(Request $request, $id)
    {

        $faq = Faq::find($id);

        $edit_data = $request->validate([

            "question" => "required",
            "answer" => "required",
        ]);


        if(!empty($faq))
        {
           $faq->update($edit_data);

        }

        return response()->json(['success',"Faq Updated Successfully",'type'=>'faq']);
    
    }

    public function del_subfaq(Request $request,Faq $faq)
    {
        $faq->delete();

        return redirect()->back()->with("success","Faq deleted success");
    }



}
