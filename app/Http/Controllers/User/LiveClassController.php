<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        $timetables = Timetable::all();
        return view('user.live-class.private',compact('user','live_class','setting','timetables'));
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
        foreach($user->privateClass->timeslot??[] as $s){
            $sloteterms[]=[
                'slot'=>$s,
                'list'=>SubClassDetail::where('class_detail_id',$classDetail->id)->whereJsonContains('timeslot',$s)->get()
            ];
        }
         
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


        // if(!File::exists("$cachepath/render.map.json")){

        //         // ini_set('memory_limit', '512M');
        //         // ini_set('max_execution_time', 300);
        //     $hash=md5("$filepath/render".time());              
        //     $imginfo = new Imagick();
        //     $imginfo->pingImage($filepath);
        //     $count= $imginfo->getNumberImages();
        //     $imgdata=[]; 

        //     for ($pageIndex=0; $pageIndex <$count ; $pageIndex++) { 

        //         $page = new Imagick();
        //         $page->setResolution(570, 800);
                
        //         $page->readImage("$filepath"."[$pageIndex]");
               
        //         $bytefile=sprintf("$hash-%02d.jpg",$pageIndex);
        //         $page->setImageFormat('jpeg');
        //         $page->setCompressionQuality(99);
        //         $page->writeImage("$cachepath/$bytefile");
        //         $width = $page->getImageWidth();
        //         $height = $page->getImageHeight();
        //         $imgdata[] = [
        //             'page' => $pageIndex + 1, 
        //             'width' => $width,
        //             'height' => $height,
        //             "data" => $bytefile,
        //             'url'=> route("live-class.privateclass.lessonpdf.load",['live' => $user->slug, 'sub_lesson_material' => $subLessonMaterial->slug,"file"=>$bytefile])
        //         ];
        //         $page->clear();  
        //         $page->destroy(); 
        //     }
       
        //     file_put_contents("$cachepath/render.map.json",json_encode($imgdata));
        // }else{
        //     $imgdata=json_decode(file_get_contents("$cachepath/render.map.json"),true); 
        // }


        if (!File::exists("$cachepath/render.map.json")) {
            try {
                // Optional: Set memory limit and max execution time
                // ini_set('memory_limit', '512M');
                // ini_set('max_execution_time', 300);
        
                $hash = md5("$filepath/render" . time());
                
                // Initialize Imagick
                $imginfo = new Imagick();
                $imginfo->pingImage($filepath);
                $count = $imginfo->getNumberImages();
                $imgdata = [];
        
                // Loop through each page of the PDF
                for ($pageIndex = 0; $pageIndex < $count; $pageIndex++) {
                    try {
                        $page = new Imagick();
                        $page->setResolution(570, 800);  // Set resolution for image quality
                        
                        // Read a specific page from the PDF
                        $page->readImage("$filepath[$pageIndex]");
                        
                        $bytefile = sprintf("$hash-%02d.jpg", $pageIndex);
                        
                        // Set the image format and compression quality
                        $page->setImageFormat('jpeg');
                        $page->setCompressionQuality(99);
                        
                        // Write the image to the specified location
                        $page->writeImage("$cachepath/$bytefile");
        
                        // Get image dimensions
                        $width = $page->getImageWidth();
                        $height = $page->getImageHeight();
        
                        // Prepare the image data
                        $imgdata[] = [
                            'page' => $pageIndex + 1,
                            'width' => $width,
                            'height' => $height,
                            "data" => $bytefile,
                            'url' => route("live-class.privateclass.lessonpdf.load", [
                                'live' => $user->slug, 
                                'sub_lesson_material' => $subLessonMaterial->slug,
                                "file" => $bytefile
                            ])
                        ];
        
                        // Clear memory
                        $page->clear();
                        $page->destroy();
                    } catch (Exception $e) {
                        // Log the error and continue processing other pages
                        Log::error("Error processing page $pageIndex of PDF: " . $e->getMessage());
                        // Optionally, you can continue or break based on the severity of the error
                    }
                }
        
                // Save the generated image data to a JSON file
                // file_put_contents("$cachepath/render.map.json", json_encode($imgdata));
        
            } catch (Exception $e) {
                // Log any errors that occur during the PDF processing
                Log::error("Error processing the PDF file $filepath: " . $e->getMessage());
                // Handle the error, e.g., show a message to the user or return a response
                // Optionally, you could also return an error response here.
            }
        } else {
            // If the map JSON file exists, load the data
            // $imgdata = json_decode(file_get_contents("$cachepath/render.map.json"), true);
        }
      
        // $pdfmap['url']=route('live-class.privateclass.lessonpdf', ["live" =>$user->slug,"sub_lesson_material"=>$subLessonMaterial->slug ]);
    //   return view('user.live-class.pdfrender',compact('user','live_class','subLessonMaterial','lessonMaterial','imgdata')); 

    }
    public function privateclasslessonpdfload(Request  $request,$live,SubLessonMaterial $subLessonMaterial,$file){
        $cachepath=Storage::disk('private')->path('cache/'.md5($subLessonMaterial->pdf_file)); 
        File::ensureDirectoryExists($cachepath);
        header('Content-Type: image/jpeg');
        print_r(file_get_contents("$cachepath/$file"));
        exit;
    }
    
}
