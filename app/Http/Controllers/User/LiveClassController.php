<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\ImageProcess;
use App\Jobs\ProcessFile;
use App\Models\ClassDetail;
use App\Models\LessonMaterial;
use App\Models\LiveClassPage;
use App\Models\PrivateClass;
use App\Models\Settings;
use App\Models\SubClassDetail;
use App\Models\SubLessonMaterial;
use App\Models\TermAccess;
use App\Models\Timetable;
use App\Models\User;
use App\Support\Helpers\ImageHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Imagick;

class LiveClassController extends Controller
{

    public function index()
    {
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        return view('user.live-class.index',compact('live_class','user'));
    }
    public function workshop(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        return view('user.live-class.workshop',compact('user','live_class'));
    }

    public function workshopform(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        if ($user->progress('intensive-workshop-payment','')=="paid"){
            return view('user.live-class.workshopform',compact('user','live_class'));
        }else{
            return redirect()->back()->with("error","Workshop Payment required");
        }
    }

    public function privateclass(Request  $request,$live){
        /**
         * @var User
         */
        $user=Auth::user();

        $live_class =  LiveClassPage::first();
        $setting = Settings::first();
        $timetables = Timetable::where('hide_time','!=','Y')->orderBy('order_no')->get();

        return view('user.live-class.private',compact('user','live_class','setting','timetables'));
    }

    public function privateclassform(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();

        $time_array = Timetable::where('hide_time', '!=', 'Y')->orderBy('order_no')->get()->map(function($item) {
            $value = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ') ' . $item->year;
            $text = $item->day . ' (' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) .'-'. str_replace(' ', '', $item->endtime) . ' ' . implode('.', str_split(strtolower($item->endtime_am_pm))) .  ') (' . $item->type . ') ';
            return [
                'text' => $text,
                'value' => $value,
            ];
        })->toArray();

