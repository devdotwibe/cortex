<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BackUpController extends Controller
{
    use ResourceController;
    


    public function index(Request $request)
    {
       
        $questions = Question::with('adminUser')->onlyTrashed()->where('id','>','0');

        if ($request->ajax()) {
            return DataTables::of($questions)

                ->addColumn("admin_user", function ($data) {

                    return $data->adminUser ? $data->adminUser->email : 'No Admin';

                })

                ->addColumn("question", function ($data) {
                    return strip_tags($data->description); 
                })

                ->addColumn("deleted_at", function ($data) {

                    return $data->deleted_at->format('Y-m-d H:i:s');

                })
               
                ->addColumn("action", function ($data) {
                    return
                    
                        '<a onclick="delsubfaq('."'".route('admin.tip.del_tip', $data->id)."'".')" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                        </span>
                    </a> ';

                })


                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("admin.back_up_files.index");
    }


}
