<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserExamReview;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;
use App\Models\PaymentTransation;
use App\Models\PrivateClass;
use App\Models\Setname;
use App\Models\TermAccess;
use App\Models\UserProgress;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            if(!empty($request->usertype)){
                switch ($request->usertype) {
                    case 'free-users': 
                        $this->where("is_free_access",false);
                        break;
                    case 'paid-users': 
                        $this->where(function($qry){
                            $qry->whereIn("id",UserSubscription::where('status','subscribed')->select('user_id'));
                            $qry->orWhere("is_free_access",true);
                        });
                        break;
                    case 'student-users': 
                        $this->where(function($qry){
                            $qry->whereIn('id',PrivateClass::where('status','!=','rejected')->select('user_id'));
                        });
                        break;
                    
                    default: 
                        break;
                }
            }
            return $this->addColumn('is_free_access',function($data){ 
                return '<div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" onchange="changeactivestatus('."'".route('admin.user.freeaccess',$data->slug)."'".')" role="switch" id="free-toggle-'.$data->id.'"  '.($data->is_free_access?"checked":"").'/>
                            <label class="form-check-label" for="free-toggle-'.$data->id.'">Free</label>
                        </div>'; 
            })->addColumn('post_status',function($data){ 
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
            })->buildTable(['post_status','is_free_access']);
        }
        $unverifyuser=User::whereNull('email_verified_at')->count();
        $verifyuser=User::whereNotNull('email_verified_at')->count();
        $freeuser=User::where('is_free_access',true)->count();
        $paiduser=User::whereIn('id',UserProgress::where('name',"cortext-subscription-payment")->where('value','paid')->select('user_id'))->count();
        return view("admin.user.index",compact('unverifyuser','verifyuser','paiduser','freeuser'));
    }
    public function create(Request $request){
        return view("admin.user.create");
    } 
    public function bulkaction(Request $request){
        if(!empty($request->deleteaction)){
            if($request->input('select_all','no')=="yes"){
                User::where('id','>',0)->delete();
            }else{
                User::whereIn('id',$request->input('selectbox',[]))->delete();
            }
            if($request->ajax()){
                return response()->json(["success"=>"Users deleted success"]);
            }
            return redirect()->route('admin.user.index')->with("success","Users deleted success");
        }else{
            $request->validate([
                "bulkaction"=>['required']
            ]);
            $data=[];
            switch ($request->bulkaction) {
                case 'enable-free-access':
                    $data["is_free_access"]=true;
                    break;
                case 'disable-free-access':
                    $data["is_free_access"]=false;
                    break;
                case 'enable-community':
                    $data["post_status"]="active";
                    break;
                case 'disable-community':
                    $data["post_status"]="banned";
                    break;
                
                default:
                    # code...
                    break;
            }
            if($request->input('select_all','no')=="yes"){
                User::where('id','>',0)->update($data);
            }else{
                User::whereIn('id',$request->input('selectbox',[]))->update($data);
            }

            if($request->ajax()){
                return response()->json(["success"=>"Users update success"]);
            }
            return redirect()->route('admin.user.index')->with("success","Users update success");
        }
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

    public function userspectate1(Request $request,User $user){
        Auth::guard('web')->login($user);
        return redirect()->route('live-class.privateclass.room',$user->slug);
    }
    public function usercomunity(Request $request,User $user){
        $user->update([
            'post_status'=>$user->post_status=="active"?"banned":"active"
        ]);
        return response()->json([
            'success'=>"Community status updated"
        ]);
    }
    public function freeaccess(Request $request,User $user){
        $user->update([
            'is_free_access'=>$user->is_free_access?false:true
        ]);
        return response()->json([
            'success'=>"Community status updated"
        ]);
    }
    public function termslist(Request $request,User $user){
        $terms=[];
        foreach(ClassDetail::all() as $term){
            $name=trim($term->term_name); 
            $terms[$name]=($terms[$name]??0)+(TermAccess::where('type','class-detail')->where('term_id',$term->id)->where('user_id',$user->id)->count()>0?1:0); 
        }
        foreach(LessonMaterial::all() as $term){
            $name=trim($term->term_name); 
            $terms[$name]=($terms[$name]??0)+(TermAccess::where('type','lesson-material')->where('term_id',$term->id)->where('user_id',$user->id)->count()>0?1:0); 
        }
        foreach(HomeWork::all() as $term){
            $name=trim($term->term_name); 
            $terms[$name]=($terms[$name]??0)+(TermAccess::where('type','home-work')->where('term_id',$term->id)->where('user_id',$user->id)->count()>0?1:0); 
        }
        foreach(LessonRecording::all() as $term){
            $name=trim($term->term_name); 
            $terms[$name]=($terms[$name]??0)+(TermAccess::where('type','lesson-record')->where('term_id',$term->id)->where('user_id',$user->id)->count()>0?1:0); 
        }
        $user->termsList=$terms;
        $user->updateUrl=route("admin.user-access.user.update",$user->slug);
        return $user;
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
        PrivateClass::where('user_id',$user->id)->delete();
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


  




public function import_users_from_csv(Request $request)
{
    // dd($request->all());
    //exit();
    $file = $request->file('file_upload');

    if (!empty($file)) {
        $avatar = "files";
        $imageName = $avatar . "/" . $file->hashName();
        Storage::put($imageName, file_get_contents($file));

        $filePath = storage_path('app/' . $imageName);


        $data = array_map('str_getcsv', file($filePath));




      
        return response()->json(["data" => $data, "filepath" => $filePath]);
    }


    return response()->json(['message' => 'No file uploaded'], 400);
}
public function import_users_from_csv_submit(Request $request)
{


    $datas = json_decode($request->input('datas'), true);

    dd($datas);

    $filePath = $request->input('path');
    $csvData = array_map('str_getcsv', file($filePath));
    $reversedData = array_reverse($csvData);
    //$columnNames = array_shift($csvData);
    $columnNames = array_pop($reversedData);

    // $profile = new Profile();
    // $user = new User();

    foreach ($reversedData as $row) {

        $usersub = new UserSubscription();
        $user = new User();

        foreach ($datas as $fieldName => $csvColumn) {

            $userColumns = Schema::getColumnListing('users');

            $csvColumnIndex = array_search($csvColumn, $columnNames);


            if ($csvColumnIndex !== false && in_array($fieldName, $userColumns, true)) {
                $user->{$fieldName} = $row[$csvColumnIndex];
            }
           
        }
            $user->password = "";
           
            // $user->subscription_plan_id = "";
            $user->save();
            if ($user->save()) {

                $usersub->status = "imported_user";
                $usersub->user_id = $user->id;
                $usersub->expire_at = $request->expiry_date;
                
                $usersub->save();
            }

    }

    return response()->json($csvData);
}

}