        return view('user.live-class.privateform',compact('time_array','user','live_class'));
    }
    public function privateclassformsubmit(Request  $request){
        $data=$request->validate([
            'email'=>['required','email:rfc,dns','unique:private_classes','max:250'],
            'full_name'=>['required','string','max:255'],
            'parent_name'=>['required','string','max:255'],
            // 'phone'=>['required'],
            'timeslot'=>['required','array','min:1']
        ]);
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();

        $data['user_id']=$user->id;

        PrivateClass::store($data);

        return redirect()->route('live-class.privateclass', $user->slug)->with('success','Class Requested Succesfully');

    }

    public function privateclassroom(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        return view('user.live-class.privateclass',compact('user','live_class'));
    }
    public function privateclassdetails(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        $classdetail = ClassDetail::whereIn('id',TermAccess::where('type','class-detail')->where('user_id',$user->id)->select('term_id'))->get();
        return view('user.live-class.class-detail',compact('user','live_class','classdetail'));
    }
    public function privateclassterm(Request  $request,$live,ClassDetail $classDetail){
        /**
         * @var User
         */
        $user=Auth::user();

        if(TermAccess::where('type','class-detail')->where('term_id',$classDetail->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        $live_class =  LiveClassPage::first();
        $sloteterms=[];

        // $sloteterms_items = [
        //     [
        //         'text' => "Monday 6:30 p.m. (Online) - Year 6",
        //         'id' => "Monday 6:30 p.m. (Online) - Year 6"
        //     ],
        //     [
        //         'text' => "Wednesday 6:30 p.m. (Online) - Year 5",
        //         'id' => "Wednesday 6:30 p.m. (Online) - Year 5"
        //     ],
        //     [
        //         'text' => "Thursday 6:30 p.m. (Online) - Year 6",
        //         'id' => "Thursday 6:30 p.m. (Online) - Year 6"
        //     ],
        //     [
        //         'text' => "Saturday 9:30 a.m. (F2F) - Year 5",
        //         'id' => "Saturday 9:30 a.m. (F2F) - Year 5"
        //     ],
        //     [
        //         'text' => "Saturday 12 p.m. (F2F) - Year 5",
        //         'id' => "Saturday 12 p.m. (F2F) - Year 5"
        //     ],
        //     [
        //         'text' => "Saturday 2:30 p.m. (F2F) - Year 6",
        //         'id' => "Saturday 2:30 p.m. (F2F) - Year 6"
        //     ],
        //     [
        //         'text' => "Sunday 9:30 a.m. (F2F) - Year 5",
        //         'id' => "Sunday 9:30 a.m. (F2F) - Year 5"
        //     ],
        //     [
        //         'text' => "Sunday 12 p.m. (F2F) - Year 5",
        //         'id' => "Sunday 12 p.m. (F2F) - Year 5"
        //     ],
        //     [
        //         'text' => "Sunday 2:30 p.m. (F2F) - Year 6",
        //         'id' => "Sunday 2:30 p.m. (F2F) - Year 6"
        //     ]
        // ];

        $sloteterms_items = Timetable::where('hide_time', '!=', 'Y')->orderBy('order_no')->get()->map(function($item) {
            $text = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ')' . $item->year;
            $value = $item->day . ' ' . str_replace(' ', '', $item->starttime) . ' ' . implode('.', str_split(strtolower($item->starttime_am_pm))) . '. (' . $item->type . ')' . $item->year;
            return [
                'text' => $text,
                'id' => $value,
            ];
        })->toArray();

        $sloteclass_terms = array_filter($sloteterms_items, function ($item) use ($classDetail) {
            return SubClassDetail::whereJsonContains('timeslot', $item['id'])
                ->where('class_detail_id', $classDetail->id)
                ->exists();
        });

        foreach($sloteclass_terms as $s){
            $sloteterms[]=[
                'slot'=>$s['id'],
                'list'=>SubClassDetail::where('class_detail_id',$classDetail->id)->whereJsonContains('timeslot',$s['id'])->get()
            ];
        }

        // ->whereJsonContains('timeslot',$s) private class terms

        return view('user.live-class.class-detail-term',compact('user','live_class','classDetail','sloteterms'));
    }

    public function privateclasslesson(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        $lessons = LessonMaterial::whereIn('id',TermAccess::where('type','lesson-material')->where('user_id',$user->id)->select('term_id'))->get();
        return view('user.live-class.lesson-detail',compact('user','live_class','lessons'));
    }
    public function privateclasslessonshow(Request  $request,$live,LessonMaterial $lessonMaterial){
        /**
         * @var User
         */
        $user=Auth::user();

        if(TermAccess::where('type','lesson-material')->where('term_id',$lessonMaterial->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        $live_class =  LiveClassPage::first();
        $lessons = SubLessonMaterial::where('lesson_material_id',$lessonMaterial->id)->paginate();
        return view('user.live-class.lesson',compact('user','live_class','lessonMaterial','lessons'));
    }

    public function privateclasslessonpdf(Request  $request,$live,SubLessonMaterial $subLessonMaterial){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();
        $lessonMaterial=LessonMaterial::find($subLessonMaterial->lesson_material_id);

        if(TermAccess::where('type','lesson-material')->where('term_id',$lessonMaterial->id)->where('user_id',$user->id)->count()==0){
            return abort(404);
        }
        $cachepath=Storage::disk('private')->path('cache/'.md5($subLessonMaterial->pdf_file));
        $filepath=Storage::disk('private')->path($subLessonMaterial->pdf_file);
        File::ensureDirectoryExists($cachepath);

        // if(!File::ensureDirectoryExists($cachepath) && $subLessonMaterial->status !== 'processing')
        // {
        //     $subLessonMaterial->status="";
        //     $subLessonMaterial->save();
        // }

        // if(!File::exists("$cachepath/render.map.json")){
        //     $pdfmap=ImageHelper::convertPdfToImage($filepath,$cachepath);
        //     file_put_contents("$cachepath/render.map.json",json_encode($pdfmap));
        // }else{
        //     $pdfmap=json_decode(file_get_contents("$cachepath/render.map.json"),true);
        // }
        // if($request->ajax()){
        //     $key =$pdfmap['hash'];
        //     $part=$request->part??0;
        //     $page=$request->page??0;
        //     $path=ImageHelper::decryptData($pdfmap["data"][$page]["data"][$part],$key);
        //     return response()->json([
        //         "hash"=>$key,
        //         "data"=>file_get_contents($path)
        //     ]);
        // }


        //  $jobStatus = Cache::get("job_status_{$process->jobIdentifier}");

         if ($subLessonMaterial->status !== 'completed' && $subLessonMaterial->status !== 'failled' || $subLessonMaterial->status === '') {

            // $process =ProcessFile::dispatch($filepath,$user,$subLessonMaterial,$cachepath);
            // ProcessFile::dispatchNow($filepath, $user, $subLessonMaterial, $cachepath);

            // ProcessFile::dispatch($filepath, $user, $subLessonMaterial, $cachepath);

            // dispatch(job: new ProcessFile($filepath, $user, $subLessonMaterial, $cachepath));
            $out="";

            if($subLessonMaterial->status !='processing')
            {

                $subLessonMaterial->status = 'processing';

                $subLessonMaterial->save();

                // $out ="php /home/cortex1/public_html/imagic.php --filepath=$filepath --cachepath=$cachepath  --subLessonMaterial={$subLessonMaterial->slug}  --user=$user->slug > output.log 2>&1 &";

            //    $out= shell_exec("php /home/cortex1/public_html/imagic.php --filepath=$filepath --cachepath=$cachepath  --subLessonMaterial={$subLessonMaterial->slug}  --user=$user->slug > output.log 2>&1 &");


                dispatch(new ImageProcess($filepath, $user, $subLessonMaterial, $cachepath));

            }
            return response()->json(['message' => 'Please wait for the file to finish processing.',"out"=>$out ,'status' => 'processing']);

        }
        elseif ($subLessonMaterial->status === 'failled') {

            return response()->json(['message' => 'There was an error processing the file. Please try again.' ,'status' => 'failled']);
        }
        elseif ($subLessonMaterial->status === 'completed') {

            $imgdata=json_decode(file_get_contents("$cachepath/render.map.json"),true);

            if (request()->ajax())
            {
                return response()->json(['message' => 'Render the pdf' ,'status' => 'completed']);
            }

        }

        $imgdataurl = [];

        foreach($imgdata as $item)
        {

            $imgdataurl[] = [
                'url' => route("live-class.privateclass.lessonpdf.load", [
                    'live' => $live,
                    'sub_lesson_material' =>$subLessonMaterial->slug,
                    'file' => $item['data'],
                ])
            ];
        }

        // $pdfmap['url']=route('live-class.privateclass.lessonpdf', ["live" =>$user->slug,"sub_lesson_material"=>$subLessonMaterial->slug ]);
        return view('user.live-class.pdfrender',compact('user','live_class','subLessonMaterial','lessonMaterial','imgdataurl'));
    }



    public function privateclasslessonpdfload(Request  $request,$live,SubLessonMaterial $subLessonMaterial,$file){
        $cachepath=Storage::disk('private')->path('cache/'.md5($subLessonMaterial->pdf_file));
        File::ensureDirectoryExists($cachepath);
        header('Content-Type: image/jpeg');
        print_r(file_get_contents("$cachepath/$file"));
        exit;
    }

}
