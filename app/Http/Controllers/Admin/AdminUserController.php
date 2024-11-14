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
            return $this->addAction(function($data){
                return '
               

                <a href="'.route("admin.full-mock-exam.index",["exam"=>$data->id]).'" class="btn btn-icons eye-button">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/mdi_incognito.svg") . '" alt="View">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/view-yellow.svg") . '" alt="View Active" title="View">
                            </span>
                 </a>


                ';
            })->where('role','!=','master')->buildTable();
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
