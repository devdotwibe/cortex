<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ImportIbDataJob;
use App\Models\Timetable;
use App\Models\User;
use App\Models\UserExamReview;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\Learn;
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
        self::$model = User::class;
        self::$routeName = "admin.user";
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->usertype)) {
                switch ($request->usertype) {
                    case 'free-users':
                        $this->where("is_free_access", false);
                        break;
                    case 'paid-users':
                        $this->where(function ($qry) {
                            $qry->where(function($query){
                                $query->whereIn("id", UserSubscription::where('status', 'subscribed')->select('user_id'))
                                      ->orWhere("is_free_access", true);
                            });
                        });
                        break;
                    case 'student-users':
                        $this->where(function ($qry) {
                            $qry->whereIn('id', PrivateClass::where('status', '!=', 'rejected')->select('user_id'));
                        });
                        break;
                    case 'non-student-users':
                        $this->where(function ($qry) {
                            $qry->doesntHave('privateClass');
                        });
                        break;


                    default:
                        break;
                }
            }

            if(!empty($request->termname)){

                $termname= $request->termname;

                $this->where(function($qry)use($termname){

                    $qry->whereIn('id',TermAccess::where('type','home-work')->where('term_id',HomeWork::where('term_name',$termname)->select('id'))->select('user_id'))


                    ->orWhereIn('id',TermAccess::where('type','class-detail')->where('term_id',ClassDetail::where('term_name',$termname)->select('id'))->select('user_id'))
                    -> orWhereIn('id',TermAccess::where('type','lesson-material')->where('term_id',LessonMaterial::where('term_name',$termname)->select('id'))->select('user_id'))
                    -> orWhereIn('id',TermAccess::where('type','lesson-recording')->where('term_id',LessonRecording::where('term_name',$termname)->select('id'))->select('user_id'))
               ;
                });

            }

        //     return $this->addColumn('is_free_access', function ($data) {
        //         return '<div class="form-check form-switch">
        //                     <input class="form-check-input" type="checkbox" onchange="changeactivestatus(' . "'" . route('admin.user.freeaccess', $data->slug) . "'" . ')" role="switch" id="free-toggle-' . $data->id . '"  ' . ($data->is_free_access ? "checked" : "") . '/>
        //                     <label class="form-check-label" for="free-toggle-' . $data->id . '">Free</label>
        //                 </div>';
        // })

               return $this->addColumn('is_free_access', function ($data) {


                return '  <a onclick="UserAccess(\'' . $data->slug . '\',this)" data-access="'.$data->free_access_terms.'" target="_blank" rel="noreferrer" class="btn btn-icons">
                            <span class="adminside-icon">
                                <img src="' . asset('assets/images/new_lock.png') . '" alt="User Access">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset('assets/images/new_lock_hover.png') . '" alt="User Access" title="User Access">
                            </span>
                        </a> ';

                })




            ->addColumn('is_user_verfied', function ($data) {
            return '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" onchange="changeactivestatus(' . "'" . route('admin.user.is_user_verfied', $data->slug) . "'" . ')" role="switch" id="free-toggle-' . $data->id . '"  ' . ($data->email_verified_at ? "checked" : "") . '/>
                        <label class="form-check-label" for="free-toggle-' . $data->id . '">Verified</label>
                    </div>';

            })->addColumn('post_status', function ($data) {
                return '<div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" onchange="changeactivestatus(' . "'" . route('admin.user.comunity', $data->slug) . "'" . ')" role="switch" id="active-toggle-' . $data->id . '"  ' . ($data->post_status == "active" ? "checked" : "") . '/>
                            <label class="form-check-label" for="active-toggle-' . $data->id . '">Active</label>
                        </div>';
            })->addAction(function ($data) {

                $privateclass =PrivateClass::where('user_id',$data->id)->first();

                $action ="";

                if(empty($privateclass))
                {
                    $action .='
                                <a onclick="UpgradeUser(\'' . $data->slug . '\')" target="_blank" rel="noreferrer" class="btn btn-icons upgrade_btn">
                                    <span class="adminside-icon">
                                        <img src="' . asset('assets/images/updgrade.png') . '" alt="Register List">
                                    </span>
                                    <span class="adminactive-icon">
                                        <img src="' . asset('assets/images/updgrade.png') . '" alt="Register Active" title="Register List">
                                    </span>
                                </a> ';

                }

                $action .= '
                                <a href="' . route('admin.user.spectate', $data->slug) . '" target="_blank" rel="noreferrer" class="btn btn-icons spectate_btn">
                                    <span class="adminside-icon">
                                        <img src="' . asset('assets/images/icons/mdi_incognitospectate.svg') . '" alt="Spectate">
                                    </span>
                                    <span class="adminactive-icon">
                                        <img src="' . asset('assets/images/iconshover/mdi_incognito-yellow.svg') . '" alt="Spectate Active" title="Spectate">
                                    </span>
                                </a>

                                <a onclick="resetpassword(' . "'" . route('admin.user.resetpassword', $data->slug) . "'" . ')" class="btn btn-icons reset_btn">
                                    <span class="adminside-icon">
                                        <img src="' . asset('assets/images/icons/material-symbols_lock-outline.svg') . '" alt="Reset Password">
                                    </span>
                                    <span class="adminactive-icon">
                                        <img src="' . asset('assets/images/iconshover/material-symbols_lock-yellow.svg') . '" alt="Reset Password Active" title="Reset Password">
                                    </span>
                                </a> ';

                return $action;

            })->buildTable(['post_status', 'is_free_access','is_user_verfied']);
        }
        $unverifyuser = User::whereNull('email_verified_at')->count();
        $verifyuser = User::whereNotNull('email_verified_at')->count();
        $freeuser = User::where('is_free_access', true)->count();
        $paiduser = User::whereIn('id', UserProgress::where('name', "cortext-subscription-payment")->where('value', 'paid')->select('user_id'))->count();


        $terms = [];

        $terms1 = ClassDetail::get();
        $terms2 = LessonMaterial::get();
        $terms3 = HomeWork::get();
        $terms4 = LessonRecording::get();

        foreach ($terms1 as $item) {
            $terms[] = $item->term_name;
        }
        foreach ($terms2 as $item) {
            if (!in_array($item->term_name, $terms)) {
                $terms[] = $item->term_name;
            }
        }

        foreach ($terms3 as $item) {
            if (!in_array($item->term_name, $terms)) {
                $terms[] = $item->term_name;
            }
        }

        foreach ($terms4 as $item) {
            if (!in_array($item->term_name, $terms)) {
                $terms[] = $item->term_name;
            }
        }

        $page_name = "Registered Users";

        $allTerms = $terms1->concat($terms2)->concat($terms3)->concat($terms4);

        $category = Category::where('id', '>', 0)
        ->whereHas('subcategories', function ($qry) {
            $qry->whereIn('id', Learn::select('sub_category_id'));
        })
        ->get();

        $time_slot = Timetable::where('hide_time', '!=', 'Y')->get()->map(function($item) {
            $text = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ') - Year ' . $item->year;
            return [
                'text' => $text,
                'value' => $text,
            ];
        })->toArray();

        return view("admin.user.index", compact('time_slot','category','page_name','unverifyuser','terms', 'verifyuser', 'paiduser', 'freeuser'));
    }
    public function create(Request $request)
    {
        return view("admin.user.create");
    }
    public function bulkaction(Request $request)
    {

        if (!empty($request->deleteaction)) {
            if ($request->input('select_all', 'no') == "yes") {

                User::whereIn('id', $request->input('select_all_values', []))->delete();

            } else {
                User::whereIn('id', $request->input('selectbox', []))->delete();
            }
            if ($request->ajax()) {
                return response()->json(["success" => "Users deleted success"]);
            }
            return redirect()->route('admin.user.index')->with("success", "Users deleted success");
        }
        elseif(!empty($request->time_slot_action))
        {
            $users = $request->input('selectbox', []);

            $selectedTimeSlot = explode(',',$request->user_time_slot);

            foreach($users as $user)
            {
                $real_user = User::find($user);

                $private_class_exist = PrivateClass::where('user_id',$user)->first();

                if(empty($private_class_exist))
                {
                    $private_class = new PrivateClass;

                    $private_class->email = $real_user->email;
                    $private_class->full_name = $real_user->first_name .' '.$real_user->last_name;
                    $private_class->parent_name = null;
                    $private_class->timeslot = $selectedTimeSlot;
                    $private_class->user_id = $user;
                    $private_class->status = 'approved';
                    $private_class->is_valid = true;

                    $private_class->save();
                }
            }

            if ($request->ajax()) {
                return response()->json(["success" => "User Registered success"]);
            }

            return redirect()->route('admin.user.index')->with("success", "Users deleted success");
        }
        elseif(!empty($request->user_access_action))
        {
            $users = $request->input('selectbox', []);

            $user_access = $request->user_access;

            foreach($users as $user)
            {
                $real_user = User::find($user);

                $real_user->free_access_terms = $user_access;

                $access= false;

                if(!empty($user_access))
                {
                    $access= true;
                }

                $real_user->is_free_access = $access;

                $real_user->save();
            }

            if ($request->ajax()) {
                return response()->json(["success" => "User Access success"]);
            }

        }
        else {
            $request->validate([
                "bulkaction" => ['required']
            ]);
            $data = [];
            switch ($request->bulkaction) {
                case 'enable-free-access':
                    $data["is_free_access"] = true;
                    break;
                case 'disable-free-access':
                    $data["is_free_access"] = false;
                    break;
                case 'enable-community':
                    $data["post_status"] = "active";
                    break;
                case 'disable-community':
                    $data["post_status"] = "banned";
                    break;

                default:
                    # code...
                    break;
            }
            if ($request->input('select_all', 'no') == "yes") {
                User::where('id', '>', 0)->update($data);
            } else {
                User::whereIn('id', $request->input('selectbox', []))->update($data);
            }

            if ($request->ajax()) {
                return response()->json(["success" => "Users update success"]);
            }
            return redirect()->route('admin.user.index')->with("success", "Users update success");
        }
    }

    public function upgrade_user(Request $request)
    {
        $real_user = User::findSlug($request->slug);

        $selectedTimeSlot = $request->user_time_slot;

        $private_class_exist = PrivateClass::where('user_id',$real_user->id)->first();

        if(empty($private_class_exist))
        {
            $private_class = new PrivateClass;

            $private_class->email = $real_user->email;
            $private_class->full_name = $real_user->first_name .' '.$real_user->last_name;
            $private_class->parent_name = null;
            $private_class->timeslot = $selectedTimeSlot;
            $private_class->user_id = $real_user->id;
            $private_class->status = 'approved';
            $private_class->is_valid = true;

            $private_class->save();
        }
        if ($request->ajax()) {
            return response()->json(["success" => "User Registered success"]);
        }

        return redirect()->route('admin.user.index')->with("success", "Users deleted success");
    }

    public function show(Request $request, User $user)
    {

        if ($request->ajax()) {
            self::$model = PaymentTransation::class;
            self::$defaultActions = [""];
            return  $this->where('user_id', $user->id)->buildTable();
        }
        return view("admin.user.show", compact('user'));
    }
    public function edit(Request $request, User $user)
    {
        return view("admin.user.edit", compact('user'));
    }
    public function userspectate(Request $request, User $user)
    {
        Auth::guard('web')->login($user);
        return redirect('/dashboard');
    }

    public function userspectate1(Request $request, User $user)
    {
        Auth::guard('web')->login($user);
        return redirect()->route('home-work.index', $user->slug);
    }
    public function usercomunity(Request $request, User $user)
    {
        $user->update([
            'post_status' => $user->post_status == "active" ? "banned" : "active"
        ]);
        return response()->json([
            'success' => "Community status updated"
        ]);
    }
    public function freeaccess(Request $request)
    {
        $user_slug = $request->user_slug;

        $user = User::findSlug($user_slug);

        $user_access = $request->user_access;

        $user_access_string ="";

        $access= false;

        if(!empty($user_access))
        {
            $values = array_column($user_access, 'value');

            $filtered_values = array_filter($values, function($value) {
                return !is_null($value);
            });

            $user_access_string = implode(',', $values);

            $access= true;
        }

        $user->is_free_access = $access;
        $user->free_access_terms = $user_access_string;

        $user->save();

        // $user->update([
        //     'is_free_access' => $user->is_free_access ? false : true
        // ]);
        return response()->json([
            'success' => "Free User status updated"
        ]);
    }

    public function is_user_verfied(Request $request, User $user)
    {
        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now()
        ]);
        return response()->json([
            'success' => "Email status updated"
        ]);
    }

    public function termslist(Request $request, User $user)
    {
        $terms = [];
        foreach (ClassDetail::all() as $term) {
            $name = trim($term->term_name);
            $terms[$name] = ($terms[$name] ?? 0) + (TermAccess::where('type', 'class-detail')->where('term_id', $term->id)->where('user_id', $user->id)->count() > 0 ? 1 : 0);
        }
        foreach (LessonMaterial::all() as $term) {
            $name = trim($term->term_name);
            $terms[$name] = ($terms[$name] ?? 0) + (TermAccess::where('type', 'lesson-material')->where('term_id', $term->id)->where('user_id', $user->id)->count() > 0 ? 1 : 0);
        }
        foreach (HomeWork::all() as $term) {
            $name = trim($term->term_name);
            $terms[$name] = ($terms[$name] ?? 0) + (TermAccess::where('type', 'home-work')->where('term_id', $term->id)->where('user_id', $user->id)->count() > 0 ? 1 : 0);
        }
        foreach (LessonRecording::all() as $term) {
            $name = trim($term->term_name);
            $terms[$name] = ($terms[$name] ?? 0) + (TermAccess::where('type', 'lesson-record')->where('term_id', $term->id)->where('user_id', $user->id)->count() > 0 ? 1 : 0);
        }
        $user->termsList = $terms;
        $user->updateUrl = route("admin.user-access.user.update", $user->slug);
        return $user;
    }
    public function resetpassword(Request $request, User $user)
    {
        $data = $request->validate([
            "password" => ["required", 'string', 'min:6', 'max:250'],
            "re_password" => ["required", "same:password"]
        ]);
        $user->update($data);
        if ($request->ajax()) {
            return response()->json(["success" => "User `" . $user->name . "` Password has been successfully updated"]);
        }
        return redirect()->route('admin.user.index')->with("success", "User `" . $user->name . "` Password has been successfully updated");
    }
    public function update(Request $request, User $user)
    {

        $userdat = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "phone" => "required",
            "schooling_year" => "required",
        ]);

        // $user->update($userdat);
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->schooling_year = $request->schooling_year;
        $user->save();

        return redirect()->route('admin.user.index')->with("success", "User updated success");
    }

    public function destroy(Request $request, User $user)
    {
        PrivateClass::where('user_id', $user->id)->delete();
        $user->delete();
        if ($request->ajax()) {
            return response()->json(["success" => "User deleted success"]);
        }
        return redirect()->route('admin.user.index')->with("success", "User deleted success");
    }
    public function getdata(Request $request)
    {
        self::$model = UserExamReview::class;

        if ($request->ajax()) {
            return $this->addAction(function ($data) {
                $title = "";
                switch ($data->name) {
                    case 'learn':
                        $category = Category::find($data->category_id);
                        $subcategory = SubCategory::find($data->sub_category_id);
                        $title = "{$category->name}-{$subcategory->name}";
                        break;

                    case 'question-bank':
                        $category = Category::find($data->category_id);
                        $subcategory = SubCategory::find($data->sub_category_id);
                        $subcategorySet = SubCategory::find($data->sub_category_set);
                        $title = "{$category->name}-{$subcategory->name} - {$subcategorySet->name}";
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


        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');


            $avathar = "files";
            $filePath = $avathar . "/" . md5(time()) . "." . $file->getClientOriginalExtension();
            Storage::put("{$filePath}", file_get_contents($file));
            $data = json_decode(Storage::get($filePath), true);


            $headers = isset($data[0]) ? $data[0] : [];

            return response()->json(["data" => $headers, "filepath" => $filePath]);
        }
        // } catch (\Throwable $th) {
        //     //throw $th;
        // return response()->json(['message' => $th->getMessage()], 400);
        // }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function import_users_from_csv_submit(Request $request)
    {


        $request->validate([
            'first_name' => 'required|string|max:255',

        'email' => 'required|max:255',
        'expiry_date' => 'required|date',


        ]);


        $datas = json_decode($request->input('datas'), true);



        $experidate = $request->expiry_date;

        $filePath = $request->input('path', '');

        dispatch(job: new ImportIbDataJob($datas, $filePath, $experidate));


        return response()->json(['success' => 'Import process has started successfully']);
    }
}
