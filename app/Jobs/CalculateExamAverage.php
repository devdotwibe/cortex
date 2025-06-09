<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\UserReviewAnswer;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class CalculateExamAverage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue,Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

    try {


        Log::info('CalculateExamAverage job started.');

        $test="1";
        $cachePath = storage_path('app/cache');

        if (!file_exists($cachePath)) {
            mkdir($cachePath, 0775, true);
        }

        $filePath = $cachePath . '/test.json';

        file_put_contents($filePath, json_encode($test));


        $question_bank_exam=Exam::where("name",'question-bank')->first();
        if(empty($question_bank_exam)){
            $question_bank_exam=Exam::store([
                "title"=>"Question Bank",
                "name"=>"question-bank",
            ]);
            $question_bank_exam=Exam::find( $question_bank_exam->id );
        }

        $category_question_bank=Category::whereHas('subcategories',function($qry)use($question_bank_exam){
            $qry->whereIn("id",Question::where('exam_id',$question_bank_exam->id)->select('sub_category_id'));
            $qry->whereHas('setname', function ($setnameQuery) {
                $setnameQuery->where(function ($query) {
                    $query->where('time_of_exam', '!=', '00:00')
                          ->where('time_of_exam', '!=', '00 : 00');
                });
            });
        })->get();

        Log::info('Categories retrieved for "question-bank" exam: ' . $category_question_bank->count());

        foreach ($category_question_bank as $item)
        {
             $averagepersentage =  $item->getExamAvgPercentage('question-bank');

             session(['exam_average_percentage_'.$item->id => $averagepersentage]);

             $cachePath = storage_path('app/cache');

             if (!file_exists($cachePath)) {
                 mkdir($cachePath, 0775, true);
             }

             $filePath = $cachePath . '/exam_average_percentage_' . $item->id . '.json';

             file_put_contents($filePath, json_encode($averagepersentage));
        }

        $category_topic = Category::with('question')
        ->whereHas('question', function ($query) {
            $query->whereIn('exam_id', function ($subquery) {
                $subquery->select('id')
                    ->from('exams')
                    ->where('name', 'full-mock-exam');
            });
        })->get();

        foreach ($category_topic as $item)
        {
             $averagepersentage =  $item->getExamAvgMark('topic-test');

             session(['exam_average_mark_'.$item->id => $averagepersentage]);

             $cachePath = storage_path('app/cache');

            if (!file_exists($cachePath)) {
                mkdir($cachePath, 0775, true);
            }

            $filePath = $cachePath . '/exam_average_mark_' . $item->id . '.json';

            file_put_contents($filePath, json_encode($averagepersentage));
        }


        Log::info('CalculateExamAverage job completed.');

         } catch (\Throwable $e) {

            Log::error('CalculateExamAverage job failed: ' . $e->getMessage());
        }

    }
}
