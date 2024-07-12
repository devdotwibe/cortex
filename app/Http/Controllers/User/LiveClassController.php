<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
use App\Models\LessonMaterial;
use App\Models\LiveClassPage;
use App\Models\PrivateClass;
use App\Models\SubClassDetail;
use App\Models\SubLessonMaterial;
use App\Models\User;
use App\Support\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function privateclass(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first(); 
        return view('user.live-class.private',compact('user','live_class'));
    }
 
    public function privateclassform(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();  
        return view('user.live-class.privateform',compact('user','live_class')); 
    }
    public function privateclassformsubmit(Request  $request){ 
        $data=$request->validate([
            'email'=>['required','email:rfc,dns','unique:private_classes','max:250'],
            'full_name'=>['required','string','max:255'],
            'parent_name'=>['required','string','max:255'],
            'phone'=>['required'],
            'timeslot'=>['required','array','min:2']
        ]);
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();  

        $data['user_id']=$user->id;

        PrivateClass::store($data); 

        return redirect()->route('live-class.privateclass', $user->slug)->with('success','Class Requiested Succesfully');

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
        $classdetail = ClassDetail::all();
        return view('user.live-class.class-detail',compact('user','live_class','classdetail')); 
    }
    public function privateclassterm(Request  $request,$live,ClassDetail $classDetail){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();  
        $terms = SubClassDetail::where('class_detail_id',$classDetail->id)->paginate();
        return view('user.live-class.class-detail-term',compact('user','live_class','classDetail','terms')); 
    }

    public function privateclasslesson(Request  $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $live_class =  LiveClassPage::first();  
        $lessons = LessonMaterial::all();
        return view('user.live-class.lesson-detail',compact('user','live_class','lessons')); 
    }
    public function privateclasslessonshow(Request  $request,$live,LessonMaterial $lessonMaterial){
        /**
         * @var User
         */
        $user=Auth::user();
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
        $cachepath=Storage::disk('private')->path('cache/'.md5($subLessonMaterial->pdf_file));
        $filepath=Storage::disk('private')->path($subLessonMaterial->pdf_file);
        File::ensureDirectoryExists($cachepath);
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
        if(!File::exists("$cachepath/render.map.json")){
            $imginfo = new \Imagick();
            $imginfo->pingImage($filepath);    
        
            $count= $imginfo->getNumberImages();
        
            $imagic = new \Imagick();
            $imagic->setResolution(570, 800);
            $imagic->readImage($filepath);
            
            $imgdata=[]; 
            $hash=md5("$filepath/render".time());
            foreach ($imagic as $pageIndex => $page) {
                $bytefile=sprintf("$hash-%02d.jpg",$pageIndex);
                $page->setImageFormat('jpeg');   
                $page->setCompressionQuality(99);
                $imagic->writeImage("$cachepath/$bytefile");
                $width = $page->getImageWidth();
                $height = $page->getImageHeight();
                $imgdata[] = [
                    'page' => $pageIndex + 1, 
                    'width' => $width,
                    'height' => $height,
                    "data" => $bytefile,
                    'url'=> route("live-class.privateclass.lessonpdf.load",['live' => $user->slug, 'sub_lesson_material' => $subLessonMaterial->slug,"file"=>$bytefile])
                ];
            }
            $imagic->clear();  
            $imagic->destroy(); 
            file_put_contents("$cachepath/render.map.json",json_encode($imgdata));
        }else{
            $imgdata=json_decode(file_get_contents("$cachepath/render.map.json"),true); 
        }
        // $pdfmap['url']=route('live-class.privateclass.lessonpdf', ["live" =>$user->slug,"sub_lesson_material"=>$subLessonMaterial->slug ]);
        return view('user.live-class.pdfrender',compact('user','live_class','subLessonMaterial','lessonMaterial','imgdata')); 
    }
    public function privateclasslessonpdfload(Request  $request,$live,SubLessonMaterial $subLessonMaterial,$file){
        $cachepath=Storage::disk('private')->path('cache/'.md5($subLessonMaterial->pdf_file)); 
        File::ensureDirectoryExists($cachepath);
        header('Content-Type: image/jpeg');
        print_r(file_get_contents("$cachepath/$file"));
        exit;
    }
    
}
