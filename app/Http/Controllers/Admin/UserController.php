<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserExamReview;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\PaymentTransation;
use App\Models\Setname;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=User::class;
        self::$routeName="admin.user";
    }
    public function index(Request $request){
        if($request->ajax()){
            return $this->addColumn('post_status',function($data){ 
                return '<div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" onchange="changeactivestatus('."'".route('admin.user.comunity',$data->slug)."'".')" role="switch" id="active-toggle-'.$data->id.'"  '.($data->post_status=="active"?"checked":"").'/>
                            <label class="form-check-label" for="active-toggle-'.$data->id.'">Active</label>
                        </div>'; 
            })->addAction(function($data){
                return '
                    <a href="'.route("admin.user.spectate",$data->slug).'" target="_blank" rel="noreferrer" class="btn btn-icons spectate_btn">
                        <img src="'.asset("assets/images/spectate.svg").'" alt="">
                    </a>
                    <a onclick="resetpassword('."'".route("admin.user.resetpassword",$data->slug)."'".')" class="btn btn-icons reset_btn">
                        <img src="'.asset("assets/images/lock.svg").'" alt="">
                    </a>
                ';
            })->buildTable(['post_status']);
        }
        return view("admin.user.index");
    }
    public function create(Request $request){
        return view("admin.user.create");
    }
    public function bulkaction(Request $request){
        if($request->input('select_all','no')=="yes"){
            User::where('id','>',0)->delete();
        }else{
            User::whereIn('id',$request->input('selectbox',[]))->delete();
        }
        if($request->ajax()){
            return response()->json(["success"=>"Users deleted success"]);
        }
        return redirect()->route('admin.user.index')->with("success","Users deleted success");
    }
    public function show(Request $request,User $user){

        if($request->ajax()){
            self::$model=PaymentTransation::class;
            self::$defaultActions=[""];
            return  $this->where('user_id',$user->id)->buildTable();
        }
        return view("admin.user.show",compact('user'));
    }
    public function edit(Request $request,User $user){
        return view("admin.user.edit",compact('user'));
    }
    public function userspectate(Request $request,User $user){
        Auth::guard('web')->login($user);
        return redirect('/dashboard');
    }
    public function usercomunity(Request $request,User $user){
        $user->update([
            'post_status'=>$user->post_status=="active"?"banned":"active"
        ]);
        return response()->json([
            'success'=>"Community status updated"
        ]);
    }
    public function resetpassword(Request $request,User $user){
        $data=$request->validate([
            "password"=>["required",'string','min:6','max:250'],
            "re_password" => ["required","same:password"]
        ]);
        $user->update($data);
        if($request->ajax()){
            return response()->json(["success"=>"User `".$user->name."` Password has been successfully updated"]);
        }
        return redirect()->route('admin.user.index')->with("success","User `".$user->name."` Password has been successfully updated");
    }
    public function update(Request $request,User $user){

        $userdat=$request->validate([
            "first_name"=>"required",
            "last_name"=>"required",
            "phone"=>"required",
            "schooling_year"=>"required",
        ]);

        // $user->update($userdat);
        $user->name = $request->first_name.' '.$request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->schooling_year = $request->schooling_year;
        $user->save();

        return redirect()->route('admin.user.index')->with("success","User updated success");
    }

    public function destroy(Request $request,User $user){
        $user->delete();
        if($request->ajax()){
            return response()->json(["success"=>"User deleted success"]);
        }
        return redirect()->route('admin.user.index')->with("success","User deleted success");
    }
    public function getdata(Request $request)
    {
        self::$model = UserExamReview::class;

        if ($request->ajax()) {
            return $this->addAction(function($data) {
                $title="";
                switch ($data->name) {
                    case 'learn':
                            $category = Category::find($data->category_id);
                            $subcategory = SubCategory::find($data->sub_category_id);
                            $title="{$category->name}-{$subcategory->name}" ;
                            break;

                    case 'question-bank':
                            $category = Category::find($data->category_id);
                            $subcategory = SubCategory::find($data->sub_category_id);
                            $subcategorySet = SubCategory::find($data->sub_category_set);
                            $title="{$category->name}-{$subcategory->name} - {$subcategorySet->name}" ;
                            break;

                    case 'topic-test':
                            $category = Category::find($data->category_id);
                            $title = $category->name;
                            break;

                    case 'full-mock-exam':
                        $title = $data->title;
                   }
                return $title;
            })->buildTable(); // Example method to build and return table data
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
}
