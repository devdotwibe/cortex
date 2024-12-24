<?php

namespace App\Console\Commands;

use App\Models\SubLessonMaterial;
use Illuminate\Console\Command;

class ProcessImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:processimage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subLessonMaterialId = $this->argument('sub_lesson_material_id');

        // Fetch the SubLessonMaterial from the database using the ID
        $subLessonMaterial = SubLessonMaterial::findSlug($subLessonMaterialId);

        // Check if the record exists
        if ($subLessonMaterial) {
            // Update the status of the sub lesson material
            $subLessonMaterial->status = 'complete'; 

            // Save the changes
            $subLessonMaterial->save();

            $this->info("SubLessonMaterial with ID {$subLessonMaterialId} has been updated to 'complete'.");
        } else {
            // If the subLessonMaterial is not found
            $this->error("SubLessonMaterial with ID {$subLessonMaterialId} not found.");
        }
    }
}
