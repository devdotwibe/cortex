<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;
use App\Models\LiveClassPage;
use App\Models\PrivateClass;
use App\Models\TermAccess;
use App\Models\User;
use App\Models\Timetable;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LiveClassController extends Controller
{
    use ResourceController;
    public function index()
    {

        $live_class =  LiveClassPage::first();

        $timetables = Timetable::whereNull('static')->orderBy('order_no')->get();

        $time_count = Timetable::whereNull('static')->count();

        return view('admin.live-class.index',compact('time_count','live_class','timetables'));
    }

    public function hide_button(Request $request)
    {
        $value = $request->value;
        $id = $request->id;

        $timetable = Timetable::find($id);

        $timetable->hide_time = $value;

        $timetable->save();

        return response()->json(['value'=>$value,'id'=>$timetable->id]);
    }

    public function time_order(Request $request)
    {
        $id = $request->id;
        $order = $request->value;

        if (!empty($order)) {

            $timetables = Timetable::find($id);

            if (!empty($timetables)) {

                $currentOrder = $timetables->order_no;
                $newOrder = $order;

                if ($currentOrder != $newOrder) {

                    if (abs($currentOrder - $newOrder) == 1) {

                        $newtimetables = Timetable::whereNull('static')
                                        ->where('order_no', $newOrder)->first();
                        $timetables->order_no = $newOrder;
                        $newtimetables->order_no = $currentOrder;

                        $timetables->save();
                        $newtimetables->save();
                    }
                    else
                    {
                        if ($newOrder > $currentOrder) {

                            Timetable::whereNull('static')
                            ->where('order_no', '>', $currentOrder)
                            ->where('order_no', '<=', $newOrder)
                            ->decrement('order_no');
                        }
                        else
                        {
                            Timetable::whereNull('static')
                            ->where('order_no', '<', $currentOrder)
                            ->where('order_no', '>=', $newOrder)
                            ->increment('order_no');

                        }

                        $timetables->order_no = $newOrder;
                        $timetables->save();
                    }

                }
            }
        }
        session()->flash('timeorder', 'Time order updated successfully.');

        return response()->json(['time'=>'Time order Updated']);
    }

    public function store(Request $request)
    {
        $live_class = LiveClassPage::first();

        if(empty( $live_class))
        {
            $live_class = new LiveClassPage;

        }

        if(!empty($request->class_title_1))
        {
            $live_class->class_title_1 = $request->class_title_1;
        }

        if(!empty($request->class_title_2))
        {
            $live_class->class_title_2 = $request->class_title_2;
        }

        if(!empty($request->class_description_1))
        {
            $live_class->class_description_1 = $request->class_description_1;
        }

        if(!empty($request->class_description_2))
        {
            $live_class->class_description_2 = $request->class_description_2;
        }


        if ($request->hasFile('class_image_1')) {

            $imageName = "";

            $avathar = "Live-Class";

            $file = $request->file('class_image_1');

            $imageName = $avathar . "/" . $file->hashName();

            Storage::put("{$avathar}", $file);

            $live_class->class_image_1 = $imageName;

        }

        if ($request->hasFile('class_image_2')) {

            $imageName = "";

            $avathar = "Live-Class";

            $file = $request->file('class_image_2');

            $imageName = $avathar . "/" . $file->hashName();

            Storage::put("{$avathar}", $file);

            $live_class->class_image_2 = $imageName;

        }

        $live_class->save();

        return redirect()->back()->with('success','Live Teaching Updated Successsfully');
    }

    public function private_class(Request $request)
    {
        $request->validate([

            "private_class" => "required",
        ]);


        $live_class = LiveClassPage::first();

        if(empty( $live_class))
        {
            $live_class = new LiveClassPage;
        }

        $live_class->private_class = $request->private_class;

        $live_class->save();

        return redirect()->back()->with('success','Updated Successfully');

    }


    public function intensive_class(Request $request)
    {
        $request->validate([

            "intensive_class" => "required",
        ]);


        $live_class = LiveClassPage::first();

        if(empty( $live_class))
        {
            $live_class = new LiveClassPage;
        }

        $live_class->intensive_class = $request->intensive_class;

        $live_class->save();

        return redirect()->back()->with('success','Updated Successfully');

    }

    public function private_class_create()
    {

        $live_class =  LiveClassPage::first();

        return view('admin.live-class.private-class',compact('live_class'));
    }
    public function private_class_request(Request $request){
        $page_name = "Registered Users";

        if($request->ajax()){
            self::reset();
            self::$model=PrivateClass::class;
            self::$defaultActions=[''];
            if(!empty($request->timeslot)){
                $slot= $request->timeslot;
                $this->where(function($qry)use($slot){
                    $qry->whereJsonContains('timeslot',$slot);
                });
            }
            $this ->where('status','approved');

            if(!empty($request->termname)){
                $termname= $request->termname;

                $this->where(function($qry)use($termname){

                    $qry->whereIn('user_id',TermAccess::where('type','home-work')->where('term_id',HomeWork::where('term_name',$termname)->select('id'))->select('user_id'))


                    ->orWhereIn('user_id',TermAccess::where('type','class-detail')->where('term_id',ClassDetail::where('term_name',$termname)->select('id'))->select('user_id'))
                    -> orWhereIn('user_id',TermAccess::where('type','lesson-material')->where('term_id',LessonMaterial::where('term_name',$termname)->select('id'))->select('user_id'))
                    -> orWhereIn('user_id',TermAccess::where('type','lesson-recording')->where('term_id',LessonRecording::where('term_name',$termname)->select('id'))->select('user_id'))


               ;
                });



            }





            return $this->addAction(function($data) {
                $action = "";
                if ($data->status == "pending" && !empty($data->user)) {
                    $action .= '
                    <a class="btn btn-icons" onclick="rejectrequest(\'' . route("admin.live-class.request.show", $data->slug) . '\')">
                        <span class="adminside-icon">
                            <img src="' . asset('assets/images/icons/icon-park-outline_reject.svg') . '" alt="Reject">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset('assets/images/iconshover/icon-park-outline_reject-yellow.svg') . '" alt="Reject Active">
                        </span>
                    </a>

                    <a class="btn btn-icons" data-id="' . $data->user->slug . '" onclick="acceptrequest(\'' . route("admin.live-class.request.show", $data->slug) . '\')">
                        <span class="adminside-icon">
                            <img src="' . asset('assets/images/icons/accept.svg') . '" alt="Accept">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset('assets/images/iconshover/accept-yellow.svg') . '" alt="Accept Active">
                        </span>
                    </a>
                    ';
                }

                // if (!empty($data->user)) {
                    if($data->status=="approved"&&!empty($data->user)){
                    $action .= '



                    <a href="' . route("admin.user.spectate1", $data->user->slug) . '" target="_blank" rel="noreferrer" class="btn btn-icons spectate_btn">
                    <span class="adminside-icon">
                        <img src="' . asset('assets/images/icons/mdi_incognitospectate.svg') . '" alt="Spectate">
                    </span>
                    <span class="adminactive-icon">
                        <img src="' . asset('assets/images/iconshover/mdi_incognito-yellow.svg') . '" alt="Spectate Active" title="Spectate">
                    </span>
                </a>';


                }




                if($data->status=="approved"&&!empty($data->user)){
                        $action.='


                        <a  class="btn btn-icons" onclick="updaterequest('."'".route("admin.live-class.request.show",$data->slug)."'".')">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
    </span>
</a>


                    ';
                }
                $action.='
                 <a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.live-class.request.destroy",$data->slug).'">
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                        </span>
                    </a>





                ';
                return $action;
            })->addColumn('timeslottext',function($data){
                return implode('<br> ',$data->timeslot);
            })->addColumn('termhtml',function($data){
                if(!empty($data->user)&&$data->status=="approved"){
                    return '<a  onclick="usertermlist('."'".route('admin.user.termslist', $data->user->slug)."'".')" class="btn btn-icons view_btn">+</a>';
                }else{
                    return '';
                }
            })->addColumn('statushtml',function($data){
                if(!empty($data->user)){
                    switch ($data->status) {
                        case 'approved':
                            return '<div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" onchange="changeactivestatus('."'".route('admin.live-class.request.status',$data->slug)."'".')" role="switch" id="active-toggle-'.$data->id.'"  '.($data->is_valid?"checked":"").'/>
                                        <label class="form-check-label" for="active-toggle-'.$data->id.'">Active</label>
                                    </div>';
                        case 'pending';
                            return '<span class="badge bg-warning">'.ucfirst($data->status).'</span>';
                        case 'rejected';
                            return '<span class="badge bg-danger">'.ucfirst($data->status).'</span>';
                        default:
                            return '<span class="badge bg-secondary">'.ucfirst($data->status).'</span>';
                    }
                }else{
                    return '<span class="badge bg-danger"> Deleted User </span>';
                }
            })->buildTable(['timeslottext','statushtml','termhtml']);
        }
        $live_class =  LiveClassPage::first();

        $terms = [];

        // Retrieve terms from the models
        $terms1 = ClassDetail::get();
        $terms2 = LessonMaterial::get();
        $terms3 = HomeWork::get();
        $terms4 = LessonRecording::get();

        // Collect unique terms from $terms1
        foreach ($terms1 as $item) {
            $terms[] = $item->term_name;
        }

        // Collect unique terms from $terms2
        foreach ($terms2 as $item) {
            if (!in_array($item->term_name, $terms)) { // Use in_array() to check existence
                $terms[] = $item->term_name;
            }
        }

        // You can repeat similar logic for $terms3 and $terms4 if needed
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

        $allTerms = $terms1->concat($terms2)->concat($terms3)->concat($terms4);

        $sloteterms_items = Timetable::where('hide_time', '!=', 'Y')->whereNull('static')->orderBy('order_no')->get()->map(function($item) {
            $text = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ') ' . $item->year;
            $value = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ') ' . $item->year;
            return [
                'text' => $text,
                'id' => $value,
            ];
        })->toArray();

        return view('admin.live-class.private-class-request',compact('sloteterms_items','live_class','terms','page_name'));
    }
    public function private_class_pending(Request $request){

        $page_name = "Pending Users";

        if($request->ajax()){
            self::reset();
            self::$model=PrivateClass::class;
            self::$defaultActions=[''];
            if(!empty($request->timeslot)){
                $slot= $request->timeslot;
                $this->where(function($qry)use($slot){
                    $qry->whereJsonContains('timeslot',$slot);
                });
            }

            $this->where(function($qry){
                $qry->where('status','pending');
                $qry->orWhere('status','rejected');
            });

            if(!empty($request->termname)){
                $termname= $request->termname;

                $this->where(function($qry)use($termname){

                    $qry->whereIn('user_id',TermAccess::where('type','home-work')->where('term_id',HomeWork::where('term_name',$termname)->select('id'))->select('user_id'))


                    ->orWhereIn('user_id',TermAccess::where('type','class-detail')->where('term_id',ClassDetail::where('term_name',$termname)->select('id'))->select('user_id'))
                    -> orWhereIn('user_id',TermAccess::where('type','lesson-material')->where('term_id',LessonMaterial::where('term_name',$termname)->select('id'))->select('user_id'))
                    -> orWhereIn('user_id',TermAccess::where('type','lesson-recording')->where('term_id',LessonRecording::where('term_name',$termname)->select('id'))->select('user_id'))


               ;
                });



            }





            return $this->addAction(function($data) {
                $action = "";
                if ($data->status == "pending" && !empty($data->user)) {
                    $action .= '
                    <a class="btn btn-icons" onclick="rejectrequest(\'' . route("admin.live-class.request.show", $data->slug) . '\')">
                        <span class="adminside-icon">
                            <img src="' . asset('assets/images/icons/icon-park-outline_reject.svg') . '" alt="Reject">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset('assets/images/iconshover/icon-park-outline_reject-yellow.svg') . '" alt="Reject Active">
                        </span>
                    </a>

                    <a class="btn btn-icons" data-id="' . $data->user->slug . '" onclick="acceptrequest(\'' . route("admin.live-class.request.show", $data->slug) . '\')">
                        <span class="adminside-icon">
                            <img src="' . asset('assets/images/icons/accept.svg') . '" alt="Accept">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset('assets/images/iconshover/accept-yellow.svg') . '" alt="Accept Active">
                        </span>
                    </a>
                    ';
                }

                // if (!empty($data->user)) {
                    if($data->status=="approved"&&!empty($data->user)){
                    $action .= '

                    <a href="' . route("admin.user.spectate1", $data->user->slug) . '" target="_blank" rel="noreferrer" class="btn btn-icons spectate_btn">
                    <span class="adminside-icon">
                        <img src="' . asset('assets/images/icons/mdi_incognitospectate.svg') . '" alt="Spectate">
                    </span>
                    <span class="adminactive-icon">
                        <img src="' . asset('assets/images/iconshover/mdi_incognito-yellow.svg') . '" alt="Spectate Active" title="Spectate">
                    </span>
                </a>';


                }




                if($data->status=="approved"&&!empty($data->user)){
                        $action.='


                        <a  class="btn btn-icons" onclick="updaterequest('."'".route("admin.live-class.request.show",$data->slug)."'".')">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
    </span>
</a>
                    ';
                }
                $action.='
                 <a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.live-class.request.destroy",$data->slug).'">
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                        </span>
                    </a>


                ';
                return $action;
            })->addColumn('timeslottext',function($data){
                return implode('<br> ',$data->timeslot);
            })->addColumn('termhtml',function($data){
                if(!empty($data->user)&&$data->status=="approved"){
                    return '<a  onclick="usertermlist('."'".route('admin.user.termslist', $data->user->slug)."'".')" class="btn btn-icons view_btn">+</a>';
                }else{
                    return '';
                }
            })->addColumn('statushtml',function($data){
                if(!empty($data->user)){
                    switch ($data->status) {
                        case 'approved':
                            return '<div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" onchange="changeactivestatus('."'".route('admin.live-class.request.status',$data->slug)."'".')" role="switch" id="active-toggle-'.$data->id.'"  '.($data->is_valid?"checked":"").'/>
                                        <label class="form-check-label" for="active-toggle-'.$data->id.'">Active</label>
                                    </div>';
                        case 'pending';
                            return '<span class="badge bg-warning">'.ucfirst($data->status).'</span>';
                        case 'rejected';
                            return '<span class="badge bg-danger">'.ucfirst($data->status).'</span>';
                        default:
                            return '<span class="badge bg-secondary">'.ucfirst($data->status).'</span>';
                    }
                }else{
                    return '<span class="badge bg-danger"> Deleted User </span>';
                }
            })->buildTable(['timeslottext','statushtml','termhtml']);
        }
        $live_class =  LiveClassPage::first();

        $terms = [];

        // Retrieve terms from the models
        $terms1 = ClassDetail::get();
        $terms2 = LessonMaterial::get();
        $terms3 = HomeWork::get();
        $terms4 = LessonRecording::get();

        // Collect unique terms from $terms1
        foreach ($terms1 as $item) {
            $terms[] = $item->term_name;
        }

        // Collect unique terms from $terms2
        foreach ($terms2 as $item) {
            if (!in_array($item->term_name, $terms)) { // Use in_array() to check existence
                $terms[] = $item->term_name;
            }
        }

        // You can repeat similar logic for $terms3 and $terms4 if needed
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

        $sloteterms_items = Timetable::where('hide_time', '!=', 'Y')->whereNull('static')->orderBy('order_no')->get()->map(function($item) {
            $text = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ') ' . $item->year;
            $value = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ') ' . $item->year;
            return [
                'text' => $text,
                'id' => $value,
            ];
        })->toArray();

        $allTerms = $terms1->concat($terms2)->concat($terms3)->concat($terms4);

        return view('admin.live-class.private-class-request',compact('sloteterms_items','live_class','terms','page_name'));

    }




    public function private_class_request_show(Request $request,PrivateClass $privateClass){
        $privateClass->rejectUrl=route("admin.live-class.request.reject",$privateClass->slug);
        $privateClass->acceptUrl=route("admin.live-class.request.accept",$privateClass->slug);
        $privateClass->updateUrl=route("admin.live-class.request.update",$privateClass->slug);
        return $privateClass;
    }
    public function private_class_request_status(Request $request,PrivateClass $privateClass){
        $privateClass->update(['is_valid'=>$privateClass->is_valid?false:true]);

        if($request->ajax()){
            return response()->json(["success"=>"Request status has been successfully changed"]);
        }
        return redirect()->back()->with('success','Request status has been successfully changed');
    }
    public function private_class_request_export(Request $request){
        if($request->ajax()){
            if($request->page_name=='Pending Users'){
                return PrivateClass::select('email as Email','full_name as Full Name','parent_name as Parent Name','phone as Phone',DB::raw("REPLACE(REPLACE(REPLACE(JSON_EXTRACT(timeslot, '$'), '\"', ''), '[', ''),']', '') as `Available Timeslote`"),'status as Status')
                                    ->where(function($qry){
                                        $qry->where('status','pending');
                                        $qry->orWhere('status','rejected');
                                    })
                                    ->get();
            }
            return PrivateClass::select('email as Email','full_name as Full Name','parent_name as Parent Name','phone as Phone',DB::raw("REPLACE(REPLACE(REPLACE(JSON_EXTRACT(timeslot, '$'), '\"', ''), '[', ''),']', '') as `Available Timeslote`"),'status as Status')
                                ->where(function($qry) {
                                    $qry->where('status', '!=', 'pending')
                                        ->where('status', '!=', 'rejected');
                                })
                                ->get();

        }
    }
    public function private_class_request_accept(Request $request,PrivateClass $privateClass){
        $request->validate([
            'timeslot'=>['required','array']
        ]);
        $privateClass->update(['status'=>"approved","timeslot"=>$request->input('timeslot',[])]);

        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully approved"]);
        }
        return redirect()->back()->with('success','Request has been successfully approved');
    }
    public function private_class_request_update(Request $request,PrivateClass $privateClass){
        $data=$request->validate([
            'timeslot'=>['required','array']
        ]);
        $privateClass->update($data);

        if($request->ajax()){
            return response()->json(["success"=>"Timeslote has been successfully updated"]);
        }
        return redirect()->back()->with('success','Timeslote has been successfully updated');
    }
    public function private_class_request_reject(Request $request,PrivateClass $privateClass){
        $privateClass->update(['status'=>"rejected"]);

        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully rejected"]);
        }
        return redirect()->back()->with('success','Request has been successfully rejected');
    }
    public function private_class_request_destroy(Request $request,PrivateClass $privateClass){

        TermAccess::where('user_id', $privateClass->user_id)->delete();

        $privateClass->delete();

        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully deleted"]);
        }
        return redirect()->back()->with('success','Request has been successfully deleted');
    }

    public function bulkaction(Request $request){

        if($request->input('select_all','no')=="yes"){

            // PrivateClass::where('id','>',0)->delete();

            PrivateClass::whereIn('id',$request->input('selectbox',[]))->delete();

        }else{

            $user_ids = PrivateClass::whereIn('id',$request->input('selectbox',[]))->pluck('user_id')->toArray();

            TermAccess::whereIn('user_id',$user_ids)->delete();

            PrivateClass::whereIn('id',$request->input('selectbox',[]))->delete();
        }
        if($request->ajax()){
            return response()->json(["success"=>"Request has been successfully deleted"]);
        }
        return redirect()->back()->with("success","Request has been successfully deleted");
    }
    public function bulkupdate(Request $request){
        $terms=[];
        foreach(ClassDetail::all() as $term){
            $name=trim($term->term_name);
            $terms[$name]=0;
        }
        foreach(LessonMaterial::all() as $term){
            $name=trim($term->term_name);
            $terms[$name]=0;
        }
        foreach(HomeWork::all() as $term){
            $name=trim($term->term_name);
            $terms[$name]=0;
        }
        foreach(LessonRecording::all() as $term){
            $name=trim($term->term_name);
            $terms[$name]=0;
        }
        $privateClass=  PrivateClass::where('id','>',0);

        // if($request->input('select_all','no')!="yes"){

            $privateClass->whereIn('id',$request->input('selectbox',[]));
        // }

        $users=User::with('privateClass')->whereIn("id",$privateClass->select('user_id'))->get();
        return ["termsList"=>$terms,"userList"=>$users];
    }


}
