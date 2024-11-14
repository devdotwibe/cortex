<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;
use App\Trait\ResourceController;

class AdminUserController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Admin::class;
        self::$routeName="admin.admin_user";
        self::$defaultActions=[''];

    }

    public function index (Request $request)
    {
        if($request->ajax()){

            self::$defaultActions=["edit","delete"]; 
            return $this->where('role','super')
            ->addAction(function($data){
                return '                
                     <a onclick="editcoupon('."'".route("admin.coupon.edit",$data->id)."'".')" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                        <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                        </span>
                    </a>

                ';
            })->buildTable();
        }

        return view('admin.admin_users.index');
    }

    
    public function store (Request $request)
    {
       
        $request->validate([

            "email"=>["required",'email:rfc,dns','unique:users','unique:admins','max:250'],
            "password"=>["required",'string'],
            "conform_password" => ["required","same:password"]
        ]);

        $admin = new Admin;

        $admin->name = 'admin '.$admin->id;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        $admin->save();

        return response()->json(['status' => 'success', 'message' => 'User created successfully!']);
       
    }
}
