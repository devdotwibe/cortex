<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Imagick;

class ImageProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filepath;
    protected $user;
    protected $subLessonMaterial;
    protected $cachepath;
    protected $jobIdentifier;
    

    /**
     * Create a new job instance.
     */
    public function __construct($filepath,$user,$subLessonMaterial,$cachepath)
    {
       $this->filepath = $filepath;
       $this->user = $user;
       $this->subLessonMaterial = $subLessonMaterial;
       $this->cachepath = $cachepath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $this->subLessonMaterial->status = 'processing';
            $this->subLessonMaterial->save();

            $imgdata=[];   
            $resolution = 300;  
            $hash = md5($this->filepath . "render" . time()); 

            if (!is_dir($this->cachepath)) {
                mkdir($this->cachepath, 0777, true);
            }
             
            $command = "gs -q -dNODISPLAY -c \"({$this->filepath}) (r) file runpdfbegin pdfpagecount = quit\"";
            exec($command, $output, $returnCode); 
            if ($returnCode !== 0 || empty($output)) {
                die("Error: Unable to determine the number of pages in the PDF.");
            } 
            $count = (int) $output[0];  
            for ($page = 1; $page <= $count; $page++) {
                $bytefile = sprintf("$hash-%02d.jpg", $page); 
                $command = "gs -dNOPAUSE -dBATCH -sDEVICE=jpeg -r$resolution -dFirstPage=$page -dLastPage=$page -sOutputFile={$this->cachepath}/{$bytefile} {$this->filepath}";
                exec($command, $execOutput, $returnCode);
            
                if ($returnCode === 0) { 
                    
                    $imgdata[] = [
                        'page' => $page,
                        // 'width' => $width,
                        // 'height' => $height,
                        'data' => $bytefile,
                        'url' => route("live-class.privateclass.lessonpdf.load", [
                            'live' => $this->user->slug,
                            'sub_lesson_material' => $this->subLessonMaterial->slug,
                            'file' => $bytefile
                        ])
                    ];
                } else { 
                    die("Error:  PDF Page missing on generation.");
                }
            }
            $this->subLessonMaterial->status = 'completed'; 
            $this->subLessonMaterial->save();
            file_put_contents($this->cachepath . '/render.map.json', json_encode($imgdata));




           /*
            $imginfo = new \Imagick();
            $imginfo->pingImage($this->filepath);    
        
            $count= $imginfo->getNumberImages();
        
            $imagic = new \Imagick();
            $imagic->setResolution(570, 800);
            $imagic->readImage($this->filepath);
            
            $imgdata=[]; 
            $pageindex = 0;

            $hash = md5($this->filepath . "render" . time());

            for ($pageIndex = 0; $pageIndex < $count; $pageIndex++) {

                $imagic->setIteratorIndex($pageIndex);
            
                $imagic->setImageFormat('jpeg');
                $imagic->setCompressionQuality(99); 
            
                $bytefile = sprintf("$hash-%02d.jpg", $pageIndex);
            
                $imagic->writeImage($this->cachepath . '/' . $bytefile);
            
                $width = $imagic->getImageWidth();
                $height = $imagic->getImageHeight();
            
                $imgdata[] = [
                    'page' => $pageIndex + 1,
                    'width' => $width,
                    'height' => $height,
                    'data' => $bytefile,
                    'url' => route("live-class.privateclass.lessonpdf.load", [
                        'live' => $this->user->slug,
                        'sub_lesson_material' => $this->subLessonMaterial->slug,
                        'file' => $bytefile
                    ])
                ];
            }
            
            $imagic->clear();
            $imagic->destroy();

            $this->subLessonMaterial->status = 'completed'; 

            $this->subLessonMaterial->save();
            
            // foreach ($imagic as $pageIndex => $page) {
            //     $bytefile=sprintf("$hash-%02d.jpg",$pageIndex);
            //     $page->setImageFormat('jpeg');   
            //     $page->setCompressionQuality(99);

            //     $imagic->writeImage("$this->cachepath/$bytefile");
            //     $imagic->writeImage($this->cachepath . '/' . $bytefile);
            //     $width = $page->getImageWidth();
            //     $height = $page->getImageHeight();
            //     $imgdata[] = [
            //         'page' => $pageIndex + 1, 
            //         'width' => $width,
            //         'height' => $height,
            //         "data" => $bytefile,
            //         'url'=> route("live-class.privateclass.lessonpdf.load",['live' => $this->user->slug, 'sub_lesson_material' => $this->subLessonMaterial->slug,"file"=>$bytefile])
            //     ];
            // }
        
            // file_put_contents("$this->cachepath/render.map.json",json_encode($imgdata));
            file_put_contents($this->cachepath . '/render.map.json', json_encode($imgdata));

            // \Log::info("File processed successfully: " . $this->filepath);
            */
        } catch (Exception $e) {

            $this->subLessonMaterial->status = 'failled'; 

            $this->subLessonMaterial->save();
           
            // \log::error("Error processing file: " . $this->filepath . " - " . $e->getMessage());
        }
            
    }
}
