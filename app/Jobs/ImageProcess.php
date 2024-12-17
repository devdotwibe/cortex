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
           
            $imginfo = new \Imagick();
            $imginfo->pingImage($this->filepath);    
            $count = $imginfo->getNumberImages();
        
            // Set up Imagick for reading the PDF
            $imagic = new \Imagick();
            $imagic->setResolution(570, 800);
            $imagic->readImage($this->filepath);
        
            $imgdata = []; 
            $hash = md5($this->filepath . "render" . time());
        
            // Process images in chunks to avoid timeout
            $chunkSize = 5; // Number of pages to process at a time
            for ($pageIndex = 0; $pageIndex < $count; $pageIndex += $chunkSize) {
                // Process each chunk
                for ($i = 0; $i < $chunkSize && ($pageIndex + $i) < $count; $i++) {
                    $currentPageIndex = $pageIndex + $i;
                    $imagic->setIteratorIndex($currentPageIndex);
                    $imagic->setImageFormat('jpeg');
                    $imagic->setCompressionQuality(99); 
        
                    // Generate filename for the image
                    $bytefile = sprintf("%s-%02d.jpg", $hash, $currentPageIndex);
                    $imagic->writeImage($this->cachepath . '/' . $bytefile);
        
                    // Get image dimensions
                    $width = $imagic->getImageWidth();
                    $height = $imagic->getImageHeight();
        
                    // Prepare data for the response
                    $imgdata[] = [
                        'page' => $currentPageIndex + 1,
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
        
                // Clear memory and allow PHP to process other requests before continuing
                if ($i > 0) {
                    // Clear Imagick resources after processing a chunk
                    $imagic->clear();
                    usleep(500000); // Sleep for 0.5 seconds (optional)
                }
            }
        
            // Clean up Imagick resources
            $imagic->clear();
            $imagic->destroy();
        
            // Update the status of the subLessonMaterial
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
            
        } catch (Exception $e) {

            $this->subLessonMaterial->status = $e->getMessage(); 

            $this->subLessonMaterial->save();
           
            // \log::error("Error processing file: " . $this->filepath . " - " . $e->getMessage());
        }
    }
}
