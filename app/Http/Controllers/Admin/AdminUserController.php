<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPermissions;
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

            self::$defaultActions=["edit"]; 
            return $this->where('role','super')
            ->addAction(function($data){
                return '                
                     <a onclick="ShowAdmin(this)" data-id="'.$data->id.'" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                        <img src="' . asset("assets/images/icons/mdi_incognito.svg") . '" alt="View">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/view-yellow.svg") . '" alt="View Active" title="View">
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

    function save_permission(Request $request)
    {
        $id = $request->id;
        $field_name = $request->field_name;
        $value = $request->value;

        $admin_permission  = AdminPermissions::where('admin_id',$id)->first();

        if(empty($admin_permission))
        {
            $admin_permission  = new AdminPermissions;
            $admin_permission->admin_id = $id;
        }
        $admin_permission->{$field_name } = $value??'N';

        $admin_permission->save();

        return response()->json([
            'message' => 'The Admin Permission Updated Successfully.'
        ]);
      
    }


    function get_permission(Request $request)
    {
        $id = $request->id;
      
        $admin_permission  = AdminPermissions::where('admin_id',$id)->first();

        if(!empty($admin_permission))
        {
            return response()->json(['data' => $admin_permission]);
        }
        
        return response()->json([
            'message' => 'The Admin Permission Not Created.'
        ]);
    }
}
