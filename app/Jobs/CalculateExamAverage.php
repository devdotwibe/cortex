<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\UserReviewAnswer;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;

class CalculateExamAverage implements SerializesModels
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

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


        foreach ($category_question_bank as $item)
        {
             $averagepersentage =  $item->getExamAvgPercentage('question-bank');

             session(['exam_average_percentage_'.$item->id => $averagepersentage]);
        }


        
    }
}
