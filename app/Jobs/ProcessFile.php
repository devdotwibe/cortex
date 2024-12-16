<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Illuminate\Support\Facades\Cache;
use Imagick;

class ProcessFile implements ShouldQueue
{
    use Queueable;

    protected $filepath;
    protected $user;
    protected $subLessonMaterial;
    protected $cachepath;
    

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
           
            $imginfo = new \Imagick();
            $imginfo->pingImage($this->filepath);    
        
            $count= $imginfo->getNumberImages();
        
            $imagic = new \Imagick();
            $imagic->setResolution(570, 800);
            $imagic->readImage($this->filepath);
            
            $imgdata=[]; 
            $hash = md5($this->filepath . "render" . time());
            foreach ($imagic as $pageIndex => $page) {
                $bytefile=sprintf("$hash-%02d.jpg",$pageIndex);
                $page->setImageFormat('jpeg');   
                $page->setCompressionQuality(99);
                // $imagic->writeImage("$this->cachepath/$bytefile");
                $imagic->writeImage($this->cachepath . '/' . $bytefile);
                $width = $page->getImageWidth();
                $height = $page->getImageHeight();
                $imgdata[] = [
                    'page' => $pageIndex + 1, 
                    'width' => $width,
                    'height' => $height,
                    "data" => $bytefile,
                    'url'=> route("live-class.privateclass.lessonpdf.load",['live' => $this->user->slug, 'sub_lesson_material' => $this->subLessonMaterial->slug,"file"=>$bytefile])
                ];
            }
            $imagic->clear();  
            $imagic->destroy(); 
            // file_put_contents("$this->cachepath/render.map.json",json_encode($imgdata));
            file_put_contents($this->cachepath . '/render.map.json', json_encode($imgdata));

            Cache::put("job_status_{$this->job->getJobId()}", 'completed', now()->addMinutes(30));
            
            \Log::info("File processed successfully: " . $this->filepath);
        } catch (Exception $e) {
           
            \log::error("Error processing file: " . $this->filepath . " - " . $e->getMessage());
        }
    }
}
